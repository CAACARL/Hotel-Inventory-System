<x-app-layout>
    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 sm:mb-8">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0"
                         style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                        <svg class="w-5 h-5 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-4xl font-bold mb-1 text-amber-700">Borrowed Items</h1>
                        <p class="text-gray-600 text-sm sm:text-lg font-medium hidden sm:block">Track all items currently borrowed by staff members</p>
                        <div class="flex items-center mt-1 sm:mt-3 text-sm text-gray-500">
                            <div class="w-2 h-2 bg-orange-500 rounded-full mr-2"></div>
                            <span class="font-medium">{{ $borrowedItems->count() }} Active Borrowings</span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('items.index') }}" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold self-start sm:self-auto" style="border: 1px solid #D4AF37; color: #3D2914;">
                    <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="hidden sm:inline">Back to Items</span>
                </a>
            </div>

            <div class="modern-card bg-white overflow-hidden shadow-lg rounded-2xl">
                <div class="p-3 sm:p-8 text-gray-900">
                    @if($borrowedItems->count() > 0)

                        {{-- MOBILE CARDS --}}
                        <div class="sm:hidden space-y-3">
                            @foreach($borrowedItems as $borrowing)
                            <div class="border border-gray-200 rounded-xl p-4 bg-gray-50">
                                <div class="flex items-start justify-between gap-2 mb-3">
                                    <div class="min-w-0">
                                        <div class="font-bold text-gray-900 text-sm">{{ $borrowing->item->name }}</div>
                                        <div class="text-xs text-gray-500">{{ $borrowing->item->category->name }}</div>
                                    </div>
                                    <span class="inline-flex px-2 py-0.5 text-xs font-bold rounded-full bg-amber-100 text-amber-800 flex-shrink-0">
                                        {{ $borrowing->quantity_borrowed }} {{ $borrowing->item->unit }}
                                    </span>
                                </div>
                                <div class="grid grid-cols-2 gap-1 text-xs text-gray-600">
                                    <div><span class="text-gray-400">Borrower:</span> <span class="font-medium">{{ $borrowing->borrower_name }}</span></div>
                                    <div><span class="text-gray-400">Dept:</span> {{ $borrowing->borrower_department }}</div>
                                    <div><span class="text-gray-400">Date:</span> {{ $borrowing->borrowed_date->format('M d, Y') }}</div>
                                    <div><span class="text-gray-400">Ref:</span> <span class="font-mono">{{ $borrowing->reference_number }}</span></div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        {{-- DESKTOP TABLE --}}
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Item</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Borrower</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Department</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Borrowed Date</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Reference</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Notes</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($borrowedItems as $borrowing)
                                    <tr class="hover:bg-gray-50">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                                    </svg>
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $borrowing->item->name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $borrowing->item->category->name }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="flex items-center">
                                                <div class="w-10 h-10 rounded-lg overflow-hidden mr-3 shadow-sm">
                                                    @if($borrowing->user->getProfilePictureUrl())
                                                        <img src="{{ $borrowing->user->getProfilePictureUrl() }}" alt="{{ $borrowing->user->name }}" class="w-full h-full object-cover">
                                                    @else
                                                        @php $avatar = $borrowing->user->getDefaultAvatar(); @endphp
                                                        <div class="w-full h-full {{ $avatar['color'] }} flex items-center justify-center text-white font-semibold text-sm">
                                                            {{ $avatar['initials'] }}
                                                        </div>
                                                    @endif
                                                </div>
                                                <div>
                                                    <div class="text-sm font-medium text-gray-900">{{ $borrowing->borrower_name }}</div>
                                                    <div class="text-sm text-gray-500">{{ $borrowing->user->email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $borrowing->borrower_department }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-amber-100 text-amber-800">
                                                {{ $borrowing->quantity_borrowed }} {{ $borrowing->item->unit }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $borrowing->borrowed_date->format('M d, Y') }}</div>
                                            <div class="text-sm text-gray-500">{{ $borrowing->borrowed_date->format('h:i A') }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                {{ $borrowing->reference_number }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm text-gray-900 max-w-xs truncate">{{ $borrowing->notes ?: 'No notes' }}</div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-12">
                            <div class="w-24 h-24 mx-auto mb-4 rounded-full flex items-center justify-center bg-gray-100">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-medium text-gray-900 mb-2">No Items Currently Borrowed</h3>
                            <p class="text-gray-500">All items have been returned or no borrowing transactions have been made.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

    <style>
        .modern-card { background: white; border: 1px solid #e5e7eb; border-radius: 16px; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.1); }
    </style>
</x-app-layout>
