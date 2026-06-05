<!-- Edit User Modal -->
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
    
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="editModal = false"></div>
    
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div x-show="editModal"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="modal-container bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto relative z-10 border border-indigo-200">
            
            <div class="modal-header-gradient flex items-center justify-between p-4 border-b border-gray-200 rounded-t-2xl" style="background: linear-gradient(135deg, #4F46E5 0%, #7C3AED 100%);">
                <div class="flex items-center">
                    <div class="w-9 h-9 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Edit User</h3>
                        <p class="text-indigo-100 text-xs">Update user information</p>
                    </div>
                </div>
                <button @click="editModal = false" class="text-white hover:text-indigo-200 transition-colors duration-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <template x-if="selectedUser">
                <form :action="'/users/' + selectedUser.id" method="POST" class="p-4"
                      x-init="
                        $nextTick(() => {
                            $el.querySelector('#edit_name').value = selectedUser.name || '';
                            $el.querySelector('#edit_email').value = selectedUser.email || '';
                            $el.querySelector('#edit_role').value = selectedUser.role || '';
                            $el.querySelector('#edit_department').value = selectedUser.department || '';
                        })
                      ">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="page" value="{{ request('page', 1) }}">
                    <div class="space-y-3">
                        <div>
                            <label for="edit_name" class="block text-xs font-semibold text-gray-700 mb-1.5">Full Name</label>
                            <input type="text" 
                                   id="edit_name" 
                                   name="name" 
                                   required
                                   class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm" 
                                   placeholder="Enter full name">
                        </div>
                        
                        <div>
                            <label for="edit_email" class="block text-xs font-semibold text-gray-700 mb-1.5">Email Address</label>
                            <input type="email" 
                                   id="edit_email" 
                                   name="email" 
                                   required
                                   class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm" 
                                   placeholder="Enter email address">
                        </div>
                        
                        <div>
                            <label for="edit_password" class="block text-xs font-semibold text-gray-700 mb-1.5">New Password (optional)</label>
                            <input type="password" 
                                   id="edit_password" 
                                   name="password" 
                                   class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm" 
                                   placeholder="Leave blank to keep current password">
                        </div>
                        
                        <div>
                            <label for="edit_password_confirmation" class="block text-xs font-semibold text-gray-700 mb-1.5">Confirm New Password</label>
                            <input type="password" 
                                   id="edit_password_confirmation" 
                                   name="password_confirmation" 
                                   class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm" 
                                   placeholder="Confirm new password">
                        </div>
                        
                        <div>
                            <label for="edit_role" class="block text-xs font-semibold text-gray-700 mb-1.5">Role</label>
                            <select name="role" 
                                    id="edit_role" 
                                    required
                                    class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm">
                                <option value="admin">Admin</option>
                                <option value="staff">Staff</option>
                            </select>
                        </div>
                        
                        <div>
                            <label for="edit_department" class="block text-xs font-semibold text-gray-700 mb-1.5">Department</label>
                            <select name="department" 
                                    id="edit_department" 
                                    required
                                    class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm">
                                @foreach($departments as $department)
                                    <option value="{{ $department->name }}">
                                        {{ $department->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
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
