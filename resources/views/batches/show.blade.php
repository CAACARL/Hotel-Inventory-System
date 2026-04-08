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
    <div x-data="{ deleteModal: false }" class="py-4 sm:py-8">
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
                            @case('recalled') bg-orange-100 text-orange-800 @break
                            @case('depleted') bg-gray-100 text-gray-800 @break
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
                            @case('recalled')
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
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
                                    @case('recalled') bg-orange-100 text-orange-800 @break
                                    @case('depleted') bg-gray-100 text-gray-800 @break
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
                        <button @click="deleteModal = true" class="modern-button inline-flex items-center px-6 py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl" style="border: 1px solid #EF4444; color: #DC2626;" onmouseover="this.style.backgroundColor='#FEF2F2'" onmouseout="this.style.backgroundColor='white'">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete Batch
                        </button>
                        
                        <div class="text-right">
                            <div class="text-sm text-gray-500 font-medium">Batch ID</div>
                            <div class="text-lg font-bold text-gray-900">#{{ $batch->id }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    

    <!-- Delete Confirmation Modal -->
    <div x-show="deleteModal"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[60] overflow-y-auto"
         @keydown.escape="deleteModal = false"
         style="display: none;"
         x-init="$watch('deleteModal', value => { document.body.classList.toggle('modal-open', value) })">

        <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="deleteModal = false"></div>

        <div class="flex items-center justify-center min-h-screen px-4 py-6">
            <div x-show="deleteModal"
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                 x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                 x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                 class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto border border-red-200 relative z-10">

                <div class="flex items-center justify-between p-4 border-b border-gray-200 rounded-t-2xl" style="background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);">
                    <div class="flex items-center">
                        <div class="w-9 h-9 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-white">Delete Batch</h3>
                            <p class="text-red-100 text-xs">This action cannot be undone</p>
                        </div>
                    </div>
                    <button @click="deleteModal = false" class="text-white hover:text-red-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg transition-colors duration-200">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="p-4">
                    <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-xl p-3 mb-4 border border-red-200">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                            </svg>
                            <div>
                                <p class="text-xs font-semibold text-red-800">Are you sure you want to delete this batch?</p>
                                <p class="text-xs text-red-700 mt-0.5">Batch <span class="font-medium">{{ $batch->batch_number }}</span> will be permanently removed.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button @click="deleteModal = false" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all duration-200 font-medium text-sm">
                            Cancel
                        </button>
                        <button type="button"
                                @click="
                                    const form = document.createElement('form');
                                    form.method = 'POST';
                                    form.action = '{{ route('batches.destroy', $batch) }}';
                                    const csrf = document.createElement('input');
                                    csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = '{{ csrf_token() }}';
                                    const method = document.createElement('input');
                                    method.type = 'hidden'; method.name = '_method'; method.value = 'DELETE';
                                    form.appendChild(csrf); form.appendChild(method);
                                    document.body.appendChild(form); form.submit();
                                "
                                class="animated-button px-5 py-2 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg text-sm" style="background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);">
                            <svg class="w-3 h-3 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</x-app-layout>