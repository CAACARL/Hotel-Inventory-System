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
                height: 100vh;
                position: fixed;
                top: 0;
                left: 0;
                z-index: 50000;
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

            /* Density — compact */
            [data-density="compact"] table td,
            [data-density="compact"] table th {
                padding-top: 0.4rem !important;
                padding-bottom: 0.4rem !important;
                padding-left: 1rem !important;
                padding-right: 1rem !important;
            }
            [data-density="compact"] .py-6 { padding-top: 0.6rem !important; padding-bottom: 0.6rem !important; }
            [data-density="compact"] .py-4 { padding-top: 0.4rem !important; padding-bottom: 0.4rem !important; }
            [data-density="compact"] .py-3 { padding-top: 0.35rem !important; padding-bottom: 0.35rem !important; }
            [data-density="compact"] .px-8 { padding-left: 1rem !important; padding-right: 1rem !important; }
            [data-density="compact"] .px-6 { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
            [data-density="compact"] .p-3 { padding: 0.5rem !important; }
            [data-density="compact"] .p-4 { padding: 0.6rem !important; }
            [data-density="compact"] .space-y-3 > * + * { margin-top: 0.4rem !important; }
            [data-density="compact"] .gap-4 { gap: 0.5rem !important; }
            [data-density="compact"] .mb-6 { margin-bottom: 0.75rem !important; }
            [data-density="compact"] .mb-8 { margin-bottom: 1rem !important; }
            [data-density="compact"] header { padding-top: 0.35rem !important; padding-bottom: 0.35rem !important; }
            [data-density="compact"] footer { padding-top: 0.35rem !important; padding-bottom: 0.35rem !important; }

            /* No animations */
            .no-animations *, .no-animations *::before, .no-animations *::after {
                animation-duration: 0s !important;
                transition-duration: 0s !important;
            }

            /* Dark mode basics */
            .dark body { background-color: #1a1a2e; color: #e2e8f0; }
            .dark .bg-white { background-color: #1e293b !important; }
            .dark .bg-gray-50 { background-color: #0f172a !important; }
            .dark .bg-gray-100 { background-color: #1e293b !important; }
            .dark .text-gray-900 { color: #f1f5f9 !important; }
            .dark .text-gray-700 { color: #cbd5e1 !important; }
            .dark .text-gray-600 { color: #94a3b8 !important; }
            .dark .text-gray-500 { color: #64748b !important; }
            .dark .border-gray-200 { border-color: #334155 !important; }
            .dark .border-gray-100 { border-color: #1e293b !important; }
            .dark .hotel-gradient-light { background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%) !important; }
            .dark .modern-card { background-color: #1e293b !important; border-color: #334155 !important; }
            .dark .divide-gray-100 > * { border-color: #334155 !important; }
            .dark .divide-gray-200 > * { border-color: #334155 !important; }
            .dark thead { background: #0f172a !important; }
            .dark .hover\:bg-gray-50:hover { background-color: #1e293b !important; }

            /* Dark mode — sidebar */
            .dark .sidebar-glass {
                background-color: rgba(10, 10, 20, 0.98) !important;
                border-right-color: rgba(100, 116, 139, 0.2) !important;
            }
            .dark .sidebar-link:hover { background: rgba(148, 163, 184, 0.1) !important; }
            .dark .sidebar-link.active { background: rgba(148, 163, 184, 0.15) !important; border-right-color: #94a3b8 !important; }
            .dark .text-amber-100 { color: #cbd5e1 !important; }
            .dark .text-amber-300 { color: #94a3b8 !important; }
            .dark .border-amber-500\/20 { border-color: rgba(100, 116, 139, 0.2) !important; }
            .dark .hover\:bg-amber-500\/10:hover { background: rgba(148, 163, 184, 0.1) !important; }
        </style>
    </head>
    <body class="font-sans antialiased bg-gray-50">
        <div x-data="{
                sidebarOpen: false,
                sidebarCollapsed: localStorage.getItem('sidebarCollapsed') === 'true',
                darkMode: localStorage.getItem('darkMode') === 'true',
                density: localStorage.getItem('density') || 'comfortable',
                animations: localStorage.getItem('animations') !== 'false'
             }"
             x-init="
                document.documentElement.classList.toggle('dark', darkMode);
                document.documentElement.setAttribute('data-density', density);
                document.documentElement.classList.toggle('no-animations', !animations);
                $watch('sidebarCollapsed', val => localStorage.setItem('sidebarCollapsed', val));
             "
             class="flex min-h-screen">

            <!-- Mobile overlay -->
            <div x-show="sidebarOpen"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="sidebarOpen = false"
                 class="fixed inset-0 bg-black bg-opacity-50 z-[49999] lg:hidden"
                 style="display:none;"></div>

            <!-- Sidebar collapse toggle (desktop only) -->
            <div x-show="sidebarCollapsed"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 -translate-x-2"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 -translate-x-2"
                 class="hidden lg:flex fixed left-0 top-1/2 -translate-y-1/2 z-[50001]"
                 style="display: none;">
                <button @click="sidebarCollapsed = false"
                        title="Show sidebar"
                        class="flex items-center justify-center w-6 h-14 rounded-r-xl shadow-lg transition-all duration-200 hover:w-8"
                        style="background: rgba(61,41,20,0.95); border: 1px solid rgba(212,175,55,0.3); border-left: none;">
                    <svg class="w-4 h-4 text-amber-300 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>

            <!-- Sidebar (hidden on mobile unless open) -->
            <div :class="[sidebarOpen ? 'translate-x-0' : '-translate-x-full', sidebarCollapsed ? 'lg:w-0 lg:overflow-hidden' : 'lg:translate-x-0 w-64']"
                 class="fixed top-0 left-0 h-full z-[50000] transition-all duration-300 ease-in-out w-64">
                @include('layouts.partials.sidebar')
            </div>

            <!-- Main Content -->
            <div :class="sidebarCollapsed ? 'lg:ml-0' : 'lg:ml-64'"
                 class="flex-1 flex flex-col min-w-0 transition-all duration-300 ease-in-out" style="position: relative; z-index: 1;">

                @include('layouts.partials.header')
                <!-- Page Heading -->
                @isset($header)
                    <header class="bg-white shadow-sm border-b border-emerald-100">
                        <div class="px-6 py-6">
                            {{ $header }}
                        </div>
                    </header>
                @endisset

                <!-- Page Content -->
                <main class="flex-1 hotel-gradient-light p-3 sm:p-6">
                    {{ $slot }}
                </main>

                @include('layouts.partials.footer')
            </div>
        </div>

        @include('layouts.partials.toasts')

        <!-- Image Lightbox -->
        <div id="imageLightbox"
             class="fixed inset-0 z-[9999] flex items-center justify-center bg-black bg-opacity-90 backdrop-blur-sm"
             style="display:none !important;"
             onclick="closeLightbox(event)">
            <button onclick="hideLightbox()" class="absolute top-4 right-4 text-white hover:text-gray-300 transition-colors p-2 rounded-full hover:bg-white hover:bg-opacity-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
            <img id="lightboxImg" src="" alt=""
                 class="w-[80vw] h-[80vh] object-contain rounded-xl shadow-2xl"
                 onclick="event.stopPropagation()">
        </div>

        <script>
            function openLightbox(src, alt) {
                const lb = document.getElementById('imageLightbox');
                const img = document.getElementById('lightboxImg');
                img.src = src;
                img.alt = alt || '';
                lb.style.removeProperty('display');
                document.body.classList.add('modal-open');
            }
            function hideLightbox() {
                const lb = document.getElementById('imageLightbox');
                lb.style.display = 'none';
                document.body.classList.remove('modal-open');
            }
            function closeLightbox(e) {
                if (e.target === document.getElementById('imageLightbox')) hideLightbox();
            }
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') hideLightbox();
            });
        </script>

        <!-- Page Loading Animation -->
        <div id="pageLoader" class="page-loader">
            <div class="loader-content">
                <div class="box-stack-loader">
                    <div class="inventory-box box-1"></div>
                    <div class="inventory-box box-2"></div>
                    <div class="inventory-box box-3"></div>
                    <div class="inventory-box box-4"></div>
                </div>
                <div class="loader-text font-bold">Icon Venue & Suites</div>
            </div>
        </div>
        
        <!-- Loading Progress Bar -->
        <div id="loadingProgress" class="loading-progress"></div>
        
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Always clean up modal-open on page load in case it got stuck
                document.body.classList.remove('modal-open');
                document.body.style.overflow = '';

                const pageLoader = document.getElementById('pageLoader');
                const loadingProgress = document.getElementById('loadingProgress');
                
                function showLoader() {
                    pageLoader.classList.add('active');
                    
                    let progress = 0;
                    const progressInterval = setInterval(() => {
                        progress += Math.random() * 15;
                        if (progress > 85) progress = 85;
                        loadingProgress.style.width = progress + '%';
                    }, 50);
                    
                    setTimeout(() => {
                        hideLoader(progressInterval);
                    }, 10000);
                    
                    return progressInterval;
                }
                
                function hideLoader(progressInterval) {
                    if (progressInterval) {
                        clearInterval(progressInterval);
                    }
                    
                    loadingProgress.style.width = '100%';
                    
                    setTimeout(() => {
                        pageLoader.classList.remove('active');
                        loadingProgress.style.width = '0%';
                    }, 200);
                }
                
                document.addEventListener('click', function(e) {
                    const link = e.target.closest('a[href]');
                    
                    if (link && 
                        !link.hasAttribute('target') && 
                        !link.hasAttribute('download') &&
                        !link.href.includes('#') && 
                        !link.href.includes('javascript:') &&
                        !link.href.includes('mailto:') &&
                        !link.href.includes('tel:') &&
                        link.href.startsWith(window.location.origin)) {
                        
                        e.preventDefault();
                        
                        const progressInterval = showLoader();
                        
                        setTimeout(() => {
                            window.location.href = link.href;
                        }, 300);
                    }
                });
                
                document.addEventListener('submit', function(e) {
                    const form = e.target;
                    
                    if (!form.hasAttribute('data-no-loader')) {
                        const progressInterval = showLoader();
                        
                        setTimeout(() => {
                            hideLoader(progressInterval);
                        }, 3000);
                    }
                });
                
                window.addEventListener('beforeunload', function() {
                    showLoader();
                });
                
                window.addEventListener('popstate', function() {
                    const progressInterval = showLoader();
                    
                    setTimeout(() => {
                        hideLoader(progressInterval);
                    }, 300);
                });
                
                window.addEventListener('pageshow', function(event) {
                    setTimeout(() => {
                        pageLoader.classList.remove('active');
                        loadingProgress.style.width = '0%';
                    }, 100);
                });
                
                window.addEventListener('load', function() {
                    setTimeout(() => {
                        pageLoader.classList.remove('active');
                        loadingProgress.style.width = '0%';
                    }, 100);
                });
            });
        </script>
    </body>
</html>
