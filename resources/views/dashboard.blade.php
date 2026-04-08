<style>
    .dashboard-card { background: white; border-radius: 20px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06); transition: all 0.3s ease; border: 1px solid #f3f4f6; }
    .dashboard-card:hover { transform: translateY(-4px); box-shadow: 0 20px 25px -5px rgba(0,0,0,0.1), 0 10px 10px -5px rgba(0,0,0,0.04); }
    .gradient-bg { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); }
    .welcome-gradient { background: linear-gradient(135deg, #3D2914 0%, #D4AF37 50%, #F4E4BC 100%); }
    .floating-animation { animation: float 6s ease-in-out infinite; }
    @keyframes float { 0%, 100% { transform: translateY(0px); } 50% { transform: translateY(-10px); } }
    .pulse-ring { animation: pulse-ring 1.25s cubic-bezier(0.215, 0.61, 0.355, 1) infinite; }
    @keyframes pulse-ring { 0% { transform: scale(.33); } 80%, 100% { opacity: 0; } }
    .border-ring { position: absolute; inset: -8px; border-radius: 50%; background: conic-gradient(from 0deg, rgba(16,185,129,0.8) 0deg, rgba(245,158,11,0.8) 120deg, rgba(239,68,68,0.8) 240deg, rgba(16,185,129,0.8) 360deg); animation: smooth-rotate 30s linear infinite; z-index: 1; }
    @keyframes smooth-rotate { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
    .border-inner { position: absolute; inset: 3px; border-radius: 50%; background: linear-gradient(135deg, rgba(255,255,255,0.95) 0%, rgba(249,250,251,0.9) 50%, rgba(255,255,255,0.95) 100%); z-index: 2; }
    .border-decorations { position: absolute; inset: -12px; z-index: 0; }
    .floating-element { position: absolute; animation: float-smooth 6s ease-in-out infinite; }
    @keyframes float-smooth { 0%, 100% { transform: translateY(0px) scale(1); opacity: 0.7; } 50% { transform: translateY(-8px) scale(1.1); opacity: 1; } }
    .mini-box { width: 12px; height: 10px; background: linear-gradient(135deg, #10B981 0%, #059669 50%, #047857 100%); border-radius: 2px; position: relative; box-shadow: 0 4px 8px rgba(16,185,129,0.4), inset 0 1px 0 rgba(255,255,255,0.3), inset 0 -1px 0 rgba(0,0,0,0.1); }
    .mini-package { width: 12px; height: 10px; background: linear-gradient(135deg, #F59E0B 0%, #D97706 50%, #B45309 100%); border-radius: 2px; position: relative; box-shadow: 0 4px 8px rgba(245,158,11,0.4), inset 0 1px 0 rgba(255,255,255,0.3), inset 0 -1px 0 rgba(0,0,0,0.1); }
    .mini-warehouse { width: 12px; height: 10px; background: linear-gradient(135deg, #EF4444 0%, #DC2626 50%, #B91C1C 100%); border-radius: 2px; position: relative; box-shadow: 0 4px 8px rgba(239,68,68,0.4), inset 0 1px 0 rgba(255,255,255,0.3), inset 0 -1px 0 rgba(0,0,0,0.1); }
    .pulse-dot { width: 3px; height: 3px; border-radius: 50%; animation: smooth-pulse 4s ease-in-out infinite; }
    @keyframes smooth-pulse { 0%, 100% { opacity: 0.4; transform: scale(1); } 50% { opacity: 1; transform: scale(1.5); } }
    .pulse-green { background: #10B981; } .pulse-orange { background: #F59E0B; } .pulse-red { background: #EF4444; }
    .pos-1 { top: -3px; left: 50%; transform: translateX(-50%); animation-delay: 0s; }
    .pos-2 { top: 20%; right: 2px; animation-delay: 1s; }
    .pos-3 { top: 50%; right: -3px; transform: translateY(-50%); animation-delay: 2s; }
    .pos-4 { bottom: 20%; right: 2px; animation-delay: 3s; }
    .pos-5 { bottom: -3px; left: 50%; transform: translateX(-50%); animation-delay: 4s; }
    .pos-6 { bottom: 20%; left: 2px; animation-delay: 5s; }
    .pos-7 { top: 50%; left: -3px; transform: translateY(-50%); animation-delay: 0.5s; }
    .pos-8 { top: 20%; left: 2px; animation-delay: 1.5s; }
    .dot-1 { top: 10%; left: 25%; animation-delay: 0s; } .dot-2 { top: 25%; right: 10%; animation-delay: 1.3s; }
    .dot-3 { bottom: 10%; right: 25%; animation-delay: 2.6s; } .dot-4 { bottom: 25%; left: 10%; animation-delay: 3.9s; }
    .inventory-border { position: relative; animation: border-glow 8s ease-in-out infinite; }
    @keyframes border-glow { 0%, 100% { filter: drop-shadow(0 0 12px rgba(16,185,129,0.4)); } 50% { filter: drop-shadow(0 0 20px rgba(245,158,11,0.5)); } }
    .activity-item { transition: all 0.2s ease; }
    .activity-item:hover { background-color: #f8fafc; transform: translateX(4px); }
</style>

<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
                
            <!-- Welcome Hero Section -->
            <div class="welcome-gradient rounded-3xl shadow-2xl overflow-hidden mb-8">
                <div class="px-4 sm:px-8 py-8 sm:py-12 relative">
                    <div class="flex flex-col sm:flex-row items-center sm:justify-between gap-6">
                        <div class="flex flex-col sm:flex-row items-center sm:space-x-6 gap-4 text-center sm:text-left">
                            <div class="relative">
                                <div class="relative w-28 h-28 flex items-center justify-center">
                                    @if(auth()->user()->profile_picture)
                                        <div class="relative rounded-full bg-gradient-to-r from-amber-600 via-yellow-700 to-amber-800 shadow-2xl z-10" style="padding: 4px;">
                                            <img src="{{ auth()->user()->getProfilePictureUrl() }}" 
                                                 alt="{{ auth()->user()->name }}" 
                                                 class="w-20 h-20 rounded-full object-cover bg-white">
                                        </div>
                                    @else
                                        <div class="relative rounded-full bg-gradient-to-r from-amber-600 via-yellow-700 to-amber-800 shadow-2xl z-10" style="padding: 4px;">
                                            <div class="w-20 h-20 bg-white bg-opacity-20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                                </svg>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="inventory-border absolute inset-0 z-0">
                                        <div class="border-ring"></div>
                                        <div class="border-inner"></div>
                                        <div class="border-decorations">
                                            <div class="floating-element mini-box pos-1"></div>
                                            <div class="floating-element mini-package pos-3"></div>
                                            <div class="floating-element mini-warehouse pos-5"></div>
                                            <div class="floating-element mini-box pos-7"></div>
                                            <div class="floating-element mini-package pos-2"></div>
                                            <div class="floating-element mini-warehouse pos-4"></div>
                                            <div class="floating-element mini-box pos-6"></div>
                                            <div class="floating-element mini-package pos-8"></div>
                                            <div class="pulse-dot pulse-green dot-1"></div>
                                            <div class="pulse-dot pulse-orange dot-2"></div>
                                            <div class="pulse-dot pulse-red dot-3"></div>
                                            <div class="pulse-dot pulse-green dot-4"></div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="absolute top-1 right-1 w-6 h-6 bg-green-400 rounded-full flex items-center justify-center shadow-lg border-2 border-white z-20">
                                    <div class="w-2 h-2 bg-white rounded-full pulse-ring"></div>
                                </div>
                            </div>
                            <div class="text-white">
                                <h1 class="text-4xl font-bold mb-2">Good {{ date('H') < 12 ? 'Morning' : (date('H') < 18 ? 'Afternoon' : 'Evening') }}, {{ auth()->user()->name }}!</h1>
                                <p class="text-xl text-white text-opacity-90 font-medium">Welcome back to your inventory workspace</p>
                                <div class="flex items-center mt-4 space-x-4 text-white text-opacity-80">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3a2 2 0 012-2h4a2 2 0 012 2v4m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1m-6 0h6m-6 0l-.5 9a2 2 0 002 2h3a2 2 0 002-2L16 7m-6 0V6a2 2 0 012-2h4a2 2 0 012 2v1"></path>
                                        </svg>
                                        <span>{{ auth()->user()->role === 'admin' ? 'Administrator' : 'Staff Member' }}</span>
                                    </div>
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                        <span>{{ now()->format('l, F j, Y') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="hidden lg:block">
                            <img src="{{ asset('images/pepega.webp') }}" alt="Icon Venue & Suites" class="w-32 h-32 object-contain floating-animation opacity-80">
                        </div>
                    </div>
                </div>
            </div>

            @include('dashboard.partials.stats-cards')

            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">
                <!-- Recent Activity -->
                <div class="lg:col-span-2">
                    @include('dashboard.partials.recent-activity')
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    @include('dashboard.partials.alerts')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
