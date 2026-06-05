<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\BorrowedItem;
use App\Models\ActivityLog;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        // Automatically process expired consumable batches
        $this->processExpiredConsumables();

        $query = Item::with(['category', 'department', 'transactions.user', 'batch']);
        
        if ($request->has('filter') && $request->filter === 'low_stock') {
            $query->lowStock();
        }
        
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%')
                  ->orWhereHas('category', function($categoryQuery) use ($search) {
                      $categoryQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }
        
        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }
        
        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->has('department') && $request->department) {
            $query->where('department_id', $request->department);
        }
        
        $items = $query->paginate(15)->appends($request->query());
        return view('items.index', compact('items'));
    }

    public function create()
    {
        // Get all categories ordered by path for hierarchical display
        $categories = Category::where('is_active', true)
            ->orderBy('path')
            ->get();
        $departments = \App\Models\Department::where('is_active', true)->get();
        return view('items.create', compact('categories', 'departments'));
    }

    public function store(Request $request)
    {
        // Check for potential duplicate items (same name, category, and department)
        $existingItem = Item::where('name', $request->name)
            ->where('category_id', $request->category_id)
            ->where('department_id', $request->department_id)
            ->first();

        if ($existingItem) {
            $category = Category::find($request->category_id);
            $department = \App\Models\Department::find($request->department_id);

            return redirect()->route('items.index', ['page' => $request->input('page', 1)])
                ->with('warning', 'An item named "' . $request->name . '" already exists in category "' . $category->name . '" and department "' . ($department ? $department->name : 'None') . '". Consider updating the existing item instead.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'required|in:available,in_use,disposed,spoiled',
            'item_type' => 'required|in:consumable,non-consumable',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        \DB::transaction(function () use ($request) {
            $itemData = $request->only([
                'name', 'description', 'category_id', 'department_id', 'status', 'item_type', 'location'
            ]);
            $itemData['quantity'] = 0;
            $itemData['minimum_stock'] = 0;
            $itemData['unit'] = $request->input('unit', 'pcs');

            if ($request->hasFile('image')) {
                $itemData['image'] = $request->file('image')->store('item-images', 'public');
            }

            Item::create($itemData);
        });

        ActivityLog::log('created', Item::where('name', $request->name)->first());

        return redirect()->route('items.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Item "' . $request->name . '" created successfully.');
    }

    public function show(Item $item)
    {
        $item->load(['category', 'department', 'transactions.user']);
        
        // Get transactions ordered by most recent first
        $transactions = $item->transactions()
            ->with('user')
            ->orderBy('transaction_date', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('items.show', compact('item', 'transactions'));
    }

    public function edit(Item $item)
    {
        $categories = Category::where('is_active', true)->get();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        if ($item->trashed()) abort(403, 'This item is archived.');
        // Check for potential duplicate items (same name, category, and department, excluding current item)
        $existingItem = Item::where('name', $request->name)
            ->where('category_id', $request->category_id)
            ->where('department_id', $request->department_id)
            ->where('id', '!=', $item->id)
            ->first();
            
        if ($existingItem) {
            $category = Category::find($request->category_id);
            $department = \App\Models\Department::find($request->department_id);
            
            return redirect()->route('items.index', ['page' => $request->input('page', 1)])
                ->with('warning', 'An item named "' . $request->name . '" already exists in category "' . $category->name . '" and department "' . ($department ? $department->name : 'None') . '". Consider updating the existing item instead.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'required|in:available,in_use,disposed,spoiled',
            'item_type' => 'required|in:consumable,non-consumable',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Don't update quantity, minimum_stock, or unit_price - these are managed through batches
        $updateData = $request->only(['name', 'description', 'category_id', 'department_id', 'status', 'item_type', 'location', 'unit']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($item->image) {
                \Storage::disk('public')->delete($item->image);
            }
            $updateData['image'] = $request->file('image')->store('item-images', 'public');
        }

        // Capture original values BEFORE updating
        $originalValues = $item->only(array_keys($updateData));

        $item->update($updateData);

        ActivityLog::log('updated', $item, $originalValues, $updateData);

        return redirect()->route('items.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Item "' . $request->name . '" updated successfully.');
    }

    public function destroy(Request $request, Item $item)
    {
        if ($item->quantity > 0) {
            return redirect()->route('items.index', ['page' => $request->input('page', 1)])
                ->with('warning', 'Cannot archive "' . $item->name . '" — it still has ' . $item->quantity . ' ' . $item->unit . ' in stock. Deplete the stock first.');
        }

        if ($item->borrowed_quantity > 0) {
            return redirect()->route('items.index', ['page' => $request->input('page', 1)])
                ->with('warning', 'Cannot archive "' . $item->name . '" — ' . $item->borrowed_quantity . ' ' . $item->unit . ' are currently borrowed. Wait for them to be returned first.');
        }

        $itemName = $item->name;
        $item->delete();
        
        ActivityLog::log('archived', $item);
        
        return redirect()->route('items.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Item "' . $itemName . '" has been archived.');
    }

    public function archived()
    {
        $items = Item::onlyTrashed()->with(['category', 'department'])->latest('deleted_at')->paginate(15);
        return view('items.archived', compact('items'));
    }

    public function unarchive(int $id)
    {
        $item = Item::onlyTrashed()->findOrFail($id);
        $item->restore();
        
        ActivityLog::log('unarchived', $item);
        
        return redirect()->route('items.archived')
            ->with('success', 'Item "' . $item->name . '" has been restored to inventory.');
    }

    public function borrow(Item $item)
    {
        return view('items.borrow', compact('item'));
    }

    public function processBorrow(Request $request, Item $item)
    {
        if ($item->trashed()) abort(403, 'This item is archived.');
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $item->quantity,
            'notes' => 'nullable|string',
            'borrower_name' => 'required|string',
            'borrower_department' => 'required|string',
        ]);

        \DB::transaction(function () use ($request, $item) {
            $remainingQty = $request->quantity;
            $batches = $item->getAvailableBatches(); // FIFO/FEFO logic

            if ($batches->sum('quantity') < $remainingQty) {
                throw new \Exception('Not enough stock available in batches.');
            }

            foreach ($batches as $batch) {
                if ($remainingQty <= 0) break;

                $deductQty = min($batch->quantity, $remainingQty);

                // Create transaction record for this batch
                Transaction::create([
                    'item_id' => $item->id,
                    'batch_id' => $batch->id,
                    'user_id' => auth()->id(),
                    'type' => 'out',
                    'transaction_type' => 'borrow',
                    'quantity' => $deductQty,
                    'notes' => $request->notes,
                    'reference_number' => 'BOR-' . str_pad(Transaction::where('transaction_type', 'borrow')->count() + 1, 3, '0', STR_PAD_LEFT),
                    'transaction_date' => now(),
                ]);

                // Update or create borrowed item record per batch
                $borrowedItem = BorrowedItem::where('item_id', $item->id)
                    ->where('batch_id', $batch->id)
                    ->where('user_id', auth()->id())
                    ->first();

                if ($borrowedItem) {
                    $borrowedItem->increment('quantity', $deductQty);
                } else {
                    BorrowedItem::create([
                        'item_id' => $item->id,
                        'batch_id' => $batch->id,
                        'user_id' => auth()->id(),
                        'quantity' => $deductQty,
                        'borrower_name' => $request->borrower_name,
                        'borrower_department' => $request->borrower_department,
                        'notes' => $request->notes,
                        'reference_number' => 'BOR-' . str_pad(BorrowedItem::count() + 1, 3, '0', STR_PAD_LEFT),
                        'borrowed_at' => now(),
                    ]);
                }

                // Deduct from batch quantity
                $batch->decrement('quantity', $deductQty);
                $remainingQty -= $deductQty;
            }

            // Update item quantity
            $item->decrement('quantity', $request->quantity);

            // If all stock is now borrowed, mark as in_use
            $item->refresh();
            if ($item->quantity <= 0 && $item->status === 'available') {
                $item->update(['status' => 'in_use']);
            }
        });

        \App\Models\Notification::notifyAdmins(
            'new_borrow',
            'New Borrow: ' . $item->name,
            $request->borrower_name . ' borrowed ' . $request->quantity . ' ' . $item->unit,
            route('items.borrowed'),
            'borrow', 'blue',
            auth()->id()
        );

        // Check if item is now low stock and notify admins
        $item->refresh();
        if ($item->isLowStock()) {
            \App\Models\Notification::notifyAdmins(
                'low_stock',
                'Low Stock: ' . $item->name,
                $item->quantity . ' ' . $item->unit . ' remaining (min: ' . $item->minimum_stock . ')',
                route('items.show', $item),
                'warning', 'yellow', null, true
            );
        }

        return redirect()->route('items.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Item borrowed successfully by ' . $request->borrower_name . ' from ' . $request->borrower_department . '.');
    }

    /**
     * Process item replenishment
     */
    public function processReplenish(Request $request, Item $item)
    {
        if ($item->trashed()) abort(403, 'This item is archived.');
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        // Create replenish transaction for history
        Transaction::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'type' => 'in',
            'transaction_type' => 'replenish',
            'quantity' => $request->quantity,
            'notes' => $request->notes,
            'reference_number' => 'REP-' . str_pad(Transaction::where('transaction_type', 'replenish')->count() + 1, 3, '0', STR_PAD_LEFT),
            'transaction_date' => now(),
        ]);

        // Update item quantity
        $item->increment('quantity', $request->quantity);

        // If item was disposed or spoiled, mark as available now that stock is back
        $item->refresh();
        if (in_array($item->status, ['disposed', 'spoiled']) && $item->quantity > 0) {
            $item->update(['status' => 'available']);
        }

        return redirect()->route('items.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Item "' . $item->name . '" replenished successfully. Added ' . number_format($request->quantity) . ' ' . $item->unit . '.');
    }

    /**
     * Mark item for disposal
     */
    public function markDisposal(Request $request, Item $item)
    {
        if ($item->trashed()) abort(403, 'This item is archived.');
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'batch_id' => 'required|exists:batches,id',
            'notes' => 'required|string',
        ]);

        \DB::transaction(function () use ($request, $item) {
            $batch = \App\Models\Batch::findOrFail($request->batch_id);

            if ($request->quantity > $batch->quantity) {
                throw new \Exception('Not enough quantity in selected batch.');
            }

            // Create disposal transaction
            Transaction::create([
                'item_id' => $item->id,
                'batch_id' => $batch->id,
                'user_id' => auth()->id(),
                'type' => 'out',
                'transaction_type' => 'disposal',
                'quantity' => $request->quantity,
                'notes' => $request->notes . ' (Batch: ' . $batch->batch_number . ')',
                'reference_number' => 'DIS-' . str_pad(Transaction::where('transaction_type', 'disposal')->count() + 1, 3, '0', STR_PAD_LEFT),
                'transaction_date' => now(),
            ]);

            // Deduct from batch quantity
            $batch->decrement('quantity', $request->quantity);

            // Update item quantity
            $item->decrement('quantity', $request->quantity);

            // If quantity hits 0 and nothing is borrowed, mark as disposed
            $item->refresh();
            $borrowedCount = \App\Models\BorrowedItem::where('item_id', $item->id)->sum('quantity');
            if ($item->quantity <= 0) {
                $item->update([
                    'status'   => $borrowedCount > 0 ? 'in_use' : 'disposed',
                    'quantity' => 0,
                ]);
            }
        });

        return redirect()->route('items.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Item marked for disposal successfully.');
    }

    public function return(Request $request, Item $item)
    {
        // Get borrowed quantity that hasn't been returned yet by the current user
        $borrowedQuantity = $this->getBorrowedQuantityByUser($item, auth()->id());
        
        if ($borrowedQuantity <= 0) {
            return redirect()->route('items.index', ['page' => $request->input('page', 1)])
                ->with('error', 'You have no borrowed items of this type to return.');
        }
        
        return view('items.return', compact('item', 'borrowedQuantity'));
    }

    public function processReturn(Request $request, Item $item)
    {
        $borrowedQuantity = $this->getBorrowedQuantityByUser($item, auth()->id());
        
        if ($borrowedQuantity <= 0) {
            return redirect()->route('items.index', ['page' => $request->input('page', 1)])
                ->with('error', 'You have no borrowed items of this type to return.');
        }
        
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $borrowedQuantity,
            'notes' => 'nullable|string',
        ]);

        \DB::transaction(function () use ($request, $item) {
            $remainingQty = $request->quantity;

            // Get borrowed items by user, ordered by oldest first
            $borrowedItems = BorrowedItem::where('item_id', $item->id)
                ->where('user_id', auth()->id())
                ->orderBy('borrowed_at', 'asc')
                ->get();

            foreach ($borrowedItems as $borrowedItem) {
                if ($remainingQty <= 0) break;

                $returnQty = min($borrowedItem->quantity, $remainingQty);

                // Create return transaction
                Transaction::create([
                    'item_id' => $item->id,
                    'batch_id' => $borrowedItem->batch_id,
                    'user_id' => auth()->id(),
                    'type' => 'in',
                    'transaction_type' => 'return',
                    'quantity' => $returnQty,
                    'notes' => $request->notes,
                    'reference_number' => 'RET-' . str_pad(Transaction::where('transaction_type', 'return')->count() + 1, 3, '0', STR_PAD_LEFT),
                    'transaction_date' => now(),
                ]);

                // Return quantity to original batch
                $batch = $borrowedItem->batch;
                if ($batch) {
                    $batch->increment('quantity', $returnQty);
                }

                // Update borrowed item record
                if ($borrowedItem->quantity <= $returnQty) {
                    $borrowedItem->delete();
                } else {
                    $borrowedItem->decrement('quantity', $returnQty);
                }

                $remainingQty -= $returnQty;
            }

            // Update item quantity
            $item->increment('quantity', $request->quantity);

            // If item was in_use, mark back as available now that stock returned
            $item->refresh();
            if ($item->status === 'in_use' && $item->quantity > 0) {
                $item->update(['status' => 'available']);
            }
            if ($item->status === 'in_use' && $item->quantity <= 0) {
                $item->update(['status' => 'disposed']);
            }
        });

        \App\Models\Notification::notifyAdmins(
            'item_returned',
            'Item Returned: ' . $item->name,
            auth()->user()->name . ' returned ' . $request->quantity . ' ' . $item->unit,
            route('items.borrowed'),
            'borrow', 'blue',
            auth()->id()
        );

        return redirect()->route('items.index', ['page' => $request->input('page', 1)])
            ->with('success', 'Item returned successfully.');
    }

    /**
     * Get the quantity of items currently borrowed (not yet returned)
     */
    private function getBorrowedQuantity(Item $item)
    {
        return BorrowedItem::where('item_id', $item->id)->sum('quantity');
    }

    /**
     * Get the quantity of items currently borrowed by a specific user (not yet returned)
     */
    private function getBorrowedQuantityByUser(Item $item, $userId)
    {
        return BorrowedItem::where('item_id', $item->id)
            ->where('user_id', $userId)
            ->sum('quantity');
    }

    /**
     * Show currently borrowed items — all for admin, own only for staff
     */
    public function borrowedItems()
    {
        $query = BorrowedItem::with(['item.category', 'user', 'batch'])
            ->orderBy('borrowed_at', 'desc');

        // Staff only see their own borrowed items
        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $borrowedItems = $query->get()->map(function ($borrowedItem) {
                return (object)[
                    'item' => $borrowedItem->item,
                    'user' => $borrowedItem->user,
                    'batch' => $borrowedItem->batch,
                    'quantity_borrowed' => $borrowedItem->quantity,
                    'borrowed_date' => $borrowedItem->borrowed_at,
                    'borrower_name' => $borrowedItem->borrower_name,
                    'borrower_department' => $borrowedItem->borrower_department,
                    'notes' => $borrowedItem->notes,
                    'reference_number' => $borrowedItem->reference_number,
                ];
            });

        return view('items.borrowed', compact('borrowedItems'));
    }

    /**
     * Automatically process expired consumable batches
     */
    private function processExpiredConsumables()
    {
        // Get all expired batches for consumable items that are still marked as active
        $expiredBatches = \App\Models\Batch::where('status', 'active')
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

    /**
     * Get available batches for an item (AJAX endpoint for disposal modal)
     */
    public function getBatches(Item $item)
    {
        $batches = $item->batches()
            ->where('quantity', '>', 0)
            ->where('status', 'active')
            ->select('id', 'batch_number', 'quantity', 'expiry_date', 'location')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function($batch) {
                return [
                    'id' => $batch->id,
                    'batch_number' => $batch->batch_number,
                    'quantity' => $batch->quantity,
                    'expiry_date' => $batch->expiry_date ? $batch->expiry_date->format('Y-m-d') : null,
                    'location' => $batch->location,
                ];
            });

        return response()->json($batches);
    }

    /**
     * Get batches that will be used for borrowing (with FIFO/FEFO order)
     */
    public function getBorrowBatches(Item $item, Request $request)
    {
        $quantity = $request->input('quantity', 0);
        
        // Get batches in FIFO/FEFO order
        $batches = $item->getAvailableBatches();
        
        $selectedBatches = [];
        $remainingQty = $quantity;
        
        foreach ($batches as $batch) {
            if ($remainingQty <= 0) break;
            
            $takeQty = min($batch->quantity, $remainingQty);
            
            $selectedBatches[] = [
                'batch_number' => $batch->batch_number,
                'location' => $batch->location ?? 'Not specified',
                'quantity' => $takeQty,
                'available' => $batch->quantity,
                'expiry_date' => $batch->expiry_date ? $batch->expiry_date->format('M d, Y') : null,
            ];
            
            $remainingQty -= $takeQty;
        }
        
        return response()->json([
            'batches' => $selectedBatches,
            'total' => $quantity,
            'feasible' => $remainingQty <= 0,
        ]);
    }

    /**
     * Get batches that items will be returned to
     */
    public function getReturnBatches(Item $item, Request $request)
    {
        $quantity = $request->input('quantity', 0);
        $userId = auth()->id();
        
        // Get borrowed items by user, ordered by oldest first
        $borrowedItems = BorrowedItem::where('item_id', $item->id)
            ->where('user_id', $userId)
            ->with('batch')
            ->orderBy('borrowed_at', 'asc')
            ->get();
        
        $returnBatches = [];
        $remainingQty = $quantity;
        
        foreach ($borrowedItems as $borrowedItem) {
            if ($remainingQty <= 0) break;
            
            $returnQty = min($borrowedItem->quantity, $remainingQty);
            
            if ($borrowedItem->batch) {
                $returnBatches[] = [
                    'batch_number' => $borrowedItem->batch->batch_number,
                    'location' => $borrowedItem->batch->location ?? 'Not specified',
                    'quantity' => $returnQty,
                    'borrowed' => $borrowedItem->quantity,
                    'borrowed_at' => $borrowedItem->borrowed_at->format('M d, Y'),
                    'expiry_date' => $borrowedItem->batch->expiry_date ? $borrowedItem->batch->expiry_date->format('M d, Y') : null,
                ];
            }
            
            $remainingQty -= $returnQty;
        }
        
        return response()->json([
            'batches' => $returnBatches,
            'total' => $quantity,
        ]);
    }
}
