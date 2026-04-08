<!-- Universal Header -->
<header class="sticky top-0 z-40 flex items-center justify-between px-4 sm:px-6 py-3 bg-white border-b border-gray-200">

    <!-- Left: hamburger (mobile) + page title -->
    <div class="flex items-center gap-3 flex-shrink-0">
        <button @click="sidebarOpen = !sidebarOpen"
                class="lg:hidden text-gray-600 p-2 rounded-lg hover:bg-gray-100 transition-colors">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </button>
        <span class="text-gray-700 font-bold text-sm sm:text-base hidden sm:block">Icon Venue & Suites</span>
    </div>

    <!-- Center-left: Command search -->
    <div x-data="{
            searchOpen: false,
            query: '',
            pages: [
                @if(auth()->user()->isAdmin())
                { label: 'Dashboard', desc: 'Overview & stats', icon: 'dashboard', url: '{{ route('dashboard') }}' },
                { label: 'Items', desc: 'Manage inventory items', icon: 'box', url: '{{ route('items.index') }}' },
                { label: 'Batches', desc: 'Stock batches & expiry', icon: 'layers', url: '{{ route('batches.index') }}' },
                { label: 'Transactions', desc: 'Transaction history', icon: 'list', url: '{{ route('transactions.index') }}' },
                { label: 'Reports', desc: 'Analytics & reports', icon: 'chart', url: '{{ route('reports') }}' },
                { label: 'Categories', desc: 'Item categories', icon: 'tag', url: '{{ route('categories.index') }}' },
                { label: 'Departments', desc: 'Manage departments', icon: 'building', url: '{{ route('departments.index') }}' },
                { label: 'Users', desc: 'Manage users', icon: 'users', url: '{{ route('users.index') }}' },
                @else
                { label: 'Dashboard', desc: 'Overview & stats', icon: 'dashboard', url: '{{ route('dashboard') }}' },
                { label: 'Items', desc: 'Browse inventory', icon: 'box', url: '{{ route('items.index') }}' },
                @endif
                { label: 'Profile Settings', desc: 'Update your account', icon: 'user', url: '{{ route('profile.edit') }}' },
            ],
            get filtered() {
                if (!this.query) return this.pages;
                const q = this.query.toLowerCase();
                return this.pages.filter(p => p.label.toLowerCase().includes(q) || p.desc.toLowerCase().includes(q));
            },
            go(url) { this.searchOpen = false; this.query = ''; window.location.href = url; }
         }"
         @keydown.window="if(event.key === '/' && !['INPUT','TEXTAREA'].includes(event.target.tagName)) { event.preventDefault(); searchOpen = true; $nextTick(() => $refs.searchInput.focus()); }"
         @keydown.escape.window="searchOpen = false; query = ''"
         class="w-full max-w-[220px] ml-6 mr-auto hidden sm:block relative">

        <!-- Search trigger -->
        <button @click="searchOpen = true; $nextTick(() => $refs.searchInput.focus())"
                class="w-full flex items-center gap-2 px-3 py-1.5 bg-white border border-gray-500 hover:border-amber-400 rounded-full text-gray-500 text-sm transition-all duration-200 shadow-sm group">
            <svg class="w-4 h-4 flex-shrink-0 group-hover:text-amber-500 transition-colors text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <span class="flex-1 text-left text-gray-500 group-hover:text-gray-600 transition-colors">Search pages...</span>
            <kbd class="hidden lg:inline-flex items-center px-1.5 py-0.5 text-xs bg-gray-100 border border-gray-400 rounded-md text-gray-500 font-mono">/</kbd>
        </button>

        <!-- Dropdown results -->
        <div x-show="searchOpen"
             x-transition:enter="transition ease-out duration-150"
             x-transition:enter-start="opacity-0 scale-95 -translate-y-1"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-100"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 -translate-y-1"
             @click.away="searchOpen = false; query = ''"
             class="absolute top-full left-0 right-0 mt-2 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-[99999] min-w-[280px]"
             style="display:none;">

            <div class="px-3 py-2 border-b border-gray-100" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                <div class="flex items-center gap-2">
                    <svg class="w-4 h-4 text-white opacity-70 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input x-ref="searchInput"
                           x-model="query"
                           type="text"
                           placeholder="Search pages & actions..."
                           class="flex-1 text-sm text-white placeholder-amber-200 bg-transparent outline-none py-1">
                    <kbd @click="searchOpen = false; query = ''" class="text-xs text-amber-200 cursor-pointer hover:text-white bg-white bg-opacity-10 px-1.5 py-0.5 rounded">Esc</kbd>
                </div>
            </div>

            <div class="max-h-72 overflow-y-auto py-1">
                <template x-if="filtered.length === 0">
                    <div class="px-4 py-6 text-center text-sm text-gray-400">No results found</div>
                </template>
                <template x-for="page in filtered" :key="page.url">
                    <button @click="go(page.url)"
                            class="w-full flex items-center gap-3 px-4 py-2.5 hover:bg-amber-50 transition-colors text-left">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                             style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <div class="text-sm font-semibold text-gray-800" x-text="page.label"></div>
                            <div class="text-xs text-gray-400" x-text="page.desc"></div>
                        </div>
                    </button>
                </template>
            </div>
        </div>
    </div>

    <!-- Right: settings + user dropdown -->
    <div class="flex items-center gap-2">

        <!-- Bell notifications -->
        <div x-data="{ bellOpen: false }" class="relative">
            <button @click="bellOpen = !bellOpen; if(bellOpen) markNotificationsRead()"
                    title="Notifications"
                    class="relative p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                @if($unreadCount > 0)
                    <span id="notifBadge" class="absolute -top-0.5 -right-0.5 min-w-[18px] h-[18px] bg-red-500 text-white text-[10px] font-bold rounded-full flex items-center justify-center px-1 ring-2 ring-white">
                        {{ $unreadCount > 99 ? '99+' : $unreadCount }}
                    </span>
                @endif
            </button>

            <div x-show="bellOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                 @click.away="bellOpen = false"
                 class="fixed sm:absolute inset-x-4 sm:inset-x-auto top-16 sm:top-auto sm:right-0 sm:mt-2 w-auto sm:w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden z-[99999]"
                 style="display:none;">

                <!-- Header -->
                <div class="px-4 py-3 border-b border-gray-100 flex items-center justify-between" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                    <div class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="text-sm font-bold text-white">Notifications</span>
                    </div>
                    @if($unreadCount > 0)
                        <span class="text-xs bg-white bg-opacity-20 text-white font-bold px-2 py-0.5 rounded-full">{{ $unreadCount }} unread</span>
                    @endif
                </div>

                <!-- List -->
                <div class="max-h-80 overflow-y-auto divide-y divide-gray-50">
                    @forelse($notifications as $n)
                        <a href="{{ $n->url }}"
                           class="flex items-start gap-3 px-4 py-3 transition-colors {{ $n->isUnread() ? 'bg-amber-50 hover:bg-amber-100' : 'hover:bg-gray-50' }}">
                            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5
                                @if($n->color === 'yellow') bg-yellow-100
                                @elseif($n->color === 'orange') bg-orange-100
                                @elseif($n->color === 'red') bg-red-100
                                @else bg-blue-100 @endif">
                                @if($n->icon === 'warning')
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                                @elseif($n->icon === 'clock')
                                    <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                @elseif($n->icon === 'x')
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 4h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17.294 15M10 14l4-2"></path></svg>
                                @else
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                                @endif
                            </div>
                            <div class="min-w-0 flex-1">
                                <div class="text-sm font-semibold text-gray-800 truncate flex items-center gap-1">
                                    {{ $n->title }}
                                    @if($n->isUnread())
                                        <span class="w-1.5 h-1.5 bg-amber-500 rounded-full flex-shrink-0"></span>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 mt-0.5">{{ $n->description }}</div>
                                <div class="text-xs text-gray-400 mt-0.5">{{ $n->created_at->diffForHumans() }}</div>
                            </div>
                        </a>
                    @empty
                        <div class="px-4 py-8 text-center">
                            <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                            <p class="text-sm text-gray-400 font-medium">All clear, no notifications</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Appearance Settings -->
        <div x-data="{ settingsOpen: false }" class="relative">
            <button @click="settingsOpen = !settingsOpen"
                    title="Appearance"
                    class="p-2 rounded-lg text-gray-500 hover:bg-gray-100 hover:text-gray-700 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                </svg>
            </button>

            <div x-show="settingsOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                 @click.away="settingsOpen = false"
                 class="absolute right-0 mt-2 w-72 bg-white rounded-xl shadow-2xl border border-gray-200 py-3 z-[99999]"
                 style="display: none;">

                <div class="px-4 pb-2 border-b border-gray-100">
                    <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Appearance</p>
                </div>

                <!-- Dark Mode -->
                <div class="px-4 py-3 border-b border-gray-100">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Dark Mode</span>
                        </div>
                        <button @click="
                                darkMode = !darkMode;
                                localStorage.setItem('darkMode', darkMode);
                                document.documentElement.classList.toggle('dark', darkMode);
                            "
                            :class="darkMode ? 'bg-amber-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200">
                            <span :class="darkMode ? 'translate-x-6' : 'translate-x-1'"
                                  class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform duration-200"></span>
                        </button>
                    </div>
                </div>



                <!-- Density -->
                <div class="px-4 py-3 border-b border-gray-100">
                    <div class="flex items-center gap-2 mb-2">
                        <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        <span class="text-sm font-medium text-gray-700">Density</span>
                    </div>
                    <div class="flex gap-2">
                        <template x-for="d in [{label: 'Compact', value: 'compact'}, {label: 'Comfortable', value: 'comfortable'}]" :key="d.value">
                            <button @click="
                                    density = d.value;
                                    localStorage.setItem('density', density);
                                    document.documentElement.setAttribute('data-density', density);
                                "
                                :class="density === d.value ? 'bg-amber-600 text-white border-amber-600' : 'bg-white text-gray-600 border-gray-300 hover:border-amber-400'"
                                class="flex-1 py-1.5 text-xs font-bold rounded-lg border transition-colors duration-150"
                                x-text="d.label">
                            </button>
                        </template>
                    </div>
                </div>

                <!-- Animations -->
                <div class="px-4 py-3">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span class="text-sm font-medium text-gray-700">Animations</span>
                        </div>
                        <button @click="
                                animations = !animations;
                                localStorage.setItem('animations', animations);
                                document.documentElement.classList.toggle('no-animations', !animations);
                            "
                            :class="animations ? 'bg-amber-600' : 'bg-gray-200'"
                            class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200">
                            <span :class="animations ? 'translate-x-6' : 'translate-x-1'"
                                  class="inline-block h-4 w-4 transform rounded-full bg-white shadow transition-transform duration-200"></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- User dropdown -->
        <div x-data="{ open: false }" class="relative">
            <button @click="open = !open"
                    class="flex items-center gap-2 px-3 py-1.5 rounded-xl hover:bg-gray-100 transition-colors text-gray-700">
                <div class="w-8 h-8 rounded-lg overflow-hidden flex-shrink-0">
                    @if(Auth::user()->getProfilePictureUrl())
                        <img src="{{ Auth::user()->getProfilePictureUrl() }}" alt="{{ Auth::user()->name }}" class="w-full h-full object-cover">
                    @else
                        @php $avatar = Auth::user()->getDefaultAvatar(); @endphp
                        <div class="w-full h-full {{ $avatar['color'] }} flex items-center justify-center text-white font-semibold text-xs">
                            {{ $avatar['initials'] }}
                        </div>
                    @endif
                </div>
                <div class="hidden sm:block text-left">
                    <div class="text-sm font-semibold leading-tight text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-500 capitalize leading-tight">{{ Auth::user()->role }}</div>
                </div>
                <svg class="w-4 h-4 text-gray-400 transition-transform duration-200" :class="{'rotate-180': open}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>

            <div x-show="open"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-1"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-1"
                 @click.away="open = false"
                 class="absolute right-0 mt-2 w-56 bg-white rounded-xl shadow-2xl border border-gray-200 py-2 z-[99999]"
                 style="display: none;">

                <div class="px-4 py-2 border-b border-gray-100">
                    <div class="text-sm font-semibold text-gray-900">{{ Auth::user()->name }}</div>
                    <div class="text-xs text-gray-500">{{ Auth::user()->email }}</div>
                </div>

                <a href="{{ route('profile.edit') }}"
                   class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-900 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    <div>
                        <div class="font-medium">Profile Settings</div>
                        <div class="text-xs text-gray-400">Update your account details</div>
                    </div>
                </a>

                <div class="border-t border-gray-100 my-1"></div>

                <form method="POST" action="{{ route('logout') }}" data-no-loader>
                    @csrf
                    <button type="submit"
                            class="flex items-center w-full px-4 py-2 text-sm text-red-700 hover:bg-red-50 hover:text-red-900 transition-colors duration-200 text-left">
                        <svg class="w-4 h-4 mr-3 flex-shrink-0 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        <div>
                            <div class="font-medium">Log Out</div>
                            <div class="text-xs text-gray-400">Sign out of your account</div>
                        </div>
                    </button>
                </form>
            </div>
        </div>
    </div>
</header>

<script>
function markNotificationsRead() {
    const badge = document.getElementById('notifBadge');
    if (!badge) return;
    fetch('{{ route('notifications.markRead') }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json'
        }
    }).then(() => {
        if (badge) badge.remove();
    });
}
</script>
