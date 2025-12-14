<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-amber-700 to-yellow-500 bg-clip-text text-transparent">
                    Create New Category
                </h2>
                <p class="text-gray-600 mt-1">Add a new category to organize your inventory items</p>
            </div>
            <a href="{{ route('categories.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Categories
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-effect rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('categories.store') }}" method="POST">
                        @csrf
                        
                        <div class="space-y-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Category Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                    placeholder="Enter category name" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div>
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                <textarea name="description" id="description" rows="4" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                    placeholder="Enter category description (optional)">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600 flex items-center">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div class="bg-gradient-to-r from-emerald-50 to-green-50 rounded-xl p-4 border border-emerald-200">
                                <label class="flex items-center">
                                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                        class="w-5 h-5 rounded border-emerald-300 text-emerald-600 shadow-sm focus:border-emerald-500 focus:ring-emerald-500">
                                    <span class="ml-3 text-sm font-semibold text-gray-700">Active Category</span>
                                </label>
                                <p class="text-xs text-gray-600 mt-1 ml-8">Active categories will be available for item assignment</p>
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('categories.index') }}" 
                                class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors duration-200">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="px-6 py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white font-semibold rounded-xl hover:from-emerald-600 hover:to-green-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                                Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>