<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-700 to-purple-500 bg-clip-text text-transparent">
                    Edit Batch
                </h2>
                <p class="text-gray-600 mt-1">{{ $batch->batch_number }}</p>
            </div>
            <a href="{{ route('batches.show', $batch) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-xl hover:bg-gray-200 transition-colors duration-200">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                Back to Batch
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="glass-effect rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                <div class="p-8">
                    <form action="{{ route('batches.update', $batch) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="item_id" class="block text-sm font-semibold text-gray-700 mb-2">Item</label>
                                <select name="item_id" id="item_id" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" required>
                                    <option value="">Select Item</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}" {{ (old('item_id', $batch->item_id) == $item->id) ? 'selected' : '' }}>
                                            {{ $item->name }} ({{ $item->category->name }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('item_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="quantity" class="block text-sm font-semibold text-gray-700 mb-2">Quantity</label>
                                <input type="number" name="quantity" id="quantity" value="{{ old('quantity', $batch->quantity) }}" min="0"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" 
                                    placeholder="Enter quantity" required>
                                @error('quantity')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="unit_cost" class="block text-sm font-semibold text-gray-700 mb-2">Unit Cost (Optional)</label>
                                <input type="number" name="unit_cost" id="unit_cost" value="{{ old('unit_cost', $batch->unit_cost) }}" min="0" step="0.01"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                    placeholder="0.00">
                                @error('unit_cost')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="status" class="block text-sm font-semibold text-gray-700 mb-2">Status</label>
                                <select name="status" id="status" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200" required>
                                    <option value="active" {{ old('status', $batch->status) == 'active' ? 'selected' : '' }}>Active</option>
                                    <option value="expired" {{ old('status', $batch->status) == 'expired' ? 'selected' : '' }}>Expired</option>
                                    <option value="recalled" {{ old('status', $batch->status) == 'recalled' ? 'selected' : '' }}>Recalled</option>
                                    <option value="depleted" {{ old('status', $batch->status) == 'depleted' ? 'selected' : '' }}>Depleted</option>
                                </select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="supplier" class="block text-sm font-semibold text-gray-700 mb-2">Supplier</label>
                                <input type="text" name="supplier" id="supplier" value="{{ old('supplier', $batch->supplier) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                    placeholder="Supplier name">
                                @error('supplier')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="manufacture_date" class="block text-sm font-semibold text-gray-700 mb-2">Manufacture Date</label>
                                <input type="date" name="manufacture_date" id="manufacture_date" value="{{ old('manufacture_date', $batch->manufacture_date?->format('Y-m-d')) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                @error('manufacture_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="expiry_date" class="block text-sm font-semibold text-gray-700 mb-2">Expiry Date</label>
                                <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', $batch->expiry_date?->format('Y-m-d')) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200">
                                @error('expiry_date')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="lot_number" class="block text-sm font-semibold text-gray-700 mb-2">Lot Number</label>
                                <input type="text" name="lot_number" id="lot_number" value="{{ old('lot_number', $batch->lot_number) }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                    placeholder="Lot/Serial number">
                                @error('lot_number')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label for="notes" class="block text-sm font-semibold text-gray-700 mb-2">Notes</label>
                                <textarea name="notes" id="notes" rows="3" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-colors duration-200"
                                    placeholder="Additional batch information">{{ old('notes', $batch->notes) }}</textarea>
                                @error('notes')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                            <a href="{{ route('batches.show', $batch) }}" 
                                class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors duration-200">
                                Cancel
                            </a>
                            <button type="submit" 
                                class="px-6 py-3 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl" 
                                style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Update Batch
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>