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

            <div class="modern-card bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-3 sm:p-8 text-gray-900">

                    {{-- MOBILE CARD LAYOUT --}}
                    <div class="sm:hidden space-y-3">
                        @forelse($transactions as $transaction)
                        <div class="border border-gray-200 rounded-xl p-3 bg-gray-50">
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
                                        <div class="font-bold text-gray-900 text-sm truncate">{{ $transaction->item->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $transaction->item->category->name }}</div>
                                    </div>
                                </div>
                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold flex-shrink-0
                                    @switch($transaction->transaction_type)
                                        @case('delivery') bg-green-100 text-green-800 @break
                                        @case('borrow') bg-blue-100 text-blue-800 @break
                                        @case('return') bg-purple-100 text-purple-800 @break
                                        @case('disposal') bg-red-100 text-red-800 @break
                                        @case('recovery') bg-yellow-100 text-yellow-800 @break
                                        @case('replenish') bg-indigo-100 text-indigo-800 @break
                                        @default bg-gray-100 text-gray-800 @break
                                    @endswitch">
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
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Date</th>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Item</th>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Type</th>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Quantity</th>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">User</th>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Reference</th>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($transactions as $transaction)
                                <tr class="hover:bg-gray-50 transition-colors duration-200">
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $transaction->transaction_date->format('M d, Y') }}</div>
                                        <div class="text-sm text-gray-500">{{ $transaction->transaction_date->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="flex items-center">
                                            @if($transaction->item->image)
                                                <img src="{{ Storage::url($transaction->item->image) }}" alt="{{ $transaction->item->name }}"
                                                     class="w-10 h-10 object-cover rounded-xl mr-3 shadow-sm border border-gray-200 cursor-pointer hover:opacity-80 transition-opacity flex-shrink-0"
                                                     onclick="openLightbox('{{ Storage::url($transaction->item->image) }}', '{{ addslashes($transaction->item->name) }}')">
                                            @else
                                                <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3 shadow-sm flex-shrink-0" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="text-sm font-bold text-gray-900">{{ $transaction->item->name }}</div>
                                                <div class="text-sm text-gray-500">{{ $transaction->item->category->name }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold
                                            @switch($transaction->transaction_type)
                                                @case('delivery') bg-green-100 text-green-800 @break
                                                @case('borrow') bg-blue-100 text-blue-800 @break
                                                @case('return') bg-purple-100 text-purple-800 @break
                                                @case('disposal') bg-red-100 text-red-800 @break
                                                @case('recovery') bg-yellow-100 text-yellow-800 @break
                                                @case('replenish') bg-indigo-100 text-indigo-800 @break
                                                @default bg-gray-100 text-gray-800 @break
                                            @endswitch">
                                            @if($transaction->type === 'in')
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8l-8-8-8 8"></path></svg>
                                            @else
                                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20V4m-8 8l8 8 8-8"></path></svg>
                                            @endif
                                            {{ ucfirst(str_replace('_', ' ', $transaction->transaction_type)) }}
                                        </span>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $transaction->quantity }} {{ $transaction->item->unit }}</div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="text-sm text-gray-900 font-medium">{{ $transaction->user->name }}</div>
                                        <div class="text-sm text-gray-500 capitalize">{{ $transaction->user->role }}</div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $transaction->reference_number ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap text-sm font-medium">
                                        <a href="{{ route('transactions.show', $transaction) }}"
                                           class="inline-flex items-center px-3 py-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 text-sm font-medium rounded-lg transition-all duration-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
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

                    <div class="mt-4 sm:mt-6 px-0 sm:px-8 pb-4 sm:pb-8">
                        {{ $transactions->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

</x-app-layout>