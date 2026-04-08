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
                                
                                <div class="px-4 py-2">
                                    <p class="text-xs text-gray-500">You'll be asked to select a date range before downloading.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- KPI Cards -->
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6 mb-8">
                <!-- Total Transactions -->
                <div class="modern-card stats-card glass-effect rounded-2xl p-4 sm:p-6 border border-white/20 hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center mr-3 sm:mr-4 shadow-lg flex-shrink-0" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                            <svg class="w-5 h-5 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Total Transactions</p>
                            <p class="text-xl sm:text-3xl font-bold text-gray-900">{{ number_format($totalTransactions) }}</p>
                            <p class="text-xs font-medium text-green-600 hidden sm:block">+12% this month</p>
                        </div>
                    </div>
                </div>

                <!-- Total Items -->
                <div class="modern-card stats-card glass-effect rounded-2xl p-4 sm:p-6 border border-white/20 hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center mr-3 sm:mr-4 shadow-lg flex-shrink-0" style="background: linear-gradient(135deg, #059669 0%, #10B981 100%);">
                            <svg class="w-5 h-5 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Total Items</p>
                            <p class="text-xl sm:text-3xl font-bold text-gray-900">{{ number_format($totalItems) }}</p>
                            <p class="text-xs font-medium text-gray-500 hidden sm:block">Across all categories</p>
                        </div>
                    </div>
                </div>

                <!-- Inventory Value -->
                <div class="modern-card stats-card glass-effect rounded-2xl p-4 sm:p-6 border border-white/20 hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center mr-3 sm:mr-4 shadow-lg flex-shrink-0" style="background: linear-gradient(135deg, #7C3AED 0%, #A855F7 100%);">
                            <svg class="w-5 h-5 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Inventory Value</p>
                            <p class="text-lg sm:text-3xl font-bold text-gray-900 truncate">₱{{ number_format($totalValue, 0) }}</p>
                            <p class="text-xs font-medium text-gray-500 hidden sm:block">Total asset value</p>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Alerts -->
                <div class="modern-card stats-card glass-effect rounded-2xl p-4 sm:p-6 border border-white/20 hover:shadow-2xl transition-all duration-300">
                    <div class="flex items-center">
                        <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center mr-3 sm:mr-4 shadow-lg flex-shrink-0" style="background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);">
                            <svg class="w-5 h-5 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <p class="text-xs sm:text-sm font-medium text-gray-600 mb-1">Low Stock Alerts</p>
                            <p class="text-xl sm:text-3xl font-bold text-gray-900">{{ $lowStockItems }}</p>
                            <p class="text-xs font-medium {{ $lowStockItems > 0 ? 'text-red-600' : 'text-green-600' }}">
                                {{ $lowStockItems > 0 ? 'Needs attention' : 'All good!' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 mb-8">
                <!-- Transaction Types Chart -->
                <div class="modern-card p-4 sm:p-6">
                    <div class="flex items-center justify-between mb-4 sm:mb-6">
                        <div>
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900">Transaction Types</h3>
                            <p class="text-sm text-gray-600">Distribution of transaction activities</p>
                        </div>
                    </div>
                    <div class="relative h-56 sm:h-80">
                        <canvas id="transactionTypesChart"></canvas>
                    </div>
                </div>

                <!-- Stock Status Chart -->
                <div class="modern-card p-4 sm:p-6">
                    <div class="flex items-center justify-between mb-4 sm:mb-6">
                        <div>
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900">Stock Status</h3>
                            <p class="text-sm text-gray-600">Current inventory health overview</p>
                        </div>
                    </div>
                    <div class="relative h-56 sm:h-80">
                        <canvas id="stockStatusChart"></canvas>
                    </div>
                </div>
            </div>

            <!-- Transaction Trends Chart -->
            <div class="modern-card p-4 sm:p-6 mb-6 sm:mb-8">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900">Transaction Trends</h3>
                        <p class="text-sm text-gray-600">Monthly transaction activity over the last 12 months</p>
                    </div>
                </div>
                <div class="relative h-56 sm:h-80">
                    <canvas id="transactionTrendsChart"></canvas>
                </div>
            </div>

            <!-- Items by Category Chart -->
            <div class="modern-card p-4 sm:p-6 mb-6 sm:mb-8">
                <div class="flex items-center justify-between mb-4 sm:mb-6">
                    <div>
                        <h3 class="text-lg sm:text-xl font-bold text-gray-900">Items by Category</h3>
                        <p class="text-sm text-gray-600">Distribution of items across categories</p>
                    </div>
                </div>
                <div class="relative h-56 sm:h-80">
                    <canvas id="itemsByCategoryChart"></canvas>
                </div>
            </div>

            <!-- Top Borrowed Items and User Activity -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 mb-6 sm:mb-8">
                <!-- Top Borrowed Items -->
                <div class="modern-card p-4 sm:p-6">
                    <div class="flex items-center justify-between mb-4 sm:mb-6">
                        <div>
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900">Top Borrowed Items</h3>
                            <p class="text-sm text-gray-600">Top 5 frequently borrowed items</p>
                        </div>
                    </div>
                    <div class="space-y-4">
                        @forelse($topBorrowedItems as $index => $item)
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-red-600 rounded-xl flex items-center justify-center mr-4">
                                <span class="text-white font-bold text-sm">{{ $index + 1 }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900">{{ $item->name }}</p>
                                <p class="text-sm text-gray-600">{{ $item->borrow_count }} times borrowed</p>
                            </div>
                            <div class="text-right">
                                <p class="text-lg font-bold text-blue-600">{{ $item->total_borrowed }}</p>
                                <p class="text-xs text-gray-500">Total quantity</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">
                            <p>No borrowing activity yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- User Activity -->
                <div class="modern-card p-4 sm:p-6">
                    <div class="flex items-center justify-between mb-4 sm:mb-6">
                        <div>
                            <h3 class="text-lg sm:text-xl font-bold text-gray-900">User Activity</h3>
                            <p class="text-sm text-gray-600">Most active users in the system</p>
                        </div>
                        <a href="{{ route('transactions.index') }}" class="text-sm text-blue-600 hover:text-blue-800 font-medium hidden sm:block">View All Transactions</a>
                    </div>
                    <div class="space-y-4">
                        @forelse($userActivity as $user)
                        <div class="flex items-center p-4 bg-gray-50 rounded-xl">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-purple-600 rounded-full flex items-center justify-center mr-4">
                                <span class="text-white font-bold text-sm">{{ substr($user->name, 0, 1) }}</span>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-900 text-sm">{{ $user->name }}</p>
                                <p class="text-2xl font-bold text-blue-600">{{ $user->transaction_count }}</p>
                                <p class="text-xs text-gray-500">Transactions</p>
                            </div>
                        </div>
                        @empty
                        <div class="text-center py-8 text-gray-500">
                            <p>No user activity data available</p>
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