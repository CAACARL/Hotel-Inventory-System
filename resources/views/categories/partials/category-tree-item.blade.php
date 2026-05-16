<div x-data="{ 
        expanded: {{ $category->children->count() > 0 ? 'true' : 'false' }},
        showAddForm: false,
        newSubcategoryName: '',
        newSubcategoryDescription: ''
    }" 
     @toggle-all-categories.window="expanded = $event.detail.expanded"
     class="modern-card category-card-glow bg-white rounded-2xl border-2 shadow-lg overflow-hidden category-item depth-{{ min($level, 3) }} mb-4 relative" 
     style="margin-left: {{ min($level * 2.5, 7.5) }}rem; border-color: {{ $level === 0 ? '#D4AF37' : ($level === 1 ? '#F4E4BC' : '#e5e7eb') }};">
    
    <!-- Depth Indicator Bar -->
    <div class="depth-indicator"></div>
    
    <!-- Decorative Corner Gradient -->
    <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-amber-500/5 to-transparent rounded-full -mr-16 -mt-16 pointer-events-none"></div>
    
    <!-- Category Header -->
    <div class="flex items-center justify-between p-4 sm:p-6 {{ $category->children->count() > 0 ? 'cursor-pointer hover:bg-gradient-to-r hover:from-amber-50/50 hover:to-transparent' : '' }} transition-all duration-300 relative"
         @if($category->children->count() > 0) @click="expanded = !expanded" @endif>

        <div class="flex items-center space-x-3 sm:space-x-5 min-w-0 flex-1">
            <!-- Expand/collapse or hierarchy indicator -->
            @if($category->children->count() > 0)
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg transition-all duration-300"
                     style="background: linear-gradient(135deg, {{ $level === 0 ? '#3D2914 0%, #D4AF37 100%' : ($level === 1 ? '#D4AF37 0%, #F4E4BC 100%' : '#F4E4BC 0%, #D4AF37 100%') }});">
                    <svg class="w-5 h-5 sm:w-6 sm:h-6 text-white transition-all duration-300 ease-out" 
                         :class="{ 'rotate-180': !expanded, 'rotate-0': expanded }" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </div>
            @else
                <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center flex-shrink-0 shadow-md"
                     style="background: linear-gradient(135deg, {{ $level === 0 ? '#3D2914 0%, #D4AF37 100%' : ($level === 1 ? '#D4AF37 0%, #F4E4BC 100%' : '#F4E4BC 0%, #D4AF37 100%') }});">
                    <div class="w-2.5 h-2.5 bg-white rounded-full shadow-inner"></div>
                </div>
            @endif
            
            <!-- Category Icon with Level Badge -->
            <div class="relative flex-shrink-0">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center shadow-lg" 
                     style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                    <svg class="w-6 h-6 sm:w-7 sm:h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path>
                    </svg>
                </div>
                @if($level > 0)
                    <div class="absolute -bottom-1 -right-1 w-6 h-6 rounded-lg flex items-center justify-center text-xs font-bold text-white shadow-lg"
                         style="background: linear-gradient(135deg, #D4AF37 0%, #3D2914 100%);">
                        L{{ $level }}
                    </div>
                @endif
            </div>
            
            <!-- Category Name & Info -->
            <div class="min-w-0 flex-1">
                <div class="flex items-center gap-2 mb-1">
                    <h3 class="text-base sm:text-xl font-bold text-gray-900 truncate">{{ $category->name }}</h3>
                    @if($category->children->count() > 0)
                        <span class="inline-flex items-center px-2 py-0.5 rounded-lg text-xs font-semibold bg-gradient-to-r from-amber-100 to-yellow-100 text-amber-800 border border-amber-200">
                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                            </svg>
                            {{ $category->children->count() }} sub
                        </span>
                    @endif
                </div>
                <div class="flex flex-wrap items-center gap-2 sm:gap-3 text-xs sm:text-sm">
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg font-semibold bg-gradient-to-r from-blue-100 to-indigo-100 text-blue-800 border border-blue-200">
                        <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                        {{ $category->items_count }} {{ $category->items_count == 1 ? 'item' : 'items' }}
                    </span>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg font-semibold {{ $category->is_active ? 'bg-gradient-to-r from-green-100 to-emerald-100 text-green-800 border border-green-200' : 'bg-gradient-to-r from-red-100 to-pink-100 text-red-800 border border-red-200' }}">
                        <div class="w-2 h-2 rounded-full {{ $category->is_active ? 'bg-green-500' : 'bg-red-500' }} mr-1.5 animate-pulse"></div>
                        {{ $category->is_active ? 'Active' : 'Inactive' }}
                    </span>
                    @if($category->parent)
                        <span class="inline-flex items-center px-2.5 py-1 rounded-lg font-semibold bg-gradient-to-r from-purple-100 to-pink-100 text-purple-800 border border-purple-200">
                            <svg class="w-3.5 h-3.5 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path>
                            </svg>
                            Child of {{ $category->parent->name }}
                        </span>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="flex items-center space-x-1 sm:space-x-2 flex-shrink-0 ml-3">
            <button @click.stop="selectedCategory = {{ $category->toJson() }}; viewModal = true" 
                    class="inline-flex items-center p-2 sm:px-3 sm:py-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 text-sm font-medium rounded-xl transition-all duration-200 border border-transparent hover:border-blue-200 hover:shadow-md"
                    title="View">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                </svg>
                <span class="hidden sm:inline ml-1.5">View</span>
            </button>
            
            <button @click.stop="selectedCategory = {{ $category->toJson() }}; editModal = true" 
                    class="inline-flex items-center p-2 sm:px-3 sm:py-2 text-indigo-600 hover:text-indigo-800 hover:bg-indigo-50 text-sm font-medium rounded-xl transition-all duration-200 border border-transparent hover:border-indigo-200 hover:shadow-md"
                    title="Edit">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span class="hidden sm:inline ml-1.5">Edit</span>
            </button>
            
            <button @click.stop="showAddForm = !showAddForm; expanded = true; $nextTick(() => { if(showAddForm) $refs.subcategoryNameInput?.focus(); })" 
                    class="inline-flex items-center p-2 sm:px-3 sm:py-2 text-green-600 hover:text-green-800 hover:bg-green-50 text-sm font-medium rounded-xl transition-all duration-200 border border-transparent hover:border-green-200 hover:shadow-md"
                    title="Add subcategory">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                </svg>
                <span class="hidden sm:inline ml-1.5">Add Sub</span>
            </button>
            
            @if($category->items_count == 0 && $category->children->count() == 0)
                <button @click.stop="deleteCategoryId = {{ $category->id }}; deleteCategoryName = '{{ $category->name }}'; deleteModal = true" 
                        class="inline-flex items-center p-2 sm:px-3 sm:py-2 text-gray-600 hover:text-gray-800 hover:bg-gray-100 text-sm font-medium rounded-xl transition-all duration-200 border border-transparent hover:border-gray-300 hover:shadow-md"
                        title="Archive">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1 12a2 2 0 002 2h8a2 2 0 002-2l1-12M10 12v4m4-4v4"></path>
                    </svg>
                    <span class="hidden sm:inline ml-1.5">Archive</span>
                </button>
            @else
                <button disabled 
                        class="inline-flex items-center p-2 sm:px-3 sm:py-2 text-gray-400 cursor-not-allowed text-sm font-medium rounded-xl opacity-50 border border-gray-200"
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
         class="border-t-2 border-green-200 bg-gradient-to-br from-green-50 via-emerald-50 to-green-50 p-4 sm:p-6 relative overflow-hidden">
        
        <!-- Decorative elements -->
        <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-br from-green-500/10 to-transparent rounded-full -mr-16 -mt-16"></div>
        
        <form action="{{ route('categories.store') }}" method="POST" class="space-y-4 relative">
            @csrf
            <input type="hidden" name="parent_id" value="{{ $category->id }}">
            
            <div class="flex items-center space-x-3 mb-4">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center flex-shrink-0 shadow-lg">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
                <div>
                    <h4 class="text-base font-bold text-green-900">Adding subcategory to {{ $category->name }}</h4>
                    <p class="text-xs text-green-700">This will be a child category under the current one</p>
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
                           class="w-full px-3 py-2.5 border-2 border-green-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm bg-white shadow-sm">
                </div>
                
                <div>
                    <label class="block text-xs font-semibold text-gray-700 mb-1.5">Description (Optional)</label>
                    <textarea name="description" 
                              x-model="newSubcategoryDescription"
                              placeholder="Enter description" 
                              rows="1"
                              class="w-full px-3 py-2.5 border-2 border-green-300 rounded-xl focus:ring-2 focus:ring-green-500 focus:border-green-500 text-sm bg-white shadow-sm"></textarea>
                </div>
            </div>
            
            <div class="flex items-center justify-end space-x-3 pt-2">
                <button type="button" 
                        @click="showAddForm = false; newSubcategoryName = ''; newSubcategoryDescription = ''"
                        class="px-4 py-2.5 bg-white text-gray-700 text-sm font-semibold rounded-xl hover:bg-gray-100 transition-all duration-200 border-2 border-gray-200 shadow-sm">
                    Cancel
                </button>
                <button type="submit" 
                        class="animated-button px-6 py-2.5 bg-gradient-to-r from-green-500 to-emerald-600 text-white text-sm font-bold rounded-xl hover:from-green-600 hover:to-emerald-700 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:scale-105">
                    <svg class="w-4 h-4 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
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
         class="border-t-2 border-amber-100 bg-gradient-to-br from-amber-50/30 via-yellow-50/20 to-amber-50/30 p-3 sm:p-5">
        
        <div class="space-y-3 sm:space-y-4">
            @foreach($category->children as $child)
                @include('categories.partials.category-tree-item', ['category' => $child, 'level' => $level + 1])
            @endforeach
        </div>
    </div>
</div>
