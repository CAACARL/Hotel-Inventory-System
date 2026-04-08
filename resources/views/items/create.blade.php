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
                                        @include('items.partials.category-option', ['category' => $category])
                                    @endforeach
                                </select>
                                @error('category_id')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="department_id" class="block text-sm font-semibold text-gray-700 mb-2">Department (Optional)</label>
                                <select name="department_id" id="department_id" 
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;">
                                    <option value="">Select Department</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->id }}" {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                            {{ $department->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('department_id')
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
                                <label for="unit_price" class="block text-sm font-semibold text-gray-700 mb-2">Unit Price in Pesos (Optional)</label>
                                <input type="number" name="unit_price" id="unit_price" value="{{ old('unit_price') }}" min="0" step="0.01"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                    placeholder="0.00">
                                @error('unit_price')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Depreciation Section -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                </svg>
                                Asset & Depreciation Information
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="purchase_price" class="block text-sm font-semibold text-gray-700 mb-2">Purchase Price (Optional)</label>
                                    <input type="number" name="purchase_price" id="purchase_price" value="{{ old('purchase_price') }}" min="0" step="0.01"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                        placeholder="0.00">
                                    @error('purchase_price')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="purchase_date" class="block text-sm font-semibold text-gray-700 mb-2">Purchase Date (Optional)</label>
                                    <input type="date" name="purchase_date" id="purchase_date" value="{{ old('purchase_date') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;">
                                    @error('purchase_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="useful_life_years" class="block text-sm font-semibold text-gray-700 mb-2">Useful Life (Years)</label>
                                    <input type="number" name="useful_life_years" id="useful_life_years" value="{{ old('useful_life_years') }}" min="1" max="50"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                        placeholder="5">
                                    @error('useful_life_years')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="depreciation_method" class="block text-sm font-semibold text-gray-700 mb-2">Depreciation Method</label>
                                    <select name="depreciation_method" id="depreciation_method" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;">
                                        <option value="none" {{ old('depreciation_method', 'none') == 'none' ? 'selected' : '' }}>No Depreciation</option>
                                        <option value="straight_line" {{ old('depreciation_method') == 'straight_line' ? 'selected' : '' }}>Straight Line</option>
                                        <option value="declining_balance" {{ old('depreciation_method') == 'declining_balance' ? 'selected' : '' }}>Declining Balance</option>
                                    </select>
                                    @error('depreciation_method')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="salvage_value" class="block text-sm font-semibold text-gray-700 mb-2">Salvage Value (Optional)</label>
                                    <input type="number" name="salvage_value" id="salvage_value" value="{{ old('salvage_value') }}" min="0" step="0.01"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                        placeholder="0.00">
                                    @error('salvage_value')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Batch Information Section -->
                        <div class="mt-8 pt-6 border-t border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                                Batch Information (Optional)
                            </h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label for="manufacture_date" class="block text-sm font-semibold text-gray-700 mb-2">Manufacture Date</label>
                                    <input type="date" name="manufacture_date" id="manufacture_date" value="{{ old('manufacture_date') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;">
                                    @error('manufacture_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="expiry_date" class="block text-sm font-semibold text-gray-700 mb-2">Expiry Date</label>
                                    <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;">
                                    @error('expiry_date')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="supplier" class="block text-sm font-semibold text-gray-700 mb-2">Supplier</label>
                                    <input type="text" name="supplier" id="supplier" value="{{ old('supplier') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                        placeholder="Supplier name">
                                    @error('supplier')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="lot_number" class="block text-sm font-semibold text-gray-700 mb-2">Lot Number</label>
                                    <input type="text" name="lot_number" id="lot_number" value="{{ old('lot_number') }}"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                        placeholder="Lot/Serial number">
                                    @error('lot_number')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="md:col-span-2">
                                    <label for="batch_notes" class="block text-sm font-semibold text-gray-700 mb-2">Batch Notes</label>
                                    <textarea name="batch_notes" id="batch_notes" rows="2" 
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                        placeholder="Additional batch information">{{ old('batch_notes') }}</textarea>
                                    @error('batch_notes')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
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