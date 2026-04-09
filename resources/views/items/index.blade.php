<style>
    /* Modern styling */
    .modern-card { background: white; border: 1px solid #e5e7eb; border-radius: 16px; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.1), 0 1px 2px 0 rgba(0,0,0,0.06); transition: all 0.2s ease-in-out; }
    .modern-card:hover { box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); transform: translateY(-2px); }
    .modern-button { padding: 12px 24px; border-radius: 12px; font-weight: 600; transition: all 0.2s ease-in-out; }
    .modern-button:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    .modal-container { animation: modalSlideIn 0.3s ease-out; }
    @keyframes modalSlideIn { from { opacity: 0; transform: scale(0.95) translateY(20px); } to { opacity: 1; transform: scale(1) translateY(0); } }
    .modal-header-gradient { position: relative; overflow: hidden; }
    .modal-header-gradient::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%); pointer-events: none; }
    .modern-input { background: white; transition: all 0.2s ease-in-out; font-weight: 500; }
    .modern-input:focus { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .modern-input:hover:not(:focus) { box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    .animated-button { position: relative; overflow: hidden; }
    .animated-button::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition: left 0.5s; }
    .animated-button:hover::before { left: 100%; }
    .backdrop-blur-sm { backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); }
    @keyframes pulseRing { 0% { transform: scale(0.33); } 40%, 50% { opacity: 1; } 100% { opacity: 0; transform: scale(1.2); } }
    .pulse-ring { animation: pulseRing 1.25s cubic-bezier(0.215, 0.61, 0.355, 1) infinite; }
    .modal-container::-webkit-scrollbar { width: 6px; }
    .modal-container::-webkit-scrollbar-track { background: #f1f5f9; border-radius: 3px; }
    .modal-container::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 3px; }
    .modal-container::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
    body.modal-open { overflow: hidden; }
</style>

<div x-data="{ 
    createModal: false,
    viewModal: false,
    editModal: false,
    borrowModal: false,
    returnModal: false,
    searchModal: false, 
    deleteModal: false,
    selectedItem: null,
    deleteItemId: null,
    deleteItemName: ''
}">
<x-app-layout>
    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            
            <!-- Modern Page Header -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 sm:mb-8">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0" 
                         style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                        <svg class="w-5 h-5 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-4xl font-bold mb-1 text-amber-700">Inventory Items</h1>
                        <p class="text-gray-600 text-sm sm:text-lg font-medium hidden sm:block">Manage your hotel's inventory items and stock levels</p>
                        <div class="flex items-center mt-1 sm:mt-3 text-sm text-gray-500">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                            <span class="font-medium">{{ $items->total() }} Items</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-center space-x-2 sm:space-x-4">
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('items.borrowed') }}" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold" style="border: 1px solid #F97316; color: #EA580C;">
                            <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            <span class="hidden sm:inline">Borrowed Items</span>
                        </a>
                        <button @click="createModal = true" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold" style="border: 1px solid #D4AF37; color: #3D2914;">
                            <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span class="hidden sm:inline">Add New Item</span>
                        </button>
                    @else
                        <a href="{{ route('items.borrowed') }}" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold" style="border: 1px solid #F97316; color: #EA580C;">
                            <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path>
                            </svg>
                            <span class="hidden sm:inline">My Borrowed Items</span>
                        </a>
                    @endif
                </div>
            </div>

            @include('items.partials.filters')

            @include('items.partials.table')

        </div>

        @include('items.partials.create-modal')

        @include('items.partials.edit-modal')

    </div>

    @include('items.partials.scripts')

</x-app-layout>
</div>
