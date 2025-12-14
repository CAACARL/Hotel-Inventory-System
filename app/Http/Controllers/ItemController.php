<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Models\Transaction;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $query = Item::with('category');
        
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
        
        $items = $query->paginate(15)->appends($request->query());
        return view('items.index', compact('items'));
    }

    public function create()
    {
        $categories = Category::where('is_active', true)->get();
        return view('items.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'status' => 'required|in:available,in_use,damaged,disposed',
            'location' => 'nullable|string|max:255',
            'unit_price' => 'nullable|numeric|min:0',
        ]);

        Item::create($request->all());

        return redirect()->route('items.index')
            ->with('success', 'Item created successfully.');
    }

    public function show(Item $item)
    {
        $item->load(['category', 'transactions.user']);
        return view('items.show', compact('item'));
    }

    public function edit(Item $item)
    {
        $categories = Category::where('is_active', true)->get();
        return view('items.edit', compact('item', 'categories'));
    }

    public function update(Request $request, Item $item)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:categories,id',
            'quantity' => 'required|integer|min:0',
            'minimum_stock' => 'required|integer|min:0',
            'unit' => 'required|string|max:50',
            'status' => 'required|in:available,in_use,damaged,disposed',
            'location' => 'nullable|string|max:255',
            'unit_price' => 'nullable|numeric|min:0',
        ]);

        $item->update($request->all());

        return redirect()->route('items.index')
            ->with('success', 'Item updated successfully.');
    }

    public function destroy(Item $item)
    {
        $item->delete();
        return redirect()->route('items.index')
            ->with('success', 'Item deleted successfully.');
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
        ]);

        // Create transaction
        Transaction::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'type' => 'out',
            'transaction_type' => 'borrow',
            'quantity' => $request->quantity,
            'notes' => $request->notes,
            'transaction_date' => now(),
        ]);

        // Update item quantity
        $item->decrement('quantity', $request->quantity);

        return redirect()->route('items.index')
            ->with('success', 'Item borrowed successfully.');
    }
}
