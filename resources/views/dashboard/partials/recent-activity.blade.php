<!-- Recent Activity -->
<div class="dashboard-card p-6">
    <div class="flex items-center justify-between mb-6">
        <div>
            <h3 class="text-xl font-bold text-gray-900">Recent Activity</h3>
            <p class="text-gray-600 text-sm">Latest inventory movements</p>
        </div>
        @if(auth()->user()->isAdmin())
        <a href="{{ route('transactions.index') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium flex items-center">
            View All
            <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
            </svg>
        </a>
        @endif
    </div>
    <div class="space-y-4">
        @forelse($recentTransactions as $transaction)
        <div class="activity-item flex items-center p-4 rounded-xl border border-gray-100">
            <div class="w-10 h-10 rounded-full flex items-center justify-center mr-4 
                {{ $transaction->transaction_type === 'borrow' ? 'bg-orange-100 text-orange-600' : 
                   ($transaction->transaction_type === 'return' ? 'bg-green-100 text-green-600' : 
                   ($transaction->transaction_type === 'delivery' ? 'bg-blue-100 text-blue-600' : 'bg-gray-100 text-gray-600')) }}">
                @if($transaction->transaction_type === 'borrow')
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4"></path>
                    </svg>
                @elseif($transaction->transaction_type === 'return')
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 17l-4 4m0 0l-4-4m4 4V3"></path>
                    </svg>
                @elseif($transaction->transaction_type === 'delivery')
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                @else
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                @endif
            </div>
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-semibold text-gray-900">{{ $transaction->item->name }}</p>
                        <p class="text-sm text-gray-600">
                            {{ ucfirst(str_replace('_', ' ', $transaction->transaction_type)) }} • 
                            {{ $transaction->quantity }} {{ $transaction->item->unit }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm text-gray-500">{{ $transaction->transaction_date->format('M j') }}</p>
                        <p class="text-xs text-gray-400">{{ $transaction->transaction_date->format('g:i A') }}</p>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="text-center py-8 text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
            </svg>
            <p>No recent activity</p>
        </div>
        @endforelse
    </div>
</div>
