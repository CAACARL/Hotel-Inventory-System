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
        $recentTransactions = \App\Models\Transaction::with(['item', 'user'])
            ->latest()
            ->take(10)
            ->get();
        
        $lowStockItemsList = \App\Models\Item::with('category')
            ->lowStock()
            ->take(5)
            ->get();

        return view('dashboard', compact(
            'totalItems',
            'totalCategories', 
            'lowStockItems',
            'recentTransactions',
            'lowStockItemsList'
        ));
    }
}
