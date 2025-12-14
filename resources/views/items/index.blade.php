<div x-data="{ 
    createModal: false,
    viewModal: false,
    editModal: false,
    borrowModal: false,
    searchModal: false, 
    deleteModal: false,
    selectedItem: null,
    deleteItemId: null,
    deleteItemName: ''
}">
<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-amber-700 to-yellow-500 bg-clip-text text-transparent">
                    Inventory Items
                </h2>
                <p class="text-gray-600 mt-1">Manage your hotel's inventory items and stock levels</p>
            </div>
            <div class="flex space-x-3">
                <button @click="createModal = true" class="inline-flex items-center px-6 py-3 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-200" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Add New Item
                </button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <!-- Search and Filter Buttons -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex space-x-3">
                    <button @click="searchModal = true" class="inline-flex items-center px-4 py-2 bg-white rounded-xl transition-all duration-200 shadow-sm" style="border: 1px solid #D4AF37; color: #3D2914;" onmouseover="this.style.backgroundColor='#F4E4BC'" onmouseout="this.style.backgroundColor='white'">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        Search Items
                    </button>
                    <a href="{{ route('items.index', ['filter' => 'low_stock']) }}" 
                        class="inline-flex items-center px-4 py-2 bg-amber-100 border border-amber-300 rounded-xl text-amber-700 hover:bg-amber-200 transition-all duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                        </svg>
                        Low Stock
                    </a>
                    <a href="{{ route('items.index') }}" 
                        class="inline-flex items-center px-4 py-2 bg-gray-100 border border-gray-300 rounded-xl text-gray-700 hover:bg-gray-200 transition-all duration-200 shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        All Items
                    </a>
                </div>
                @if(request('search'))
                    <div class="text-sm text-gray-600">
                        Showing results for: <span class="font-semibold" style="color: #D4AF37;">"{{ request('search') }}"</span>
                        <a href="{{ route('items.index') }}" class="ml-2" style="color: #D4AF37;" onmouseover="this.style.color='#3D2914'" onmouseout="this.style.color='#D4AF37'">Clear</a>
                    </div>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($items as $item)
                                <tr class="{{ $item->isLowStock() ? 'bg-yellow-50' : '' }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm font-medium text-gray-900">{{ $item->name }}</div>
                                        <div class="text-sm text-gray-500">{{ Str::limit($item->description, 50) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->category->name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">
                                            {{ $item->quantity }} {{ $item->unit }}
                                            @if($item->isLowStock())
                                                <span class="text-red-500 text-xs">(Low Stock)</span>
                                            @endif
                                        </div>
                                        <div class="text-xs text-gray-500">Min: {{ $item->minimum_stock }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full 
                                            @switch($item->status)
                                                @case('available') text-white @break
                                                @case('in_use') bg-blue-100 text-blue-800 @break
                                                @case('damaged') bg-red-100 text-red-800 @break
                                                @case('disposed') bg-gray-100 text-gray-800 @break
                                            @endswitch" 
                                            @if($item->status === 'available') style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);" @endif
                                            {{ ucfirst(str_replace('_', ' ', $item->status)) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $item->location ?? 'Not specified' }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                        <button @click="selectedItem = {{ $item->toJson() }}; viewModal = true" class="text-blue-600 hover:text-blue-900 mr-3">View</button>
                                        <button @click="selectedItem = {{ $item->toJson() }}; editModal = true" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</button>
                                        @if($item->quantity > 0 && $item->status === 'available')
                                            <button @click="selectedItem = {{ $item->toJson() }}; borrowModal = true" class="mr-3" style="color: #D4AF37;" onmouseover="this.style.color='#3D2914'" onmouseout="this.style.color='#D4AF37'">Borrow</button>
                                        @endif
                                        <button @click="deleteItemId = {{ $item->id }}; deleteItemName = '{{ $item->name }}'; deleteModal = true" 
                                                class="text-red-600 hover:text-red-900 font-medium">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">No items found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        {{ $items->links() }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Modal -->
        <div x-show="searchModal" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 z-[60] overflow-y-auto" 
             style="display: none;"
             @keydown.escape="searchModal = false"
             x-init="$watch('searchModal', value => { document.body.classList.toggle('modal-open', value) })"
            
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black bg-opacity-50" @click="searchModal = false"></div>
            
            <!-- Modal Content -->
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div x-show="searchModal"
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Search Items</h3>
                                <p class="text-sm text-gray-600">Find items by name, description, or category</p>
                            </div>
                        </div>
                        <button @click="searchModal = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <form method="GET" action="{{ route('items.index') }}" class="p-6">
                        <div class="space-y-4">
                            <div>
                                <label for="search" class="block text-sm font-medium text-gray-700 mb-2">Search Term</label>
                                <input type="text" 
                                       id="search" 
                                       name="search" 
                                       value="{{ request('search') }}"
                                       placeholder="Enter item name, description, or category..."
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                       autofocus>
                            </div>
                            
                            <div>
                                <label for="category" class="block text-sm font-medium text-gray-700 mb-2">Filter by Category (Optional)</label>
                                <select name="category" id="category" class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;">
                                    <option value="">All Categories</option>
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Filter by Status (Optional)</label>
                                <select name="status" id="status" class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;">
                                    <option value="">All Statuses</option>
                                    <option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available</option>
                                    <option value="in_use" {{ request('status') == 'in_use' ? 'selected' : '' }}>In Use</option>
                                    <option value="damaged" {{ request('status') == 'damaged' ? 'selected' : '' }}>Damaged</option>
                                    <option value="disposed" {{ request('status') == 'disposed' ? 'selected' : '' }}>Disposed</option>
                                </select>
                            </div>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                            <button type="button" 
                                    @click="searchModal = false"
                                    class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-6 py-2 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                                Search Items
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
             class="fixed inset-0 z-[70] overflow-y-auto" 
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
                                <h3 class="text-lg font-bold text-gray-900">Delete Item</h3>
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
                                    <p class="text-sm font-semibold text-red-800">Are you sure you want to delete this item?</p>
                                    <p class="text-sm text-red-700 mt-1">
                                        <span class="font-medium" x-text="deleteItemName"></span> will be permanently removed from your inventory.
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
                            <form :action="'/items/' + deleteItemId" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" 
                                        class="px-6 py-3 bg-gradient-to-r from-red-500 to-pink-600 text-white font-semibold rounded-xl hover:from-red-600 hover:to-pink-700 transition-all duration-200 shadow-lg hover:shadow-xl">
                                    <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                    </svg>
                                    Delete Item
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Create Item Modal -->
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
             x-init="$watch('createModal', value => { document.body.classList.toggle('modal-open', value) })">>
            
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
                     class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-auto relative z-10" style="border: 1px solid #D4AF37;">
                    
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Create New Item</h3>
                                <p class="text-sm text-gray-600">Add a new item to your inventory</p>
                            </div>
                        </div>
                        <button @click="createModal = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <form action="{{ route('items.store') }}" method="POST" class="p-6">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="modal_item_name" class="block text-sm font-medium text-gray-700 mb-2">Item Name</label>
                                <input type="text" 
                                       id="modal_item_name" 
                                       name="name" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                       style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                       placeholder="Enter item name">
                            </div>
                            
                            <div>
                                <label for="modal_category_id" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select name="category_id" 
                                        id="modal_category_id" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                        style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;">
                                    <option value="">Select Category</option>
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="modal_description" class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                                <textarea id="modal_description" 
                                          name="description" 
                                          rows="2"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                          style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                          placeholder="Enter item description"></textarea>
                            </div>
                            
                            <div>
                                <label for="modal_quantity" class="block text-sm font-medium text-gray-700 mb-2">Initial Quantity</label>
                                <input type="number" 
                                       id="modal_quantity" 
                                       name="quantity" 
                                       min="0"
                                       value="0"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                       style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                       placeholder="0">
                            </div>
                            
                            <div>
                                <label for="modal_minimum_stock" class="block text-sm font-medium text-gray-700 mb-2">Minimum Stock</label>
                                <input type="number" 
                                       id="modal_minimum_stock" 
                                       name="minimum_stock" 
                                       min="0"
                                       value="0"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                       style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                       placeholder="0">
                            </div>
                            
                            <div>
                                <label for="modal_unit" class="block text-sm font-medium text-gray-700 mb-2">Unit</label>
                                <input type="text" 
                                       id="modal_unit" 
                                       name="unit" 
                                       value="pcs"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                       style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                       placeholder="e.g., pcs, kg, liters">
                            </div>
                            
                            <div>
                                <label for="modal_status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status" 
                                        id="modal_status" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                        style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;">
                                    <option value="available">Available</option>
                                    <option value="in_use">In Use</option>
                                    <option value="damaged">Damaged</option>
                                    <option value="disposed">Disposed</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="modal_location" class="block text-sm font-medium text-gray-700 mb-2">Location (Optional)</label>
                                <input type="text" 
                                       id="modal_location" 
                                       name="location" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                       style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                       placeholder="e.g., Storage Room A">
                            </div>
                            
                            <div>
                                <label for="modal_unit_price" class="block text-sm font-medium text-gray-700 mb-2">Unit Price (Optional)</label>
                                <input type="number" 
                                       id="modal_unit_price" 
                                       name="unit_price" 
                                       min="0"
                                       step="0.01"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                       style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                       placeholder="0.00">
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
                                Create Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- View Item Modal -->
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
                     class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-auto relative z-10" style="border: 1px solid #D4AF37;">
                    
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
                                <h3 class="text-lg font-semibold text-gray-900">Item Details</h3>
                                <p class="text-sm text-gray-600">View item information</p>
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
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4" x-show="selectedItem">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Item Name</label>
                                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900" x-text="selectedItem?.name"></div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900" x-text="selectedItem?.category?.name"></div>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900" x-text="selectedItem?.description || 'No description provided'"></div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900" x-text="selectedItem?.quantity + ' ' + selectedItem?.unit"></div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Stock</label>
                                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900" x-text="selectedItem?.minimum_stock"></div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900" x-text="selectedItem?.status?.replace('_', ' ')?.replace(/\b\w/g, l => l.toUpperCase())"></div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Location</label>
                                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900" x-text="selectedItem?.location || 'Not specified'"></div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Unit Price</label>
                                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900" x-text="selectedItem?.unit_price ? '$' + selectedItem?.unit_price : 'Not specified'"></div>
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
                     class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full mx-auto relative z-10" style="border: 1px solid #D4AF37;">
                    
                    <!-- Modal Header -->
                    <div class="flex items-center justify-between p-6 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center mr-3" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Edit Item</h3>
                                <p class="text-sm text-gray-600">Update item information</p>
                            </div>
                        </div>
                        <button @click="editModal = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <form :action="'/items/' + selectedItem?.id" method="POST" class="p-6" x-show="selectedItem">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label for="edit_item_name" class="block text-sm font-medium text-gray-700 mb-2">Item Name</label>
                                <input type="text" 
                                       id="edit_item_name" 
                                       name="name" 
                                       required
                                       :value="selectedItem?.name"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                       style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                       placeholder="Enter item name">
                            </div>
                            
                            <div>
                                <label for="edit_category_id" class="block text-sm font-medium text-gray-700 mb-2">Category</label>
                                <select name="category_id" 
                                        id="edit_category_id" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                        style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;">
                                    <option value="">Select Category</option>
                                    @foreach(\App\Models\Category::all() as $category)
                                        <option :selected="selectedItem?.category_id == {{ $category->id }}" value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label for="edit_item_description" class="block text-sm font-medium text-gray-700 mb-2">Description (Optional)</label>
                                <textarea id="edit_item_description" 
                                          name="description" 
                                          rows="2"
                                          :value="selectedItem?.description"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                          style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                          placeholder="Enter item description"></textarea>
                            </div>
                            
                            <div>
                                <label for="edit_quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity</label>
                                <input type="number" 
                                       id="edit_quantity" 
                                       name="quantity" 
                                       min="0"
                                       required
                                       :value="selectedItem?.quantity"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                       style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                       placeholder="0">
                            </div>
                            
                            <div>
                                <label for="edit_minimum_stock" class="block text-sm font-medium text-gray-700 mb-2">Minimum Stock</label>
                                <input type="number" 
                                       id="edit_minimum_stock" 
                                       name="minimum_stock" 
                                       min="0"
                                       required
                                       :value="selectedItem?.minimum_stock"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                       style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                       placeholder="0">
                            </div>
                            
                            <div>
                                <label for="edit_unit" class="block text-sm font-medium text-gray-700 mb-2">Unit</label>
                                <input type="text" 
                                       id="edit_unit" 
                                       name="unit" 
                                       required
                                       :value="selectedItem?.unit"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                       style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                       placeholder="e.g., pcs, kg, liters">
                            </div>
                            
                            <div>
                                <label for="edit_status" class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status" 
                                        id="edit_status" 
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                        style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;">
                                    <option :selected="selectedItem?.status == 'available'" value="available">Available</option>
                                    <option :selected="selectedItem?.status == 'in_use'" value="in_use">In Use</option>
                                    <option :selected="selectedItem?.status == 'damaged'" value="damaged">Damaged</option>
                                    <option :selected="selectedItem?.status == 'disposed'" value="disposed">Disposed</option>
                                </select>
                            </div>
                            
                            <div>
                                <label for="edit_location" class="block text-sm font-medium text-gray-700 mb-2">Location (Optional)</label>
                                <input type="text" 
                                       id="edit_location" 
                                       name="location" 
                                       :value="selectedItem?.location"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                       style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                       placeholder="e.g., Storage Room A">
                            </div>
                            
                            <div>
                                <label for="edit_unit_price" class="block text-sm font-medium text-gray-700 mb-2">Unit Price (Optional)</label>
                                <input type="number" 
                                       id="edit_unit_price" 
                                       name="unit_price" 
                                       min="0"
                                       step="0.01"
                                       :value="selectedItem?.unit_price"
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                       style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                       placeholder="0.00">
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
                                Update Item
                            </button>
                        </div>
                    </form>
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
            
            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black bg-opacity-50" @click="borrowModal = false"></div>
            
            <!-- Modal Content -->
            <div class="flex items-center justify-center min-h-screen px-4 py-6">
                <div x-show="borrowModal"
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
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Borrow Item</h3>
                                <p class="text-sm text-gray-600">Record item borrowing transaction</p>
                            </div>
                        </div>
                        <button @click="borrowModal = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Modal Body -->
                    <form :action="'/items/' + selectedItem?.id + '/borrow'" method="POST" class="p-6" x-show="selectedItem">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Item</label>
                                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900" x-text="selectedItem?.name"></div>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Available Quantity</label>
                                <div class="w-full px-4 py-3 bg-gray-50 border border-gray-300 rounded-xl text-gray-900" x-text="selectedItem?.quantity + ' ' + selectedItem?.unit"></div>
                            </div>
                            
                            <div>
                                <label for="borrow_quantity" class="block text-sm font-medium text-gray-700 mb-2">Quantity to Borrow</label>
                                <input type="number" 
                                       id="borrow_quantity" 
                                       name="quantity" 
                                       min="1"
                                       :max="selectedItem?.quantity"
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                       style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                       placeholder="Enter quantity">
                            </div>
                            
                            <div>
                                <label for="borrower_name" class="block text-sm font-medium text-gray-700 mb-2">Borrower Name</label>
                                <input type="text" 
                                       id="borrower_name" 
                                       name="borrower_name" 
                                       required
                                       class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                       style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                       placeholder="Enter borrower name">
                            </div>
                            
                            <div>
                                <label for="notes" class="block text-sm font-medium text-gray-700 mb-2">Notes (Optional)</label>
                                <textarea id="notes" 
                                          name="notes" 
                                          rows="2"
                                          class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-colors duration-200" 
                                          style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                                          placeholder="Enter any additional notes"></textarea>
                            </div>
                        </div>
                        
                        <!-- Modal Footer -->
                        <div class="flex justify-end space-x-3 mt-6 pt-4 border-t border-gray-200">
                            <button type="button" 
                                    @click="borrowModal = false"
                                    class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors duration-200">
                                Cancel
                            </button>
                            <button type="submit" 
                                    class="px-6 py-2 text-white font-semibold rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl" 
                                    style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                                </svg>
                                Borrow Item
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
</div>