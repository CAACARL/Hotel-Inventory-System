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
        padding: 1rem;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        transition: all 0.2s ease-in-out;
    }

    @media (min-width: 640px) {
        .detail-card { padding: 2rem; }
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

    .table-modern {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        overflow: hidden;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
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
                    @if($item->image)
                        <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}"
                             class="w-14 h-14 sm:w-20 sm:h-20 object-cover rounded-2xl shadow-lg flex-shrink-0 border border-gray-200 cursor-pointer hover:opacity-80 transition-opacity"
                             onclick="openLightbox('{{ Storage::url($item->image) }}', '{{ addslashes($item->name) }}')">
                    @else
                        <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0"
                             style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                            <svg class="w-5 h-5 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg>
                        </div>
                    @endif
                    <div>
                        <h1 class="text-2xl sm:text-4xl font-bold mb-1 text-amber-700">{{ $item->name }}</h1>
                        <p class="text-gray-600 text-sm sm:text-lg font-medium hidden sm:block">Detailed information about this inventory item</p>
                        <div class="flex flex-wrap items-center mt-1 sm:mt-3 gap-3 sm:gap-6 text-sm text-gray-500">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                                <span class="font-medium">{{ $item->category->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <span class="status-badge
                        @if($item->quantity > $item->minimum_stock) bg-green-100 text-green-800
                        @elseif($item->quantity > 0) bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        @if($item->quantity > $item->minimum_stock)
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            In Stock
                        @elseif($item->quantity > 0)
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            Low Stock
                        @else
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14H5.236a2 2 0 01-1.789-2.894l3.5-7A2 2 0 018.736 4h4.018a2 2 0 01.485.06l3.76.94m-7 10v5a2 2 0 002 2h.096c.5 0 .905-.405.905-.904 0-.715.211-1.413.608-2.008L17.294 15M10 14l4-2c.707-.707 1.707-1.707 2.414-2.414"></path>
                            </svg>
                            Out of Stock
                        @endif
                    </span>
                    <a href="{{ route('items.index') }}" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold" style="border: 1px solid #D4AF37; color: #3D2914;">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Items
                    </a>
                </div>
            </div>

            <!-- Action Buttons (Admin Only) -->
            @if(auth()->user()->isAdmin() && $item->status !== 'disposed' && $item->status !== 'spoiled' && $item->quantity > 0)
            <div class="detail-card mb-6 sm:mb-8" x-data="{ disposeModal: false }">
                <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-5 h-5 mr-2 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path>
                    </svg>
                    Actions
                </h3>
                <div class="flex flex-wrap gap-3">
                    <button @click="disposeModal = true"
                            class="inline-flex items-center px-4 py-2 text-red-600 bg-red-50 hover:bg-red-100 rounded-xl transition-all duration-200 font-medium text-sm border border-red-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Dispose Item
                    </button>
                </div>

                <!-- Dispose Modal -->
                <div x-show="disposeModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100"
                     x-transition:leave-end="opacity-0"
                     class="fixed inset-0 z-[70] overflow-y-auto"
                     @keydown.escape="disposeModal = false"
                     style="display:none"
                     x-init="$watch('disposeModal', v => document.body.classList.toggle('modal-open', v))">

                    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="disposeModal = false"></div>

                    <div class="flex items-center justify-center min-h-screen px-4 py-6">
                        <div x-show="disposeModal"
                             x-transition:enter="transition ease-out duration-300 transform"
                             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                             x-transition:leave="transition ease-in duration-200 transform"
                             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                             class="modal-container bg-white rounded-2xl shadow-2xl max-w-sm w-full mx-auto relative z-10 border border-red-200">

                            <div class="flex items-center justify-between p-4 border-b border-gray-200 rounded-t-2xl" style="background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);">
                                <div class="flex items-center">
                                    <div class="w-9 h-9 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                                        </svg>
                                    </div>
                                    <div>
                                        <h3 class="text-base font-bold text-white">Dispose Item</h3>
                                        <p class="text-red-100 text-xs">{{ $item->name }}</p>
                                    </div>
                                </div>
                                <button @click="disposeModal = false" class="text-white hover:text-red-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                </button>
                            </div>

                            <form action="{{ route('items.disposal', $item) }}" method="POST" class="p-4">
                                @csrf
                                <div class="space-y-3">
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Quantity to Dispose <span class="text-red-500">*</span></label>
                                        <input type="number" name="quantity" min="1" max="{{ $item->quantity }}" required
                                               class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-red-400 focus:border-red-400"
                                               placeholder="Enter quantity">
                                        <p class="mt-1 text-xs text-gray-500">Available stock: <span class="font-semibold">{{ $item->quantity }}</span></p>
                                    </div>
                                    <div>
                                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Reason <span class="text-red-500">*</span></label>
                                        <textarea name="notes" required rows="2"
                                               class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-red-400 focus:border-red-400"
                                               placeholder="e.g. Broken beyond repair"></textarea>
                                    </div>
                                </div>
                                <div class="flex justify-end space-x-3 mt-4 pt-3 border-t border-gray-200">
                                    <button type="button" @click="disposeModal = false"
                                            class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium text-sm transition-colors">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="animated-button px-5 py-2 text-white font-semibold rounded-xl shadow-lg text-sm transition-all"
                                            style="background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);">
                                        Confirm Dispose
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Details Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8 mb-6 sm:mb-8">
                <!-- Stock Information Card -->
                <div class="detail-card">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                        Stock Information
                    </h3>
                    
                    <div class="space-y-6">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Current Stock</span>
                            <span class="text-xl font-bold text-gray-900">{{ number_format($item->quantity) }} {{ $item->unit }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Minimum Stock</span>
                            <span class="text-lg font-semibold text-gray-900">{{ number_format($item->minimum_stock) }} {{ $item->unit }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Currently Borrowed</span>
                            <span class="text-lg font-semibold text-orange-600">{{ number_format($item->borrowed_quantity) }} {{ $item->unit }}</span>
                        </div>
                        
                        @if($item->unit_price)
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Unit Price</span>
                            <span class="text-lg font-semibold text-gray-900">₱{{ number_format($item->unit_price, 2) }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-3">
                            <span class="text-sm font-semibold text-gray-700">Total Value</span>
                            <span class="text-xl font-bold text-green-600">₱{{ number_format($item->quantity * $item->unit_price, 2) }}</span>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Item Information Card -->
                <div class="detail-card">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Item Information
                    </h3>
                    
                    <div class="space-y-6">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Category</span>
                            <div class="text-right">
                                <div class="text-lg font-semibold text-gray-900">{{ $item->category->name }}</div>
                                @if($item->subcategory)
                                    <div class="text-sm text-gray-500 font-medium">{{ $item->subcategory->name }}</div>
                                @endif
                            </div>
                        </div>
                        
                        @if($item->department)
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Department</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $item->department->name }}</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Status</span>
                            <span class="text-lg font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $item->status) }}</span>
                        </div>
                        
                        @if($item->location)
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Location</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $item->location }}</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between items-center py-3">
                            <span class="text-sm font-semibold text-gray-700">Unit</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $item->unit }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Card -->
            @if($item->description)
            <div class="detail-card mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Description
                </h3>
                <div class="bg-gray-50 rounded-xl p-6">
                    <p class="text-gray-900 text-lg leading-relaxed">{{ $item->description }}</p>
                </div>
            </div>
            @endif

            <!-- Transaction History Card -->
            @if(auth()->user()->isAdmin())
            <div class="detail-card">
                <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6 sm:mb-8">
                    <div>
                        <h3 class="text-xl font-bold text-gray-900 flex items-center">
                            <svg class="w-6 h-6 mr-3 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                            </svg>
                            Transaction History
                        </h3>
                        <p class="text-gray-600 text-lg font-medium mt-2">Complete history of all transactions for this item</p>
                    </div>
                    @if($transactions->count() > 0)
                    <button onclick="document.getElementById('itemExportModal').classList.remove('hidden'); document.getElementById('itemExportModal').classList.add('flex');" class="modern-button inline-flex items-center px-6 py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl" style="border: 1px solid #F97316; color: #EA580C;" onmouseover="this.style.backgroundColor='#FFF7ED'" onmouseout="this.style.backgroundColor='white'">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Export CSV
                    </button>
                    @endif
                </div>

                @if($transactions->count() > 0)
                @php
                    $runningStock = $item->quantity;
                    $transactionsArray = $transactions->toArray();
                    $stockAfterLevels = [];
                    $stockBeforeLevels = [];
                    foreach ($transactionsArray as $trans) {
                        $stockAfterLevels[$trans['id']] = $runningStock;
                        if ($trans['type'] === 'in') { $runningStock -= $trans['quantity']; }
                        else { $runningStock += $trans['quantity']; }
                        $stockBeforeLevels[$trans['id']] = $runningStock;
                    }
                @endphp

                {{-- MOBILE: transaction cards --}}
                <div class="sm:hidden space-y-3">
                    @foreach($transactions as $transaction)
                    <div class="border border-gray-200 rounded-xl p-3 bg-gray-50">
                        <div class="flex items-center justify-between mb-2">
                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-semibold
                                @switch($transaction->transaction_type)
                                    @case('delivery') bg-green-100 text-green-800 @break
                                    @case('borrow') bg-blue-100 text-blue-800 @break
                                    @case('return') bg-purple-100 text-purple-800 @break
                                    @case('disposal') bg-red-100 text-red-800 @break
                                    @case('replenish') bg-indigo-100 text-indigo-800 @break
                                    @default bg-gray-100 text-gray-800 @break
                                @endswitch">
                                {{ ucfirst(str_replace('_', ' ', $transaction->transaction_type)) }}
                            </span>
                            <span class="text-xs text-gray-500">{{ $transaction->transaction_date->format('M d, Y') }}</span>
                        </div>
                        <div class="grid grid-cols-2 gap-2 text-xs">
                            <div><span class="text-gray-500">Qty:</span> <span class="font-bold">{{ number_format($transaction->quantity) }} {{ $item->unit }}</span></div>
                            <div><span class="text-gray-500">Stock after:</span> <span class="font-bold">{{ number_format($stockAfterLevels[$transaction->id]) }}</span></div>
                            <div><span class="text-gray-500">By:</span> <span class="font-medium">{{ $transaction->user->name }}</span></div>
                            @if($transaction->reference_number)
                            <div><span class="text-gray-500">Ref:</span> <span class="font-mono">{{ $transaction->reference_number }}</span></div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>

                {{-- DESKTOP: full table --}}
                <div class="hidden sm:block table-modern">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Previous Stock</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Total Stock</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Reference</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($transactions as $transaction)
                                <tr class="hover:bg-gray-50 transition-colors">
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                        <div class="font-semibold">{{ $transaction->transaction_date->format('M d, Y') }}</div>
                                        <div class="text-gray-500 text-xs">{{ $transaction->transaction_date->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold
                                            @switch($transaction->transaction_type)
                                                @case('delivery') bg-green-100 text-green-800 @break
                                                @case('borrow') bg-blue-100 text-blue-800 @break
                                                @case('return') bg-purple-100 text-purple-800 @break
                                                @case('disposal') bg-red-100 text-red-800 @break
                                                @case('recovery') bg-yellow-100 text-yellow-800 @break
                                                @default bg-gray-100 text-gray-800 @break
                                            @endswitch">
                                            @if($transaction->type === 'in')
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8l-8-8-8 8"></path>
                                                </svg>
                                            @else
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20V4m-8 8l8 8 8-8"></path>
                                                </svg>
                                            @endif
                                            {{ ucfirst(str_replace('_', ' ', $transaction->transaction_type)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                        {{ number_format($transaction->quantity) }} {{ $item->unit }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-semibold text-gray-600">
                                        {{ number_format($stockBeforeLevels[$transaction->id]) }} {{ $item->unit }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                        {{ number_format($stockAfterLevels[$transaction->id]) }} {{ $item->unit }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-900">
                                        <div class="font-semibold">{{ $transaction->user->name }}</div>
                                        <div class="text-xs text-gray-500 capitalize font-medium">{{ $transaction->user->role }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        @if($transaction->reference_number)
                                        <span class="font-mono text-xs bg-gray-100 px-3 py-1 rounded-lg font-semibold">{{ $transaction->reference_number }}</span>
                                        @else
                                        <span class="text-gray-400 font-medium">N/A</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>{{-- end desktop table --}}
                @else
                <div class="text-center py-16 bg-gray-50 rounded-xl">
                    <svg class="mx-auto h-16 w-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="mt-4 text-lg font-semibold text-gray-900">No transactions yet</h3>
                    <p class="mt-2 text-gray-500 font-medium">This item has no transaction history.</p>
                </div>
                @endif
            </div>
            @endif
        </div>
    </div>

    <!-- Item Export Date Range Modal -->
    @if(auth()->user()->isAdmin())
    <div id="itemExportModal" class="hidden fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm z-50 items-center justify-center p-4">
        <div class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto border border-amber-200">
            <div class="flex items-center justify-between p-4 border-b border-gray-200 rounded-t-2xl" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                <div class="flex items-center">
                    <div class="w-9 h-9 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Export Transactions</h3>
                        <p class="text-amber-100 text-xs">Select a date range (optional)</p>
                    </div>
                </div>
                <button onclick="document.getElementById('itemExportModal').classList.add('hidden'); document.getElementById('itemExportModal').classList.remove('flex');" class="text-white hover:text-amber-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg transition-colors duration-200">
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
                        <input type="date" id="item_export_date_from" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">To</label>
                        <input type="date" id="item_export_date_to" class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                </div>
                <div class="flex justify-end space-x-3 pt-2 border-t border-gray-100">
                    <button onclick="document.getElementById('itemExportModal').classList.add('hidden'); document.getElementById('itemExportModal').classList.remove('flex');" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl text-sm font-medium transition-colors duration-200">Cancel</button>
                    <button onclick="
                        const from = document.getElementById('item_export_date_from').value;
                        const to = document.getElementById('item_export_date_to').value;
                        let url = '{{ route('items.transactions.export', $item) }}';
                        const params = new URLSearchParams();
                        if (from) params.append('date_from', from);
                        if (to) params.append('date_to', to);
                        if (params.toString()) url += '?' + params.toString();
                        document.getElementById('itemExportModal').classList.add('hidden');
                        document.getElementById('itemExportModal').classList.remove('flex');
                        const link = document.createElement('a');
                        link.href = url;
                        link.download = '';
                        link.style.display = 'none';
                        document.body.appendChild(link);
                        link.click();
                        document.body.removeChild(link);
                    " class="animated-button px-5 py-2 text-white font-semibold rounded-xl text-sm transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                        <svg class="w-4 h-4 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Download CSV
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>
