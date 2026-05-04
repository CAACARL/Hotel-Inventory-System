<x-app-layout>
    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">

            <!-- Page Header -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 sm:mb-8">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0"
                         style="background: linear-gradient(135deg, #374151 0%, #6B7280 100%);">
                        <svg class="w-5 h-5 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12M10 12v4m4-4v4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-4xl font-bold mb-1 text-gray-700">Archived Items</h1>
                        <p class="text-gray-600 text-sm sm:text-lg font-medium hidden sm:block">Items removed from active inventory</p>
                        <div class="flex items-center mt-1 sm:mt-3 text-sm text-gray-500">
                            <div class="w-2 h-2 bg-gray-400 rounded-full mr-2"></div>
                            <span class="font-medium">{{ $items->total() }} Archived</span>
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

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200">
                <div class="p-3 sm:p-8 text-gray-900">
                    @if($items->count() > 0)

                        {{-- MOBILE CARDS --}}
                        <div class="sm:hidden space-y-3">
                            @foreach($items as $item)
                            <div class="border border-gray-200 rounded-xl p-4 bg-gray-50 opacity-75">
                                <div class="flex items-start justify-between gap-2 mb-2">
                                    <div class="flex items-start gap-2 min-w-0">
                                        @if($item->image)
                                            <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="w-9 h-9 object-cover rounded-lg border border-gray-200 flex-shrink-0 grayscale">
                                        @else
                                            <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 bg-gray-300">
                                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                            </div>
                                        @endif
                                        <div class="min-w-0">
                                            <div class="font-bold text-gray-700 text-sm">{{ $item->name }}</div>
                                            <div class="text-xs text-gray-400">{{ $item->category->getFullPath() }}</div>
                                        </div>
                                    </div>
                                    <span class="inline-flex px-2 py-0.5 text-xs font-bold rounded-full bg-gray-100 text-gray-600 flex-shrink-0">Archived</span>
                                </div>
                                <div class="text-xs text-gray-400">Archived {{ $item->deleted_at->diffForHumans() }}</div>
                                <form method="POST" action="{{ route('items.unarchive', $item->id) }}" class="mt-2">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center px-3 py-1.5 text-xs font-medium rounded-lg border border-amber-300 text-amber-700 hover:bg-amber-50 transition-colors">
                                        <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                        Unarchive
                                    </button>
                                </form>
                            </div>
                            @endforeach
                        </div>

                        {{-- DESKTOP TABLE --}}
                        <div class="hidden sm:block overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Item</th>
                                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Category</th>
                                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Department</th>
                                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Type</th>
                                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Last Status</th>
                                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Archived</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($items as $item)
                                    <tr class="hover:bg-gray-50 opacity-75">
                                        <td class="px-8 py-5 whitespace-nowrap">
                                            <div class="flex items-center gap-3">
                                                @if($item->image)
                                                    <img src="{{ Storage::url($item->image) }}" alt="{{ $item->name }}" class="w-10 h-10 object-cover rounded-lg border border-gray-200 grayscale">
                                                @else
                                                    <div class="w-10 h-10 rounded-lg flex items-center justify-center bg-gray-200">
                                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                                    </div>
                                                @endif
                                                <div>
                                                    <div class="text-sm font-bold text-gray-600">{{ $item->name }}</div>
                                                    <div class="text-xs text-gray-400">{{ Str::limit($item->description, 40) }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-500">{{ $item->category->getFullPath() }}</td>
                                        <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-500">{{ $item->department->name ?? '—' }}</td>
                                        <td class="px-8 py-5 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-0.5 text-xs font-bold rounded-full bg-gray-100 text-gray-600">
                                                {{ $item->item_type === 'consumable' ? 'Consumable' : 'Non-Consumable' }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 whitespace-nowrap">
                                            <span class="inline-flex px-2 py-0.5 text-xs font-bold rounded-full bg-gray-100 text-gray-600">
                                                {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                            </span>
                                        </td>
                                        <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-400">
                                            {{ $item->deleted_at->format('M d, Y') }}
                                            <div class="text-xs text-gray-300">{{ $item->deleted_at->diffForHumans() }}</div>
                                            <form method="POST" action="{{ route('items.unarchive', $item->id) }}" class="mt-1">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center px-3 py-1 text-xs font-medium rounded-lg border border-amber-300 text-amber-700 hover:bg-amber-50 transition-colors">
                                                    <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                                                    Unarchive
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="mt-4 sm:mt-6 px-0 sm:px-8 pb-4 sm:pb-8">
                            {{ $items->links() }}
                        </div>

                    @else
                        <div class="text-center py-16">
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full flex items-center justify-center bg-gray-100">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12M10 12v4m4-4v4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Archived Items</h3>
                            <p class="text-gray-500">Items you archive will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
