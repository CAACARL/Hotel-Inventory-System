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
            .login-bg {
                background-image: 
                    radial-gradient(circle at 20% 80%, rgba(212, 175, 55, 0.3) 0%, transparent 50%),
                    radial-gradient(circle at 80% 20%, rgba(61, 41, 20, 0.3) 0%, transparent 50%),
                    radial-gradient(circle at 40% 40%, rgba(244, 228, 188, 0.3) 0%, transparent 50%);
            }

            /* Simple Black Stick Figure Walking Animations */
            .stick-figure {
                position: absolute;
                width: 50px;
                height: 80px;
                opacity: 0.4;
            }

            .stick-man-1 {
                animation: walkLeftToRight 12s linear infinite;
                top: 15%;
            }

            .stick-man-2 {
                animation: walkLeftToRight 15s linear infinite;
                top: 25%;
                animation-delay: -3s;
            }

            .stick-man-3 {
                animation: walkLeftToRight 18s linear infinite;
                top: 75%;
                animation-delay: -6s;
            }

            .stick-man-4 {
                animation: walkLeftToRight 14s linear infinite;
                top: 85%;
                animation-delay: -9s;
            }

            @keyframes walkLeftToRight {
                0% { left: -80px; }
                100% { left: calc(100% + 80px); }
            }

            /* Individual limb animations for realistic walking - facing right */
            .left-leg {
                animation: leftLegWalk 1s ease-in-out infinite;
                transform-origin: 25px 45px;
            }

            .right-leg {
                animation: rightLegWalk 1s ease-in-out infinite;
                transform-origin: 25px 45px;
            }

            /* Left leg (back leg) animation */
            @keyframes leftLegWalk {
                0% { transform: rotate(-15deg); }
                50% { transform: rotate(15deg); }
                100% { transform: rotate(-15deg); }
            }

            /* Right leg (front leg) animation */
            @keyframes rightLegWalk {
                0% { transform: rotate(15deg); }
                50% { transform: rotate(-15deg); }
                100% { transform: rotate(15deg); }
            }

            /* Cargo Truck Animations */
            .cargo-truck {
                position: absolute;
                width: 120px;
                height: 60px;
                opacity: 0.6;
            }

            .truck-1 {
                animation: truckLeftToRight 20s linear infinite;
                top: 40%;
            }

            .truck-2 {
                animation: truckLeftToRight 25s linear infinite;
                top: 60%;
                animation-delay: -10s;
            }

            @keyframes truckLeftToRight {
                0% { left: -150px; }
                100% { left: calc(100% + 150px); }
            }
        </style>
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen login-bg hotel-gradient-light flex items-center justify-center p-4">
            <!-- Background decorative elements -->
            <div class="absolute inset-0 overflow-hidden pointer-events-none">
                <div class="absolute top-1/4 left-1/4 w-64 h-64 bg-blue-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 floating-animation"></div>
                <div class="absolute top-3/4 right-1/4 w-64 h-64 bg-purple-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 floating-animation" style="animation-delay: 2s;"></div>
                <div class="absolute bottom-1/4 left-1/2 w-64 h-64 bg-pink-400 rounded-full mix-blend-multiply filter blur-xl opacity-20 floating-animation" style="animation-delay: 4s;"></div>
                
                <!-- Black Stick Figures Facing Right and Carrying Boxes -->
                <!-- Stick Man 1 - Carrying a box -->
                <div class="stick-figure stick-man-1">
                    <svg viewBox="0 0 60 80" fill="none">
                        <!-- Head facing right -->
                        <circle cx="25" cy="10" r="6" fill="#000"/>
                        <!-- Eye facing right -->
                        <circle cx="27" cy="9" r="1" fill="#fff"/>
                        <!-- Body -->
                        <line x1="25" y1="16" x2="25" y2="45" stroke="#000" stroke-width="3"/>
                        <!-- Box being carried -->
                        <rect x="30" y="18" width="12" height="10" fill="#8B4513" stroke="#654321" stroke-width="1"/>
                        <!-- Arms holding box -->
                        <line x1="25" y1="22" x2="30" y2="20" stroke="#000" stroke-width="3"/>
                        <line x1="25" y1="26" x2="30" y2="28" stroke="#000" stroke-width="3"/>
                        <!-- Left leg (back) -->
                        <g class="left-leg">
                            <line x1="25" y1="45" x2="20" y2="65" stroke="#000" stroke-width="3"/>
                            <line x1="20" y1="65" x2="18" y2="65" stroke="#000" stroke-width="3"/>
                        </g>
                        <!-- Right leg (front) -->
                        <g class="right-leg">
                            <line x1="25" y1="45" x2="30" y2="65" stroke="#000" stroke-width="3"/>
                            <line x1="30" y1="65" x2="32" y2="65" stroke="#000" stroke-width="3"/>
                        </g>
                    </svg>
                </div>

                <!-- Stick Man 2 - Carrying a different box -->
                <div class="stick-figure stick-man-2">
                    <svg viewBox="0 0 60 80" fill="none">
                        <!-- Head facing right -->
                        <circle cx="25" cy="10" r="6" fill="#000"/>
                        <!-- Eye facing right -->
                        <circle cx="27" cy="9" r="1" fill="#fff"/>
                        <!-- Body -->
                        <line x1="25" y1="16" x2="25" y2="45" stroke="#000" stroke-width="3"/>
                        <!-- Box being carried -->
                        <rect x="29" y="16" width="14" height="8" fill="#4A5568" stroke="#2D3748" stroke-width="1"/>
                        <!-- Arms holding box -->
                        <line x1="25" y1="20" x2="29" y2="18" stroke="#000" stroke-width="3"/>
                        <line x1="25" y1="24" x2="29" y2="24" stroke="#000" stroke-width="3"/>
                        <!-- Left leg (back) -->
                        <g class="left-leg">
                            <line x1="25" y1="45" x2="20" y2="65" stroke="#000" stroke-width="3"/>
                            <line x1="20" y1="65" x2="18" y2="65" stroke="#000" stroke-width="3"/>
                        </g>
                        <!-- Right leg (front) -->
                        <g class="right-leg">
                            <line x1="25" y1="45" x2="30" y2="65" stroke="#000" stroke-width="3"/>
                            <line x1="30" y1="65" x2="32" y2="65" stroke="#000" stroke-width="3"/>
                        </g>
                    </svg>
                </div>

                <!-- Stick Man 3 - Carrying a small package -->
                <div class="stick-figure stick-man-3">
                    <svg viewBox="0 0 60 80" fill="none">
                        <!-- Head facing right -->
                        <circle cx="25" cy="10" r="6" fill="#000"/>
                        <!-- Eye facing right -->
                        <circle cx="27" cy="9" r="1" fill="#fff"/>
                        <!-- Body -->
                        <line x1="25" y1="16" x2="25" y2="45" stroke="#000" stroke-width="3"/>
                        <!-- Small package being carried -->
                        <rect x="31" y="19" width="10" height="8" fill="#DC2626" stroke="#991B1B" stroke-width="1"/>
                        <!-- Arms holding package -->
                        <line x1="25" y1="23" x2="31" y2="21" stroke="#000" stroke-width="3"/>
                        <line x1="25" y1="27" x2="31" y2="27" stroke="#000" stroke-width="3"/>
                        <!-- Left leg (back) -->
                        <g class="left-leg">
                            <line x1="25" y1="45" x2="20" y2="65" stroke="#000" stroke-width="3"/>
                            <line x1="20" y1="65" x2="18" y2="65" stroke="#000" stroke-width="3"/>
                        </g>
                        <!-- Right leg (front) -->
                        <g class="right-leg">
                            <line x1="25" y1="45" x2="30" y2="65" stroke="#000" stroke-width="3"/>
                            <line x1="30" y1="65" x2="32" y2="65" stroke="#000" stroke-width="3"/>
                        </g>
                    </svg>
                </div>

                <!-- Stick Man 4 - Carrying a large box -->
                <div class="stick-figure stick-man-4">
                    <svg viewBox="0 0 60 80" fill="none">
                        <!-- Head facing right -->
                        <circle cx="25" cy="10" r="6" fill="#000"/>
                        <!-- Eye facing right -->
                        <circle cx="27" cy="9" r="1" fill="#fff"/>
                        <!-- Body -->
                        <line x1="25" y1="16" x2="25" y2="45" stroke="#000" stroke-width="3"/>
                        <!-- Large box being carried -->
                        <rect x="28" y="15" width="16" height="12" fill="#2563EB" stroke="#1D4ED8" stroke-width="1"/>
                        <!-- Arms holding large box -->
                        <line x1="25" y1="19" x2="28" y2="17" stroke="#000" stroke-width="3"/>
                        <line x1="25" y1="25" x2="28" y2="25" stroke="#000" stroke-width="3"/>
                        <!-- Left leg (back) -->
                        <g class="left-leg">
                            <line x1="25" y1="45" x2="20" y2="65" stroke="#000" stroke-width="3"/>
                            <line x1="20" y1="65" x2="18" y2="65" stroke="#000" stroke-width="3"/>
                        </g>
                        <!-- Right leg (front) -->
                        <g class="right-leg">
                            <line x1="25" y1="45" x2="30" y2="65" stroke="#000" stroke-width="3"/>
                            <line x1="30" y1="65" x2="32" y2="65" stroke="#000" stroke-width="3"/>
                        </g>
                    </svg>
                </div>

                <!-- Cargo Trucks carrying hotel supplies -->
                <!-- Truck 1 - Hotel Linens (facing right) -->
                <div class="cargo-truck truck-1">
                    <svg viewBox="0 0 120 60" fill="none">
                        <!-- Truck bed/cargo area (now on left) -->
                        <rect x="0" y="15" width="60" height="30" fill="#4A5568" stroke="#2D3748" stroke-width="2" rx="2"/>
                        <!-- Hotel supplies in truck bed -->
                        <rect x="5" y="18" width="12" height="8" fill="#8B4513" stroke="#654321" stroke-width="1"/>
                        <rect x="20" y="18" width="12" height="8" fill="#DC2626" stroke="#991B1B" stroke-width="1"/>
                        <rect x="35" y="18" width="12" height="8" fill="#D4AF37" stroke="#B8941F" stroke-width="1"/>
                        <rect x="5" y="28" width="12" height="8" fill="#7C3AED" stroke="#5B21B6" stroke-width="1"/>
                        <rect x="20" y="28" width="12" height="8" fill="#EA580C" stroke="#C2410C" stroke-width="1"/>
                        <rect x="35" y="28" width="12" height="8" fill="#0891B2" stroke="#0E7490" stroke-width="1"/>
                        <!-- Truck cab (now on right) -->
                        <rect x="60" y="20" width="30" height="25" fill="#2563EB" stroke="#1D4ED8" stroke-width="2" rx="3"/>
                        <!-- Windshield (facing right) -->
                        <rect x="85" y="22" width="4" height="15" fill="#87CEEB" stroke="#4682B4" stroke-width="1"/>
                        <!-- Front grille -->
                        <rect x="89" y="25" width="2" height="12" fill="#1D4ED8"/>
                        <!-- Wheels -->
                        <circle cx="15" cy="45" r="8" fill="#1F2937" stroke="#111827" stroke-width="2"/>
                        <circle cx="15" cy="45" r="4" fill="#6B7280"/>
                        <circle cx="75" cy="45" r="8" fill="#1F2937" stroke="#111827" stroke-width="2"/>
                        <circle cx="75" cy="45" r="4" fill="#6B7280"/>
                        <!-- Hotel logo on truck -->
                        <rect x="20" y="5" width="20" height="8" fill="#3D2914" rx="2"/>
                        <text x="30" y="11" text-anchor="middle" fill="white" font-size="6" font-weight="bold">ICON</text>
                    </svg>
                </div>

                <!-- Truck 2 - Room Amenities (facing right) -->
                <div class="cargo-truck truck-2">
                    <svg viewBox="0 0 120 60" fill="none">
                        <!-- Truck bed/cargo area (now on left) -->
                        <rect x="0" y="15" width="60" height="30" fill="#374151" stroke="#1F2937" stroke-width="2" rx="2"/>
                        <!-- Room amenities in truck bed -->
                        <rect x="5" y="20" width="10" height="6" fill="#F59E0B" stroke="#D97706" stroke-width="1"/>
                        <rect x="18" y="20" width="10" height="6" fill="#EF4444" stroke="#DC2626" stroke-width="1"/>
                        <rect x="31" y="20" width="10" height="6" fill="#8B5CF6" stroke="#7C3AED" stroke-width="1"/>
                        <rect x="44" y="20" width="10" height="6" fill="#06B6D4" stroke="#0891B2" stroke-width="1"/>
                        <rect x="5" y="30" width="10" height="6" fill="#D4AF37" stroke="#B8941F" stroke-width="1"/>
                        <rect x="18" y="30" width="10" height="6" fill="#F97316" stroke="#EA580C" stroke-width="1"/>
                        <rect x="31" y="30" width="10" height="6" fill="#EC4899" stroke="#DB2777" stroke-width="1"/>
                        <rect x="44" y="30" width="10" height="6" fill="#6366F1" stroke="#4F46E5" stroke-width="1"/>
                        <!-- Truck cab (now on right) -->
                        <rect x="60" y="20" width="30" height="25" fill="#3D2914" stroke="#2A1F0F" stroke-width="2" rx="3"/>
                        <!-- Windshield (facing right) -->
                        <rect x="85" y="22" width="4" height="15" fill="#87CEEB" stroke="#4682B4" stroke-width="1"/>
                        <!-- Front grille -->
                        <rect x="89" y="25" width="2" height="12" fill="#2A1F0F"/>
                        <!-- Wheels -->
                        <circle cx="15" cy="45" r="8" fill="#1F2937" stroke="#111827" stroke-width="2"/>
                        <circle cx="15" cy="45" r="4" fill="#6B7280"/>
                        <circle cx="75" cy="45" r="8" fill="#1F2937" stroke="#111827" stroke-width="2"/>
                        <circle cx="75" cy="45" r="4" fill="#6B7280"/>
                        <!-- Hotel logo on truck -->
                        <rect x="20" y="5" width="20" height="8" fill="#2563EB" rx="2"/>
                        <text x="30" y="11" text-anchor="middle" fill="white" font-size="6" font-weight="bold">VENUE</text>
                    </svg>
                </div>
            </div>

            <div class="relative w-full max-w-md">
                <!-- Hotel Logo and Branding -->
                <div class="text-center mb-8">
                    <img src="{{ asset('images/pepega.webp') }}" alt="Icon Venue & Suites" class="w-24 h-24 object-contain mb-4 floating-animation mx-auto block">
                    <h1 class="text-3xl font-bold bg-gradient-to-r from-amber-600 via-yellow-600 to-amber-700 bg-clip-text text-transparent mb-2">
                        Icon Venue & Suites
                    </h1>
                    <p class="text-gray-600 font-medium">Inventory Management System</p>
                    <div class="w-24 h-1 hotel-gradient rounded-full mx-auto mt-4"></div>
                </div>

                <!-- Login Card -->
                <div class="glass-effect rounded-3xl shadow-2xl p-8 border border-white/20">
                    <div class="text-center mb-6">
                        <h2 class="text-2xl font-bold text-gray-900 mb-2">Welcome Back</h2>
                        <p class="text-gray-600">Please sign in to your account</p>
                    </div>

                    {{ $slot }}
                </div>
            </div>
        </div>
    </body>
</html>
