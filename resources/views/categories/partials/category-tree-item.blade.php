<div x-data="{ 
        expanded: {{ $category->children->count() > 0 ? 'true' : 'false' }},
        showAddForm: false,
        newSubcategoryName: '',
        newSubcategoryDescription: '',
        dropdownOpen: false
    }" 
     @toggle-all-categories.window="expanded = $event.detail.expanded"
     class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden category-item depth-{{ min($level, 3) }} mb-3 relative transition-shadow duration-200 hover:shadow-md" 
     style="margin-left: {{ min($level * 2.5, 7.5) }}rem;">
    
    <!-- Category Header -->
    <div class="flex items-center justify-between p-4 sm:p-5 {{ $category->children->count() > 0 ? 'cursor-pointer hover:bg-gray-50' : '' }} transition-colors duration-200 relative z-10"
         @if($category->children->count() > 0) @click="expanded = !expanded" @endif>

        <div class="flex items-center space-x-3 sm:space-x-4 min-w-0 flex-1">
            <!-- Expand/collapse or hierarchy indicator -->
            @if($category->children->count() > 0)
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg flex items-center justify-center flex-shrink-0 bg-gray-100 border border-gray-200">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-700 transition-transform duration-200" 
                         :class="{ 'rotate-180': !expanded, 'rotate-0': expanded }" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            @else
                <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-lg flex items-center justify-center flex-shrink-0 bg-gray-50 border border-gray-200">
                    <div class="w-2 h-2 bg-gray-400 rounded-full"></div>
                </div>
            @endif
            
            <!-- Category Icon with Level Badge -->
            <div class="relative flex-shrink-0">
                <div class="w-11 h-11 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center shadow-sm" 
                     style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                @if($level > 0)
                    <div class="absolute -bottom-0.5 -right-0.5 w-5 h-5 rounded-md flex items-center justify-center text-xs font-bold text-white shadow-sm"
                         style="background: linear-gradient(135deg, #D4AF37 0%, #3D2914 100%);">
                        {{ $level }}
                    </div>
                @endif
            </div>
            
            <!-- Category Name & Info -->
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-2 mb-1">
                    <h3 class="text-base sm:text-lg font-bold text-gray-900 truncate">{{ $category->name }}</h3>
                    @if($category->children->count() > 0)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-md text-xs font-medium bg-amber-50 text-amber-700 border border-amber-200">
                            {{ $category->children->count() }} sub
                        </span>
                    @endif
                </div>
                <div class="flex flex-wrap items-center gap-2 text-xs sm:text-sm text-gray-600">
                    <span class="inline-flex items-center">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        {{ $category->items_count }} {{ $category->items_count == 1 ? 'item' : 'items' }}
                    </span>
                    <span class="inline-flex items-center">
                        <div class="w-1.5 h-1.5 rounded-full {{ $category->is_active ? 'bg-green-500' : 'bg-red-500' }} mr-1.5"></div>
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    @if($category->parent)
                        <span class="inline-flex items-center text-gray-500">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                            {{ $category->parent->name }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Action Buttons - Show on Click -->
        <div class="flex items-center space-x-1 flex-shrink-0 ml-3" x-data="{ actionsOpen: false }">
            <!-- Actions Container - Hidden by default, shows on click -->
            <div x-show="actionsOpen" 
                 @click.away="actionsOpen = false"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 translate-x-2"
                 x-transition:enter-end="opacity-100 translate-x-0"
                 x-transition:leave="transition ease-in duration-150"
                 x-transition:leave-start="opacity-100 translate-x-0"
                 x-transition:leave-end="opacity-0 translate-x-2"
                 class="flex items-center space-x-1">
                <button @click.stop="selectedCategory = {{ $category->toJson() }}; viewModal = true; actionsOpen = false"
                        class="inline-flex items-center px-3 py-1.5 text-blue-700 hover:bg-blue-50 text-xs font-medium rounded-lg transition-colors border border-blue-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span class="hidden sm:inline">View</span>
                </button>

                <button @click.stop="selectedCategory = {{ $category->toJson() }}; editModal = true; actionsOpen = false"
                        class="inline-flex items-center px-3 py-1.5 text-indigo-700 hover:bg-indigo-50 text-xs font-medium rounded-lg transition-colors border border-indigo-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span class="hidden sm:inline">Edit</span>
                </button>

                <button @click.stop="showAddForm = !showAddForm; expanded = true; actionsOpen = false; $nextTick(() => { if(showAddForm) $refs.subcategoryNameInput?.focus(); })"
                        class="inline-flex items-center px-3 py-1.5 text-green-700 hover:bg-green-50 text-xs font-medium rounded-lg transition-colors border border-green-200">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    <span class="hidden sm:inline">Add Sub</span>
                </button>

                @if($category->items_count == 0 && $category->children->count() == 0)
                    <button @click.stop="deleteCategoryId = {{ $category->id }}; deleteCategoryName = '{{ $category->name }}'; deleteModal = true; actionsOpen = false"
                            class="inline-flex items-center px-3 py-1.5 text-gray-700 hover:bg-gray-100 text-xs font-medium rounded-lg transition-colors border border-gray-300">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12M10 12v4m4-4v4"></path>
                        </svg>
                        <span class="hidden sm:inline">Archive</span>
                    </button>
                @else
                    <button disabled
                            class="inline-flex items-center px-3 py-1.5 text-gray-400 cursor-not-allowed text-xs font-medium rounded-lg opacity-50 border border-gray-300"
                            title="Cannot archive: has items or subcategories">
                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12M10 12v4m4-4v4"></path>
                        </svg>
                        <span class="hidden sm:inline">Archive</span>
                    </button>
                @endif
            </div>
            
            <!-- Three-dot button -->
            <button @click.stop="actionsOpen = !actionsOpen" 
                    class="inline-flex items-center px-3 py-1.5 text-gray-700 hover:bg-gray-100 rounded-lg transition-all duration-200 text-xs font-medium border border-gray-300">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                </svg>
            </button>
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
         class="border-t border-gray-200 bg-gray-50 p-4 sm:p-5">
        
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-4">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $category->id }}">
            
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-9 h-9 rounded-lg bg-green-100 flex items-center justify-center flex-shrink-0">
                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-sm font-bold text-gray-900">Adding subcategory to {{ $category->name }}</h4>
                    <p class="text-xs text-gray-600">This will be a child category</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Subcategory Name</label>
                    <input type="text" 
                           name="name" 
                           x-ref="subcategoryNameInput"
                           x-model="newSubcategoryName"
                           placeholder="Enter name" 
                           required
                           class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Description (Optional)</label>
                    <textarea name="description" 
                              x-model="newSubcategoryDescription"
                              placeholder="Enter description" 
                              rows="1"
                              class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm"></textarea>
                </div>
            </div>
            
            <div class="flex items-center justify-end space-x-3 pt-2">
                <button type="button" 
                        @click="showAddForm = false; newSubcategoryName = ''; newSubcategoryDescription = ''"
                        class="px-4 py-2 bg-white text-gray-700 text-sm font-medium rounded-lg hover:bg-gray-100 transition-colors border border-gray-300">
                    Cancel
                </button>
                <button type="submit" 
                        class="px-5 py-2 bg-green-600 text-white text-sm font-semibold rounded-lg hover:bg-green-700 transition-colors">
                    Create Subcategory
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
         class="border-t border-gray-100 bg-gray-50/50 p-3 sm:p-4">
        
        <div class="space-y-3">
            @foreach($category->children as $child)
                @include('categories.partials.category-tree-item', ['category' => $child, 'level' => $level + 1])
            @endforeach
        </div>
    </div>
</div>
