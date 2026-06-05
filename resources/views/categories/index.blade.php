<div x-data="{ 
    createModal: false,
    viewModal: false,
    editModal: false,
    deleteModal: false,
    searchModal: false,
    selectedCategory: null,
    deleteCategoryId: null,
    deleteCategoryName: '',
    parentCategories: [],
    globalExpanded: true,
    toggleAllCategories() {
        this.globalExpanded = !this.globalExpanded;
        // Dispatch event to all category items
        this.$dispatch('toggle-all-categories', { expanded: this.globalExpanded });
    }
}">
<style>
    html {
        overflow-y: scroll;
    }
    
    /* Hierarchical Tree Styling */
    .category-tree {
        position: relative;
    }
    
    .category-item {
        position: relative;
    }
    
    /* Connection lines for hierarchy */
    .category-item::before {
        content: '';
        position: absolute;
        left: -20px;
        top: 0;
        bottom: 50%;
        width: 20px;
        border-left: 2px solid #e5e7eb;
        border-bottom: 2px solid #e5e7eb;
        border-bottom-left-radius: 8px;
    }
    
    .category-item::after {
        content: '';
        position: absolute;
        left: -20px;
        top: 50%;
        bottom: -100%;
        width: 2px;
        background: linear-gradient(to bottom, #e5e7eb 0%, transparent 100%);
    }
    
    .category-item:last-child::after {
        display: none;
    }
    
    /* Depth-based styling */
    .depth-0 {
        margin-left: 0;
    }
    
    .depth-1 {
        margin-left: 2.5rem;
    }
    
    .depth-2 {
        margin-left: 5rem;
    }
    
    .depth-3 {
        margin-left: 7.5rem;
    }
    
    /* Modern card styling */
    .modern-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 12px;
        box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
        transition: all 0.2s ease;
    }
    
    .modern-card:hover {
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .modern-button {
        padding: 12px 24px;
        border-radius: 12px;
        font-weight: 600;
        transition: all 0.2s ease-in-out;
    }
    
    .modern-button:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* Animated Button with Shine Effect */
    .animated-button {
        position: relative;
        overflow: hidden;
    }
    
    .animated-button::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .animated-button:hover::before {
        left: 100%;
    }
</style>
<x-app-layout>
    <!-- Page Header integrated into main content -->
    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            
            <!-- Modern Page Header -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 sm:mb-8">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0" 
                         style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                        <svg class="w-5 h-5 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-4xl font-bold mb-1 text-amber-700">Categories Management</h1>
                        <p class="text-gray-600 text-sm sm:text-lg font-medium hidden sm:block">Organize your inventory items with hierarchical categories</p>
                        <div class="flex items-center mt-1 sm:mt-3 text-sm text-gray-500">
                            <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                            <span class="font-medium">{{ $categories->count() }} Categories</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    <button @click="toggleAllCategories()" 
                            class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold" 
                            style="border: 1px solid #6B7280; color: #374151;">
                        <span x-text="globalExpanded ? 'Collapse All' : 'Expand All'"></span>
                    </button>
                    <a href="{{ route('categories.archived') }}" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold" style="border: 1px solid #6B7280; color: #374151;">
                        <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12M10 12v4m4-4v4"></path>
                        </svg>
                        <span class="hidden sm:inline">Archived</span>
                    </a>
                    <button @click="createModal = true" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold" style="border: 1px solid #D4AF37; color: #3D2914;">
                        <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="hidden sm:inline">Add New Category</span>
                    </button>
                </div>
            </div>

            <!-- Search Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">
                <div class="flex flex-wrap gap-2">
                    <button @click="searchModal = true" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold" style="border: 1px solid #D4AF37; color: #3D2914;">
                        <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span class="hidden sm:inline">Search Categories</span>
                    </button>
                </div>
                @if(request('search'))
                    <div class="text-sm text-gray-600 sm:ml-auto">
                        Results for: <span class="font-semibold" style="color: #D4AF37;">"{{ request('search') }}"</span>
                        <a href="{{ route('categories.index') }}" class="ml-2" style="color: #D4AF37;">Clear</a>
                    </div>
                @endif
            </div>

            <!-- Recursive Categories Tree Layout -->
            <div class="space-y-4 category-tree">
                @forelse($categories as $category)
                    @include('categories.partials.category-tree-item', ['category' => $category, 'level' => 0])
                @empty
                <!-- Modern Empty State -->
                <div class="text-center py-20 bg-gradient-to-br from-gray-50 to-slate-100 rounded-2xl border-2 border-dashed border-gray-300 modern-card">
                    <div class="w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">No categories found</h3>
                    <p class="text-gray-600 mb-8 text-lg max-w-md mx-auto">Create your first category to start organizing your inventory items.</p>
                    <button @click="createModal = true" class="modern-button inline-flex items-center px-8 py-4 text-white font-bold rounded-xl transition-all duration-200 shadow-lg" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                        <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Add Category
                    </button>
                </div>
                @endforelse
            </div>

            <!-- Pagination -->
            @if($categories->hasPages())
            <div class="mt-8 flex justify-center">
                {{ $categories->links() }}
            </div>
            @endif
        </div>

        <!-- Delete Confirmation Modal -->
        <div x-show="deleteModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[9999] overflow-y-auto" 
             style="display: none;"
             @keydown.escape="deleteModal = false"
             x-init="$watch('deleteModal', value => { document.body.classList.toggle('modal-open', value) })">
            
            <!-- Enhanced Backdrop with Blur -->
            <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="deleteModal = false"></div>
            
            <!-- Modal Content -->
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div x-show="deleteModal"
                     x-transition:enter="transition ease-out duration-300 transform"
                     x-transition:enter-start="opacity-0 scale-95 translate-y-4"
                     x-transition:enter-end="opacity-100 scale-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-200 transform"
                     x-transition:leave-start="opacity-100 scale-100 translate-y-0"
                     x-transition:leave-end="opacity-0 scale-95 translate-y-4"
                     class="modal-container bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto border border-gray-300 relative z-10">
                    
                    <!-- Modern Modal Header with Gradient -->
                    <div class="modal-header-gradient flex items-center justify-between p-4 border-b border-gray-200 rounded-t-2xl" style="background: linear-gradient(135deg, #374151 0%, #6B7280 100%);">
                        <div class="flex items-center">
                            <div class="w-9 h-9 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12M10 12v4m4-4v4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-white">Archive Category</h3>
                                <p class="text-gray-200 text-xs">Category will be hidden from the list</p>
                            </div>
                        </div>
                        <button @click="deleteModal = false" class="text-white hover:text-gray-200 transition-colors duration-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <div class="p-4">
                        <div class="bg-gray-50 rounded-xl p-3 mb-4 border border-gray-200">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12M10 12v4m4-4v4"></path>
                                </svg>
                                <div>
                                    <p class="text-xs font-semibold text-gray-800">Archive this category?</p>
                                    <p class="text-xs text-gray-600 mt-0.5">
                                        <span class="font-medium" x-text="deleteCategoryName"></span> will be moved to the archive. You can view it under Archived Categories.
                                    </p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Modern Modal Footer -->
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
                                        form.action = '/categories/' + deleteCategoryId;
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
                                    style="background: linear-gradient(135deg, #374151 0%, #6B7280 100%);">
                                <svg class="w-3 h-3 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12M10 12v4m4-4v4"></path>
                                </svg>
                                Archive
                            </button>
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
             class="fixed inset-0 z-[9999] overflow-y-auto" 
             @keydown.escape="createModal = false"
             style="display: none;"
             x-init="$watch('createModal', value => { 
                 document.body.classList.toggle('modal-open', value);
                 if (value) {
                     fetch('/api/categories/hierarchy')
                         .then(response => response.json())
                         .then(data => parentCategories = data)
                         .catch(error => console.error('Error loading categories:', error));
                 }
             })">
            
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-white">Create New Category</h3>
                                <p class="text-amber-100 text-xs">Add a new category to organize your items</p>
                            </div>
                        </div>
                        <button @click="createModal = false" class="text-white hover:text-amber-200 transition-colors duration-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Modal Body with Modern Form -->
                    <form action="{{ route('categories.store') }}" method="POST" class="p-4">
                        @csrf
                        <input type="hidden" name="page" value="{{ request('page', 1) }}">
                        <div class="space-y-3">
                            <div>
                                <label for="modal_name" class="block text-xs font-semibold text-gray-700 mb-1.5">Category Name</label>
                                <input type="text" 
                                       id="modal_name" 
                                       name="name" 
                                       required
                                       class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm" 
                                       placeholder="Enter category name">
                            </div>

                            <div>
                                <label for="modal_parent_id" class="block text-xs font-semibold text-gray-700 mb-1.5">Parent Category (Optional)</label>
                                <select id="modal_parent_id" 
                                        name="parent_id"
                                        class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm">
                                    <option value="">-- Root Category --</option>
                                    <template x-for="category in parentCategories" :key="category.id">
                                        <optgroup :label="category.name">
                                            <option :value="category.id" x-text="'└ ' + category.name"></option>
                                            <template x-for="child in category.children" :key="child.id">
                                                <option :value="child.id" x-text="'  └ ' + child.name"></option>
                                            </template>
                                        </optgroup>
                                    </template>
                                </select>
                            </div>
                            
                            <div>
                                <label for="modal_description" class="block text-xs font-semibold text-gray-700 mb-1.5">Description (Optional)</label>
                                <textarea id="modal_description" 
                                          name="description" 
                                          rows="3"
                                          class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 hover:border-gray-400 text-sm" 
                                          placeholder="Enter category description"></textarea>
                            </div>
                        </div>
                        
                        <!-- Modern Modal Footer -->
                        <div class="flex justify-end space-x-3 mt-4 pt-4 border-t border-gray-200">
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
                                Create
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
             class="fixed inset-0 z-[9999] overflow-y-auto" 
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
                                <h3 class="text-base font-bold text-white">Category Details</h3>
                                <p class="text-blue-100 text-xs">View category information</p>
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
                        <div class="space-y-3" x-show="selectedCategory">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Category Name</label>
                                <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedCategory?.name"></div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Full Path</label>
                                <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedCategory?.path || selectedCategory?.name"></div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Description</label>
                                <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedCategory?.description || 'No description provided'"></div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Items Count</label>
                                <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedCategory?.items_count + ' items'"></div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Status</label>
                                <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedCategory?.is_active ? 'Active' : 'Inactive'"></div>
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

        <!-- Edit Category Modal -->
        <div x-show="editModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[9999] overflow-y-auto" 
             @keydown.escape="editModal = false"
             style="display: none;"
             x-init="$watch('editModal', value => { 
                 document.body.classList.toggle('modal-open', value);
                 if (value) {
                     fetch('/api/categories/hierarchy')
                         .then(response => response.json())
                         .then(data => parentCategories = data)
                         .catch(error => console.error('Error loading categories:', error));
                 }
             })">
            
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
                                <h3 class="text-base font-bold text-white">Edit Category</h3>
                                <p class="text-indigo-100 text-xs">Update category information</p>
                            </div>
                        </div>
                        <button @click="editModal = false" class="text-white hover:text-indigo-200 transition-colors duration-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Modal Body with Modern Form -->
                    <form :action="'/categories/' + selectedCategory?.id" method="POST" class="p-4" x-show="selectedCategory">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="page" value="{{ request('page', 1) }}">
                        <div class="space-y-3">
                            <div>
                                <label for="edit_name" class="block text-xs font-semibold text-gray-700 mb-1.5">Category Name</label>
                                <input type="text" 
                                       id="edit_name" 
                                       name="name" 
                                       required
                                       :value="selectedCategory?.name"
                                       class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm" 
                                       placeholder="Enter category name">
                            </div>

                            <div>
                                <label for="edit_parent_id" class="block text-xs font-semibold text-gray-700 mb-1.5">Parent Category (Optional)</label>
                                <select id="edit_parent_id" 
                                        name="parent_id"
                                        class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm">
                                    <option value="">-- Root Category --</option>
                                    <template x-for="category in parentCategories" :key="category.id">
                                        <template x-if="category.id !== selectedCategory?.id">
                                            <optgroup :label="category.name">
                                                <option :value="category.id" 
                                                        :selected="category.id === selectedCategory?.parent_id"
                                                        x-text="'└ ' + category.name"></option>
                                                <template x-for="child in category.children" :key="child.id">
                                                    <template x-if="child.id !== selectedCategory?.id">
                                                        <option :value="child.id" 
                                                                :selected="child.id === selectedCategory?.parent_id"
                                                                x-text="'  └ ' + child.name"></option>
                                                    </template>
                                                </template>
                                            </optgroup>
                                        </template>
                                    </template>
                                </select>
                            </div>
                            
                            <div>
                                <label for="edit_description" class="block text-xs font-semibold text-gray-700 mb-1.5">Description (Optional)</label>
                                <textarea id="edit_description" 
                                          name="description" 
                                          rows="3"
                                          :value="selectedCategory?.description"
                                          class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl transition-all duration-200 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 hover:border-gray-400 text-sm" 
                                          placeholder="Enter category description"></textarea>
                            </div>
                        </div>
                        
                        <!-- Modern Modal Footer -->
                        <div class="flex justify-end space-x-3 mt-4 pt-4 border-t border-gray-200">
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

    </div>
</x-app-layout>

<!-- Search Modal -->
<div x-show="searchModal"
     x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
     class="fixed inset-0 z-[9999] overflow-y-auto" style="display: none;"
     @keydown.escape="searchModal = false"
     x-init="$watch('searchModal', value => { document.body.classList.toggle('modal-open', value) })">
    <div class="fixed inset-0 bg-black bg-opacity-50 backdrop-blur-sm" @click="searchModal = false"></div>
    <div class="flex items-center justify-center min-h-screen px-4 py-6">
        <div x-show="searchModal"
             x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="opacity-0 scale-95 translate-y-4" x-transition:enter-end="opacity-100 scale-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200 transform" x-transition:leave-start="opacity-100 scale-100 translate-y-0" x-transition:leave-end="opacity-0 scale-95 translate-y-4"
             class="modal-container bg-white rounded-2xl shadow-2xl max-w-md w-full mx-auto relative z-10 border border-amber-200">
            <div class="modal-header-gradient flex items-center justify-between p-4 border-b border-gray-200 rounded-t-2xl" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                <div class="flex items-center">
                    <div class="w-9 h-9 bg-white bg-opacity-20 rounded-xl flex items-center justify-center mr-3 backdrop-blur-sm">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-base font-bold text-white">Search Categories</h3>
                        <p class="text-amber-100 text-xs">Find categories by name</p>
                    </div>
                </div>
                <button @click="searchModal = false" class="text-white hover:text-amber-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <form method="GET" action="{{ route('categories.index') }}" class="p-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Category Name</label>
                    <input type="text" name="search" value="{{ request('search') }}" autofocus
                           placeholder="Search by category name..."
                           class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                </div>
                <div class="flex justify-end space-x-3 mt-4 pt-4 border-t border-gray-200">
                    <button type="button" @click="searchModal = false" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium text-sm">Cancel</button>
                    <button type="submit" class="animated-button px-6 py-2 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 text-sm" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                        <svg class="w-4 h-4 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        Search
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>