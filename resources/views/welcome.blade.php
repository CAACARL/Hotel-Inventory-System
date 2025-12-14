<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'Icon Venue & Suites') }} - Luxury Hotel Experience</title>
        <script src="https://cdn.tailwindcss.com"></script>
        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        <style>
            .hotel-gradient {
                background: linear-gradient(135deg, #3D2914 0%, #D4AF37 50%, #F4E4BC 100%);
            }
            .hotel-gradient-brown {
                background: linear-gradient(135deg, #2A1F0F 0%, #3D2914 50%, #4A3319 100%);
            }
            .hotel-gradient-light {
                background: linear-gradient(135deg, #F9F7F4 0%, #F4E4BC 50%, #E8D5A3 100%);
            }
            .glass-effect {
                backdrop-filter: blur(16px) saturate(180%);
                background-color: rgba(255, 255, 255, 0.85);
                border: 1px solid rgba(209, 213, 219, 0.3);
            }
            .floating-animation {
                animation: float 6s ease-in-out infinite;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px); }
                50% { transform: translateY(-20px); }
            }
            .hero-bg {
                background-image: 
                    linear-gradient(135deg, rgba(42, 31, 15, 0.95) 0%, rgba(61, 41, 20, 0.9) 50%, rgba(74, 51, 25, 0.85) 100%),
                    radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.2) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(244, 228, 188, 0.2) 0%, transparent 50%),
                    radial-gradient(circle at 40% 40%, rgba(61, 41, 20, 0.3) 0%, transparent 50%);
            }
            .scroll-smooth {
                scroll-behavior: smooth;
            }
            .icon-logo {
                width: 60px;
                height: 60px;
                fill: currentColor;
            }
        </style>
    </head>
    <body class="font-sans antialiased scroll-smooth">
        <!-- Navigation -->
        <nav class="fixed top-0 w-full z-50 glass-effect">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0 flex items-center">
                            <div class="w-10 h-10 hotel-gradient rounded-xl flex items-center justify-center">
                                <svg class="w-6 h-6 text-white" viewBox="0 0 100 100" fill="currentColor">
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
                            <span class="ml-3 text-xl font-bold bg-gradient-to-r from-amber-600 to-yellow-600 bg-clip-text text-transparent">Icon Venue & Suites</span>
                        </div>
                    </div>
                    <div class="hidden md:block">
                        <div class="ml-10 flex items-baseline space-x-8">
                            <a href="#home" class="text-gray-700 hover:text-amber-600 px-3 py-2 text-sm font-medium transition-colors">Home</a>
                            <a href="#about" class="text-gray-700 hover:text-amber-600 px-3 py-2 text-sm font-medium transition-colors">About</a>
                            <a href="#services" class="text-gray-700 hover:text-amber-600 px-3 py-2 text-sm font-medium transition-colors">Services</a>
                            <a href="#contact" class="text-gray-700 hover:text-amber-600 px-3 py-2 text-sm font-medium transition-colors">Contact</a>
                        </div>
                    </div>
                    <div class="flex items-center space-x-4">
                        @if (Route::has('login'))
                            @auth
                                <a href="{{ url('/dashboard') }}" class="bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 transform hover:-translate-y-0.5">Dashboard</a>
                            @else
                                <a href="{{ route('login') }}" class="bg-gradient-to-r from-amber-600 to-yellow-600 hover:from-amber-700 hover:to-yellow-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition-all duration-200 transform hover:-translate-y-0.5">Login</a>
                            @endauth
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section id="home" class="min-h-screen hero-bg flex items-center justify-center relative overflow-hidden">
            <!-- Background decorative elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 floating-animation"></div>
                <div class="absolute top-3/4 right-1/4 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 floating-animation" style="animation-delay: 2s;"></div>
                <div class="absolute bottom-1/4 left-1/2 w-64 h-64 bg-pink-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 floating-animation" style="animation-delay: 4s;"></div>
            </div>

            <div class="relative text-center text-white px-4 max-w-4xl mx-auto">
                <!-- Hotel Logo and Branding -->
                <div class="inline-flex items-center justify-center w-40 h-40 bg-white/10 backdrop-blur-lg rounded-3xl shadow-2xl mb-8 floating-animation border border-amber-300/30">
                    <svg class="w-24 h-24 text-amber-300" viewBox="0 0 100 100" fill="none">
                        <!-- Geometric I Logo -->
                        <g stroke="currentColor" stroke-width="1.5" fill="none">
                            <!-- Top left square -->
                            <rect x="15" y="15" width="12" height="12"/>
                            <rect x="17" y="17" width="8" height="8"/>
                            <!-- Top right square -->
                            <rect x="73" y="15" width="12" height="12"/>
                            <rect x="75" y="17" width="8" height="8"/>
                            <!-- Center vertical line -->
                            <rect x="42" y="15" width="16" height="70"/>
                            <rect x="45" y="18" width="10" height="64"/>
                            <!-- Bottom left square -->
                            <rect x="15" y="73" width="12" height="12"/>
                            <rect x="17" y="75" width="8" height="8"/>
                            <!-- Bottom right square -->
                            <rect x="73" y="73" width="12" height="12"/>
                            <rect x="75" y="75" width="8" height="8"/>
                        </g>
                    </svg>
                </div>
                
                <h1 class="text-6xl md:text-7xl font-bold mb-6 leading-tight">
                    Icon Venue & Suites
                </h1>
                <p class="text-xl md:text-2xl mb-4 text-white/90 font-light">Where Luxury Meets Excellence</p>
                <p class="text-lg mb-12 text-white/80 max-w-2xl mx-auto">Experience unparalleled hospitality with our world-class amenities, exceptional service, and sophisticated inventory management systems.</p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-10 py-5 bg-white hover:bg-gray-100 text-emerald-600 font-bold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 text-lg">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                </svg>
                                Access Dashboard
                            </a>
                            <a href="#about" class="inline-flex items-center px-8 py-4 bg-white/20 backdrop-blur-lg hover:bg-white/30 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 border border-white/30">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Learn More
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-10 py-5 bg-white hover:bg-gray-100 text-amber-700 font-bold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 text-lg">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Access System
                            </a>
                            <a href="#about" class="inline-flex items-center px-8 py-4 bg-white/20 backdrop-blur-lg hover:bg-white/30 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 border border-white/30">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Learn More
                            </a>
                        @endauth
                    @endif
                </div>
            </div>

            <!-- Scroll indicator -->
            <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
                <svg class="w-6 h-6 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                </svg>
            </div>
        </section>

        <!-- About Section -->
        <section id="about" class="py-20 bg-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">About Icon Venue & Suites</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">A premier hospitality destination combining luxury accommodations with cutting-edge operational excellence.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="text-center p-8 glass-effect rounded-3xl">
                        <div class="w-16 h-16 hotel-gradient rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Luxury Experience</h3>
                        <p class="text-gray-600">Premium accommodations with world-class amenities and personalized service that exceeds expectations.</p>
                    </div>

                    <div class="text-center p-8 glass-effect rounded-3xl">
                        <div class="w-16 h-16 hotel-gradient rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Operational Excellence</h3>
                        <p class="text-gray-600">Advanced inventory management systems ensuring seamless operations and optimal resource utilization.</p>
                    </div>

                    <div class="text-center p-8 glass-effect rounded-3xl">
                        <div class="w-16 h-16 hotel-gradient rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold text-gray-900 mb-4">Professional Team</h3>
                        <p class="text-gray-600">Dedicated staff committed to delivering exceptional hospitality and maintaining the highest standards.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Staff Access Section -->
        <section class="py-16 hotel-gradient-brown">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
                <div class="bg-white/10 backdrop-blur-lg rounded-3xl p-8 border border-white/20">
                    <h2 class="text-3xl font-bold text-white mb-4">Management Portal</h2>
                    <p class="text-xl text-white/90 mb-8">Access the inventory management system to track supplies, manage categories, and monitor hotel operations.</p>
                    
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ url('/dashboard') }}" class="inline-flex items-center px-8 py-4 bg-white hover:bg-gray-100 text-emerald-600 font-bold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 text-lg">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2-2z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5a2 2 0 012-2h4a2 2 0 012 2v6H8V5z"></path>
                                </svg>
                                Go to Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center px-8 py-4 bg-white hover:bg-gray-100 text-amber-700 font-bold rounded-2xl shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-200 text-lg">
                                <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                                </svg>
                                Enter Portal
                            </a>
                        @endauth
                    @endif
                    
                    <div class="mt-6 text-white/80 text-sm">
                        <p>Demo Credentials: admin@iconvenue.com / staff@iconvenue.com (password: password)</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="services" class="py-20 hotel-gradient-light">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold text-gray-900 mb-4">Our Services</h2>
                    <p class="text-xl text-gray-600 max-w-3xl mx-auto">Comprehensive hospitality solutions powered by advanced management systems.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 hotel-gradient rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Luxury Suites</h3>
                        <p class="text-gray-600 text-sm">Premium accommodations with modern amenities and elegant design.</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 hotel-gradient rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Inventory Management</h3>
                        <p class="text-gray-600 text-sm">Advanced tracking and management of hotel supplies and amenities.</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 hotel-gradient rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 100 4m0-4v2m0-6V4"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Operations Control</h3>
                        <p class="text-gray-600 text-sm">Streamlined operations with real-time monitoring and control systems.</p>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-lg hover:shadow-xl transition-shadow">
                        <div class="w-12 h-12 hotel-gradient rounded-xl flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 5.636l-3.536 3.536m0 5.656l3.536 3.536M9.172 9.172L5.636 5.636m3.536 9.192L5.636 18.364M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-5 0a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">24/7 Support</h3>
                        <p class="text-gray-600 text-sm">Round-the-clock assistance and maintenance for uninterrupted service.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section id="contact" class="py-20 bg-gray-900 text-white">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16">
                    <h2 class="text-4xl font-bold mb-4">Get In Touch</h2>
                    <p class="text-xl text-gray-300 max-w-3xl mx-auto">Ready to experience luxury hospitality? Contact us for reservations or inquiries.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                    <div class="p-8">
                        <div class="w-16 h-16 hotel-gradient rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-4">Location</h3>
                        <p class="text-gray-300">123 Luxury Avenue<br>Premium District<br>City, State 12345</p>
                    </div>

                    <div class="p-8">
                        <div class="w-16 h-16 hotel-gradient rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-4">Phone</h3>
                        <p class="text-gray-300">Reservations: (555) 123-4567<br>Concierge: (555) 123-4568<br>Management: (555) 123-4569</p>
                    </div>

                    <div class="p-8">
                        <div class="w-16 h-16 hotel-gradient rounded-2xl flex items-center justify-center mx-auto mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-semibold mb-4">Email</h3>
                        <p class="text-gray-300">info@iconvenue.com<br>reservations@iconvenue.com<br>support@iconvenue.com</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="bg-black text-white py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="flex items-center mb-4 md:mb-0">
                        <div class="w-10 h-10 hotel-gradient rounded-xl flex items-center justify-center mr-3">
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
                        <span class="text-xl font-bold">Icon Venue & Suites</span>
                    </div>
                    <div class="text-center md:text-right">
                        <p class="text-gray-400 mb-2">© {{ date('Y') }} Icon Venue & Suites. All rights reserved.</p>
                        <p class="text-sm text-gray-500">Luxury • Excellence • Innovation</p>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>