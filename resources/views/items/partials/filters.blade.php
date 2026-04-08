<!-- Search and Filter Buttons -->
<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6 sm:mb-8">
    <div class="flex flex-wrap gap-2 sm:gap-4">
        <button @click="searchModal = true" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold" style="border: 1px solid #D4AF37; color: #3D2914;">
            <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <span class="hidden sm:inline">Search Items</span>
        </button>
        <a href="{{ route('items.index', ['filter' => 'low_stock']) }}" 
            class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-amber-100 border border-amber-300 rounded-xl text-amber-700 hover:bg-amber-200 transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold">
            <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            <span class="hidden sm:inline">Low Stock</span>
            <span class="sm:hidden">Low</span>
        </a>
        <a href="{{ route('items.index') }}" 
            class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-gray-100 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-200 transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold">
            <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
            </svg>
            <span class="hidden sm:inline">All Items</span>
            <span class="sm:hidden">All</span>
        </a>
    </div>
    @if(request('search'))
        <div class="text-sm text-gray-600">
            Results for: <span class="font-semibold" style="color: #D4AF37;">"{{ request('search') }}"</span>
            <a href="{{ route('items.index') }}" class="ml-2" style="color: #D4AF37;">Clear</a>
        </div>
    @else
        @if(auth()->user()->isAdmin())
        <div class="hidden sm:flex items-center space-x-2">
            <span class="text-sm text-gray-500">Need to export?</span>
            <a href="{{ route('reports') }}" class="text-sm font-medium hover:underline" style="color: #D4AF37;">
                Visit Reports →
            </a>
        </div>
        @endif
    @endif
</div>
