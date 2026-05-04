<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Transaction;
use App\Models\BorrowedItem;
use App\Models\Item;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Populate borrowed_items table from existing transaction data
        // Use DB::table() to bypass Eloquent SoftDeletes scope — deleted_at column doesn't exist yet at this migration point
        $items = \Illuminate\Support\Facades\DB::table('items')->get();
        
        foreach ($items as $item) {
            // Get all users who have borrowed this item
            $borrowers = Transaction::where('item_id', $item->id)
                ->where('transaction_type', 'borrow')
                ->with('user')
                ->get()
                ->groupBy('user_id');
                
            foreach ($borrowers as $userId => $userBorrows) {
                $totalBorrowed = $userBorrows->sum('quantity');
                
                $totalReturned = Transaction::where('item_id', $item->id)
                    ->where('user_id', $userId)
                    ->where('transaction_type', 'return')
                    ->sum('quantity');
                    
                $currentlyBorrowed = $totalBorrowed - $totalReturned;
                
                if ($currentlyBorrowed > 0) {
                    $latestBorrow = $userBorrows->sortByDesc('transaction_date')->first();
                    
                    // Create borrowed item record
                    BorrowedItem::create([
                        'item_id' => $item->id,
                        'user_id' => $userId,
                        'quantity' => $currentlyBorrowed,
                        'borrower_name' => $latestBorrow->borrower_name,
                        'borrower_department' => $latestBorrow->borrower_department,
                        'notes' => $latestBorrow->notes,
                        'reference_number' => $latestBorrow->reference_number,
                        'borrowed_at' => $latestBorrow->transaction_date,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Clear the borrowed_items table
        BorrowedItem::truncate();
    }
};