<!-- Recent Activity -->
<div class="dashboard-card p-6 relative overflow-hidden">
    <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-br from-blue-500/5 to-transparent rounded-full -mr-20 -mt-20"></div>
    <div class="relative">
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-3">
                <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl flex items-center justify-center shadow-lg">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-gray-900">Recent Activity</h3>
                    <p class="text-gray-600 text-sm">Latest inventory movements</p>
                </div>
            </div>
            @if(auth()->user()->isAdmin())
            <a href="{{ route('transactions.index') }}" class="flex items-center gap-1 px-3 py-1.5 rounded-xl text-xs font-semibold bg-gradient-to-r from-blue-50 to-indigo-50 text-blue-700 border border-blue-200 hover:shadow-md transition-all duration-200">
                View All
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>
            </a>
            @endif
        </div>
        <div class="space-y-3">
            @forelse($recentTransactions as $transaction)
            <div class="activity-item flex items-center p-4 rounded-xl border border-gray-100 hover:border-blue-200 hover:shadow-md transition-all duration-200 bg-gradient-to-r from-white to-gray-50">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center mr-4 shadow-md flex-shrink-0
                    {{ $transaction->transaction_type === 'borrow' ? 'bg-gradient-to-br from-orange-500 to-red-600' : 
                       ($transaction->transaction_type === 'return' ? 'bg-gradient-to-br from-green-500 to-emerald-600' : 
                       ($transaction->transaction_type === 'replenish' ? 'bg-gradient-to-br from-blue-500 to-indigo-600' : 
                       ($transaction->transaction_type === 'disposal' ? 'bg-gradient-to-br from-red-500 to-pink-600' : 
                       ($transaction->transaction_type === 'spoiled' ? 'bg-gradient-to-br from-yellow-500 to-orange-600' : 'bg-gradient-to-br from-gray-500 to-gray-600')))) }}">
                    @if($transaction->transaction_type === 'borrow')
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4"></path>
                        </svg>
                    @elseif($transaction->transaction_type === 'return')
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 17l-4 4m0 0l-4-4m4 4V3"></path>
                        </svg>
                    @elseif($transaction->transaction_type === 'replenish')
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    @elseif($transaction->transaction_type === 'disposal')
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    @else
                        <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                        </svg>
                    @endif
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center justify-between">
                        <div class="flex-1 min-w-0 mr-4">
                            <p class="font-semibold text-gray-900 truncate">{{ $transaction->item->name }}</p>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium
                                    {{ $transaction->transaction_type === 'borrow' ? 'bg-orange-100 text-orange-700' : 
                                       ($transaction->transaction_type === 'return' ? 'bg-green-100 text-green-700' : 
                                       ($transaction->transaction_type === 'replenish' ? 'bg-blue-100 text-blue-700' : 
                                       ($transaction->transaction_type === 'disposal' ? 'bg-red-100 text-red-700' : 
                                       ($transaction->transaction_type === 'spoiled' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-700')))) }}">
                                    {{ ucfirst(str_replace('_', ' ', $transaction->transaction_type)) }}
                                </span>
                                <span class="text-sm text-gray-600">{{ $transaction->quantity }} {{ $transaction->item->unit }}</span>
                            </div>
                        </div>
                        <div class="text-right flex-shrink-0">
                            <p class="text-sm font-medium text-gray-700">{{ $transaction->transaction_date->format('M j') }}</p>
                            <p class="text-xs text-gray-500">{{ $transaction->transaction_date->format('g:i A') }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-12 text-gray-400">
                <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                </svg>
                <p class="font-medium">No recent activity</p>
                <p class="text-sm mt-1">Transactions will appear here</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
