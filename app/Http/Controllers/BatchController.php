<?php

namespace App\Http\Controllers;

use App\Models\Batch;
use App\Models\Item;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ActivityLog;

class BatchController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Automatically process expired consumable batches
        $this->processExpiredConsumables();

        $query = Batch::with(['item' => fn($q) => $q->withTrashed()->with('category')]);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by expiry
        if ($request->filled('expiry_filter')) {
            switch ($request->expiry_filter) {
                case 'expired':
                    $query->expired();
                    break;
                case 'expiring_soon':
                    $query->expiringSoon();
                    break;
                case 'valid':
                    $query->where('expiry_date', '>', now())->orWhereNull('expiry_date');
                    break;
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('batch_number', 'like', "%{$search}%")
                  ->orWhere('supplier', 'like', "%{$search}%")
                  ->orWhere('lot_number', 'like', "%{$search}%")
                  ->orWhereHas('item', function ($itemQuery) use ($search) {
                      $itemQuery->where('name', 'like', "%{$search}%");
                  });
            });
        }

        $batches = $query->orderBy('created_at', 'desc')->paginate(15);

        // Get statistics
        $stats = [
            'total' => Batch::count(),
            'active' => Batch::where('status', 'active')->count(),
            'expired' => Batch::expired()->count(),
            'expiring_soon' => Batch::expiringSoon()->count(),
        ];

        // Get items for edit modal
        $items = Item::with('category')->orderBy('name')->get();

        return view('batches.index', compact('batches', 'stats', 'items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $items = Item::with('category')->orderBy('name')->get();
        return view('batches.create', compact('items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'unit_cost' => 'nullable|numeric|min:0',
            'manufacture_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:manufacture_date',
            'supplier' => 'nullable|string|max:255',
            'lot_number' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            // Depreciation fields
            'depreciation_method' => 'nullable|in:straight_line,declining_balance',
            'useful_life_years' => 'nullable|integer|min:1|max:50',
            'salvage_value' => 'nullable|numeric|min:0',
            'depreciation_rate' => 'nullable|numeric|min:0|max:100',
        ]);

        DB::transaction(function () use ($request) {
            // Create batch with depreciation fields
            $batch = Batch::create([
                'batch_number'       => Batch::generateBatchNumber(),
                'item_id'            => $request->item_id,
                'quantity'           => $request->quantity,
                'unit_cost'          => $request->unit_cost,
                'purchase_price'     => $request->unit_cost,
                'purchase_date'      => now()->toDateString(),
                'depreciation_method'=> $request->depreciation_method ?? 'none',
                'useful_life_years'  => $request->useful_life_years,
                'salvage_value'      => $request->salvage_value,
                'depreciation_rate'  => $request->depreciation_rate,
                'manufacture_date'   => $request->manufacture_date,
                'expiry_date'        => $request->expiry_date,
                'supplier'           => $request->supplier,
                'lot_number'         => $request->lot_number,
                'location'           => $request->location,
                'notes'              => $request->notes,
            ]);

            // Update item quantity and depreciation settings if provided
            $item = Item::find($request->item_id);
            $item->increment('quantity', $request->quantity);

            // If item was disposed or spoiled, mark as available now that stock is back
            $item->refresh();
            if (in_array($item->status, ['disposed', 'spoiled']) && $item->quantity > 0) {
                $item->update(['status' => 'available']);
            }

            if (!$item->unit || $item->unit === 'pcs') {
                $item->update([
                    'unit' => $request->unit ?? 'pcs',
                    'minimum_stock' => $item->minimum_stock ?: 10,
                ]);
            }

            Transaction::create([
                'item_id' => $item->id,
                'user_id' => auth()->id(),
                'type' => 'in',
                'transaction_type' => 'replenish',
                'quantity' => $request->quantity,
                'notes' => 'Batch replenishment: ' . $batch->batch_number . ($request->notes ? ' - ' . $request->notes : ''),
                'reference_number' => 'REP-' . str_pad(Transaction::where('transaction_type', 'replenish')->count() + 1, 3, '0', STR_PAD_LEFT),
                'transaction_date' => now(),
            ]);

            // Notify admins of new batch (exclude the creator)
            \App\Models\Notification::notifyAdmins(
                'new_batch',
                'New Batch: ' . $item->name,
                'Batch ' . $batch->batch_number . ' added — ' . number_format($request->quantity) . ' ' . $item->unit . ($request->supplier ? ' from ' . $request->supplier : ''),
                route('batches.show', $batch),
                'borrow', 'blue',
                auth()->id()
            );
            
            ActivityLog::log('created', $batch);
        });

        return redirect()->route('batches.index', ['page' => $request->input('page', 1)])
                        ->with('success', 'Stock replenished successfully. New batch created.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Batch $batch)
    {
        $batch->load(['item' => fn($q) => $q->withTrashed()->with('category'), 'items']);
        return view('batches.show', compact('batch'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Batch $batch)
    {
        $items = Item::with('category')->orderBy('name')->get();
        return view('batches.edit', compact('batch', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Batch $batch)
    {
        $request->validate([
            'item_id' => 'required|exists:items,id',
            'quantity' => 'required|integer|min:0',
            'unit_cost' => 'nullable|numeric|min:0',
            'manufacture_date' => 'nullable|date',
            'expiry_date' => 'nullable|date|after:manufacture_date',
            'supplier' => 'nullable|string|max:255',
            'lot_number' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'notes' => 'nullable|string',
            'status' => 'required|in:active,expired',
        ]);

        DB::transaction(function () use ($request, $batch) {
            $oldQuantity = $batch->quantity;
            $newQuantity = $request->quantity;
            $quantityDiff = $newQuantity - $oldQuantity;

            // Update batch
            $batch->update($request->only([
                'item_id', 'quantity', 'unit_cost', 'manufacture_date',
                'expiry_date', 'supplier', 'lot_number', 'location', 'notes', 'status'
            ]));

            // Update item quantity if changed
            if ($quantityDiff != 0) {
                $item = Item::find($request->item_id);
                $item->increment('quantity', $quantityDiff);
            }
        });

        return redirect()->route('batches.index', ['page' => $request->input('page', 1)])
                        ->with('success', 'Batch updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Batch $batch)
    {
        DB::transaction(function () use ($batch) {
            // Decrease item quantity
            $batch->item->decrement('quantity', $batch->quantity);
            
            // Delete batch
            $batch->delete();
        });

        return redirect()->route('batches.index', ['page' => $request->input('page', 1)])
                        ->with('success', 'Batch deleted successfully.');
    }

    /**
     * Mark batch as expired
     */
    public function markExpired(Batch $batch)
    {
        $batch->update(['status' => 'expired']);

        return redirect()->back()
                        ->with('success', 'Batch marked as expired.');
    }

    /**
     * Get expiring batches for dashboard
     */
    public function getExpiringBatches()
    {
        return Batch::with(['item'])
                   ->expiringSoon()
                   ->orderBy('expiry_date')
                   ->limit(10)
                   ->get();
    }

    /**
     * Automatically process expired consumable batches
     */
    private function processExpiredConsumables()
    {
        // Get all expired batches for consumable items that are still marked as active
        $expiredBatches = Batch::where('status', 'active')
            ->where('expiry_date', '<', now())
            ->whereHas('item', function($query) {
                $query->where('item_type', 'consumable');
            })
            ->with('item')
            ->get();

        foreach ($expiredBatches as $batch) {
            $batch->markAsExpired();
        }
    }
}