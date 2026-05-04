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
</style>

<x-app-layout>
    <div class="py-8">
        <div class="max-w-7xl mx-auto px-6 lg:px-8">
            
            <!-- Modern Page Header -->
            <div class="flex justify-between items-center mb-8">
                <div class="flex items-center space-x-4">
                    <!-- Modern Icon -->
                    <div class="w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg" 
                         style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-4xl font-bold mb-2 text-amber-700">
                            Transaction #{{ $transaction->id }}
                        </h1>
                        <p class="text-gray-600 text-lg font-medium">Detailed information about this transaction</p>
                        <div class="flex items-center mt-3 space-x-6 text-sm text-gray-500">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                                <span class="font-medium">{{ $transaction->transaction_date->format('F d, Y \a\t h:i A') }}</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                <span class="font-medium">{{ $transaction->user->name }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-4">
                    <span class="status-badge
                        @switch($transaction->transaction_type)
                            @case('borrow') bg-blue-100 text-blue-800 @break
                            @case('return') bg-purple-100 text-purple-800 @break
                            @case('replenish') bg-indigo-100 text-indigo-800 @break
                            @case('disposal') bg-red-100 text-red-800 @break
                            @case('spoiled') bg-orange-100 text-orange-800 @break
                            @default bg-gray-100 text-gray-800 @break
                        @endswitch">
                        @if($transaction->type === 'in')
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8l-8-8-8 8"></path>
                            </svg>
                        @else
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 20V4m-8 8l8 8 8-8"></path>
                            </svg>
                        @endif
                        {{ ucfirst(str_replace('_', ' ', $transaction->transaction_type)) }}
                    </span>
                    <a href="{{ route('transactions.index') }}" class="modern-button inline-flex items-center px-6 py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl" style="border: 1px solid #D4AF37; color: #3D2914;" onmouseover="this.style.backgroundColor='#F4E4BC'" onmouseout="this.style.backgroundColor='white'">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                        </svg>
                        Back to Transactions
                    </a>
                </div>
            </div>

            <!-- Details Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Transaction Information Card -->
                <div class="detail-card">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                        Transaction Information
                    </h3>
                    
                    <div class="space-y-6">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Transaction Type</span>
                            <span class="text-lg font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $transaction->transaction_type) }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Quantity</span>
                            <span class="text-xl font-bold text-gray-900">
                                {{ $transaction->type === 'out' ? '-' : '+' }}{{ number_format($transaction->quantity) }} {{ $transaction->item->unit }}
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Processed By</span>
                            <div class="text-right">
                                <div class="text-lg font-semibold text-gray-900">{{ $transaction->user->name }}</div>
                                <div class="text-sm text-gray-500 font-medium capitalize">{{ $transaction->user->role }}</div>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Reference Number</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $transaction->reference_number ?? 'N/A' }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-3">
                            <span class="text-sm font-semibold text-gray-700">Transaction Date</span>
                            <div class="text-right">
                                <div class="text-lg font-semibold text-gray-900">{{ $transaction->transaction_date->format('M d, Y') }}</div>
                                <div class="text-sm text-gray-500 font-medium">{{ $transaction->transaction_date->format('h:i A') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Item Information Card -->
                <div class="detail-card">
                    <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                        <svg class="w-6 h-6 mr-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        Item Information
                    </h3>
                    
                    <div class="space-y-6">
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Item Name</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $transaction->item->name }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Category</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $transaction->item->category->name }}</span>
                        </div>
                        
                        @if($transaction->item->department)
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Department</span>
                            <span class="text-lg font-semibold text-gray-900">{{ $transaction->item->department->name }}</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between items-center py-3 border-b border-gray-100">
                            <span class="text-sm font-semibold text-gray-700">Current Stock</span>
                            <span class="text-lg font-semibold text-gray-900">{{ number_format($transaction->item->quantity) }} {{ $transaction->item->unit }}</span>
                        </div>
                        
                        <div class="flex justify-between items-center py-3">
                            <span class="text-sm font-semibold text-gray-700">Item Status</span>
                            <span class="text-lg font-semibold text-gray-900 capitalize">{{ str_replace('_', ' ', $transaction->item->status) }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description/Notes Card -->
            @if($transaction->notes)
            <div class="detail-card mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
                    <svg class="w-6 h-6 mr-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Transaction Notes
                </h3>
                <div class="bg-gray-50 rounded-xl p-6">
                    <p class="text-gray-900 text-lg leading-relaxed">{{ $transaction->notes }}</p>
                </div>
            </div>
            @endif

            <!-- Action Buttons Card -->
            <div class="detail-card">
                <div class="flex justify-between items-center">
                    <a href="{{ route('items.show', ['item' => $transaction->item, 'from' => 'transaction', 'transaction_id' => $transaction->id]) }}" class="modern-button inline-flex items-center px-6 py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl" style="border: 1px solid #3B82F6; color: #1D4ED8;" onmouseover="this.style.backgroundColor='#EFF6FF'" onmouseout="this.style.backgroundColor='white'">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        View Item Details
                    </a>
                    
                    <div class="text-right">
                        <div class="text-sm text-gray-500 font-medium">Transaction ID</div>
                        <div class="text-lg font-bold text-gray-900">#{{ $transaction->id }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>