<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Item;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Transaction::with(['item' => function ($q) {
            $q->withTrashed()->with('category');
        }, 'user', 'batch']);

        if (auth()->user()->isStaff()) {
            $query->where('user_id', auth()->id());
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('item', fn($i) => $i->where('name', 'like', "%{$search}%"))
                  ->orWhere('reference_number', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->where('transaction_type', $request->type);
        }

        $transactions = $query->orderBy('transaction_date', 'desc')
            ->paginate(15)
            ->appends($request->query());

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        // If user is staff, only allow viewing their own transactions
        if (auth()->user()->isStaff() && $transaction->user_id !== auth()->id()) {
            abort(403, 'You can only view your own transactions.');
        }

        $transaction->load(['item' => function ($q) {
            $q->withTrashed()->with('category');
        }, 'user', 'batch']);
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Display reports page.
     */
    public function reports()
    {
        $totalTransactions = Transaction::count();
        $totalItems = Item::count();

        // Calculate transaction growth (this month vs last month)
        $thisMonthTransactions = Transaction::whereMonth('transaction_date', now()->month)
            ->whereYear('transaction_date', now()->year)
            ->count();
        $lastMonthTransactions = Transaction::whereMonth('transaction_date', now()->subMonth()->month)
            ->whereYear('transaction_date', now()->subMonth()->year)
            ->count();
        $transactionGrowth = $lastMonthTransactions > 0 
            ? round((($thisMonthTransactions - $lastMonthTransactions) / $lastMonthTransactions) * 100, 1)
            : 0;

        // Calculate items growth (current vs 30 days ago)
        $itemsThirtyDaysAgo = Transaction::where('transaction_type', 'replenish')
            ->where('transaction_date', '<', now()->subDays(30))
            ->count();
        $itemsGrowth = $itemsThirtyDaysAgo > 0
            ? round((($totalItems - $itemsThirtyDaysAgo) / $itemsThirtyDaysAgo) * 100, 1)
            : 0;

        // Sum current book value across all active batches that have depreciation set
        $totalValue = \App\Models\Batch::where('status', 'active')
            ->whereNotNull('purchase_price')
            ->get()
            ->sum(fn($batch) => ($batch->getCurrentBookValue() ?? 0) * $batch->quantity)
            // Add items with unit_price but no batch depreciation
            + Item::whereNotNull('unit_price')
                ->get()
                ->sum(fn($item) => $item->unit_price * $item->quantity);

        $lowStockItems = Item::lowStock()->count();
        $lowStockPercentage = $totalItems > 0 ? round(($lowStockItems / $totalItems) * 100, 1) : 0;

        $recentTransactions = Transaction::with(['item' => fn($q) => $q->withTrashed()->with('category'), 'user'])
            ->orderBy('transaction_date', 'desc')
            ->limit(10)
            ->get();

        $transactionsByType = Transaction::selectRaw('transaction_type, COUNT(*) as count')
            ->groupBy('transaction_type')
            ->get();

        $transactionsByMonth = Transaction::selectRaw('DATE_FORMAT(transaction_date, "%Y-%m") as month, COUNT(*) as count')
            ->where('transaction_date', '>=', now()->subMonths(12))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $transactionsByDay = Transaction::selectRaw('DATE(transaction_date) as date, COUNT(*) as count')
            ->where('transaction_date', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $itemsByCategory = Item::selectRaw('categories.name as category, COUNT(*) as count, SUM(items.quantity) as total_quantity')
            ->join('categories', 'items.category_id', '=', 'categories.id')
            ->groupBy('categories.id', 'categories.name')
            ->get();

        $stockStatus = [
            'in_stock' => Item::where('quantity', '>', 0)->whereRaw('quantity > minimum_stock')->count(),
            'low_stock' => Item::lowStock()->where('quantity', '>', 0)->count(),
            'out_of_stock' => Item::where('quantity', 0)->count(),
        ];

        $topBorrowedItems = Transaction::selectRaw('transactions.item_id, items.name, COUNT(*) as borrow_count, SUM(transactions.quantity) as total_borrowed')
            ->join('items', 'transactions.item_id', '=', 'items.id')
            ->where('transaction_type', 'borrow')
            ->groupBy('transactions.item_id', 'items.name')
            ->orderBy('total_borrowed', 'desc')
            ->limit(5)
            ->get();

        $userActivity = Transaction::selectRaw('users.name, COUNT(*) as transaction_count')
            ->join('users', 'transactions.user_id', '=', 'users.id')
            ->groupBy('users.id', 'users.name')
            ->orderBy('transaction_count', 'desc')
            ->limit(5)
            ->get();

        return view('transactions.reports', compact(
            'totalTransactions',
            'transactionGrowth',
            'totalItems',
            'itemsGrowth',
            'totalValue',
            'lowStockItems',
            'lowStockPercentage',
            'recentTransactions',
            'transactionsByType',
            'transactionsByMonth',
            'transactionsByDay',
            'itemsByCategory',
            'stockStatus',
            'topBorrowedItems',
            'userActivity'
        ));
    }

    /**
     * Clear all transaction history (Admin only)
     */
    public function clearHistory(Request $request)
    {
        if (!auth()->user()->isAdmin()) {
            return redirect()->route('reports')
                ->with('error', 'Only administrators can clear transaction history.');
        }

        $transactionCount = Transaction::count();

        if ($transactionCount === 0) {
            return redirect()->route('reports')
                ->with('warning', 'Transaction history is already empty. No data to clear.');
        }

        $request->validate([
            'confirmation' => 'required|in:CLEAR_ALL_TRANSACTIONS'
        ], [
            'confirmation.required' => 'You must type the confirmation text to proceed.',
            'confirmation.in' => 'The confirmation text must match exactly: CLEAR_ALL_TRANSACTIONS'
        ]);

        try {
            Transaction::truncate();

            return redirect()->route('reports')
                ->with('success', 'Transaction history cleared successfully. ' . number_format($transactionCount) . ' transactions were permanently deleted. Borrowed items tracking remains intact.');

        } catch (\Exception $e) {
            return redirect()->route('reports')
                ->with('error', 'Failed to clear transaction history: ' . $e->getMessage());
        }
    }
}
