<!-- Quick Stats Overview -->
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <!-- Total Inventory Value -->
    <div class="dashboard-card p-6 bg-gradient-to-br from-emerald-500 to-teal-600 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center shadow-lg backdrop-blur-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                    </svg>
                </div>
                <div class="flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur-sm">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                    </svg>
                    Assets
                </div>
            </div>
            <p class="text-emerald-100 text-sm font-medium mb-1">Total Asset Value</p>
            <p class="text-4xl font-bold mb-2">₱{{ number_format($totalInventoryValue, 0) }}</p>
            <p class="text-emerald-200 text-xs">Current book value of inventory</p>
        </div>
    </div>

    <!-- Total Items -->
    <div class="dashboard-card p-6 bg-gradient-to-br from-blue-500 to-indigo-600 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center shadow-lg backdrop-blur-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                </div>
                <div class="flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur-sm">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    Active
                </div>
            </div>
            <p class="text-blue-100 text-sm font-medium mb-1">Items Managed</p>
            <p class="text-4xl font-bold mb-2">{{ number_format($totalItems) }}</p>
            <p class="text-blue-200 text-xs">Total items in inventory system</p>
        </div>
    </div>

    <!-- Categories -->
    <div class="dashboard-card p-6 bg-gradient-to-br from-purple-500 to-pink-600 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center shadow-lg backdrop-blur-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                <div class="flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur-sm">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                    </svg>
                    Groups
                </div>
            </div>
            <p class="text-purple-100 text-sm font-medium mb-1">Categories</p>
            <p class="text-4xl font-bold mb-2">{{ $totalCategories }}</p>
            <p class="text-purple-200 text-xs">Active classification groups</p>
        </div>
    </div>

    <!-- Borrowed Items -->
    <div class="dashboard-card p-6 bg-gradient-to-br from-orange-500 to-red-600 text-white relative overflow-hidden">
        <div class="absolute top-0 right-0 w-32 h-32 bg-white/10 rounded-full -mr-16 -mt-16"></div>
        <div class="relative">
            <div class="flex items-center justify-between mb-4">
                <div class="w-14 h-14 bg-white bg-opacity-20 rounded-xl flex items-center justify-center shadow-lg backdrop-blur-sm">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                </div>
                @if($totalBorrowedItems > 0)
                    <div class="flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur-sm animate-pulse">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Out
                    </div>
                @else
                    <div class="flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-white/20 backdrop-blur-sm">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Clear
                    </div>
                @endif
            </div>
            <p class="text-orange-100 text-sm font-medium mb-1">Items Out</p>
            <p class="text-4xl font-bold mb-2">{{ $totalBorrowedItems }}</p>
            <p class="text-orange-200 text-xs">{{ $totalBorrowedItems > 0 ? 'Currently borrowed by users' : 'All items returned' }}</p>
        </div>
    </div>
</div>
