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

    /* Enhanced Modal Styling */
    .modal-container {
        animation: modalSlideIn 0.3s ease-out;
    }
    
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
    
    .modal-header-gradient {
        position: relative;
        overflow: hidden;
    }
    
    .modal-header-gradient::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        pointer-events: none;
    }
    
    /* Backdrop Blur Support */
    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }
    
    /* Prevent body scroll when modal is open */
    body.modal-open {
        overflow: hidden;
    }
</style>

<div x-data="{ searchModal: false }">
<x-app-layout>
    <!-- Page Header integrated into main content -->
    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            
            <!-- Modern Page Header -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 sm:mb-8">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0" 
                         style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                        <svg class="w-5 h-5 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-4xl font-bold mb-1 text-amber-700">Transaction History</h1>
                        <p class="text-gray-600 text-sm sm:text-lg font-medium hidden sm:block">
                            @if(auth()->user()->isStaff())
                                Your personal inventory transactions and activities
                            @else
                                Track all inventory movements and activities
                            @endif
                        </p>
                        <div class="flex items-center mt-1 sm:mt-3 text-sm text-gray-500">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                            <span class="font-medium">{{ $transactions->total() }} Transactions</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                </div>
            </div>

            <!-- Search & Filter Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6 sm:mb-8">
                <div class="flex flex-wrap gap-2 sm:gap-4">
                    <button @click="searchModal = true" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold" style="border: 1px solid #D4AF37; color: #3D2914;">
                        <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span class="hidden sm:inline">Search</span>
                    </button>
                </div>
                @if(request('search') || request('type'))
                    <div class="text-sm text-gray-600 sm:ml-auto">
                        @if(request('search'))Results for: <span class="font-semibold" style="color: #D4AF37;">"{{ request('search') }}"</span>@endif
                        <a href="{{ route('transactions.index') }}" class="ml-2" style="color: #D4AF37;">Clear</a>
                    </div>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200 relative">
                <!-- Decorative Background - Abstract Triangles -->
                <div class="absolute inset-0 opacity-[0.04] pointer-events-none overflow-hidden">
                    <!-- Top right triangle -->
                    <svg class="absolute -top-10 -right-10 w-40 h-40 text-blue-400" viewBox="0 0 100 100">
                        <polygon points="0,0 100,0 100,100" fill="currentColor"/>
                    </svg>
                    <!-- Bottom left triangle -->
                    <svg class="absolute -bottom-10 -left-10 w-32 h-32 text-indigo-400" viewBox="0 0 100 100">
                        <polygon points="0,100 0,0 100,100" fill="currentColor"/>
                    </svg>
                    <!-- Small accent triangle -->
                    <svg class="absolute top-1/3 right-20 w-16 h-16 text-purple-300" viewBox="0 0 100 100">
                        <polygon points="50,0 100,100 0,100" fill="currentColor"/>
                    </svg>
                </div>
                
                <div class="p-3 sm:p-6 text-gray-900 relative z-10">

                    {{-- MOBILE CARD LAYOUT --}}
                    <div class="sm:hidden space-y-3">
                        @forelse($transactions as $transaction)
                        <div class="border border-gray-200 rounded-xl p-3 bg-white shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <div class="flex items-start gap-2 min-w-0">
                                    @if($transaction->item->image)
                                        <img src="{{ Storage::url($transaction->item->image) }}" alt="{{ $transaction->item->name }}"
                                             class="w-9 h-9 object-cover rounded-lg border border-gray-200 flex-shrink-0 cursor-pointer hover:opacity-80 transition-opacity mt-0.5"
                                             onclick="openLightbox('{{ Storage::url($transaction->item->image) }}', '{{ addslashes($transaction->item->name) }}')">
                                    @else
                                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <div class="font-semibold text-gray-900 text-sm truncate">{{ $transaction->item->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $transaction->item->category->name }}</div>
                                    </div>
                                </div>
                                <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-md text-xs font-medium border flex-shrink-0 min-w-[90px]
                                    @switch($transaction->transaction_type)
                                        @case('borrow') bg-orange-50 text-orange-700 border-orange-200 @break
                                        @case('return') bg-green-50 text-green-700 border-green-200 @break
                                        @case('replenish') bg-blue-50 text-blue-700 border-blue-200 @break
                                        @case('disposal') bg-red-50 text-red-700 border-red-200 @break
                                        @case('spoiled') bg-yellow-50 text-yellow-700 border-yellow-200 @break
                                        @default bg-gray-50 text-gray-700 border-gray-200 @break
                                    @endswitch">
                                    @if($transaction->transaction_type === 'borrow')
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4"></path>
                                        </svg>
                                    @elseif($transaction->transaction_type === 'return')
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 17l-4 4m0 0l-4-4m4 4V3"></path>
                                        </svg>
                                    @elseif($transaction->transaction_type === 'replenish')
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                        </svg>
                                    @elseif($transaction->transaction_type === 'disposal')
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                                        </svg>
                                    @elseif($transaction->transaction_type === 'spoiled')
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                    @endif
                                    {{ ucfirst(str_replace('_', ' ', $transaction->transaction_type)) }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-1 text-xs text-gray-600 mb-2">
                                <div><span class="text-gray-400">Date:</span> {{ $transaction->transaction_date->format('M d, Y') }}</div>
                                <div><span class="text-gray-400">Qty:</span> <span class="font-bold">{{ $transaction->quantity }} {{ $transaction->item->unit }}</span></div>
                                <div><span class="text-gray-400">By:</span> {{ $transaction->user->name }}</div>
                                @if($transaction->reference_number)
                                <div><span class="text-gray-400">Ref:</span> <span class="font-mono">{{ $transaction->reference_number }}</span></div>
                                @endif
                            </div>
                            <a href="{{ route('transactions.show', $transaction) }}"
                               class="inline-flex items-center px-3 py-1.5 text-blue-600 hover:bg-blue-50 text-xs font-medium rounded-lg border border-blue-200 transition-colors">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                View
                            </a>
                        </div>
                        @empty
                        <div class="text-center py-12 text-gray-500">
                            <svg class="w-12 h-12 text-gray-400 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No transactions found</h3>
                            <p class="text-gray-500">Transaction history will appear here as items are borrowed, returned, or moved.</p>
                        </div>
                        @endforelse
                    </div>

                    {{-- DESKTOP TABLE LAYOUT --}}
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Item</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Quantity</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">User</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Reference</th>
                                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($transactions as $transaction)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $transaction->transaction_date->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $transaction->transaction_date->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($transaction->item->image)
                                                <img src="{{ Storage::url($transaction->item->image) }}" alt="{{ $transaction->item->name }}"
                                                     class="w-10 h-10 object-cover rounded-lg mr-3 shadow-sm border border-gray-200 cursor-pointer hover:opacity-80 transition-opacity flex-shrink-0"
                                                     onclick="openLightbox('{{ Storage::url($transaction->item->image) }}', '{{ addslashes($transaction->item->name) }}')">
                                            @else
                                                <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3 shadow-sm flex-shrink-0" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-semibold text-gray-900">{{ $transaction->item->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $transaction->item->category->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center justify-center px-2.5 py-1 rounded-md text-xs font-medium border min-w-[100px]
                                            @switch($transaction->transaction_type)
                                                @case('borrow') bg-orange-50 text-orange-700 border-orange-200 @break
                                                @case('return') bg-green-50 text-green-700 border-green-200 @break
                                                @case('replenish') bg-blue-50 text-blue-700 border-blue-200 @break
                                                @case('disposal') bg-red-50 text-red-700 border-red-200 @break
                                                @case('spoiled') bg-yellow-50 text-yellow-700 border-yellow-200 @break
                                                @default bg-gray-50 text-gray-700 border-gray-200 @break
                                            @endswitch">
                                            @if($transaction->transaction_type === 'borrow')
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4"></path>
                                                </svg>
                                            @elseif($transaction->transaction_type === 'return')
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 17l-4 4m0 0l-4-4m4 4V3"></path>
                                                </svg>
                                            @elseif($transaction->transaction_type === 'replenish')
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                </svg>
                                            @elseif($transaction->transaction_type === 'disposal')
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                                                </svg>
                                            @elseif($transaction->transaction_type === 'spoiled')
                                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                                </svg>
                                            @endif
                                            {{ ucfirst(str_replace('_', ' ', $transaction->transaction_type)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-semibold text-gray-900">{{ $transaction->quantity }} {{ $transaction->item->unit }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-medium">{{ $transaction->user->name }}</div>
                                        <div class="text-xs text-gray-500 capitalize">{{ $transaction->user->role }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $transaction->reference_number ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('transactions.show', $transaction) }}"
                                           class="inline-flex items-center px-3 py-2 text-blue-600 hover:bg-blue-50 text-sm font-medium rounded-lg transition-colors duration-150">
                                            <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            View
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="7" class="px-8 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No transactions found</h3>
                                            <p class="text-gray-500">Transaction history will appear here as items are borrowed, returned, or moved.</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4 sm:mt-6">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>

<!-- Search Modal -->
<div x-show="searchModal"
     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;"
     @keydown.escape="searchModal = false"
     x-init="$watch('searchModal', value => { document.body.classList.toggle('modal-open', value) })">
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="searchModal = false"></div>
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div x-show="searchModal"
             x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="modal-container bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto relative z-10 border border-amber-200">
            <div class="modal-header-gradient flex items-center justify-between p-4 border-b border-gray-200 rounded-t-2xl" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                <div class="flex items-center">
                    <div class="w-9 h-9 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Search Transactions</h3>
                        <p class="text-amber-100 text-xs">Find by item name, reference number, or notes</p>
                    </div>
                </div>
                <button @click="searchModal = false" class="text-white hover:text-amber-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form method="GET" action="{{ route('transactions.index') }}" class="p-4">
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Search Term</label>
                        <input type="text" name="search" value="{{ request('search') }}" autofocus
                               placeholder="Item name, reference number, notes..."
                               class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Filter by Type</label>
                        <select name="type" class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                            <option value="">All Types</option>
                            @foreach(['borrow','return','replenish','disposal','spoiled'] as $t)
                                <option value="{{ $t }}" {{ request('type') === $t ? 'selected' : '' }}>{{ ucfirst($t) }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-4 pt-4 border-t border-gray-200">
                    <button type="button" @click="searchModal = false" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium text-sm">Cancel</button>
                    <button type="submit" class="animated-button px-6 py-2 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 text-sm" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                        <svg class="w-4 h-4 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Search Transactions
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

</div>