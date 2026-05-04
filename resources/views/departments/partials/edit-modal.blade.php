<!-- Edit Department Modal -->
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
             class="modal-container bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto relative z-10 border border-indigo-200">
            
            <!-- Modern Modal Header with Gradient -->
            <div class="modal-header-gradient flex items-center justify-between p-4 border-b border-gray-200 rounded-t-2xl" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
                <div class="flex items-center">
                    <div class="w-9 h-9 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Edit Department</h3>
                        <p class="text-indigo-100 text-xs">Update department information</p>
                    </div>
                </div>
                <button @click="editModal = false" class="text-white hover:text-indigo-200 transition-colors duration-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <template x-if="selectedDepartment">
                <form :action="'/departments/' + selectedDepartment.id" method="POST" class="p-4" 
                      x-init="
                        $nextTick(() => {
                            $el.querySelector('#edit_name').value = selectedDepartment.name || '';
                            $el.querySelector('#edit_description').value = selectedDepartment.description || '';
                            $el.querySelector('#edit_location').value = selectedDepartment.location || '';
                            $el.querySelector('#edit_is_active').checked = selectedDepartment.is_active;
                        })
                      ">
                    @csrf
                    @method('PUT')
                    <div class="space-y-3">
                        <div>
                            <label for="edit_name" class="block text-xs font-semibold text-gray-700 mb-1.5">Department Name</label>
                            <input type="text" 
                                   id="edit_name" 
                                   name="name" 
                                   required
                                   class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm" 
                                   placeholder="Department name">
                        </div>
                        
                        <div>
                            <label for="edit_description" class="block text-xs font-semibold text-gray-700 mb-1.5">Description</label>
                            <textarea id="edit_description" 
                                      name="description" 
                                      rows="3"
                                      class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm" 
                                      placeholder="Department description"></textarea>
                        </div>
                        
                        <div>
                            <label for="edit_location" class="block text-xs font-semibold text-gray-700 mb-1.5">Location</label>
                            <input type="text" 
                                   id="edit_location" 
                                   name="location" 
                                   class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm" 
                                   placeholder="Department location">
                        </div>
                    </div>
                    
                    <!-- Modern Modal Footer -->
                    <div class="flex justify-end space-x-3 mt-4 pt-3 border-t border-gray-200">
                        <button type="button" 
                                @click="editModal = false"
                                class="px-3 py-1.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 font-medium text-sm">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="animated-button px-4 py-1.5 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 text-sm" 
                                style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
                            <svg class="w-3 h-3 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Update
                        </button>
                    </div>
                </form>
            </template>
        </div>
    </div>
</div>
