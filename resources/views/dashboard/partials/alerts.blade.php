<!-- Low Stock Alert -->
@if($lowStockItems > 0)
<div class="dashboard-card p-6 bg-gradient-to-br from-red-50 to-orange-50 border-red-200 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-500/10 to-transparent rounded-full -mr-16 -mt-16"></div>
    <div class="relative">
        <div class="flex items-center mb-5">
            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center mr-3 shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-red-800 text-lg">Low Stock Alert</h4>
                <p class="text-red-600 text-sm font-medium">{{ $lowStockItems }} items need attention</p>
            </div>
        </div>
        <div class="space-y-2">
            @foreach($lowStockItemsList as $item)
            <div class="flex items-center justify-between p-3 bg-white rounded-xl border border-red-100 hover:border-red-300 transition-all duration-200 hover:shadow-md">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-900 text-sm truncate">{{ $item->name }}</p>
                    <p class="text-xs text-gray-600">{{ $item->category->name }}</p>
                </div>
                <div class="text-right ml-3">
                    <p class="text-sm font-bold text-red-600">{{ $item->quantity }}</p>
                    <p class="text-xs text-gray-500">left</p>
                </div>
            </div>
            @endforeach
        </div>
        <a href="{{ route('items.index') }}?filter=low_stock" class="block mt-4 text-center bg-gradient-to-r from-red-600 to-red-700 text-white py-2.5 px-4 rounded-xl hover:from-red-700 hover:to-red-800 transition-all duration-200 text-sm font-semibold shadow-lg hover:shadow-xl transform hover:scale-105">
            View All Low Stock Items
        </a>
    </div>
</div>
@endif

<!-- Currently Borrowed Items -->
@if($borrowedItemsList->count() > 0)
<div class="dashboard-card p-6 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-orange-500/5 to-transparent rounded-full -mr-16 -mt-16"></div>
    <div class="relative">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="font-bold text-gray-900 text-lg">Items Out</h4>
                    <p class="text-gray-600 text-sm">Currently borrowed</p>
                </div>
            </div>
            <a href="{{ route('items.borrowed') }}" class="flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-orange-50 to-red-50 text-orange-700 border border-orange-200 hover:shadow-md transition-all duration-200">
                View All
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
        </div>
        <div class="space-y-2">
            @foreach($borrowedItemsList as $item)
            <div class="flex items-center justify-between p-3 bg-gradient-to-r from-gray-50 to-white rounded-xl border border-gray-100 hover:border-orange-200 transition-all duration-200 hover:shadow-md">
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-900 text-sm truncate">{{ $item->name }}</p>
                    <p class="text-xs text-gray-600">{{ $item->category->name }}</p>
                </div>
                <div class="text-right ml-3">
                    <p class="text-sm font-bold text-orange-600">{{ $item->borrowed_quantity }}</p>
                    <p class="text-xs text-gray-500">out</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
@endif

<!-- Quick Actions -->
<div class="dashboard-card p-6 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-blue-500/5 to-transparent rounded-full -mr-16 -mt-16"></div>
    <div class="relative">
        <div class="flex items-center space-x-3 mb-5">
            <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <div>
                <h4 class="font-bold text-gray-900 text-lg">Quick Actions</h4>
                <p class="text-gray-600 text-sm">Common tasks</p>
            </div>
        </div>
        <div class="space-y-2">
            <a href="{{ route('items.index') }}" class="flex items-center p-3 bg-gradient-to-r from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 rounded-xl transition-all duration-200 group border border-green-100 hover:border-green-300 hover:shadow-md">
                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200 shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">Browse Items</p>
                    <p class="text-xs text-gray-600">View all inventory</p>
                </div>
            </a>
            
            @if(auth()->user()->isAdmin())
            <a href="{{ route('transactions.index') }}" class="flex items-center p-3 bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 rounded-xl transition-all duration-200 group border border-blue-100 hover:border-blue-300 hover:shadow-md">
                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200 shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">View Transactions</p>
                    <p class="text-xs text-gray-600">Activity history</p>
                </div>
            </a>
            @endif

            @if(auth()->user()->isAdmin())
            <a href="{{ route('reports') }}" class="flex items-center p-3 bg-gradient-to-r from-purple-50 to-pink-50 hover:from-purple-100 hover:to-pink-100 rounded-xl transition-all duration-200 group border border-purple-100 hover:border-purple-300 hover:shadow-md">
                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-600 rounded-lg flex items-center justify-center mr-3 group-hover:scale-110 transition-transform duration-200 shadow-md">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 text-sm">View Reports</p>
                    <p class="text-xs text-gray-600">Analytics dashboard</p>
                </div>
            </a>
            @endif
        </div>
    </div>
</div>
