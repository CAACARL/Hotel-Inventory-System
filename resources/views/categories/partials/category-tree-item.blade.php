<div x-data="{ 
        expanded: {{ $category->children->count() > 0 ? 'true' : 'false' }},
        showAddForm: false,
        newSubcategoryName: '',
        newSubcategoryDescription: ''
    }" 
     @toggle-all-categories.window="expanded = $event.detail.expanded"
     class="modern-card bg-white rounded-xl border border-gray-200 shadow-sm overflow-hidden category-item mb-3" 
     style="margin-left: {{ min($level * 1.25, 3) }}rem;">
    
    <!-- Category Header -->
    <div class="flex items-center justify-between p-3 sm:p-6 {{ $category->children->count() > 0 ? 'cursor-pointer hover:bg-gray-50' : '' }} transition-all duration-200"
         @if($category->children->count() > 0) @click="expanded = !expanded" @endif>

        <div class="flex items-center space-x-2 sm:space-x-5 min-w-0">
            <!-- Expand/collapse or dot indicator -->
            @if($category->children->count() > 0)
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-800 transition-all duration-300 ease-out" 
                         :class="{ 'rotate-180': !expanded, 'rotate-0': expanded }" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            @else
                <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-br from-gray-50 to-gray-100 border border-gray-200 flex items-center justify-center flex-shrink-0">
                    <div class="w-2 h-2 bg-gradient-to-br from-gray-400 to-gray-500 rounded-full"></div>
                </div>
            @endif
            
            <!-- Category Icon -->
            <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center shadow-sm flex-shrink-0" 
                 style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                <svg class="w-4 h-4 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                </svg>
            </div>
            
            <!-- Category Name & Info -->
            <div class="min-w-0">
                <h3 class="text-sm sm:text-lg font-bold text-gray-900 truncate">{{ $category->name }}</h3>
                <div class="flex flex-wrap items-center gap-2 sm:gap-4 text-xs sm:text-sm text-gray-500 mt-0.5">
                    <span class="font-medium">{{ $category->items_count }} {{ $category->items_count == 1 ? 'item' : 'items' }}</span>
                    <span class="inline-flex items-center">
                        <div class="w-1.5 h-1.5 rounded-full {{ $category->is_active ? 'bg-green-500' : 'bg-red-500' }} mr-1"></div>
                        <span class="{{ $category->is_active ? 'text-green-700' : 'text-red-700' }}">
                            {{ $category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </span>
                </div>
            </div>
        </div>
        
        <!-- Action Buttons — icon only on mobile, icon+text on desktop -->
        <div class="flex items-center space-x-1 sm:space-x-2 flex-shrink-0 ml-2">
            <button @click.stop="selectedCategory = {{ $category->toJson() }}; viewModal = true" 
                    class="inline-flex items-center p-1.5 sm:px-3 sm:py-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 text-sm font-medium rounded-lg transition-all duration-200"
                    title="View">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span class="hidden sm:inline ml-1">View</span>
            </button>
            
            <button @click.stop="selectedCategory = {{ $category->toJson() }}; editModal = true" 
                    class="inline-flex items-center p-1.5 sm:px-3 sm:py-2 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 text-sm font-medium rounded-lg transition-all duration-200"
                    title="Edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span class="hidden sm:inline ml-1">Edit</span>
            </button>
            
            <button @click.stop="showAddForm = !showAddForm; expanded = true; $nextTick(() => { if(showAddForm) $refs.subcategoryNameInput?.focus(); })" 
                    class="inline-flex items-center p-1.5 sm:px-3 sm:py-2 text-green-600 hover:text-green-800 hover:bg-green-50 text-sm font-medium rounded-lg transition-all duration-200"
                    title="Add subcategory">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span class="hidden sm:inline ml-1">Add Sub</span>
            </button>
            
            @if($category->items_count == 0 && $category->children->count() == 0)
                <button @click.stop="deleteCategoryId = {{ $category->id }}; deleteCategoryName = '{{ $category->name }}'; deleteModal = true" 
                        class="inline-flex items-center p-1.5 sm:px-3 sm:py-2 text-red-600 hover:text-red-800 hover:bg-red-50 text-sm font-medium rounded-lg transition-all duration-200"
                        title="Delete">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    <span class="hidden sm:inline ml-1">Delete</span>
                </button>
            @else
                <button disabled 
                        class="inline-flex items-center p-1.5 sm:px-3 sm:py-2 text-gray-400 cursor-not-allowed text-sm font-medium rounded-lg opacity-50"
                        title="Cannot delete: has items or subcategories">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                </button>
            @endif
        </div>
    </div>

    <!-- Inline Add Subcategory Form -->
    <div x-show="showAddForm" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-4"
         class="border-t border-gray-200 bg-gradient-to-r from-green-50 to-emerald-50 p-3 sm:p-6">
        
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-3 sm:space-y-4">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $category->id }}">
            
            <div class="flex items-center space-x-3 mb-3">
                <div class="w-7 h-7 rounded-xl bg-green-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-3 h-3 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-green-800">Adding subcategory to {{ $category->name }}</h4>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:gap-4">
                <input type="text" 
                       name="name" 
                       x-ref="subcategoryNameInput"
                       x-model="newSubcategoryName"
                       placeholder="Subcategory name" 
                       required
                       class="w-full px-3 py-2 border border-green-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                
                <textarea name="description" 
                          x-model="newSubcategoryDescription"
                          placeholder="Description (optional)" 
                          rows="2"
                          class="w-full px-3 py-2 border border-green-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"></textarea>
            </div>
            
            <div class="flex items-center justify-end space-x-2 sm:space-x-3">
                <button type="button" 
                        @click="showAddForm = false; newSubcategoryName = ''; newSubcategoryDescription = ''"
                        class="px-3 py-2 bg-gray-100 text-gray-700 text-sm font-medium rounded-xl hover:bg-gray-200 transition-colors duration-200">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-4 py-2 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-sm font-bold rounded-xl hover:from-green-600 hover:to-emerald-700 transition-all duration-200 shadow-lg">
                    Create
                </button>
            </div>
        </form>
    </div>
    
    <!-- Children Categories -->
    <div x-show="expanded || showAddForm" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 transform -translate-y-4"
         x-transition:enter-end="opacity-100 transform translate-y-0"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 transform translate-y-0"
         x-transition:leave-end="opacity-0 transform -translate-y-4"
         class="border-t border-gray-100 bg-gradient-to-br from-gray-50 to-slate-50 p-2 sm:p-4">
        
        <div class="space-y-2 sm:space-y-3">
            @foreach($category->children as $child)
                @include('categories.partials.category-tree-item', ['category' => $child, 'level' => $level + 1])
            @endforeach
        </div>
    </div>
</div>
