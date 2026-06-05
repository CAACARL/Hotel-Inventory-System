<style>
    /* Modern styling */
    .modern-card {
        background: white;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
        transition: all 0.2s ease-in-out;
    }
    .modern-card:hover {
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        transform: translateY(-2px);
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

    /* Enhanced Modal Styling */
    .modal-container {
        animation: modalSlideIn 0.3s ease-out;
    }
    
    @keyframes modalSlideIn {
        from {
            opacity: 0;
            transform: scale(0.95) translateY(20px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }
    
    .modal-header-gradient {
        position: relative;
        overflow: hidden;
    }
    
    .modal-header-gradient::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%);
        pointer-events: none;
    }
    
    /* Modern Input Styling */
    .modern-input {
        background: white;
        transition: all 0.2s ease-in-out;
        font-weight: 500;
    }
    
    .modern-input:focus {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .modern-input:hover:not(:focus) {
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
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
    
    /* Backdrop Blur Support */
    .backdrop-blur-sm {
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
    }
</style>

<div x-data="{ 
    createModal: false,
    viewModal: false,
    searchModal: false,
    selectedBatch: null
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-4xl font-bold mb-1 text-amber-700">Batch Management</h1>
                        <p class="text-gray-600 text-sm sm:text-lg font-medium hidden sm:block">Manage inventory replenishment, batches, expiry dates, and depreciation tracking</p>
                        <div class="flex flex-wrap items-center mt-1 sm:mt-3 gap-3 sm:gap-6 text-sm text-gray-500">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                <span class="font-medium">{{ $stats['active'] }} Active</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-yellow-500 rounded-full mr-2"></div>
                                <span class="font-medium">{{ $stats['expiring_soon'] }} Expiring</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-red-500 rounded-full mr-2"></div>
                                <span class="font-medium">{{ $stats['expired'] }} Expired</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    @if(auth()->user()->isAdmin())
                        <button @click="createModal = true" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold" style="border: 1px solid #D4AF37; color: #3D2914;">
                            <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            <span class="hidden sm:inline">Replenish Stock</span>
                        </button>
                    @endif
                </div>
            </div>

            <!-- Filter Buttons -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6 sm:mb-8">
                <div class="flex flex-wrap gap-2 sm:gap-4">
                    <button @click="searchModal = true" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold" style="border: 1px solid #D4AF37; color: #3D2914;">
                        <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span class="hidden sm:inline">Search Batches</span>
                    </button>
                </div>
                @if(request('search') || request('expiry_filter') || request('status'))
                    <div class="text-sm text-gray-600 sm:ml-auto">
                        @if(request('search'))
                            Results for: <span class="font-semibold" style="color: #D4AF37;">"{{ request('search') }}"</span>
                        @endif
                        <a href="{{ route('batches.index') }}" class="ml-2" style="color: #D4AF37;">Clear</a>
                    </div>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm rounded-xl border border-gray-200 relative">
                <!-- Decorative Background - Zigzag Lines Pattern -->
                <div class="absolute inset-0 opacity-[0.12] pointer-events-none overflow-hidden">
                    <!-- Zigzag lines -->
                    <svg class="absolute top-0 left-0 w-full h-full" viewBox="0 0 1000 1000" preserveAspectRatio="none">
                        <!-- Horizontal zigzag lines -->
                        <polyline points="0,80 50,60 100,80 150,60 200,80 250,60 300,80 350,60 400,80 450,60 500,80 550,60 600,80 650,60 700,80 750,60 800,80 850,60 900,80 950,60 1000,80" 
                                  stroke="#2563EB" stroke-width="3" fill="none" opacity="0.7"/>
                        <polyline points="0,160 50,140 100,160 150,140 200,160 250,140 300,160 350,140 400,160 450,140 500,160 550,140 600,160 650,140 700,160 750,140 800,160 850,140 900,160 950,140 1000,160" 
                                  stroke="#3B82F6" stroke-width="3" fill="none" opacity="0.65"/>
                        <polyline points="0,240 50,220 100,240 150,220 200,240 250,220 300,240 350,220 400,240 450,220 500,240 550,220 600,240 650,220 700,240 750,220 800,240 850,220 900,240 950,220 1000,240" 
                                  stroke="#60A5FA" stroke-width="3" fill="none" opacity="0.6"/>
                        <polyline points="0,320 50,300 100,320 150,300 200,320 250,300 300,320 350,300 400,320 450,300 500,320 550,300 600,320 650,300 700,320 750,300 800,320 850,300 900,320 950,300 1000,320" 
                                  stroke="#60A5FA" stroke-width="3" fill="none" opacity="0.55"/>
                        <polyline points="0,400 50,380 100,400 150,380 200,400 250,380 300,400 350,380 400,400 450,380 500,400 550,380 600,400 650,380 700,400 750,380 800,400 850,380 900,400 950,380 1000,400" 
                                  stroke="#93C5FD" stroke-width="3" fill="none" opacity="0.5"/>
                        <polyline points="0,480 50,460 100,480 150,460 200,480 250,460 300,480 350,460 400,480 450,460 500,480 550,460 600,480 650,460 700,480 750,460 800,480 850,460 900,480 950,460 1000,480" 
                                  stroke="#93C5FD" stroke-width="3" fill="none" opacity="0.45"/>
                        <polyline points="0,560 50,540 100,560 150,540 200,560 250,540 300,560 350,540 400,560 450,540 500,560 550,540 600,560 650,540 700,560 750,540 800,560 850,540 900,560 950,540 1000,560" 
                                  stroke="#BFDBFE" stroke-width="3" fill="none" opacity="0.4"/>
                        <polyline points="0,640 50,620 100,640 150,620 200,640 250,620 300,640 350,620 400,640 450,620 500,640 550,620 600,640 650,620 700,640 750,620 800,640 850,620 900,640 950,620 1000,640" 
                                  stroke="#BFDBFE" stroke-width="3" fill="none" opacity="0.35"/>
                        <polyline points="0,720 50,700 100,720 150,700 200,720 250,700 300,720 350,700 400,720 450,700 500,720 550,700 600,720 650,700 700,720 750,700 800,720 850,700 900,720 950,700 1000,720" 
                                  stroke="#DBEAFE" stroke-width="3" fill="none" opacity="0.3"/>
                        <polyline points="0,800 50,780 100,800 150,780 200,800 250,780 300,800 350,780 400,800 450,780 500,800 550,780 600,800 650,780 700,800 750,780 800,800 850,780 900,800 950,780 1000,800" 
                                  stroke="#DBEAFE" stroke-width="3" fill="none" opacity="0.25"/>
                        <polyline points="0,880 50,860 100,880 150,860 200,880 250,860 300,880 350,860 400,880 450,860 500,880 550,860 600,880 650,860 700,880 750,860 800,880 850,860 900,880 950,860 1000,880" 
                                  stroke="#EFF6FF" stroke-width="3" fill="none" opacity="0.2"/>
                    </svg>
                    
                    <!-- Diagonal zigzag accents -->
                    <svg class="absolute top-0 right-0 w-80 h-80 text-blue-400" viewBox="0 0 100 100">
                        <polyline points="0,15 10,5 20,15 30,5 40,15 50,5 60,15 70,5 80,15 90,5 100,15" 
                                  stroke="currentColor" stroke-width="2" fill="none" opacity="0.6"/>
                        <polyline points="0,30 10,20 20,30 30,20 40,30 50,20 60,30 70,20 80,30 90,20 100,30" 
                                  stroke="currentColor" stroke-width="2" fill="none" opacity="0.5"/>
                        <polyline points="0,45 10,35 20,45 30,35 40,45 50,35 60,45 70,35 80,45 90,35 100,45" 
                                  stroke="currentColor" stroke-width="2" fill="none" opacity="0.4"/>
                        <polyline points="0,60 10,50 20,60 30,50 40,60 50,50 60,60 70,50 80,60 90,50 100,60" 
                                  stroke="currentColor" stroke-width="2" fill="none" opacity="0.3"/>
                    </svg>
                    
                    <!-- Bottom left zigzag accent -->
                    <svg class="absolute bottom-0 left-0 w-64 h-64 text-blue-300" viewBox="0 0 100 100">
                        <polyline points="0,40 10,50 20,40 30,50 40,40 50,50 60,40 70,50 80,40 90,50 100,40" 
                                  stroke="currentColor" stroke-width="2" fill="none" opacity="0.5"/>
                        <polyline points="0,55 10,65 20,55 30,65 40,55 50,65 60,55 70,65 80,55 90,65 100,55" 
                                  stroke="currentColor" stroke-width="2" fill="none" opacity="0.4"/>
                        <polyline points="0,70 10,80 20,70 30,80 40,70 50,80 60,70 70,80 80,70 90,80 100,70" 
                                  stroke="currentColor" stroke-width="2" fill="none" opacity="0.3"/>
                    </svg>
                </div>
                
                <div class="p-3 sm:p-6 text-gray-900 relative z-10">

                    {{-- MOBILE CARD LAYOUT --}}
                    <div class="sm:hidden space-y-3">
                        @forelse($batches as $batch)
                        <div class="border rounded-xl p-4 {{ $batch->isExpired() ? 'border-red-300 bg-red-50' : ($batch->isExpiringSoon() ? 'border-yellow-300 bg-yellow-50' : 'border-gray-200 bg-white') }}">
                            <div class="flex items-start justify-between gap-2 mb-3">
                                <div class="flex items-start gap-2 min-w-0">
                                    @if($batch->item->image)
                                        <img src="{{ Storage::url($batch->item->image) }}" alt="{{ $batch->item->name }}"
                                             class="w-9 h-9 object-cover rounded-lg border border-gray-200 flex-shrink-0 cursor-pointer hover:opacity-80 transition-opacity mt-0.5"
                                             onclick="openLightbox('{{ Storage::url($batch->item->image) }}', '{{ addslashes($batch->item->name) }}')">
                                    @else
                                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <div class="font-bold text-gray-900 text-sm">{{ $batch->batch_number }}</div>
                                        <div class="text-xs text-gray-600 font-medium">{{ $batch->item->name }}</div>
                                        <div class="text-xs text-gray-400">{{ $batch->item->category->name }}</div>
                                    </div>
                                </div>
                                <span class="inline-flex px-2 py-0.5 text-xs font-bold rounded-full flex-shrink-0
                                    @switch($batch->status)
                                        @case('active') bg-green-100 text-green-800 @break
                                        @case('expired') bg-red-100 text-red-800 @break
                                        @default bg-gray-100 text-gray-800 @break
                                    @endswitch">
                                    {{ ucfirst($batch->status) }}
                                </span>
                            </div>
                            <div class="grid grid-cols-2 gap-2 text-xs text-gray-600 mb-3">
                                <div><span class="text-gray-400">Qty:</span> <span class="font-bold text-gray-900">{{ number_format($batch->quantity) }} {{ $batch->item->unit }}</span></div>
                                @if($batch->unit_cost)
                                <div><span class="text-gray-400">Cost:</span> <span class="font-bold">₱{{ number_format($batch->unit_cost, 2) }}</span></div>
                                @endif
                                @if($batch->supplier)
                                <div><span class="text-gray-400">Supplier:</span> <span>{{ $batch->supplier }}</span></div>
                                @endif
                                @if($batch->expiry_date)
                                <div>
                                    <span class="text-gray-400">Expiry:</span>
                                    <span class="{{ $batch->isExpired() ? 'text-red-600 font-bold' : ($batch->isExpiringSoon() ? 'text-yellow-600 font-bold' : '') }}">
                                        {{ $batch->expiry_date->format('M d, Y') }}
                                    </span>
                                </div>
                                @endif
                            </div>
                            <a href="{{ route('batches.show', $batch) }}"
                               class="inline-flex items-center px-3 py-1.5 text-blue-700 hover:bg-blue-50 text-xs font-medium rounded-lg transition-colors border border-blue-200">
                                <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                View
                            </a>
                        </div>
                        @empty
                        <div class="text-center py-12 text-gray-500">
                            <svg class="w-12 h-12 text-gray-400 mb-4 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No batches found</h3>
                            @if(auth()->user()->isAdmin())
                                <button @click="createModal = true" class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors mt-2">
                                    Replenish Stock
                                </button>
                            @endif
                        </div>
                        @endforelse
                    </div>

                    {{-- DESKTOP TABLE LAYOUT --}}
                    <div class="hidden sm:block overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gradient-to-r from-gray-50 to-gray-100">
                                <tr>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Batch Number</th>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Item</th>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Supplier</th>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Location</th>
                                    <th class="px-8 py-4 text-left text-xs font-bold text-gray-600 uppercase tracking-wider">Expiry Date</th>
                                    <th class="px-8 py-4 text-center text-xs font-bold text-gray-600 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-100">
                                @forelse($batches as $batch)
                                <tr class="hover:bg-gray-50 transition-colors duration-200 {{ $batch->isExpired() ? 'bg-red-50 border-l-4 border-red-400' : ($batch->isExpiringSoon() ? 'bg-yellow-50 border-l-4 border-yellow-400' : '') }}">
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="text-sm font-bold text-gray-900">{{ $batch->batch_number }}</div>
                                        @if($batch->lot_number)
                                            <div class="text-sm text-gray-500">Lot: {{ $batch->lot_number }}</div>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="flex items-center gap-3">
                                            @if($batch->item->image)
                                                <img src="{{ Storage::url($batch->item->image) }}" alt="{{ $batch->item->name }}"
                                                     class="w-10 h-10 object-cover rounded-lg border border-gray-200 flex-shrink-0 cursor-pointer hover:opacity-80 transition-opacity"
                                                     onclick="openLightbox('{{ Storage::url($batch->item->image) }}', '{{ addslashes($batch->item->name) }}')">
                                            @else
                                                <div class="w-10 h-10 rounded-lg flex items-center justify-center flex-shrink-0" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                                </div>
                                            @endif
                                            <div>
                                                <div class="flex items-center gap-2">
                                                    <span class="text-sm font-semibold text-gray-900">{{ $batch->item->name }}</span>
                                                    <span class="text-xs font-medium text-gray-500">({{ number_format($batch->quantity) }} {{ $batch->item->unit }})</span>
                                                </div>
                                                <div class="text-xs text-gray-500">{{ $batch->item->category->name }}</div>
                                                <div class="flex items-center gap-2 mt-0.5">
                                                    <span class="inline-flex px-2 py-0.5 text-xs font-medium rounded-md border
                                                        @switch($batch->status)
                                                            @case('active') bg-green-50 text-green-700 border-green-200 @break
                                                            @case('expired') bg-red-50 text-red-700 border-red-200 @break
                                                            @default bg-gray-50 text-gray-700 border-gray-200 @break
                                                        @endswitch">
                                                        {{ ucfirst($batch->status) }}
                                                    </span>
                                                    @if($batch->unit_cost)
                                                        <span class="text-xs text-gray-500">
                                                            Unit: ₱{{ number_format($batch->unit_cost, 2) }} • Total: ₱{{ number_format($batch->quantity * $batch->unit_cost, 2) }}
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $batch->supplier ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $batch->location ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap">
                                        @if($batch->expiry_date)
                                            <div class="text-sm font-medium {{ $batch->isExpired() ? 'text-red-600' : ($batch->isExpiringSoon() ? 'text-yellow-600' : 'text-gray-900') }}">
                                                {{ $batch->expiry_date->format('M d, Y') }}
                                            </div>
                                            @if($batch->isExpired())
                                                <div class="text-xs text-red-500">Expired {{ $batch->expiry_date->diffForHumans() }}</div>
                                            @elseif($batch->isExpiringSoon())
                                                <div class="text-xs text-yellow-600">Expires {{ $batch->expiry_date->diffForHumans() }}</div>
                                            @endif
                                        @else
                                            <div class="text-sm text-gray-500">No expiry</div>
                                        @endif
                                    </td>
                                    <td class="px-8 py-6 whitespace-nowrap text-center text-sm font-medium">
                                        <a href="{{ route('batches.show', $batch) }}"
                                           class="inline-flex items-center px-3 py-1.5 text-blue-700 hover:bg-blue-50 text-xs font-medium rounded-lg transition-colors border border-blue-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                            <span class="hidden sm:inline">View</span>
                                        </a>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="px-8 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <svg class="w-12 h-12 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                                            <h3 class="text-lg font-semibold text-gray-900 mb-2">No batches found</h3>
                                            <p class="text-gray-500 mb-4">Start by replenishing stock to create your first batch.</p>
                                            @if(auth()->user()->isAdmin())
                                                <button @click="createModal = true" class="inline-flex items-center px-4 py-2 bg-amber-600 text-white rounded-lg hover:bg-amber-700 transition-colors duration-200">
                                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                                                    Replenish Stock
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>{{-- end desktop table --}}

                    <div class="mt-4 sm:mt-6 px-0 sm:px-8 pb-4 sm:pb-8">
                        {{ $batches->links() }}
                    </div>
                </div>
            </div>

            @include('batches.partials.create-modal')
        </div>
    </div>

    <!-- Search Modal -->
    <div x-show="searchModal"
         x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-[60] overflow-y-auto" style="display: none;"
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
                            <h3 class="text-base font-bold text-white">Search Batches</h3>
                            <p class="text-amber-100 text-xs">Find by batch number, item name, or supplier</p>
                        </div>
                    </div>
                    <button @click="searchModal = false" class="text-white hover:text-amber-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form method="GET" action="{{ route('batches.index') }}" class="p-4">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Search Term</label>
                            <input type="text" name="search" value="{{ request('search') }}" autofocus
                                   placeholder="Batch number, item name, supplier..."
                                   class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Filter by Expiry</label>
                            <select name="expiry_filter" class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                <option value="">All Batches</option>
                                <option value="expiring_soon" {{ request('expiry_filter') === 'expiring_soon' ? 'selected' : '' }}>Expiring Soon</option>
                                <option value="expired" {{ request('expiry_filter') === 'expired' ? 'selected' : '' }}>Expired</option>
                                <option value="valid" {{ request('expiry_filter') === 'valid' ? 'selected' : '' }}>Valid</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Filter by Status</label>
                            <select name="status" class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                <option value="">All Statuses</option>
                                <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-4 pt-4 border-t border-gray-200">
                        <button type="button" @click="searchModal = false" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium text-sm">Cancel</button>
                        <button type="submit" class="animated-button px-6 py-2 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 text-sm" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                            <svg class="w-4 h-4 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Search Batches
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Hide depreciation section for consumable items
        document.addEventListener('DOMContentLoaded', function() {
            const itemSelect = document.getElementById('create_item_id');
            const depreciationSection = document.getElementById('depreciation-section');
            
            // Store item types data
            const itemTypes = {
                @foreach($items as $item)
                    {{ $item->id }}: '{{ $item->item_type }}',
                @endforeach
            };
            
            function toggleDepreciationSection() {
                const selectedItemId = itemSelect.value;
                const itemType = itemTypes[selectedItemId];
                
                if (depreciationSection) {
                    if (itemType === 'consumable') {
                        depreciationSection.style.display = 'none';
                    } else {
                        depreciationSection.style.display = 'block';
                    }
                }
            }
            
            // Initial check
            toggleDepreciationSection();
            
            // Listen for changes
            itemSelect.addEventListener('change', toggleDepreciationSection);
        });
    </script>
</x-app-layout>
</div>
