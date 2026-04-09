<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\BorrowedItem;

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

            return redirect()->route('items.index')
                ->with('warning', 'An item named "' . $request->name . '" already exists in category "' . $category->name . '" and department "' . ($department ? $department->name : 'None') . '". Consider updating the existing item instead.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'required|in:available,in_use,damaged,disposed,spoiled',
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
            $itemData['unit'] = 'pcs';

            if ($request->hasFile('image')) {
                $itemData['image'] = $request->file('image')->store('item-images', 'public');
            }

            Item::create($itemData);
        });

        return redirect()->route('items.index')
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
        // Check for potential duplicate items (same name, category, and department, excluding current item)
        $existingItem = Item::where('name', $request->name)
            ->where('category_id', $request->category_id)
            ->where('department_id', $request->department_id)
            ->where('id', '!=', $item->id)
            ->first();
            
        if ($existingItem) {
            $category = Category::find($request->category_id);
            $department = \App\Models\Department::find($request->department_id);
            
            return redirect()->route('items.index')
                ->with('warning', 'An item named "' . $request->name . '" already exists in category "' . $category->name . '" and department "' . ($department ? $department->name : 'None') . '". Consider updating the existing item instead.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'department_id' => 'nullable|exists:departments,id',
            'status' => 'required|in:available,in_use,damaged,disposed,spoiled',
            'item_type' => 'required|in:consumable,non-consumable',
            'location' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        // Don't update quantity, minimum_stock, unit, or unit_price - these are managed through batches
        $updateData = $request->only(['name', 'description', 'category_id', 'department_id', 'status', 'item_type', 'location']);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($item->image) {
                \Storage::disk('public')->delete($item->image);
            }
            $updateData['image'] = $request->file('image')->store('item-images', 'public');
        }

        $item->update($updateData);

        return redirect()->route('items.index')
            ->with('success', 'Item "' . $request->name . '" updated successfully.');
    }

    public function destroy(Item $item)
    {
        $itemName = $item->name;
        $item->delete();
        return redirect()->route('items.index')
            ->with('success', 'Item "' . $itemName . '" deleted successfully.');
    }

    public function borrow(Item $item)
    {
        return view('items.borrow', compact('item'));
    }

    public function processBorrow(Request $request, Item $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $item->quantity,
            'notes' => 'nullable|string',
            'borrower_name' => 'required|string',
            'borrower_department' => 'required|string',
        ]);

        // Create transaction record for history
        Transaction::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'type' => 'out',
            'transaction_type' => 'borrow',
            'quantity' => $request->quantity,
            'notes' => $request->notes,
            'borrower_name' => $request->borrower_name,
            'borrower_department' => $request->borrower_department,
            'reference_number' => 'BOR-' . str_pad(Transaction::where('transaction_type', 'borrow')->count() + 1, 3, '0', STR_PAD_LEFT),
            'transaction_date' => now(),
        ]);

        // Update or create borrowed item record
        $borrowedItem = BorrowedItem::where('item_id', $item->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($borrowedItem) {
            // User already has this item borrowed, increase quantity
            $borrowedItem->increment('quantity', $request->quantity);
        } else {
            // Create new borrowed item record
            BorrowedItem::create([
                'item_id' => $item->id,
                'user_id' => auth()->id(),
                'quantity' => $request->quantity,
                'borrower_name' => $request->borrower_name,
                'borrower_department' => $request->borrower_department,
                'notes' => $request->notes,
                'reference_number' => 'BOR-' . str_pad(BorrowedItem::count() + 1, 3, '0', STR_PAD_LEFT),
                'borrowed_at' => now(),
            ]);
        }

        // Update item quantity
        $item->decrement('quantity', $request->quantity);

        // Notify admins of new borrow (exclude the borrower if they are admin)
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

        return redirect()->route('items.index')
            ->with('success', 'Item borrowed successfully by ' . $request->borrower_name . ' from ' . $request->borrower_department . '.');
    }

    /**
     * Process item replenishment
     */
    public function processReplenish(Request $request, Item $item)
    {
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

        // If item was out of stock, mark as available
        if ($item->status === 'disposed' && $item->quantity > 0) {
            $item->update(['status' => 'available']);
        }

        return redirect()->route('items.index')
            ->with('success', 'Item "' . $item->name . '" replenished successfully. Added ' . number_format($request->quantity) . ' ' . $item->unit . '.');
    }

    /**
     * Mark item as recovered (from damaged status)
     */
    public function markRecovered(Request $request, Item $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'notes' => 'nullable|string',
        ]);

        // Create recovered transaction
        Transaction::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'type' => 'in',
            'transaction_type' => 'recovered',
            'quantity' => $request->quantity,
            'notes' => $request->notes,
            'reference_number' => 'REC-' . str_pad(Transaction::where('transaction_type', 'recovered')->count() + 1, 3, '0', STR_PAD_LEFT),
            'transaction_date' => now(),
        ]);

        // Update item quantity and status
        $item->increment('quantity', $request->quantity);
        if ($item->status === 'damaged') {
            $item->update(['status' => 'available']);
        }

        return redirect()->route('items.index')
            ->with('success', 'Item marked as recovered successfully.');
    }

    /**
     * Mark item for disposal
     */
    public function markDisposal(Request $request, Item $item)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $item->quantity,
            'notes' => 'required|string',
        ]);

        // Create disposal transaction
        Transaction::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'type' => 'out',
            'transaction_type' => 'disposal',
            'quantity' => $request->quantity,
            'notes' => $request->notes,
            'reference_number' => 'DIS-' . str_pad(Transaction::where('transaction_type', 'disposal')->count() + 1, 3, '0', STR_PAD_LEFT),
            'transaction_date' => now(),
        ]);

        // Update item quantity
        $item->decrement('quantity', $request->quantity);
        
        // If all quantity disposed, mark as disposed
        if ($item->quantity == 0) {
            $item->update(['status' => 'disposed']);
        }

        return redirect()->route('items.index')
            ->with('success', 'Item marked for disposal successfully.');
    }

    public function return(Item $item)
    {
        // Get borrowed quantity that hasn't been returned yet by the current user
        $borrowedQuantity = $this->getBorrowedQuantityByUser($item, auth()->id());
        
        if ($borrowedQuantity <= 0) {
            return redirect()->route('items.index')
                ->with('error', 'You have no borrowed items of this type to return.');
        }
        
        return view('items.return', compact('item', 'borrowedQuantity'));
    }

    public function processReturn(Request $request, Item $item)
    {
        $borrowedQuantity = $this->getBorrowedQuantityByUser($item, auth()->id());
        
        if ($borrowedQuantity <= 0) {
            return redirect()->route('items.index')
                ->with('error', 'You have no borrowed items of this type to return.');
        }
        
        $request->validate([
            'quantity' => 'required|integer|min:1|max:' . $borrowedQuantity,
            'notes' => 'nullable|string',
        ]);

        // Create return transaction for history
        Transaction::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'type' => 'in',
            'transaction_type' => 'return',
            'quantity' => $request->quantity,
            'notes' => $request->notes,
            'reference_number' => 'RET-' . str_pad(Transaction::where('transaction_type', 'return')->count() + 1, 3, '0', STR_PAD_LEFT),
            'transaction_date' => now(),
        ]);

        // Update borrowed item record
        $borrowedItem = BorrowedItem::where('item_id', $item->id)
            ->where('user_id', auth()->id())
            ->first();

        if ($borrowedItem) {
            if ($borrowedItem->quantity <= $request->quantity) {
                // Returning all or more than borrowed, delete the record
                $borrowedItem->delete();
            } else {
                // Returning partial quantity, decrease the borrowed amount
                $borrowedItem->decrement('quantity', $request->quantity);
            }
        }

        // Update item quantity
        $item->increment('quantity', $request->quantity);

        // Notify admins of return (exclude the returner if they are admin)
        \App\Models\Notification::notifyAdmins(
            'item_returned',
            'Item Returned: ' . $item->name,
            auth()->user()->name . ' returned ' . $request->quantity . ' ' . $item->unit,
            route('items.borrowed'),
            'borrow', 'blue',
            auth()->id()
        );

        return redirect()->route('items.index')
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
        $borrowedItem = BorrowedItem::where('item_id', $item->id)
            ->where('user_id', $userId)
            ->first();
            
        return $borrowedItem ? $borrowedItem->quantity : 0;
    }

    /**
     * Show currently borrowed items — all for admin, own only for staff
     */
    public function borrowedItems()
    {
        $query = BorrowedItem::with(['item.category', 'user'])
            ->orderBy('borrowed_at', 'desc');

        // Staff only see their own borrowed items
        if (!auth()->user()->isAdmin()) {
            $query->where('user_id', auth()->id());
        }

        $borrowedItems = $query->get()->map(function ($borrowedItem) {
                return (object)[
                    'item' => $borrowedItem->item,
                    'user' => $borrowedItem->user,
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
}
