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

    .detail-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 2rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        transition: all 0.2s ease-in-out;
    }

    .detail-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
    }

    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 0.75rem 1.5rem;
        border-radius: 12px;
        font-size: 0.875rem;
        font-weight: 600;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
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
    <div x-data="{}" class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            
            <!-- Modern Page Header -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 sm:mb-8">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0" 
                         style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                        <svg class="w-5 h-5 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-4xl font-bold mb-1 text-amber-700">{{ $batch->batch_number }}</h1>
                        <p class="text-gray-600 text-sm sm:text-lg font-medium hidden sm:block">Detailed information about this batch</p>
                        <div class="flex flex-wrap items-center mt-1 sm:mt-3 gap-3 sm:gap-6 text-sm text-gray-500">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                                <span class="font-medium">{{ $batch->item->name }}</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                <span class="font-medium">{{ number_format($batch->quantity) }} {{ $batch->item->unit }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="status-badge
                        @switch($batch->status)
                            @case('active') bg-green-100 text-green-800 @break
                            @case('expired') bg-red-100 text-red-800 @break
                            @default bg-gray-100 text-gray-800 @break
                        @endswitch">
                        @switch($batch->status)
                            @case('active')
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @break
                            @case('expired')
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                @break
                            @default
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                                </svg>
                                @break
                        @endswitch
                        {{ ucfirst($batch->status) }}
                    </span>
                    <a href="{{ route('batches.index') }}" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold" style="border: 1px solid #D4AF37; color: #3D2914;">
                        <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        <span class="hidden sm:inline">Back to Batches</span>
                    </a>
                </div>
            </div>

            <!-- Status Alerts -->
            @if($batch->isExpired())
                <div class="mb-8 p-6 bg-red-50 border border-red-200 rounded-2xl">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <span class="text-red-700 font-semibold text-lg">This batch has expired</span>
                    </div>
                </div>
            @elseif($batch->isExpiringSoon())
                <div class="mb-8 p-6 bg-yellow-50 border border-yellow-200 rounded-2xl">
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-yellow-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span class="text-yellow-700 font-semibold text-lg">This batch is expiring soon</span>
                    </div>
                </div>
            @endif

            <!-- Details Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 mb-8">
                <!-- Basic Information Card -->
                <div class="detail-card">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path>
                        </svg>
                        Basic Information
                    </h3>
                    
                    <div class="space-y-6">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Batch Number</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $batch->batch_number }}</span>
                        </div>

                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Item</span>
                            <div class="text-right">
                                <div class="text-lg font-semibold text-gray-900">{{ $batch->item->name }}</div>
                                <div class="text-sm text-gray-500 font-medium">{{ $batch->item->category->name }}</div>
                            </div>
                        </div>

                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Quantity</span>
                            <span class="text-xl font-bold text-gray-900">{{ number_format($batch->quantity) }} {{ $batch->item->unit }}</span>
                        </div>

                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Status</span>
                            <span class="inline-flex items-center px-3 py-1 text-sm font-semibold rounded-full 
                                @switch($batch->status)
                                    @case('active') bg-green-100 text-green-800 @break
                                    @case('expired') bg-red-100 text-red-800 @break
                                    @default bg-gray-100 text-gray-800 @break
                                @endswitch">
                                {{ ucfirst($batch->status) }}
                            </span>
                        </div>

                        @if($batch->unit_cost)
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Unit Cost</span>
                            <span class="text-lg font-semibold text-gray-900">₱{{ number_format($batch->unit_cost, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-3">
                            <span class="text-sm font-semibold text-gray-700">Total Value</span>
                            <span class="text-xl font-bold text-green-600">₱{{ number_format($batch->quantity * $batch->unit_cost, 2) }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Tracking Information Card -->
                <div class="detail-card">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Tracking Information
                    </h3>
                    
                    <div class="space-y-6">
                        @if($batch->supplier)
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Supplier</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $batch->supplier }}</span>
                        </div>
                        @endif

                        @if($batch->lot_number)
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Lot Number</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $batch->lot_number }}</span>
                        </div>
                        @endif

                        @if($batch->manufacture_date)
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Manufacture Date</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $batch->manufacture_date->format('M d, Y') }}</span>
                        </div>
                        @endif

                        @if($batch->expiry_date)
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Expiry Date</span>
                            <div class="text-right">
                                <div class="text-lg font-semibold {{ $batch->isExpired() ? 'text-red-600' : ($batch->isExpiringSoon() ? 'text-yellow-600' : 'text-gray-900') }}">
                                    {{ $batch->expiry_date->format('M d, Y') }}
                                </div>
                                @if($batch->isExpired())
                                    <div class="text-sm text-red-500 font-medium">Expired {{ $batch->expiry_date->diffForHumans() }}</div>
                                @elseif($batch->isExpiringSoon())
                                    <div class="text-sm text-yellow-600 font-medium">Expires {{ $batch->expiry_date->diffForHumans() }}</div>
                                @else
                                    <div class="text-sm text-gray-600 font-medium">{{ $batch->expiry_date->diffForHumans() }}</div>
                                @endif
                            </div>
                        </div>
                        @endif

                        <div class="flex justify-between items-center py-3">
                            <span class="text-sm font-semibold text-gray-700">Created</span>
                            <div class="text-right">
                                <div class="text-lg font-semibold text-gray-900">{{ $batch->created_at->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-600 font-medium">{{ $batch->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Depreciation Card -->
            @if($batch->hasDepreciation())
            <div class="detail-card mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                    </svg>
                    Depreciation
                </h3>
                <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs font-semibold text-gray-500 mb-1">Method</p>
                        <p class="text-sm font-bold text-gray-900">{{ ucfirst(str_replace('_', ' ', $batch->depreciation_method)) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs font-semibold text-gray-500 mb-1">Purchase Price</p>
                        <p class="text-sm font-bold text-gray-900">₱{{ number_format($batch->purchase_price, 2) }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs font-semibold text-gray-500 mb-1">Purchase Date</p>
                        <p class="text-sm font-bold text-gray-900">{{ $batch->purchase_date->format('M d, Y') }}</p>
                    </div>
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs font-semibold text-gray-500 mb-1">Useful Life</p>
                        <p class="text-sm font-bold text-gray-900">{{ $batch->useful_life_years }} years</p>
                    </div>
                    @if($batch->salvage_value)
                    <div class="bg-gray-50 rounded-xl p-4">
                        <p class="text-xs font-semibold text-gray-500 mb-1">Salvage Value</p>
                        <p class="text-sm font-bold text-gray-900">₱{{ number_format($batch->salvage_value, 2) }}</p>
                    </div>
                    @endif
                    <div class="bg-indigo-50 rounded-xl p-4">
                        <p class="text-xs font-semibold text-indigo-600 mb-1">Accumulated Depreciation</p>
                        <p class="text-sm font-bold text-indigo-900">₱{{ number_format($batch->calculateDepreciation(), 2) }}</p>
                    </div>
                    <div class="bg-green-50 rounded-xl p-4">
                        <p class="text-xs font-semibold text-green-600 mb-1">Current Book Value</p>
                        <p class="text-sm font-bold text-green-900">₱{{ number_format($batch->getCurrentBookValue(), 2) }}</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Notes Card -->
            @if($batch->notes)
            <div class="detail-card mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Notes
                </h3>
                <div class="bg-gray-50 rounded-xl p-6">
                    <p class="text-gray-900 text-lg leading-relaxed">{{ $batch->notes }}</p>
                </div>
            </div>
            @endif

            <!-- Actions Card -->
            <div class="detail-card">
                <div class="flex justify-between items-center">
                    <div class="flex items-center space-x-4">
                        @if($batch->status === 'active' && $batch->isExpired())
                            <form action="{{ route('batches.mark-expired', $batch) }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="modern-button inline-flex items-center px-6 py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl" style="border: 1px solid #F97316; color: #EA580C;" onmouseover="this.style.backgroundColor='#FFF7ED'" onmouseout="this.style.backgroundColor='white'">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Mark as Expired
                                </button>
                            </form>
                        @endif
                    </div>

                    <div class="flex items-center space-x-4">
                        <div class="text-right">
                            <div class="text-sm text-gray-500 font-medium">Batch ID</div>
                            <div class="text-lg font-bold text-gray-900">#{{ $batch->id }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
</div>
</x-app-layout>