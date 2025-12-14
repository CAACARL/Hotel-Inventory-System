<div x-data="{ 
    createModal: false,
    viewModal: false,
    editModal: false,
    deleteModal: false,
    selectedCategory: null,
    deleteCategoryId: null,
    deleteCategoryName: ''
}">
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-amber-700 to-yellow-500 bg-clip-text text-transparent">
                    Categories Management
                </h2>
                <p class="text-gray-600 mt-1">Organize your inventory items by categories</p>
            </div>
            <button @click="createModal = true" class="btn-primary inline-flex items-center px-6 py-3 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                Add New Category
            </button>
        </div>
    </x-slot>

    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="glass-effect rounded-2xl shadow-xl border border-white/20 overflow-hidden">
                <div class="p-6">
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Name</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Description</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Items Count</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Status</th>
                                    <th class="px-6 py-4 text-left text-sm font-semibold text-gray-900">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @forelse($categories as $category)
                                <tr class="table-row hover:bg-gradient-to-r hover:from-blue-50 hover:to-purple-50 transition-all duration-200">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 rounded-lg flex items-center justify-center mr-3" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                </svg>
                                            </div>
                                            <div class="text-sm font-semibold text-gray-900">{{ $category->name }}</div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm text-gray-700">{{ $category->description ?? 'No description provided' }}</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center">
                                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium text-white" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                                {{ $category->items_count }} items
                                            </span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $category->is_active ? 'text-white' : 'bg-red-100 text-red-800' }}" @if($category->is_active) style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);" @endif>
                                            <div class="w-2 h-2 {{ $category->is_active ? 'bg-white' : 'bg-red-500' }} rounded-full mr-2"></div>
                                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-2">
                                            <button @click="selectedCategory = {{ $category->toJson() }}; viewModal = true" class="inline-flex items-center px-3 py-1 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                                </svg>
                                                View
                                            </button>
                                            <button @click="selectedCategory = {{ $category->toJson() }}; editModal = true" class="inline-flex items-center px-3 py-1 bg-indigo-100 text-indigo-700 rounded-lg hover:bg-indigo-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                                </svg>
                                                Edit
                                            </button>
                                            @if($category->items_count == 0)
                                            <button @click="deleteCategoryId = {{ $category->id }}; deleteCategoryName = '{{ $category->name }}'; deleteModal = true" 
                                                    class="inline-flex items-center px-3 py-1 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors duration-200">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                </svg>
                                                Delete
                                            </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center">
                                        <div class="flex flex-col items-center">
                                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-medium text-gray-900 mb-2">No categories found</h3>
                                            <p class="text-gray-500 mb-4">Get started by creating your first category</p>
                                            <button @click="createModal = true" class="inline-flex items-center px-4 py-2 text-white font-medium rounded-lg transition-all duration-200" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                                </svg>
                                                Add Category
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $categories->links() }}
                    </div>
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
             x-init="$watch('deleteModal', value => { document.body.classList.toggle('modal-open', value) })"
            
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black bg-opacity-50" @click="deleteModal = false"></div>
            
            <!-- Modal Content -->
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div x-show="deleteModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto border border-red-200 relative z-10">
                    
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-red-500 to-pink-600 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-bold text-gray-900">Delete Category</h3>
                                <p class="text-sm text-gray-600">This action cannot be undone</p>
                            </div>
                        </div>
                        <button @click="deleteModal = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <div class="p-6">
                        <div class="bg-gradient-to-r from-red-50 to-pink-50 rounded-xl p-4 mb-6 border border-red-200">
                            <div class="flex items-center">
                                <svg class="w-8 h-8 text-red-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                </svg>
                                <div>
                                    <p class="text-sm font-semibold text-red-800">Are you sure you want to delete this category?</p>
                                    <p class="text-sm text-red-700 mt-1">
                                        <span class="font-medium" x-text="deleteCategoryName"></span> will be permanently removed.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="flex justify-end space-x-3">
                            <button type="button" 
                                    @click="deleteModal = false"
                                    class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-xl hover:bg-gray-200 transition-colors duration-200">
                                Cancel
                            </button>
                            <form :action="'/categories/' + deleteCategoryId" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-6 py-3 bg-gradient-to-r from-red-500 to-pink-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete Category
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Category Modal -->
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
            
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black bg-opacity-50" @click="createModal = false"></div>
            
            <!-- Modal Content -->
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div x-show="createModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto relative z-10" style="border: 1px solid #D4AF37;">
                    
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Create New Category</h3>
                                <p class="text-sm text-gray-600">Add a new category to organize your items</p>
                            </div>
                        </div>
                        <button @click="createModal = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <form action="{{ route('categories.store') }}" method="POST" class="p-6">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label for="modal_name" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                                <input type="text" 
                                       id="modal_name" 
                                       name="name" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                       style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                       placeholder="Enter category name">
                            </div>
                            
                            <div>
                                <label for="modal_description" class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                                <textarea id="modal_description" 
                                          name="description" 
                                          rows="3"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                          style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                          placeholder="Enter category description"></textarea>
                            </div>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                            <button type="button" 
                                    @click="createModal = false"
                                    class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-6 py-2 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl" 
                                    style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                                Create Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- View Category Modal -->
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
            
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black bg-opacity-50" @click="viewModal = false"></div>
            
            <!-- Modal Content -->
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div x-show="viewModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto relative z-10" style="border: 1px solid #D4AF37;">
                    
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Category Details</h3>
                                <p class="text-sm text-gray-600">View category information</p>
                            </div>
                        </div>
                        <button @click="viewModal = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <div class="p-6">
                        <div class="space-y-4" x-show="selectedCategory">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900" x-text="selectedCategory?.name"></div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900" x-text="selectedCategory?.description || 'No description provided'"></div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Items Count</label>
                                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900" x-text="selectedCategory?.items_count + ' items'"></div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900" x-text="selectedCategory?.is_active ? 'Active' : 'Inactive'"></div>
                            </div>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="flex justify-end mt-6 pt-4 border-t border-gray-200">
                            <button type="button" 
                                    @click="viewModal = false"
                                    class="px-6 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Category Modal -->
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
            
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black bg-opacity-50" @click="editModal = false"></div>
            
            <!-- Modal Content -->
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div x-show="editModal"
                     x-transition:enter="transition ease-out duration-300"
                     x-transition:enter-start="opacity-0 scale-95"
                     x-transition:enter-end="opacity-100 scale-100"
                     x-transition:leave="transition ease-in duration-200"
                     x-transition:leave-start="opacity-100 scale-100"
                     x-transition:leave-end="opacity-0 scale-95"
                     class="bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto relative z-10" style="border: 1px solid #D4AF37;">
                    
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Edit Category</h3>
                                <p class="text-sm text-gray-600">Update category information</p>
                            </div>
                        </div>
                        <button @click="editModal = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <form :action="'/categories/' + selectedCategory?.id" method="POST" class="p-6" x-show="selectedCategory">
                        @csrf
                        @method('PUT')
                        <div class="space-y-4">
                            <div>
                                <label for="edit_name" class="block text-sm font-medium text-gray-700 mb-2">Category Name</label>
                                <input type="text" 
                                       id="edit_name" 
                                       name="name" 
                                       required
                                       :value="selectedCategory?.name"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                       style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                       placeholder="Enter category name">
                            </div>
                            
                            <div>
                                <label for="edit_description" class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                                <textarea id="edit_description" 
                                          name="description" 
                                          rows="3"
                                          :value="selectedCategory?.description"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                          style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                          placeholder="Enter category description"></textarea>
                            </div>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                            <button type="button" 
                                    @click="editModal = false"
                                    class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-6 py-2 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl" 
                                    style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                                Update Category
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
</div>