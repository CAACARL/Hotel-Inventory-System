<!-- Low Stock Alert -->
@if($lowStockItems > 0)
<div class="dashboard-card p-6 bg-gradient-to-br from-red-50 to-orange-50 border-red-200">
    <div class="flex items-center mb-4">
        <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center mr-3">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
        </div>
        <div>
            <h4 class="font-bold text-red-800">Low Stock Alert</h4>
            <p class="text-red-600 text-sm">{{ $lowStockItems }} items need attention</p>
        </div>
    </div>
    <div class="space-y-2">
        @foreach($lowStockItemsList as $item)
        <div class="flex items-center justify-between p-2 bg-white rounded-lg">
            <div>
                <p class="font-medium text-gray-900 text-sm">{{ $item->name }}</p>
                <p class="text-xs text-gray-600">{{ $item->category->name }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-bold text-red-600">{{ $item->quantity }}</p>
                <p class="text-xs text-gray-500">left</p>
            </div>
        </div>
        @endforeach
    </div>
    <a href="{{ route('items.index') }}?filter=low_stock" class="block mt-4 text-center bg-red-600 text-white py-2 px-4 rounded-lg hover:bg-red-700 transition-colors text-sm font-medium">
        View All Low Stock Items
    </a>
</div>
@endif

<!-- Currently Borrowed Items -->
@if($borrowedItemsList->count() > 0)
<div class="dashboard-card p-6">
    <div class="flex items-center justify-between mb-4">
        <div>
            <h4 class="font-bold text-gray-900">Items Out</h4>
            <p class="text-gray-600 text-sm">Currently borrowed</p>
        </div>
        <a href="{{ route('items.borrowed') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">View All</a>
    </div>
    <div class="space-y-3">
        @foreach($borrowedItemsList as $item)
        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
            <div>
                <p class="font-medium text-gray-900 text-sm">{{ $item->name }}</p>
                <p class="text-xs text-gray-600">{{ $item->category->name }}</p>
            </div>
            <div class="text-right">
                <p class="text-sm font-bold text-orange-600">{{ $item->borrowed_quantity }}</p>
                <p class="text-xs text-gray-500">out</p>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endif

<!-- Quick Actions -->
<div class="dashboard-card p-6">
    <h4 class="font-bold text-gray-900 mb-4">Quick Actions</h4>
    <div class="space-y-3">
        <a href="{{ route('items.index') }}" class="flex items-center p-3 bg-green-50 hover:bg-green-100 rounded-lg transition-colors group">
            <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-green-600 transition-colors">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
            </div>
            <div>
                <p class="font-medium text-gray-900">Browse Items</p>
                <p class="text-xs text-gray-600">View all inventory</p>
            </div>
        </a>
        
        @if(auth()->user()->isAdmin())
        <a href="{{ route('transactions.index') }}" class="flex items-center p-3 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors group">
            <div class="w-8 h-8 bg-blue-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-blue-600 transition-colors">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
            </div>
            <div>
                <p class="font-medium text-gray-900">View Transactions</p>
                <p class="text-xs text-gray-600">Activity history</p>
            </div>
        </a>
        @endif

        @if(auth()->user()->isAdmin())
        <a href="{{ route('reports') }}" class="flex items-center p-3 bg-purple-50 hover:bg-purple-100 rounded-lg transition-colors group">
            <div class="w-8 h-8 bg-purple-500 rounded-lg flex items-center justify-center mr-3 group-hover:bg-purple-600 transition-colors">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                </svg>
            </div>
            <div>
                <p class="font-medium text-gray-900">View Reports</p>
                <p class="text-xs text-gray-600">Analytics dashboard</p>
            </div>
        </a>
        @endif
    </div>
</div>
