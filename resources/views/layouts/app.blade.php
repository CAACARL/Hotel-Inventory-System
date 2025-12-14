<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Tailwind CSS CDN -->
        <script src="https://cdn.tailwindcss.com"></script>
        <!-- Alpine.js for interactivity -->
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <style>
            /* Icon Venue & Suites - Exact Logo Colors */
            .hotel-gradient {
                background: linear-gradient(135deg, #3D2914 0%, #D4AF37 50%, #F4E4BC 100%);
            }
            .hotel-gradient-light {
                background: linear-gradient(135deg, #F9F7F4 0%, #F4E4BC 50%, #E8D5A3 100%);
            }
            .hotel-gradient-dark {
                background: linear-gradient(135deg, #2A1F0F 0%, #3D2914 50%, #4A3319 100%);
            }
            .hotel-gradient-brown {
                background: linear-gradient(135deg, #2A1F0F 0%, #3D2914 50%, #4A3319 100%);
            }
            .stats-card {
                transition: all 0.3s ease-in-out;
                backdrop-filter: blur(10px);
            }
            .stats-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 20px 25px -5px rgba(212, 175, 55, 0.2), 0 10px 10px -5px rgba(212, 175, 55, 0.1);
            }
            .low-stock-alert {
                animation: pulse 2s infinite;
            }
            @keyframes pulse {
                0%, 100% { opacity: 1; }
                50% { opacity: 0.7; }
            }
            .glass-effect {
                backdrop-filter: blur(16px) saturate(180%);
                background-color: rgba(255, 255, 255, 0.85);
                border: 1px solid rgba(212, 175, 55, 0.2);
            }
            .sidebar-glass {
                backdrop-filter: blur(20px) saturate(180%);
                background-color: rgba(61, 41, 20, 0.95);
                border-right: 1px solid rgba(212, 175, 55, 0.2);
            }
            .btn-primary {
                background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);
                transition: all 0.3s ease;
            }
            .btn-primary:hover {
                background: linear-gradient(135deg, #2A1F0F 0%, #B8941F 100%);
                transform: translateY(-1px);
                box-shadow: 0 10px 15px -3px rgba(212, 175, 55, 0.3);
            }
            .table-row:hover {
                background: linear-gradient(90deg, rgba(212, 175, 55, 0.05) 0%, rgba(244, 228, 188, 0.05) 100%);
            }
            .sidebar-link {
                position: relative;
                transition: all 0.3s ease;
            }
            .sidebar-link:hover {
                background: rgba(212, 175, 55, 0.1);
                transform: translateX(4px);
            }
            .sidebar-link.active {
                background: rgba(212, 175, 55, 0.2);
                border-right: 3px solid #D4AF37;
            }
            .floating-animation {
                animation: float 6s ease-in-out infinite;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-10px); }
            }
            
            /* Modal and overlay fixes */
            .modal-open {
                overflow: hidden;
            }
            
            .modal-backdrop {
                backdrop-filter: none;
                -webkit-backdrop-filter: none;
            }
            
            /* Ensure proper z-index stacking */
            .z-\[60\] { z-index: 60; }
            .z-\[70\] { z-index: 70; }
            .z-\[100\] { z-index: 100; }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div class="flex min-h-screen">
            <!-- Sidebar -->
            <div class="w-64 sidebar-glass shadow-2xl" x-data="{ sidebarOpen: true }">
                <div class="flex flex-col h-full">
                    <!-- Logo Section -->
                    <div class="flex items-center justify-center py-6 px-4 border-b border-amber-500/20">
                        <div class="flex items-center space-x-3">
                            <div class="w-12 h-12 hotel-gradient rounded-xl flex items-center justify-center shadow-lg floating-animation">
                                <svg class="w-6 h-6 text-white" viewBox="0 0 100 100" fill="none">
                                    <!-- Geometric I Logo -->
                                    <g stroke="currentColor" stroke-width="2" fill="none">
                                        <!-- Top left square -->
                                        <rect x="10" y="10" width="15" height="15"/>
                                        <rect x="12" y="12" width="11" height="11"/>
                                        <!-- Top right square -->
                                        <rect x="75" y="10" width="15" height="15"/>
                                        <rect x="77" y="12" width="11" height="11"/>
                                        <!-- Center vertical line -->
                                        <rect x="45" y="10" width="10" height="80"/>
                                        <rect x="47" y="12" width="6" height="76"/>
                                        <!-- Bottom left square -->
                                        <rect x="10" y="75" width="15" height="15"/>
                                        <rect x="12" y="77" width="11" height="11"/>
                                        <!-- Bottom right square -->
                                        <rect x="75" y="75" width="15" height="15"/>
                                        <rect x="77" y="77" width="11" height="11"/>
                                    </g>
                                </svg>
                            </div>
                            <div>
                                <h1 class="text-lg font-bold text-white">Icon Venue</h1>
                                <p class="text-xs text-amber-200">& Suites</p>
                            </div>
                        </div>
                    </div>

                    <!-- Navigation Links -->
                    <nav class="flex-1 px-4 py-6 space-y-2">
                        <a href="{{ route('dashboard') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('dashboard') ? 'active text-white' : 'text-amber-100 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                            </svg>
                            Dashboard
                        </a>

                        <a href="{{ route('categories.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('categories.*') ? 'active text-white' : 'text-amber-100 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                            Categories
                        </a>

                        <a href="{{ route('items.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('items.*') ? 'active text-white' : 'text-amber-100 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Items
                        </a>

                        <a href="{{ route('transactions.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('transactions.*') ? 'active text-white' : 'text-amber-100 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Transactions
                        </a>

                        <a href="{{ route('reports') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('reports') ? 'active text-white' : 'text-amber-100 hover:text-white' }}">
                            <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Reports
                        </a>

                        @if(auth()->user()->isAdmin())
                            <a href="{{ route('users.index') }}" class="sidebar-link flex items-center px-4 py-3 text-sm font-medium rounded-xl {{ request()->routeIs('users.*') ? 'active text-white' : 'text-amber-100 hover:text-white' }}">
                                <svg class="w-5 h-5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                                </svg>
                                Users
                            </a>
                        @endif
                    </nav>

                    <!-- User Profile Section -->
                    <div class="px-4 py-4 border-t border-amber-500/20" x-data="{ dropdownOpen: false }">
                        <div class="relative">
                            <button @click="dropdownOpen = !dropdownOpen" class="w-full flex items-center px-4 py-3 text-sm font-medium text-amber-100 hover:text-white hover:bg-amber-500/10 rounded-xl transition-all duration-200">
                                <div class="w-8 h-8 bg-amber-400 rounded-lg flex items-center justify-center mr-3">
                                    <svg class="w-4 h-4 text-amber-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 text-left">
                                    <div class="font-semibold">{{ Auth::user()->name }}</div>
                                    <div class="text-xs text-amber-300 capitalize">{{ Auth::user()->role }}</div>
                                </div>
                                <svg class="w-4 h-4 transition-transform duration-200" :class="{'rotate-180': dropdownOpen}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>

                            <div x-show="dropdownOpen" 
                                 @click.away="dropdownOpen = false"
                                 x-transition:enter="transition ease-out duration-200"
                                 x-transition:enter-start="opacity-0 scale-95"
                                 x-transition:enter-end="opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="opacity-100 scale-100"
                                 x-transition:leave-end="opacity-0 scale-95"
                                 class="absolute bottom-full left-0 right-0 mb-2 bg-white/95 backdrop-blur-sm rounded-xl shadow-xl border border-amber-200 py-2">
                                
                                <a href="{{ route('profile.edit') }}" class="flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-amber-50 hover:text-amber-900 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    Profile Settings
                                </a>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center w-full px-4 py-3 text-sm text-red-700 hover:bg-red-50 hover:text-red-900 transition-colors duration-200">
                                        <svg class="w-4 h-4 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                                        </svg>
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="flex-1 flex flex-col">
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow-sm border-b border-emerald-100">
                        <div class="px-6 py-6">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 hotel-gradient-light p-6">
                    {{ $slot }}
                </main>
            </div>
        </div>

        <!-- Global Success Toast Notification -->
        @if(session('success'))
        <div x-data="{ show: true }" 
             x-show="show"
             x-init="setTimeout(() => show = false, 4000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-full"
             class="fixed top-4 right-4 z-[100] max-w-sm w-full pointer-events-auto">
            
            <div class="bg-white rounded-2xl shadow-2xl border border-green-200 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-gray-900">Success!</h4>
                            <p class="text-sm text-gray-600">{{ session('success') }}</p>
                        </div>
                        <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 ml-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Progress bar -->
                <div class="bg-gray-200 h-1">
                    <div class="bg-gradient-to-r from-green-500 to-emerald-600 h-1 animate-pulse" style="width: 100%; animation: shrink 4s linear;"></div>
                </div>
            </div>
        </div>
        @endif

        <!-- Global Error Toast Notification -->
        @if(session('error'))
        <div x-data="{ show: true }" 
             x-show="show"
             x-init="setTimeout(() => show = false, 5000)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-x-full"
             x-transition:enter-end="opacity-100 translate-x-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-x-0"
             x-transition:leave-end="opacity-0 translate-x-full"
             class="fixed top-4 right-4 z-[100] max-w-sm w-full pointer-events-auto">
            
            <div class="bg-white rounded-2xl shadow-2xl border border-red-200 overflow-hidden">
                <div class="p-4">
                    <div class="flex items-center">
                        <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-pink-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <h4 class="text-sm font-bold text-gray-900">Error!</h4>
                            <p class="text-sm text-gray-600">{{ session('error') }}</p>
                        </div>
                        <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 ml-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Progress bar -->
                <div class="bg-gray-200 h-1">
                    <div class="bg-gradient-to-r from-red-500 to-pink-600 h-1 animate-pulse" style="width: 100%; animation: shrink 5s linear;"></div>
                </div>
            </div>
        </div>
        @endif

        <style>
            @keyframes shrink {
                from { width: 100%; }
                to { width: 0%; }
            }
        </style>
    </body>
</html>
