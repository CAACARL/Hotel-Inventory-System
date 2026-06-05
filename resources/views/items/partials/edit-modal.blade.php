<!-- Edit Item Modal -->
<div x-show="editModal" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[60] overflow-y-auto" 
     @keydown.escape="editModal = false"
     style="display: none;"
     x-init="$watch('editModal', value => { document.body.classList.toggle('modal-open', value) })">
    
    <!-- Enhanced Backdrop with Blur -->
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="editModal = false"></div>
    
    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div x-show="editModal"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="modal-container bg-white rounded-2xl shadow-2xl max-w-lg w-full mx-auto relative z-10 border border-indigo-200">
            
            <!-- Modern Modal Header with Gradient -->
            <div class="modal-header-gradient flex items-center justify-between p-4 border-b border-gray-200 rounded-t-2xl" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
                <div class="flex items-center">
                    <div class="w-9 h-9 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Edit Item</h3>
                        <p class="text-indigo-100 text-xs">Update item information</p>
                    </div>
                </div>
                <button @click="editModal = false" class="text-white hover:text-indigo-200 transition-colors duration-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <form :action="'/items/' + selectedItem?.id" method="POST" class="p-4" x-show="selectedItem" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <input type="hidden" name="page" value="{{ request('page', 1) }}">
                
                <div class="space-y-3">
                    <div>
                        <label for="edit_item_name" class="block text-xs font-semibold text-gray-700 mb-1.5">Item Name</label>
                        <input type="text" 
                               id="edit_item_name" 
                               name="name" 
                               required
                               :value="selectedItem?.name"
                               class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm" 
                               placeholder="Enter item name">
                    </div>
                    
                    <div>
                        <label for="edit_category_id" class="block text-xs font-semibold text-gray-700 mb-1.5">Category</label>
                        <select name="category_id" 
                                id="edit_category_id" 
                                required
                                class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm">
                            <option value="">Select Category</option>
                            @foreach(\App\Models\Category::where('is_active', true)->orderBy('path')->get() as $category)
                                <option :selected="selectedItem?.category_id == {{ $category->id }}" value="{{ $category->id }}">
                                    @if($category->level == 0)
                                        {{ $category->name }}
                                    @else
                                        {{ str_repeat('│  ', $category->level - 1) }}├─ {{ $category->name }}
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div>
                        <label for="edit_department_id" class="block text-xs font-semibold text-gray-700 mb-1.5">Department</label>
                        <select name="department_id" 
                                id="edit_department_id" 
                                class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm">
                            <option value="">Select Department (Optional)</option>
                            @foreach(\App\Models\Department::where('is_active', true)->get() as $department)
                                <option :selected="selectedItem?.department_id == {{ $department->id }}" value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="edit_status" class="block text-xs font-semibold text-gray-700 mb-1.5">Status</label>
                            <div class="w-full px-3 py-2 bg-gray-50 border border-gray-200 rounded-xl text-sm font-medium text-gray-700 capitalize"
                                 x-text="selectedItem?.status?.replace('_', ' ')"></div>
                            <input type="hidden" name="status" :value="selectedItem?.status">
                        </div>

                        <div>
                            <label for="edit_item_type" class="block text-xs font-semibold text-gray-700 mb-1.5">Item Type</label>
                            <select name="item_type"
                                    id="edit_item_type"
                                    required
                                    class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm">
                                <option :selected="selectedItem?.item_type == 'non-consumable'" value="non-consumable">Non-Consumable</option>
                                <option :selected="selectedItem?.item_type == 'consumable'" value="consumable">Consumable</option>
                            </select>
                        </div>
                        <div x-data="{ custom: false, unit: 'pcs' }" x-init="$watch('selectedItem', v => { const std = ['pcs','sets','bottles','bags','rolls','boxes','pairs','kits','reams','cans','packs']; custom = !!v?.unit && !std.includes(v.unit); unit = v?.unit || 'pcs'; })">
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Unit</label>
                            <select x-show="!custom"
                                    x-model="unit"
                                    @change="if(unit === 'other') { custom = true; unit = ''; $nextTick(() => $refs.editUnitCustom.focus()); }"
                                    class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm">
                                <option value="pcs">pcs</option>
                                <option value="sets">sets</option>
                                <option value="bottles">bottles</option>
                                <option value="bags">bags</option>
                                <option value="rolls">rolls</option>
                                <option value="boxes">boxes</option>
                                <option value="pairs">pairs</option>
                                <option value="kits">kits</option>
                                <option value="reams">reams</option>
                                <option value="cans">cans</option>
                                <option value="packs">packs</option>
                                <option value="other">Other...</option>
                            </select>
                            <div x-show="custom" class="flex gap-1">
                                <input type="text" x-ref="editUnitCustom" x-model="unit" required
                                       class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="e.g. liters">
                                <button type="button" @click="custom = false; unit = 'pcs'"
                                        class="px-2 py-1 text-gray-400 hover:text-gray-600 text-xs rounded-lg border border-gray-200">↩</button>
                            </div>
                            <input type="hidden" name="unit" :value="unit">
                        </div>
                    </div>

                    <div>
                        <label for="edit_location" class="block text-xs font-semibold text-gray-700 mb-1.5">Location</label>
                        <input type="text" 
                               id="edit_location" 
                               name="location" 
                               :value="selectedItem?.location"
                               class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm" 
                               placeholder="e.g., Storage Room A">
                    </div>
                    
                    <div>
                        <label for="edit_item_description" class="block text-xs font-semibold text-gray-700 mb-1.5">Description</label>
                        <textarea id="edit_item_description" 
                                  name="description" 
                                  rows="2"
                                  :value="selectedItem?.description"
                                  class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm" 
                                  placeholder="Enter item description"></textarea>
                    </div>

                    <div>
                        <label for="edit_image" class="block text-xs font-semibold text-gray-700 mb-1.5">Item Image (Optional)</label>
                        <div x-show="selectedItem?.image" class="mb-2">
                            <img :src="'/storage/' + selectedItem?.image" class="w-16 h-16 object-cover rounded-lg border border-gray-200">
                            <p class="text-xs text-gray-400 mt-1">Current image — upload a new one to replace it.</p>
                        </div>
                        <input type="file"
                               id="edit_image"
                               name="image"
                               accept="image/*"
                               class="w-full px-3 py-2 border border-gray-300 rounded-xl text-sm text-gray-700 file:mr-3 file:py-1 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 transition-all duration-200">
                        <p class="mt-1 text-xs text-gray-400">JPEG, PNG, GIF or WebP. Max 2MB.</p>
                    </div>
                </div>
                
                <!-- Modal Footer -->
                <div class="flex justify-end space-x-3 mt-4 pt-3 border-t border-gray-200">
                    <button type="button"
                            @click="editModal = false"
                            class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all duration-200 font-medium text-sm">
                        Cancel
                    </button>
                    <button type="submit"
                            class="animated-button px-6 py-2 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 text-sm"
                            style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
                        <svg class="w-4 h-4 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Dispose Modal -->
<div x-data="{ open: false, itemId: null, itemName: '', maxQty: 0 }"
     @open-dispose.window="open = true; itemId = $event.detail.id; itemName = $event.detail.name; maxQty = $event.detail.qty"
     x-show="open"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[70] overflow-y-auto"
     @keydown.escape="open = false"
     style="display:none"
     x-init="$watch('open', v => document.body.classList.toggle('modal-open', v))">

    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="open = false"></div>

    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="modal-container bg-white rounded-2xl shadow-2xl max-w-sm w-full mx-auto relative z-10 border border-red-200">

            <div class="flex items-center justify-between p-4 border-b border-gray-200 rounded-t-2xl" style="background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);">
                <div class="flex items-center">
                    <div class="w-9 h-9 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Dispose Item</h3>
                        <p class="text-red-100 text-xs" x-text="itemName"></p>
                    </div>
                </div>
                <button @click="open = false" class="text-white hover:text-red-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <form :action="'/items/' + itemId + '/disposal'" method="POST" class="p-4">
                @csrf
                <input type="hidden" name="page" value="{{ request('page', 1) }}">
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Quantity to Dispose <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" min="1" :max="maxQty" required
                               class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-red-400 focus:border-red-400"
                               placeholder="Enter quantity">
                        <p class="mt-1 text-xs text-gray-500">Available stock: <span class="font-semibold" x-text="maxQty"></span></p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Reason <span class="text-red-500">*</span></label>
                        <input type="text" name="notes" required
                               class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-red-400 focus:border-red-400"
                               placeholder="e.g. Broken beyond repair">
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-4 pt-3 border-t border-gray-200">
                    <button type="button" @click="open = false"
                            class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium text-sm transition-colors">
                        Cancel
                    </button>
                    <button type="submit"
                            class="animated-button px-5 py-2 text-white font-semibold rounded-xl shadow-lg text-sm transition-all"
                            style="background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);">
                        Confirm Dispose
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
        </div>
    </div>
</div>

<!-- Borrow Item Modal -->
<div x-show="borrowModal" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[60] overflow-y-auto" 
     @keydown.escape="borrowModal = false"
     style="display: none;"
     x-init="$watch('borrowModal', value => { document.body.classList.toggle('modal-open', value) })">
    
    <!-- Enhanced Backdrop with Blur -->
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="borrowModal = false"></div>
    
    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div x-show="borrowModal"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="modal-container bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto relative z-10 border border-amber-200">
            
            <!-- Modern Modal Header with Gradient -->
            <div class="modal-header-gradient flex items-center justify-between p-4 border-b border-gray-200 rounded-t-2xl" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                <div class="flex items-center">
                    <div class="w-9 h-9 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Borrow Item</h3>
                        <p class="text-amber-100 text-xs">Record item borrowing transaction</p>
                    </div>
                </div>
                <button @click="borrowModal = false" class="text-white hover:text-amber-200 transition-colors duration-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body with Modern Form -->
            <form :action="'/items/' + selectedItem?.id + '/borrow'" method="POST" class="p-4" x-show="selectedItem">
                @csrf
                <input type="hidden" name="page" value="{{ request('page', 1) }}">
                <div class="space-y-3">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Item</label>
                        <div class="w-full px-3 py-2 bg-gradient-to-r from-amber-50 to-yellow-50 border border-amber-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedItem?.name"></div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Available Quantity</label>
                        <div class="w-full px-3 py-2 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedItem?.quantity + ' ' + selectedItem?.unit"></div>
                    </div>
                    
                    <div>
                        <label for="borrow_quantity" class="block text-xs font-semibold text-gray-700 mb-1.5">Quantity to Borrow</label>
                        <input type="number" 
                               id="borrow_quantity" 
                               name="quantity" 
                               min="1"
                               :max="selectedItem?.quantity"
                               required
                               class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm" 
                               placeholder="Enter quantity">
                    </div>
                    
                    <div>
                        <label for="borrower_name" class="block text-xs font-semibold text-gray-700 mb-1.5">Borrower Name</label>
                        <input type="text" 
                               id="borrower_name" 
                               name="borrower_name" 
                               value="{{ auth()->user()->name }}"
                               readonly
                               class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-300 rounded-xl text-gray-900 font-medium text-sm" 
                               placeholder="Borrower name">
                    </div>
                    
                    <div>
                        <label for="borrower_department" class="block text-xs font-semibold text-gray-700 mb-1.5">Department</label>
                        <input type="text" 
                               id="borrower_department" 
                               name="borrower_department" 
                               value="{{ auth()->user()->department }}"
                               readonly
                               class="w-full px-3 py-2 bg-gradient-to-r from-gray-50 to-gray-100 border border-gray-300 rounded-xl text-gray-900 font-medium text-sm" 
                               placeholder="Department">
                    </div>
                    
                    <div>
                        <label for="notes" class="block text-xs font-semibold text-gray-700 mb-1.5">Notes (Optional)</label>
                        <textarea id="notes" 
                                  name="notes" 
                                  rows="2"
                                  class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm" 
                                  placeholder="Enter any additional notes"></textarea>
                    </div>
                </div>
                
                <!-- Modern Modal Footer -->
                <div class="flex justify-end space-x-3 mt-4 pt-3 border-t border-gray-200">
                    <button type="button" 
                            @click="borrowModal = false"
                            class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all duration-200 font-medium text-sm">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="animated-button px-5 py-2 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 text-sm" 
                            style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                        <svg class="w-3 h-3 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                        </svg>
                        Borrow
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Return Item Modal -->
<div x-show="returnModal" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[60] overflow-y-auto" 
     @keydown.escape="returnModal = false"
     style="display: none;"
     x-init="$watch('returnModal', value => { document.body.classList.toggle('modal-open', value) })">
    
    <!-- Enhanced Backdrop with Blur -->
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="returnModal = false"></div>
    
    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div x-show="returnModal"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="modal-container bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto relative z-10 border border-green-200">
            
            <!-- Modern Modal Header with Gradient -->
            <div class="modal-header-gradient flex items-center justify-between p-4 border-b border-gray-200 rounded-t-2xl" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
                <div class="flex items-center">
                    <div class="w-9 h-9 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Return Item</h3>
                        <p class="text-green-100 text-xs">Return borrowed inventory item</p>
                    </div>
                </div>
                <button @click="returnModal = false" class="text-white hover:text-green-200 transition-colors duration-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body with Modern Form -->
            <template x-if="selectedItem">
                <form :action="'/items/' + selectedItem.id + '/return'" method="POST" class="p-4">
                    @csrf
                    <input type="hidden" name="page" value="{{ request('page', 1) }}">
                    <div class="space-y-3">
                        <!-- Enhanced Item Info Card -->
                        <div class="bg-gradient-to-r from-green-50 to-emerald-50 rounded-xl p-3 border border-green-200">
                            <div class="flex items-center mb-2">
                                <div class="w-7 h-7 bg-green-100 rounded-lg flex items-center justify-center mr-2">
                                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                    </svg>
                                </div>
                                <h4 class="font-bold text-gray-900 text-sm" x-text="selectedItem?.name"></h4>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-xs">
                                <div class="bg-white bg-opacity-50 rounded-lg p-2">
                                    <span class="font-semibold text-gray-700">Available to Return:</span>
                                    <div class="text-green-700 font-bold" x-text="selectedItem?.borrowed_quantity + ' ' + selectedItem?.unit"></div>
                                </div>
                                <div class="bg-white bg-opacity-50 rounded-lg p-2">
                                    <span class="font-semibold text-gray-700">Current Stock:</span>
                                    <div class="text-gray-900 font-bold" x-text="selectedItem?.quantity + ' ' + selectedItem?.unit"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Return Quantity -->
                        <div>
                            <label for="return_quantity" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Return Quantity <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <input type="number" 
                                       id="return_quantity" 
                                       name="quantity" 
                                       min="1" 
                                       :max="selectedItem?.borrowed_quantity"
                                       :value="selectedItem?.borrowed_quantity"
                                       required
                                       class="modern-input w-full px-3 py-2 pr-12 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 text-sm"
                                       placeholder="Enter quantity to return">
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                    <span class="text-gray-500 text-xs font-medium" x-text="selectedItem?.unit"></span>
                                </div>
                            </div>
                            <p class="mt-1 text-xs text-gray-500 bg-gray-50 rounded-lg p-1.5">
                                Maximum returnable: <span class="font-semibold" x-text="selectedItem?.borrowed_quantity + ' ' + selectedItem?.unit"></span>
                            </p>
                        </div>

                        <!-- Return Notes -->
                        <div>
                            <label for="return_notes" class="block text-xs font-semibold text-gray-700 mb-1.5">
                                Return Notes
                            </label>
                            <textarea id="return_notes" 
                                      name="notes" 
                                      rows="2"
                                      class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-green-500 focus:border-green-500 hover:border-gray-400 text-sm"
                                      placeholder="Optional notes about the return (condition, reason, etc.)"></textarea>
                        </div>
                    </div>
                    
                    <!-- Modern Modal Footer -->
                    <div class="flex justify-end space-x-3 mt-4 pt-3 border-t border-gray-200">
                        <button type="button" 
                                @click="returnModal = false"
                                class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all duration-200 font-medium text-sm">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="animated-button px-5 py-2 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 text-sm" 
                                style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
                            <svg class="w-3 h-3 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 15v-1a4 4 0 00-4-4H8m0 0l3 3m-3-3l3-3m9 14V5a2 2 0 00-2-2H6a2 2 0 00-2 2v16l4-2 4 2 4-2 4 2z"></path>
                            </svg>
                            Return
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>
</div>
