<x-app-layout>
    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">

            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 sm:mb-8">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0"
                         style="background: linear-gradient(135deg, #374151 0%, #6B7280 100%);">
                        <svg class="w-5 h-5 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12M10 12v4m4-4v4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-4xl font-bold mb-1 text-gray-700">Archived Categories</h1>
                        <p class="text-gray-600 text-sm sm:text-lg font-medium hidden sm:block">Categories removed from active use</p>
                        <div class="flex items-center mt-1 sm:mt-3 text-sm text-gray-500">
                            <div class="w-2 h-2 bg-gray-400 rounded-full mr-2"></div>
                            <span class="font-medium">{{ $categories->total() }} Archived</span>
                        </div>
                    </div>
                </div>
                <a href="{{ route('categories.index') }}" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold self-start sm:self-auto" style="border: 1px solid #D4AF37; color: #3D2914;">
                    <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span class="hidden sm:inline">Back to Categories</span>
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-lg rounded-2xl border border-gray-200">
                <div class="p-3 sm:p-8">
                    @if($categories->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                    <tr>
                                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Name</th>
                                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Description</th>
                                        <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Archived</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-100">
                                    @foreach($categories as $category)
                                    <tr class="hover:bg-gray-50 opacity-75">
                                        <td class="px-8 py-5 whitespace-nowrap">
                                            <div class="text-sm font-bold text-gray-600">{{ $category->name }}</div>
                                            <div class="text-xs text-gray-400">{{ $category->path }}</div>
                                        </td>
                                        <td class="px-8 py-5 text-sm text-gray-500">{{ $category->description ?: '—' }}</td>
                                        <td class="px-8 py-5 whitespace-nowrap text-sm text-gray-400">
                                            {{ $category->deleted_at->format('M d, Y') }}
                                            <div class="text-xs text-gray-300">{{ $category->deleted_at->diffForHumans() }}</div>
                                            <form method="POST" action="{{ route('categories.unarchive', $category->id) }}" class="mt-1">
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
                        <div class="mt-6 px-8 pb-4">
                            {{ $categories->links() }}
                        </div>
                    @else
                        <div class="text-center py-16">
                            <div class="w-20 h-20 mx-auto mb-4 rounded-full flex items-center justify-center bg-gray-100">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12M10 12v4m4-4v4"></path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No Archived Categories</h3>
                            <p class="text-gray-500">Categories you archive will appear here.</p>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
