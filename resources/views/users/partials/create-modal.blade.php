<!-- Create User Modal -->
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
             class="modal-container bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto relative z-10 border border-amber-200">
            
            <!-- Modern Modal Header with Gradient -->
            <div class="modal-header-gradient flex items-center justify-between p-4 border-b border-gray-200 rounded-t-2xl" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                <div class="flex items-center">
                    <div class="w-9 h-9 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Create New User</h3>
                        <p class="text-amber-100 text-xs">Add a new user to the system</p>
                    </div>
                </div>
                <button @click="createModal = false" class="text-white hover:text-amber-200 transition-colors duration-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <form action="{{ route('users.store') }}" method="POST" class="p-4" @submit="if (!validateForm()) { $event.preventDefault(); }">
                @csrf
                <input type="hidden" name="page" value="{{ request('page', 1) }}">
                <div class="space-y-3">
                    <div>
                        <label for="modal_name" class="block text-xs font-semibold text-gray-700 mb-1.5">Full Name</label>
                        <input type="text" 
                               id="modal_name" 
                               name="name" 
                               x-model="formData.name"
                               value="{{ old('name') }}"
                               required
                               class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm @error('name') border-red-500 @enderror" 
                               :class="formErrors.name ? 'border-red-500' : 'border-gray-300'"
                               placeholder="e.g., John Doe">
                        @error('name')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p x-show="formErrors.name" x-text="formErrors.name" class="mt-1 text-xs text-red-600"></p>
                    </div>
                    
                    <div>
                        <label for="modal_email" class="block text-xs font-semibold text-gray-700 mb-1.5">Email Address</label>
                        <input type="email" 
                               id="modal_email" 
                               name="email" 
                               x-model="formData.email"
                               value="{{ old('email') }}"
                               required
                               class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm @error('email') border-red-500 @enderror" 
                               :class="formErrors.email ? 'border-red-500' : 'border-gray-300'"
                               placeholder="e.g., john@example.com">
                        @error('email')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p x-show="formErrors.email" x-text="formErrors.email" class="mt-1 text-xs text-red-600"></p>
                    </div>
                    
                    <div>
                        <label for="modal_password" class="block text-xs font-semibold text-gray-700 mb-1.5">Password</label>
                        <input type="password" 
                               id="modal_password" 
                               name="password" 
                               x-model="formData.password"
                               required
                               minlength="8"
                               class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm @error('password') border-red-500 @enderror" 
                               :class="formErrors.password ? 'border-red-500' : 'border-gray-300'"
                               placeholder="Minimum 8 characters">
                        @error('password')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p x-show="formErrors.password" x-text="formErrors.password" class="mt-1 text-xs text-red-600"></p>
                    </div>
                    
                    <div>
                        <label for="modal_password_confirmation" class="block text-xs font-semibold text-gray-700 mb-1.5">Confirm Password</label>
                        <input type="password" 
                               id="modal_password_confirmation" 
                               name="password_confirmation" 
                               x-model="formData.password_confirmation"
                               required
                               minlength="8"
                               class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm" 
                               :class="formErrors.password_confirmation ? 'border-red-500' : 'border-gray-300'"
                               placeholder="Confirm your password">
                        <p x-show="formErrors.password_confirmation" x-text="formErrors.password_confirmation" class="mt-1 text-xs text-red-600"></p>
                    </div>
                    
                    <div>
                        <label for="modal_role" class="block text-xs font-semibold text-gray-700 mb-1.5">Role</label>
                        <select name="role" 
                                id="modal_role" 
                                x-model="formData.role"
                                required
                                class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm @error('role') border-red-500 @enderror" 
                                :class="formErrors.role ? 'border-red-500' : 'border-gray-300'">
                            <option value="">Select Role</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="staff" {{ old('role') == 'staff' ? 'selected' : '' }}>Staff</option>
                        </select>
                        @error('role')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p x-show="formErrors.role" x-text="formErrors.role" class="mt-1 text-xs text-red-600"></p>
                    </div>
                    
                    <div>
                        <label for="modal_department" class="block text-xs font-semibold text-gray-700 mb-1.5">Department</label>
                        <select name="department" 
                                id="modal_department" 
                                x-model="formData.department"
                                required
                                class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm @error('department') border-red-500 @enderror" 
                                :class="formErrors.department ? 'border-red-500' : 'border-gray-300'">
                            <option value="">Select Department</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->name }}" {{ old('department') == $department->name ? 'selected' : '' }}>
                                    {{ $department->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('department')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                        <p x-show="formErrors.department" x-text="formErrors.department" class="mt-1 text-xs text-red-600"></p>
                    </div>
                </div>
                
                <!-- Modern Modal Footer -->
                <div class="flex justify-end space-x-3 mt-4 pt-3 border-t border-gray-200">
                    <button type="button" 
                            @click="createModal = false; resetForm()"
                            class="px-3 py-1.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200 font-medium text-sm">
                        Cancel
                    </button>
                    <button type="submit" 
                            class="animated-button px-4 py-1.5 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 text-sm" 
                            style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                        <svg class="w-3 h-3 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Create
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div x-show="deleteModal" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[60] overflow-y-auto" 
     style="display: none;"
     @keydown.escape="deleteModal = false"
     x-init="$watch('deleteModal', value => { document.body.classList.toggle('modal-open', value) })">
    
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="deleteModal = false"></div>
    
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div x-show="deleteModal"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="modal-container bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto border border-red-200 relative z-10">
            
            <div class="modal-header-gradient flex items-center justify-between p-4 border-b border-gray-200 rounded-t-2xl" style="background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);">
                <div class="flex items-center">
                    <div class="w-9 h-9 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Delete User</h3>
                        <p class="text-red-100 text-xs">This action cannot be undone</p>
                    </div>
                </div>
                <button @click="deleteModal = false" class="text-white hover:text-red-200 transition-colors duration-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <div class="p-4">
                <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-xl p-3 mb-4 border border-red-200">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-red-600 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        <div>
                            <p class="text-xs font-semibold text-red-800">Are you sure you want to delete this user?</p>
                            <p class="text-xs text-red-700 mt-0.5">
                                <span class="font-medium" x-text="deleteUserName"></span> will be permanently removed from the system.
                            </p>
                        </div>
                    </div>
                </div>
                
                <div class="flex justify-end space-x-3">
                    <button type="button" 
                            @click="deleteModal = false"
                            class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all duration-200 font-medium text-sm">
                        Cancel
                    </button>
                    <button type="button"
                            @click="
                                const form = document.createElement('form');
                                form.method = 'POST';
                                form.action = '/users/' + deleteUserId;
                                const csrfToken = document.createElement('input');
                                csrfToken.type = 'hidden';
                                csrfToken.name = '_token';
                                csrfToken.value = '{{ csrf_token() }}';
                                const methodField = document.createElement('input');
                                methodField.type = 'hidden';
                                methodField.name = '_method';
                                methodField.value = 'DELETE';
                                const pageField = document.createElement('input');
                                pageField.type = 'hidden';
                                pageField.name = 'page';
                                pageField.value = '{{ request("page", 1) }}';
                                form.appendChild(csrfToken);
                                form.appendChild(methodField);
                                form.appendChild(pageField);
                                document.body.appendChild(form);
                                form.submit();
                            "
                            class="animated-button px-5 py-2 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105 text-sm" 
                            style="background: linear-gradient(135deg, #DC2626 0%, #EF4444 100%);">
                        <svg class="w-3 h-3 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                        </svg>
                        Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- View User Modal -->
<div x-show="viewModal" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[60] overflow-y-auto" 
     @keydown.escape="viewModal = false"
     style="display: none;"
     x-init="$watch('viewModal', value => { document.body.classList.toggle('modal-open', value) })">
    
    <!-- Enhanced Backdrop with Blur -->
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="viewModal = false"></div>
    
    <!-- Modal Content -->
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div x-show="viewModal"
             x-transition:enter="transition ease-out duration-300 transform"
             x-transition:enter-start="opacity-0 scale-95 translate-y-4"
             x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform"
             x-transition:leave-start="opacity-100 scale-100 translate-y-0"
             x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="modal-container bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto relative z-10 border border-blue-200">
            
            <!-- Modern Modal Header with Gradient -->
            <div class="modal-header-gradient flex items-center justify-between p-4 border-b border-gray-200 rounded-t-2xl" style="background: linear-gradient(135deg, #1E40AF 0%, #3B82F6 100%);">
                <div class="flex items-center">
                    <div class="w-9 h-9 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">User Details</h3>
                        <p class="text-blue-100 text-xs">View user information</p>
                    </div>
                </div>
                <button @click="viewModal = false" class="text-white hover:text-blue-200 transition-colors duration-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            
            <!-- Modal Body -->
            <div class="p-4">
                <template x-if="selectedUser">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">User Name</label>
                            <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedUser?.name"></div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Email Address</label>
                            <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedUser?.email"></div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Department</label>
                            <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedUser?.department"></div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Role</label>
                            <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm capitalize" x-text="selectedUser?.role"></div>
                        </div>
                        
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Status</label>
                            <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedUser?.is_active ? 'Active' : 'Inactive'"></div>
                        </div>
                    </div>
                </template>
                
                <!-- Modern Modal Footer -->
                <div class="flex justify-end mt-4 pt-4 border-t border-gray-200">
                    <button type="button" 
                            @click="viewModal = false"
                            class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all duration-200 font-medium text-sm">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
