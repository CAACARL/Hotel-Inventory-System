<!-- Modern Department Tiles Layout with PERFECT Equal Heights -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    @forelse($departments as $department)
    <!-- Department Tile with FIXED Height for Perfect Alignment -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 hover:shadow-md transition-shadow duration-200 overflow-hidden h-80 flex flex-col relative">
        <!-- Decorative Background Pattern -->
        <div class="absolute inset-0 opacity-[0.15] pointer-events-none">
            <svg class="absolute top-32 right-8 w-32 h-32 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
            </svg>
        </div>
        
        <!-- Subtle Gradient Accent -->
        <div class="absolute top-0 right-0 w-40 h-40 bg-gradient-to-bl from-amber-100 to-transparent rounded-full -mr-20 -mt-20"></div>
        
        <!-- Department Header - Fixed Height -->
        <div class="flex items-center justify-between p-6 border-b border-gray-100 h-24 flex-shrink-0 relative z-10">
            <div class="flex items-center">
                <div class="w-12 h-12 rounded-lg flex items-center justify-center mr-4 shadow-sm border border-gray-200" 
                     style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-semibold text-gray-900 truncate max-w-32">{{ $department->name }}</h3>
                    <p class="text-xs text-gray-500">ID: {{ $department->id }}</p>
                </div>
            </div>
            
            <!-- Status Badge -->
            <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium border {{ $department->is_active ? 'bg-green-50 text-green-700 border-green-200' : 'bg-red-50 text-red-700 border-red-200' }}">
                <div class="w-1.5 h-1.5 {{ $department->is_active ? 'bg-green-500' : 'bg-red-500' }} rounded-full mr-1.5"></div>
                {{ $department->is_active ? 'Active' : 'Inactive' }}
            </span>
        </div>
        
        <!-- Department Content - Fixed Height with Scrollable Description -->
        <div class="flex-1 flex flex-col p-6 relative z-10">
            <!-- Description Section - Fixed Height with Overflow -->
            <div class="h-20 mb-4 overflow-hidden">
                <p class="text-gray-600 leading-relaxed text-sm line-clamp-3">{{ $department->description ?: 'No description available' }}</p>
            </div>
            
            <!-- Info Section - Fixed Position -->
            <div class="flex items-center space-x-4 mb-4 h-6">
                @if($department->location)
                <div class="flex items-center text-sm text-gray-500">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    <span class="truncate max-w-24">{{ $department->location }}</span>
                </div>
                @endif
                
                <div class="flex items-center text-sm text-gray-500">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    {{ $department->items_count }} items
                </div>
            </div>
            
            <!-- Actions Row - Fixed Position at Bottom -->
            <div class="flex items-center justify-end space-x-2 pt-2 border-t border-gray-100 h-12 mt-auto relative z-10">
                <button @click="selectedDepartment = {{ $department->toJson() }}; viewModal = true" 
                        class="inline-flex items-center px-3 py-2 text-blue-600 hover:bg-blue-50 rounded-lg transition-colors duration-150 text-sm font-medium"
                        title="View details">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    View
                </button>
                
                <button @click="selectedDepartment = {{ $department->toJson() }}; editModal = true" 
                        class="inline-flex items-center px-3 py-2 text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors duration-150 text-sm font-medium"
                        title="Edit department">
                    <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    Edit
                </button>
                
                @if($department->items_count == 0)
                    <form method="POST" action="{{ route('departments.toggle-active', $department) }}" class="flex items-center" style="display:contents">
                        @csrf
                        <input type="hidden" name="page" value="{{ request('page', 1) }}">
                        <button type="submit"
                                class="inline-flex items-center px-3 py-2 rounded-lg transition-colors duration-150 text-sm font-medium {{ $department->is_active ? 'text-yellow-600 hover:bg-yellow-50' : 'text-green-600 hover:bg-green-50' }}"
                                title="{{ $department->is_active ? 'Deactivate department' : 'Activate department' }}">
                            @if($department->is_active)
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                                Deactivate
                            @else
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Activate
                            @endif
                        </button>
                    </form>
                @else
                    <button disabled
                            class="inline-flex items-center px-3 py-2 text-gray-400 cursor-not-allowed rounded-lg text-sm font-medium"
                            title="Cannot change status: department has items">
                        <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path></svg>
                        {{ $department->is_active ? 'Deactivate' : 'Activate' }}
                    </button>
                @endif
            </div>
        </div>
    </div>
    @empty
    <!-- Empty State -->
    <div class="col-span-full text-center py-16 bg-white rounded-xl border border-gray-200 shadow-sm">
        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
            </svg>
        </div>
        <h3 class="text-lg font-semibold text-gray-900 mb-2">No departments found</h3>
        <p class="text-gray-500 mb-6 text-sm">Create your first hotel department to get started.</p>
        <button @click="createModal = true" class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-amber-900 to-yellow-600 text-white font-medium rounded-lg hover:from-amber-800 hover:to-yellow-500 transition-all duration-150 shadow-sm">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
            </svg>
            Add Department
        </button>
    </div>
    @endforelse
</div>

@if($departments->hasPages())
<div class="mt-8 flex justify-center">
    {{ $departments->links() }}
</div>
@endif

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
                        <h3 class="text-base font-bold text-white">Delete Department</h3>
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
                            <p class="text-xs font-semibold text-red-800">Are you sure you want to delete this department?</p>
                            <p class="text-xs text-red-700 mt-0.5">
                                <span class="font-medium" x-text="deleteDepartmentName"></span> will be permanently removed from the system.
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
                                form.action = '/departments/' + deleteDepartmentId;
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

<!-- View Department Modal -->
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
                        <h3 class="text-base font-bold text-white">Department Details</h3>
                        <p class="text-blue-100 text-xs">View department information</p>
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
                <div class="space-y-3" x-show="selectedDepartment">
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Department Name</label>
                        <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedDepartment?.name"></div>
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Description</label>
                        <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedDepartment?.description || 'No description provided'"></div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Location</label>
                        <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedDepartment?.location || 'Not specified'"></div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Items Count</label>
                        <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="(selectedDepartment?.items_count || 0) + ' items'"></div>
                    </div>
                    
                    <div>
                        <label class="block text-xs font-semibold text-gray-700 mb-1.5">Status</label>
                        <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedDepartment?.is_active ? 'Active' : 'Inactive'"></div>
                    </div>
                </div>
                
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
