<style>
    /* Modern styling */
    .modern-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        transition: all 0.2s ease-in-out;
    }
    .modern-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }
    .modern-button {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.2s ease-in-out;
    }
    .modern-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* Glass effect for stats cards */
    .glass-effect {
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
    }
    
    .stats-card {
        transition: all 0.3s ease;
    }
    
    .stats-card:hover {
        transform: translateY(-4px);
    }

    .animated-button {
        position: relative;
        overflow: hidden;
    }
    .animated-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    .animated-button:hover::before {
        left: 100%;
    }

    /* Enhanced chart cards */
    .chart-card {
        position: relative;
        overflow: hidden;
    }
    
    .chart-card::before {
        content: '';
        position: absolute;
        top: -2px;
        left: -2px;
        right: -2px;
        bottom: -2px;
        background: linear-gradient(135deg, #D4AF37, #3D2914, #D4AF37);
        border-radius: 18px;
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: -1;
    }
    
    .chart-card:hover::before {
        opacity: 0.15;
    }

    .chart-header-icon {
        background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);
        box-shadow: 0 4px 12px rgba(61, 41, 20, 0.2);
    }

    .list-item-card {
        transition: all 0.2s ease;
        border: 1px solid transparent;
    }

    .list-item-card:hover {
        border-color: #D4AF37;
        transform: translateX(4px);
        box-shadow: 0 4px 12px rgba(212, 175, 55, 0.15);
    }
</style>

<x-app-layout>
    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            
            <!-- Modern Page Header -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 sm:mb-8">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0" 
                         style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                        <svg class="w-5 h-5 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-4xl font-bold mb-1 text-amber-700">Analytics Dashboard</h1>
                        <p class="text-gray-600 text-sm sm:text-lg font-medium hidden sm:block">Comprehensive insights and visual analytics for your inventory</p>
                        <div class="flex items-center mt-1 sm:mt-3 text-sm text-gray-500">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            <span class="font-medium">Real-time Data</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex items-center">
                    <div x-data="{ exportDropdown: false }" class="relative">
                        <button @click="exportDropdown = !exportDropdown" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold" style="border: 1px solid #D4AF37; color: #3D2914;">
                            <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span class="hidden sm:inline">Export Reports</span>
                            <svg class="w-4 h-4 sm:ml-2 transition-transform duration-200" :class="{'rotate-180': exportDropdown}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        
                        <div x-show="exportDropdown" @click.away="exportDropdown = false" x-transition class="absolute left-0 sm:left-auto sm:right-0 mt-2 w-72 sm:w-80 bg-white rounded-2xl shadow-2xl border border-gray-100 z-50">
                            <div class="p-2">
                                <button onclick="openExportModal('{{ route('reports.export') }}', 'Complete Analytics Report')" class="w-full flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200 rounded-xl">
                                    <svg class="w-4 h-4 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                    Complete Analytics Report
                                    <span class="ml-auto text-xs text-gray-500">CSV</span>
                                </button>
                                
                                <button onclick="openExportModal('{{ route('transactions.export') }}', 'Transactions Only')" class="w-full flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200 rounded-xl">
                                    <svg class="w-4 h-4 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                    </svg>
                                    Transactions Only
                                    <span class="ml-auto text-xs text-gray-500">CSV</span>
                                </button>
                                
                                <button onclick="openExportModal('{{ route('inventory.export') }}', 'Inventory Items Only')" class="w-full flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200 rounded-xl">
                                    <svg class="w-4 h-4 mr-3 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                    Inventory Items Only
                                    <span class="ml-auto text-xs text-gray-500">CSV</span>
                                </button>
                                
                                <button onclick="openExportModal('{{ route('batches.export') }}', 'Batches Only')" class="w-full flex items-center px-4 py-3 text-sm text-gray-700 hover:bg-gray-50 hover:text-gray-900 transition-colors duration-200 rounded-xl">
                                    <svg class="w-4 h-4 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                    </svg>
                                    Batches Only
                                    <span class="ml-auto text-xs text-gray-500">CSV</span>
                                </button>
                                
                                <div class="px-4 py-2">
                                    <p class="text-xs text-gray-500">You'll be asked to select a date range before downloading.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KPI Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4 sm:gap-6 mb-8">
                <!-- Total Transactions -->
                <div class="modern-card stats-card glass-effect rounded-2xl p-6 border border-white/20 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-500/10 to-transparent rounded-full -mr-16 -mt-16"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                                </svg>
                            </div>
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold {{ $transactionGrowth >= 0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($transactionGrowth >= 0)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                    @endif
                                </svg>
                                {{ $transactionGrowth >= 0 ? '+' : '' }}{{ $transactionGrowth }}%
                            </div>
                        </div>
                        <h3 class="text-sm font-medium text-gray-600 mb-1">Total Transactions</h3>
                        <p class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($totalTransactions) }}</p>
                        <p class="text-xs text-gray-500">
                            <span class="font-medium">{{ number_format($thisMonthTransactions ?? 0) }}</span> this month
                        </p>
                    </div>
                </div>

                <!-- Total Items -->
                <div class="modern-card stats-card glass-effect rounded-2xl p-6 border border-white/20 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-500/10 to-transparent rounded-full -mr-16 -mt-16"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #059669 0%, #10B981 100%);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                {{ number_format(($totalItems - $lowStockItems)) }} OK
                            </div>
                        </div>
                        <h3 class="text-sm font-medium text-gray-600 mb-1">Inventory Items</h3>
                        <p class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($totalItems) }}</p>
                        <div class="flex items-center gap-2">
                            <div class="flex-1 h-2 bg-gray-200 rounded-full overflow-hidden">
                                <div class="h-full bg-gradient-to-r from-green-500 to-emerald-500 rounded-full" style="width: {{ $totalItems > 0 ? round((($totalItems - $lowStockItems) / $totalItems) * 100) : 0 }}%"></div>
                            </div>
                            <span class="text-xs font-medium text-gray-600">{{ $totalItems > 0 ? round((($totalItems - $lowStockItems) / $totalItems) * 100) : 0 }}%</span>
                        </div>
                    </div>
                </div>

                <!-- Inventory Value -->
                <div class="modern-card stats-card glass-effect rounded-2xl p-6 border border-white/20 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-purple-500/10 to-transparent rounded-full -mr-16 -mt-16"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #7C3AED 0%, #A855F7 100%);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div class="flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Assets
                            </div>
                        </div>
                        <h3 class="text-sm font-medium text-gray-600 mb-1">Total Value</h3>
                        <p class="text-3xl font-bold text-gray-900 mb-2">₱{{ number_format($totalValue, 0) }}</p>
                        <p class="text-xs text-gray-500">
                            Current book value
                        </p>
                    </div>
                </div>

                <!-- Low Stock Alerts -->
                <div class="modern-card stats-card glass-effect rounded-2xl p-6 border border-white/20 hover:shadow-2xl transition-all duration-300 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-red-500/10 to-transparent rounded-full -mr-16 -mt-16"></div>
                    <div class="relative">
                        <div class="flex items-center justify-between mb-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                            </div>
                            @if($lowStockItems > 0)
                                <div class="flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700 animate-pulse">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                                    </svg>
                                    Action Needed
                                </div>
                            @else
                                <div class="flex items-center gap-1 px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    All Good
                                </div>
                            @endif
                        </div>
                        <h3 class="text-sm font-medium text-gray-600 mb-1">Low Stock Alerts</h3>
                        <p class="text-3xl font-bold {{ $lowStockItems > 0 ? 'text-red-600' : 'text-gray-900' }} mb-2">{{ $lowStockItems }}</p>
                        <p class="text-xs {{ $lowStockItems > 0 ? 'text-red-600 font-medium' : 'text-gray-500' }}">
                            {{ $lowStockItems > 0 ? $lowStockPercentage . '% of inventory needs restocking' : 'All items adequately stocked' }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 mb-8">
                <!-- Transaction Types Chart -->
                <div class="modern-card chart-card p-6 sm:p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-amber-500/5 to-transparent rounded-full -mr-20 -mt-20"></div>
                    <div class="flex items-center justify-between mb-6 relative">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 chart-header-icon rounded-xl flex items-center justify-center flex-shrink-0">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.488 9H15V3.512A9.025 9.025 0 0120.488 9z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Transaction Types</h3>
                                <p class="text-sm text-gray-500 mt-0.5">Distribution of transaction activities</p>
                            </div>
                        </div>
                        <div class="hidden sm:flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-amber-50 to-yellow-50 text-amber-700 border border-amber-200">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                            </svg>
                            Live Data
                        </div>
                    </div>
                    <div class="relative h-64 sm:h-80">
                        <canvas id="transactionTypesChart"></canvas>
                    </div>
                </div>

                <!-- Stock Status Chart -->
                <div class="modern-card chart-card p-6 sm:p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-green-500/5 to-transparent rounded-full -mr-20 -mt-20"></div>
                    <div class="flex items-center justify-between mb-6 relative">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg" style="background: linear-gradient(135deg, #059669 0%, #10B981 100%);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Stock Status</h3>
                                <p class="text-sm text-gray-500 mt-0.5">Current inventory health overview</p>
                            </div>
                        </div>
                        <div class="hidden sm:flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-green-50 to-emerald-50 text-green-700 border border-green-200">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                            Inventory
                        </div>
                    </div>
                    <div class="relative h-64 sm:h-80">
                        <canvas id="stockStatusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Transaction Trends Chart -->
            <div class="modern-card chart-card p-6 sm:p-8 mb-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-500/5 to-transparent rounded-full -mr-20 -mt-20"></div>
                <div class="flex items-center justify-between mb-6 relative">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg" style="background: linear-gradient(135deg, #2563EB 0%, #3B82F6 100%);">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Transaction Trends</h3>
                            <p class="text-sm text-gray-500 mt-0.5">Monthly transaction activity over the last 12 months</p>
                        </div>
                    </div>
                    <div class="hidden sm:flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 border border-blue-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        </svg>
                        12 Months
                    </div>
                </div>
                <div class="relative h-64 sm:h-80">
                    <canvas id="transactionTrendsChart"></canvas>
                </div>
            </div>

            <!-- Items by Category Chart -->
            <div class="modern-card chart-card p-6 sm:p-8 mb-8 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-purple-500/5 to-transparent rounded-full -mr-20 -mt-20"></div>
                <div class="flex items-center justify-between mb-6 relative">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg" style="background: linear-gradient(135deg, #7C3AED 0%, #A855F7 100%);">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-900">Items by Category</h3>
                            <p class="text-sm text-gray-500 mt-0.5">Distribution of items across categories</p>
                        </div>
                    </div>
                    <div class="hidden sm:flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-purple-50 to-pink-50 text-purple-700 border border-purple-200">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path>
                        </svg>
                        Categories
                    </div>
                </div>
                <div class="relative h-64 sm:h-80">
                    <canvas id="itemsByCategoryChart"></canvas>
                </div>
            </div>

            <!-- Top Borrowed Items and User Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 mb-8">
                <!-- Top Borrowed Items -->
                <div class="modern-card chart-card p-6 sm:p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-orange-500/5 to-transparent rounded-full -mr-20 -mt-20"></div>
                    <div class="flex items-center justify-between mb-6 relative">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg" style="background: linear-gradient(135deg, #EA580C 0%, #F97316 100%);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5.5A2.5 2.5 0 109.5 8H12zm-7 4h14M5 12a2 2 0 110-4h14a2 2 0 110 4M5 12v7a2 2 0 002 2h10a2 2 0 002-2v-7"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Top Borrowed Items</h3>
                                <p class="text-sm text-gray-500 mt-0.5">Top 5 frequently borrowed items</p>
                            </div>
                        </div>
                        <div class="hidden sm:flex items-center gap-1 px-3 py-1.5 rounded-full text-xs font-semibold bg-gradient-to-r from-orange-50 to-red-50 text-orange-700 border border-orange-200">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                            </svg>
                            Top 5
                        </div>
                    </div>
                    <div class="space-y-3">
                        @forelse($topBorrowedItems as $index => $item)
                        <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl list-item-card">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-4 flex-shrink-0 shadow-md">
                                <span class="text-white font-bold text-sm">{{ $index + 1 }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-900 truncate">{{ $item->name }}</p>
                                <p class="text-sm text-gray-600">{{ $item->borrow_count }} times borrowed</p>
                            </div>
                            <div class="text-right ml-4">
                                <p class="text-lg font-bold text-orange-600">{{ $item->total_borrowed }}</p>
                                <p class="text-xs text-gray-500">Total qty</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12 text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                            </svg>
                            <p class="font-medium">No borrowing activity yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- User Activity -->
                <div class="modern-card chart-card p-6 sm:p-8 relative overflow-hidden">
                    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-500/5 to-transparent rounded-full -mr-20 -mt-20"></div>
                    <div class="flex items-center justify-between mb-6 relative">
                        <div class="flex items-center space-x-4">
                            <div class="w-12 h-12 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg" style="background: linear-gradient(135deg, #1D4ED8 0%, #3B82F6 100%);">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">User Activity</h3>
                                <p class="text-sm text-gray-500 mt-0.5">Most active users in the system</p>
                            </div>
                        </div>
                        <a href="{{ route('transactions.index') }}" class="hidden sm:flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 border border-blue-200 hover:shadow-md transition-all duration-200">
                            View All
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                    <div class="space-y-3">
                        @forelse($userActivity as $user)
                        <div class="flex items-center p-4 bg-gradient-to-r from-gray-50 to-white rounded-xl list-item-card">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-4 flex-shrink-0 shadow-md">
                                <span class="text-white font-bold text-sm">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <p class="font-semibold text-gray-900 text-sm truncate">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">System user</p>
                            </div>
                            <div class="text-right ml-4">
                                <p class="text-2xl font-bold text-blue-600">{{ $user->transaction_count }}</p>
                                <p class="text-xs text-gray-500">Transactions</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-12 text-gray-400">
                            <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                            </svg>
                            <p class="font-medium">No user activity data available</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <script>
        // Hotel brand colors
        const brandColors = {
            primary: '#3D2914',
            secondary: '#D4AF37',
            accent: '#F4E4BC',
            success: '#10B981',
            warning: '#F59E0B',
            error: '#EF4444',
            info: '#3B82F6'
        };

        // Transaction Types Pie Chart
        const transactionTypesCtx = document.getElementById('transactionTypesChart').getContext('2d');
        new Chart(transactionTypesCtx, {
            type: 'pie',
            data: {
                labels: [
                    @foreach($transactionsByType as $type)
                        '{{ ucfirst(str_replace("_", " ", $type->transaction_type)) }}',
                    @endforeach
                ],
                datasets: [{
                    data: [
                        @foreach($transactionsByType as $type)
                            {{ $type->count }},
                        @endforeach
                    ],
                    backgroundColor: [
                        brandColors.primary,
                        brandColors.secondary,
                        brandColors.success,
                        brandColors.warning,
                        brandColors.error,
                        brandColors.info
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // Stock Status Doughnut Chart
        const stockStatusCtx = document.getElementById('stockStatusChart').getContext('2d');
        new Chart(stockStatusCtx, {
            type: 'doughnut',
            data: {
                labels: ['In Stock', 'Low Stock', 'Out of Stock'],
                datasets: [{
                    data: [
                        {{ $stockStatus['in_stock'] }},
                        {{ $stockStatus['low_stock'] }},
                        {{ $stockStatus['out_of_stock'] }}
                    ],
                    backgroundColor: [
                        brandColors.success,
                        brandColors.warning,
                        brandColors.error
                    ],
                    borderWidth: 2,
                    borderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true
                        }
                    }
                }
            }
        });

        // Transaction Trends Line Chart
        const transactionTrendsCtx = document.getElementById('transactionTrendsChart').getContext('2d');
        new Chart(transactionTrendsCtx, {
            type: 'line',
            data: {
                labels: [
                    @foreach($transactionsByMonth as $month)
                        '{{ date("M Y", strtotime($month->month . "-01")) }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Transactions',
                    data: [
                        @foreach($transactionsByMonth as $month)
                            {{ $month->count }},
                        @endforeach
                    ],
                    backgroundColor: brandColors.primary,
                    borderColor: brandColors.secondary,
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });

        // Items by Category Bar Chart
        const itemsByCategoryCtx = document.getElementById('itemsByCategoryChart').getContext('2d');
        new Chart(itemsByCategoryCtx, {
            type: 'bar',
            data: {
                labels: [
                    @foreach($itemsByCategory as $category)
                        '{{ $category->category }}',
                    @endforeach
                ],
                datasets: [{
                    label: 'Items',
                    data: [
                        @foreach($itemsByCategory as $category)
                            {{ $category->count }},
                        @endforeach
                    ],
                    backgroundColor: brandColors.primary,
                    borderColor: brandColors.secondary,
                    borderWidth: 2,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f3f4f6'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        }
                    }
                }
            }
        });
    </script>
    
    <script>
        // Function to handle export clicks with proper loading state management
        function handleExportClick(event, url) {
            event.preventDefault(); // Prevent default link behavior
            event.stopPropagation(); // Stop event bubbling
            
            const pageLoader = document.getElementById('pageLoader');
            const loadingProgress = document.getElementById('loadingProgress');
            
            // Show loading state
            if (pageLoader) {
                pageLoader.classList.add('active');
            }
            
            // Simulate progress
            let progress = 0;
            const progressInterval = setInterval(() => {
                progress += Math.random() * 10;
                if (progress > 85) progress = 85;
                if (loadingProgress) {
                    loadingProgress.style.width = progress + '%';
                }
            }, 50);
            
            // Use a more reliable download method
            const link = document.createElement('a');
            link.href = url;
            link.download = ''; // This attribute forces download
            link.style.display = 'none';
            document.body.appendChild(link);
            
            // Trigger download
            link.click();
            
            // Clean up immediately
            document.body.removeChild(link);
            
            // Hide loading state after download starts
            setTimeout(() => {
                clearInterval(progressInterval);
                if (loadingProgress) {
                    loadingProgress.style.width = '100%';
                }
                
                setTimeout(() => {
                    if (pageLoader) {
                        pageLoader.classList.remove('active');
                    }
                    if (loadingProgress) {
                        loadingProgress.style.width = '0%';
                    }
                }, 200);
            }, 2000);
            
            return false; // Extra prevention of default behavior
        }
        
        // Legacy function for backward compatibility
        function downloadFile(url) {
            handleExportClick({ 
                preventDefault: () => {}, 
                stopPropagation: () => {} 
            }, url);
        }

        // Date range export modal
        let exportBaseUrl = '';

        function openExportModal(url, label) {
            exportBaseUrl = url;
            document.getElementById('exportModalTitle').textContent = label;
            document.getElementById('exportDateModal').classList.remove('hidden');
            document.getElementById('exportDateModal').classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        function closeExportModal() {
            document.getElementById('exportDateModal').classList.add('hidden');
            document.getElementById('exportDateModal').classList.remove('flex');
            document.body.style.overflow = '';
            document.getElementById('export_date_from').value = '';
            document.getElementById('export_date_to').value = '';
        }

        function submitExport() {
            const from = document.getElementById('export_date_from').value;
            const to = document.getElementById('export_date_to').value;
            let url = exportBaseUrl;
            const params = new URLSearchParams();
            if (from) params.append('date_from', from);
            if (to) params.append('date_to', to);
            if (params.toString()) url += '?' + params.toString();
            closeExportModal();
            const link = document.createElement('a');
            link.href = url;
            link.download = '';
            link.style.display = 'none';
            document.body.appendChild(link);
            link.click();
            document.body.removeChild(link);
        }

    </script>

    <!-- Date Range Export Modal -->
    <div id="exportDateModal" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto border border-amber-200">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 rounded-t-2xl" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                <div class="flex items-center">
                    <div class="w-9 h-9 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Export: <span id="exportModalTitle"></span></h3>
                        <p class="text-amber-100 text-xs">Select a date range (optional)</p>
                    </div>
                </div>
                <button onclick="closeExportModal()" class="text-white hover:text-amber-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg transition-colors duration-200">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="p-5 space-y-4">
                <p class="text-xs text-gray-500">Leave blank to export all data with no date filter.</p>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">From</label>
                        <input type="date" id="export_date_from" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">To</label>
                        <input type="date" id="export_date_to" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-2 border-t border-gray-100">
                    <button onclick="closeExportModal()" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm font-medium transition-colors duration-200">Cancel</button>
                    <button onclick="submitExport()" class="animated-button px-5 py-2 text-white font-semibold rounded-xl text-sm transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                        <svg class="w-4 h-4 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download CSV
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>