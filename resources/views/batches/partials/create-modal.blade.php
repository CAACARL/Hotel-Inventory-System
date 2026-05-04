<!-- Create Batch (Replenishment) Modal -->
<div x-show="createModal" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[60] overflow-y-auto" 
     @keydown.escape="createModal = false"
     style="display: none;"
     x-data="{ selectedItemType: '' }"
     x-init="$watch('createModal', value => { document.body.classList.toggle('modal-open', value) })">
    
    <!-- Enhanced Backdrop with Blur -->
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="createModal = false"></div>
    
    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div x-show="createModal"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="modal-container bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-auto relative z-10 border border-amber-200">
            
            <!-- Modern Modal Header with Gradient -->
            <div class="modal-header-gradient flex items-center justify-between p-4 border-b border-gray-200 rounded-t-2xl" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                <div class="flex items-center">
                    <div class="w-9 h-9 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Replenish Stock</h3>
                        <p class="text-amber-100 text-xs">Add new batch to inventory</p>
                    </div>
                </div>
                <button @click="createModal = false" class="text-white hover:text-amber-200 transition-colors duration-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body with Modern Form -->
            <div class="max-h-[70vh] overflow-y-auto">
                <form action="{{ route('batches.store') }}" method="POST" class="p-4">
                    @csrf
                    
                    <!-- Basic Information Section -->
                    <div class="mb-6">
                        <div class="flex items-center mb-3">
                            <div class="w-6 h-6 bg-amber-100 rounded-lg flex items-center justify-center mr-2">
                                <svg class="w-3 h-3 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                                </svg>
                            </div>
                            <h4 class="text-sm font-bold text-gray-900">Batch Information</h4>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label for="create_item_id" class="block text-xs font-semibold text-gray-700 mb-1.5">Item to Replenish</label>
                                <select id="create_item_id" name="item_id" 
                                    class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm" required
                                    @change="selectedItemType = $event.target.selectedOptions[0].dataset.type ?? ''">
                                    <option value="" data-type="">Select Item</option>
                                    @foreach($items as $item)
                                        <option value="{{ $item->id }}" data-type="{{ $item->item_type }}">{{ $item->name }} ({{ $item->category->name }})</option>
                                    @endforeach
                                </select>
                            </div>

                            <div>
                                <label for="create_quantity" class="block text-xs font-semibold text-gray-700 mb-1.5">Quantity to Add</label>
                                <input type="number" 
                                       id="create_quantity"
                                       name="quantity" 
                                       min="1"
                                       required
                                       class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm" 
                                       placeholder="Enter quantity">
                            </div>

                            <div>
                                <label for="create_unit_cost" class="block text-xs font-semibold text-gray-700 mb-1.5">Unit Cost (Optional)</label>
                                <input type="number" 
                                       id="create_unit_cost"
                                       name="unit_cost" 
                                       min="0" 
                                       step="0.01"
                                       class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm"
                                       placeholder="0.00">
                            </div>

                            <div>
                                <label for="create_supplier" class="block text-xs font-semibold text-gray-700 mb-1.5">Supplier</label>
                                <input type="text" 
                                       id="create_supplier"
                                       name="supplier" 
                                       class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm"
                                       placeholder="Supplier name">
                            </div>
                        </div>
                    </div>

                    <!-- Tracking & Dates Section (consumables only) -->
                    <div class="mb-6" x-show="selectedItemType !== 'non-consumable'">
                        <div class="flex items-center mb-3">
                            <div class="w-6 h-6 bg-blue-100 rounded-lg flex items-center justify-center mr-2">
                                <svg class="w-3 h-3 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                            <h4 class="text-sm font-bold text-gray-900">Tracking & Dates</h4>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label for="create_lot_number" class="block text-xs font-semibold text-gray-700 mb-1.5">Lot/Serial Number</label>
                                <input type="text" 
                                       id="create_lot_number"
                                       name="lot_number" 
                                       class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm"
                                       placeholder="Lot/Serial number">
                            </div>

                            <div>
                                <label for="create_manufacture_date" class="block text-xs font-semibold text-gray-700 mb-1.5">Manufacture Date</label>
                                <input type="date" 
                                       id="create_manufacture_date"
                                       name="manufacture_date" 
                                       class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm">
                            </div>

                            <div class="md:col-span-2">
                                <label for="create_expiry_date" class="block text-xs font-semibold text-gray-700 mb-1.5">Expiry Date</label>
                                <input type="date" 
                                       id="create_expiry_date"
                                       name="expiry_date" 
                                       class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm">
                            </div>
                        </div>
                    </div>

                    <!-- Depreciation Section (non-consumables only) -->
                    <div class="mb-6" id="depreciation-section" x-show="selectedItemType === 'non-consumable'">
                        <div class="flex items-center mb-3">
                            <div class="w-6 h-6 bg-purple-100 rounded-lg flex items-center justify-center mr-2">
                                <svg class="w-3 h-3 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                </svg>
                            </div>
                            <h4 class="text-sm font-bold text-gray-900">Depreciation Settings</h4>
                            <span class="ml-2 text-xs text-gray-500">(Optional - for assets)</span>
                        </div>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                            <div>
                                <label for="create_depreciation_method" class="block text-xs font-semibold text-gray-700 mb-1.5">Depreciation Method</label>
                                <select name="depreciation_method" 
                                        id="create_depreciation_method" 
                                        class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm">
                                    <option value="">No Depreciation</option>
                                    <option value="straight_line">Straight Line</option>
                                    <option value="declining_balance">Declining Balance</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="create_useful_life_years" class="block text-xs font-semibold text-gray-700 mb-1.5">Useful Life (Years)</label>
                                <input type="number" 
                                       id="create_useful_life_years" 
                                       name="useful_life_years" 
                                       min="1"
                                       max="50"
                                       class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm" 
                                       placeholder="e.g., 5">
                            </div>
                            
                            <div>
                                <label for="create_salvage_value" class="block text-xs font-semibold text-gray-700 mb-1.5">Salvage Value (PHP)</label>
                                <input type="number" 
                                       id="create_salvage_value" 
                                       name="salvage_value" 
                                       min="0"
                                       step="0.01"
                                       class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm" 
                                       placeholder="0.00">
                            </div>
                            
                            <div>
                                <label for="create_depreciation_rate" class="block text-xs font-semibold text-gray-700 mb-1.5">Depreciation Rate (%)</label>
                                <input type="number" 
                                       id="create_depreciation_rate" 
                                       name="depreciation_rate" 
                                       min="0"
                                       max="100"
                                       step="0.01"
                                       class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm" 
                                       placeholder="e.g., 20.00">
                            </div>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    <div class="mb-6">
                        <div class="flex items-center mb-3">
                            <div class="w-6 h-6 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                                <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </div>
                            <h4 class="text-sm font-bold text-gray-900">Additional Notes</h4>
                        </div>
                        <div>
                            <label for="create_notes" class="block text-xs font-semibold text-gray-700 mb-1.5">Notes</label>
                            <textarea id="create_notes"
                                      name="notes" 
                                      rows="3" 
                                      class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm"
                                      placeholder="Storage conditions, quality notes, purchase order details, etc."></textarea>
                        </div>
                    </div>

                    <!-- Modern Modal Footer -->
                    <div class="flex justify-end space-x-3 mt-4 pt-3 border-t border-gray-200">
                        <button type="button" 
                                @click="createModal = false"
                                class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all duration-200 font-medium text-sm">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="animated-button px-6 py-2 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 text-sm" 
                                style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                            <svg class="w-4 h-4 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Replenish
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
