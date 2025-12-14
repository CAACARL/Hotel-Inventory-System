<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-amber-700 to-yellow-500 bg-clip-text text-transparent">
                    Create New Item
                </h2>
                <p class="text-gray-600 mt-1">Add a new item to your hotel inventory</p>
            </div>
            <a href="{{ route('items.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Items
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-effect rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('items.store') }}" method="POST">
                        @csrf
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Item Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;" 
                                    placeholder="Enter item name" required>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="category_id" class="block text-sm font-semibold text-gray-700 mb-2">Category</label>
                                <select name="category_id" id="category_id" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;" required>
                                    <option value="">Select Category</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="description" class="block text-sm font-semibold text-gray-700 mb-2">Description</label>
                                <textarea name="description" id="description" rows="3" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                    placeholder="Enter item description (optional)">{{ old('description') }}</textarea>
                                @error('description')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-2">Initial Quantity</label>
                                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', 0) }}" min="0"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;" 
                                    placeholder="0" required>
                                @error('quantity')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="minimum_stock" class="block text-sm font-semibold text-gray-700 mb-2">Minimum Stock Level</label>
                                <input type="number" name="minimum_stock" id="minimum_stock" value="{{ old('minimum_stock', 0) }}" min="0"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;" 
                                    placeholder="0" required>
                                @error('minimum_stock')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="unit" class="block text-sm font-semibold text-gray-700 mb-2">Unit of Measurement</label>
                                <input type="text" name="unit" id="unit" value="{{ old('unit', 'pcs') }}" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;" 
                                    placeholder="e.g., pcs, kg, liters" required>
                                @error('unit')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                <select name="status" id="status" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;" required>
                                    <option value="available" {{ old('status', 'available') == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="in_use" {{ old('status') == 'in_use' ? 'selected' : '' }}>In Use</option>
                                    <option value="damaged" {{ old('status') == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                    <option value="disposed" {{ old('status') == 'disposed' ? 'selected' : '' }}>Disposed</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="location" class="block text-sm font-semibold text-gray-700 mb-2">Location</label>
                                <input type="text" name="location" id="location" value="{{ old('location') }}" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                    placeholder="e.g., Storage Room A, Housekeeping">
                                @error('location')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="unit_price" class="block text-sm font-semibold text-gray-700 mb-2">Unit Price (Optional)</label>
                                <input type="number" name="unit_price" id="unit_price" value="{{ old('unit_price') }}" min="0" step="0.01"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                    placeholder="0.00">
                                @error('unit_price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('items.index') }}" 
                                class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors duration-200">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="px-6 py-3 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);"
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Create Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>