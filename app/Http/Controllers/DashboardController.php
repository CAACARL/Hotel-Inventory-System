<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = \App\Models\Item::count();
        $totalCategories = \App\Models\Category::where('is_active', true)->count();
        $lowStockItems = \App\Models\Item::lowStock()->count();
        
        // Calculate total inventory value with depreciation
        $totalInventoryValue = \App\Models\Item::whereNotNull('purchase_price')
            ->get()
            ->sum(function ($item) {
                $currentValue = $item->getCurrentValue();
                return $currentValue ? $currentValue * $item->quantity : 0;
            });

        // Add consumable batch values (unit_cost × quantity for active batches)
        $consumableBatchValue = \App\Models\Batch::where('status', 'active')
            ->whereNotNull('unit_cost')
            ->whereHas('item', fn($q) => $q->where('item_type', 'consumable'))
            ->get()
            ->sum(fn($batch) => $batch->unit_cost * $batch->quantity);

        $totalInventoryValue += $consumableBatchValue;
        
        // Filter recent transactions based on user role
        $recentTransactionsQuery = \App\Models\Transaction::with(['item', 'user']);
        if (auth()->user()->isStaff()) {
            $recentTransactionsQuery->where('user_id', auth()->id());
        }
        $recentTransactions = $recentTransactionsQuery->latest()->take(10)->get();
        
        $lowStockItemsList = \App\Models\Item::with('category')
            ->lowStock()
            ->take(5)
            ->get();

        // Get items with borrowed quantities
        $borrowedItemsList = \App\Models\Item::with(['category', 'transactions'])
            ->get()
            ->filter(function ($item) {
                return $item->borrowed_quantity > 0;
            })
            ->take(5);

        $totalBorrowedItems = \App\Models\Item::get()
            ->filter(function ($item) {
                return $item->borrowed_quantity > 0;
            })
            ->count();

        return view('dashboard', compact(
            'totalItems',
            'totalCategories', 
            'lowStockItems',
            'totalInventoryValue',
            'recentTransactions',
            'lowStockItemsList',
            'borrowedItemsList',
            'totalBorrowedItems'
        ));
    }
}
