<!-- Sidebar -->
<div class="w-64 sidebar-glass shadow-2xl h-full">
    <div class="flex flex-col h-full">
        <!-- Logo Section -->
        <div class="relative flex items-center justify-center py-6 px-4 border-b border-amber-500/20">
            <img src="{{ asset('images/pepega.webp') }}" alt="Icon Venue & Suites"
                 class="w-16 h-16 object-contain floating-animation cursor-pointer hidden lg:block"
                 @click="sidebarCollapsed = !sidebarCollapsed"
                 title="Toggle sidebar">
            <img src="{{ asset('images/pepega.webp') }}" alt="Icon Venue & Suites"
                 class="w-16 h-16 object-contain floating-animation lg:hidden">
            <button @click="sidebarOpen = false" class="lg:hidden absolute right-4 text-white hover:text-amber-200 p-1 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>

        <!-- Navigation Links -->
        <nav class="flex-1 px-4 py-6 space-y-1 overflow-y-auto">
            <!-- Overview Section -->
            <div class="mb-4">
                <h3 class="px-4 text-xs font-semibold text-amber-300 uppercase tracking-wider mb-2">Overview</h3>
                <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('dashboard') ? 'active text-white' : 'text-amber-100 hover:text-white' }}" @click="sidebarOpen = false">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                    </svg>
                    Dashboard
                </a>
            </div>

            <!-- Inventory Management Section -->
            <div class="mb-4">
                <h3 class="px-4 text-xs font-semibold text-amber-300 uppercase tracking-wider mb-2">Inventory</h3>
                <div class="space-y-1">
                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('categories.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('categories.*') ? 'active text-white' : 'text-amber-100 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                        Categories
                    </a>
                    @endif

                    <div class="relative" x-data="{ itemsDropdown: false }">
                        @if(auth()->user()->isAdmin())
                        <div @click="itemsDropdown = !itemsDropdown" class="sidebar-link flex items-center justify-between px-4 py-3 text-sm font-medium rounded-xl cursor-pointer {{ request()->routeIs('items.*') || request()->routeIs('batches.*') ? 'active text-white' : 'text-amber-100 hover:text-white' }}">
                            <div class="flex items-center">
                        @else
                        <a href="{{ route('items.index') }}" @click="sidebarOpen = false" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('items.*') ? 'active text-white' : 'text-amber-100 hover:text-white' }}">
                        @endif
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Items
                        @if(auth()->user()->isAdmin())
                            </div>
                            <svg class="w-4 h-4 lg:hidden transition-transform duration-200" :class="{'rotate-180': itemsDropdown}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                        @else
                        </a>
                        @endif

                        @if(auth()->user()->isAdmin())
                        {{-- Mobile: inline dropdown --}}
                        <div x-show="itemsDropdown"
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 -translate-y-2"
                             x-transition:enter-end="opacity-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0"
                             x-transition:leave-end="opacity-0 -translate-y-2"
                             class="lg:hidden mt-1 ml-4 space-y-1"
                             style="display: none;">
                            <a href="{{ route('items.index') }}" @click="sidebarOpen = false; itemsDropdown = false" class="flex items-center px-4 py-2 text-sm text-amber-100 hover:text-white hover:bg-amber-500/10 rounded-xl transition-colors duration-200 {{ request()->routeIs('items.*') ? 'text-white' : '' }}">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                All Items
                            </a>
                            <a href="{{ route('batches.index') }}" @click="sidebarOpen = false; itemsDropdown = false" class="flex items-center px-4 py-2 text-sm text-amber-100 hover:text-white hover:bg-amber-500/10 rounded-xl transition-colors duration-200 {{ request()->routeIs('batches.*') ? 'text-white' : '' }}">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                Batch Management
                            </a>
                        </div>

                        {{-- Desktop: flyout (click) --}}
                        <div x-show="itemsDropdown"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 scale-100 translate-x-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-x-2"
                             @click.away="itemsDropdown = false"
                             class="hidden lg:block fixed left-64 w-56 bg-white/95 backdrop-blur-sm rounded-xl shadow-2xl border border-gray-200 py-2 z-[99999]"
                             style="top: 272px; display: none;">
                            <div class="px-3 py-1">
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Item Management</p>
                            </div>
                            <a href="{{ route('items.index') }}" @click="itemsDropdown = false" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-900 transition-colors duration-200 {{ request()->routeIs('items.*') ? 'bg-blue-50 text-blue-900' : '' }}">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                <div>
                                    <div class="font-medium">All Items</div>
                                    <div class="text-xs text-gray-500">View & manage inventory</div>
                                </div>
                            </a>
                            <a href="{{ route('batches.index') }}" @click="itemsDropdown = false" class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-900 transition-colors duration-200 {{ request()->routeIs('batches.*') ? 'bg-amber-50 text-amber-900' : '' }}">
                                <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                <div>
                                    <div class="font-medium">Batch Management</div>
                                    <div class="text-xs text-gray-500">Track expiry & suppliers</div>
                                </div>
                            </a>
                        </div>

                        @endif
                    </div>

                    @if(auth()->user()->isAdmin())
                    <a href="{{ route('transactions.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('transactions.*') ? 'active text-white' : 'text-amber-100 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Transactions
                    </a>
                    @endif
                </div>
            </div>

            <!-- Analytics Section -->
            @if(auth()->user()->isAdmin())
            <div class="mb-4">
                <h3 class="px-4 text-xs font-semibold text-amber-300 uppercase tracking-wider mb-2">Analytics</h3>
                <a href="{{ route('reports') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('reports') ? 'active text-white' : 'text-amber-100 hover:text-white' }}">
                    <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Reports
                </a>
            </div>
            @endif

            <!-- Administration Section -->
            @if(auth()->user()->isAdmin())
            @if(auth()->user()->isAdmin())
            <div class="mb-4">
                <h3 class="px-4 text-xs font-semibold text-amber-300 uppercase tracking-wider mb-2">Administration</h3>
                <div class="space-y-1">
                    <a href="{{ route('departments.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('departments.*') ? 'active text-white' : 'text-amber-100 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        Departments
                    </a>
                    
                    <a href="{{ route('users.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('users.*') ? 'active text-white' : 'text-amber-100 hover:text-white' }}">
                        <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                        Users
                    </a>
                </div>
            </div>
            @endif
            @endif
        </nav>

        <!-- Decorative bottom image -->
        <div class="relative mt-auto overflow-hidden flex-shrink-0" style="height: 120px;">
            <div class="absolute inset-x-0 top-0 h-12 z-10" style="background: linear-gradient(to bottom, rgba(61,41,20,0.95), transparent);"></div>
            <img src="{{ asset('images/buddy.jpg') }}" alt=""
                 class="w-full h-full object-cover object-center opacity-80"
                 style="mask-image: linear-gradient(to top, rgba(0,0,0,0.7) 40%, transparent 100%);
                        -webkit-mask-image: linear-gradient(to top, rgba(0,0,0,0.7) 40%, transparent 100%);">
            <div class="absolute inset-x-0 bottom-0 h-16" style="background: linear-gradient(to top, rgba(61,41,20,0.95), transparent);"></div>
        </div>
    </div>
</div>
