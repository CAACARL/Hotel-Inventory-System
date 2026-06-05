<x-app-layout>
    <div x-data="{ 
        viewModal: false,
        selectedLog: null,
        openViewModal(log) {
            this.selectedLog = log;
            this.viewModal = true;
        }
    }">
    <style>
        .modern-card { background: white; border: 1px solid #e5e7eb; border-radius: 16px; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.1), 0 1px 2px 0 rgba(0,0,0,0.06); transition: all 0.2s ease-in-out; }
        .modern-card:hover { box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); transform: translateY(-2px); }
        .modern-button { padding: 12px 24px; border-radius: 12px; font-weight: 600; transition: all 0.2s ease-in-out; }
        .modern-button:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
        .animated-button { position: relative; overflow: hidden; }
        .animated-button::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition: left 0.5s; }
        .animated-button:hover::before { left: 100%; }
        .modal-header-gradient { position: relative; overflow: hidden; }
        .modal-header-gradient::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%); pointer-events: none; }
        body.modal-open { overflow: hidden; }
    </style>

    <div class="py-4 sm:py-8">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            
            <!-- Modern Page Header -->
            <div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-4 mb-6 sm:mb-8">
                <div class="flex items-center space-x-3 sm:space-x-4">
                    <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0" 
                         style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                        <svg class="w-5 h-5 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-4xl font-bold mb-1 text-amber-700">Activity Logs</h1>
                        <p class="text-gray-600 text-sm sm:text-lg font-medium hidden sm:block">Track all administrative actions and changes</p>
                        <div class="flex items-center mt-1 sm:mt-3 text-sm text-gray-500">
                            <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                            <span class="font-medium">{{ $logs->total() }} Activities</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Filters Section -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
                <form method="GET" action="{{ route('activity-logs.index') }}" class="space-y-4">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                        <!-- Search -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Search</label>
                            <input type="text" 
                                   name="search" 
                                   value="{{ request('search') }}"
                                   placeholder="Search by name..."
                                   class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm">
                        </div>

                        <!-- Action Filter -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Action</label>
                            <select name="action" class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm">
                                <option value="">All Actions</option>
                                <option value="created" {{ request('action') == 'created' ? 'selected' : '' }}>Created</option>
                                <option value="updated" {{ request('action') == 'updated' ? 'selected' : '' }}>Updated</option>
                                <option value="archived" {{ request('action') == 'archived' ? 'selected' : '' }}>Archived</option>
                                <option value="unarchived" {{ request('action') == 'unarchived' ? 'selected' : '' }}>Unarchived</option>
                                <option value="activated" {{ request('action') == 'activated' ? 'selected' : '' }}>Activated</option>
                                <option value="deactivated" {{ request('action') == 'deactivated' ? 'selected' : '' }}>Deactivated</option>
                            </select>
                        </div>

                        <!-- Model Type Filter -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Type</label>
                            <select name="model_type" class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm">
                                <option value="">All Types</option>
                                <option value="Item" {{ request('model_type') == 'Item' ? 'selected' : '' }}>Item</option>
                                <option value="Category" {{ request('model_type') == 'Category' ? 'selected' : '' }}>Category</option>
                                <option value="Department" {{ request('model_type') == 'Department' ? 'selected' : '' }}>Department</option>
                                <option value="User" {{ request('model_type') == 'User' ? 'selected' : '' }}>User</option>
                                <option value="Batch" {{ request('model_type') == 'Batch' ? 'selected' : '' }}>Batch</option>
                            </select>
                        </div>

                        <!-- User Filter -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">User</label>
                            <select name="user_id" class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm">
                                <option value="">All Users</option>
                                @foreach($users as $user)
                                    <option value="{{ $user->id }}" {{ request('user_id') == $user->id ? 'selected' : '' }}>
                                        {{ $user->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Date From -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Date From</label>
                            <input type="date" 
                                   name="date_from" 
                                   value="{{ request('date_from') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm">
                        </div>

                        <!-- Date To -->
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Date To</label>
                            <input type="date" 
                                   name="date_to" 
                                   value="{{ request('date_to') }}"
                                   class="w-full px-3 py-2 border border-gray-300 rounded-xl focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm">
                        </div>
                    </div>

                    <!-- Filter Buttons -->
                    <div class="flex flex-wrap gap-2">
                        <button type="submit" class="inline-flex items-center px-4 py-2 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold" style="border: 1px solid #D4AF37; color: #3D2914;">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path>
                            </svg>
                            Apply Filters
                        </button>
                        @if(request()->hasAny(['search', 'action', 'model_type', 'user_id', 'date_from', 'date_to']))
                            <a href="{{ route('activity-logs.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 rounded-xl transition-all duration-200 text-sm font-semibold text-gray-700">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Clear Filters
                            </a>
                        @endif
                    </div>
                </form>
            </div>

            @if($logs->isEmpty())
                <!-- Empty State -->
                <div class="text-center py-20 bg-gradient-to-br from-gray-50 to-slate-100 rounded-2xl border-2 border-dashed border-gray-300 modern-card">
                    <div class="w-20 h-20 bg-gradient-to-br from-gray-200 to-gray-300 rounded-full flex items-center justify-center mx-auto mb-6">
                        <svg class="w-10 h-10 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3">No activity logs found</h3>
                    <p class="text-gray-600 mb-8 text-lg max-w-md mx-auto">
                        @if(request()->hasAny(['search', 'action', 'model_type', 'user_id', 'date_from', 'date_to']))
                            No activities match your current filters. Try adjusting your search criteria.
                        @else
                            Activity logs will appear here as actions are performed.
                        @endif
                    </p>
                </div>
            @else
                <!-- Desktop Table View (hidden on mobile) -->
                <div class="hidden md:block bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">User</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Action</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Type</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($logs as $log)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <div class="w-8 h-8 rounded-lg flex items-center justify-center text-white text-xs font-bold mr-3"
                                                 style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                                {{ substr($log->user->name, 0, 2) }}
                                            </div>
                                            <div>
                                                <div class="text-sm font-medium text-gray-900">{{ $log->user->name }}</div>
                                                <div class="text-xs text-gray-500">{{ $log->user->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-bold border
                                            @if($log->action_color == 'green') bg-green-50 text-green-700 border-green-200
                                            @elseif($log->action_color == 'blue') bg-blue-50 text-blue-700 border-blue-200
                                            @elseif($log->action_color == 'yellow') bg-yellow-50 text-yellow-700 border-yellow-200
                                            @else bg-gray-50 text-gray-700 border-gray-200
                                            @endif">
                                            {{ ucfirst($log->action) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900">{{ $log->model_type }}</span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="text-sm text-gray-900">{{ $log->model_name ?? 'N/A' }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="text-sm text-gray-900">{{ $log->created_at->format('M d, Y') }}</div>
                                        <div class="text-xs text-gray-500">{{ $log->created_at->format('h:i A') }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm">
                                        <button @click="openViewModal({
                                            user_name: '{{ $log->user->name }}',
                                            user_email: '{{ $log->user->email }}',
                                            action: '{{ ucfirst($log->action) }}',
                                            action_color: '{{ $log->action_color }}',
                                            model_type: '{{ $log->model_type }}',
                                            model_name: '{{ $log->model_name ?? "N/A" }}',
                                            created_at: '{{ $log->created_at->format("F d, Y \a\\t h:i A") }}',
                                            old_values: {{ json_encode($log->old_values) }},
                                            new_values: {{ json_encode($log->new_values) }}
                                        })" 
                                           class="inline-flex items-center px-3 py-1.5 text-blue-700 hover:bg-blue-50 text-xs font-medium rounded-lg transition-colors border border-blue-200">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                            </svg>
                                            View
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Mobile Card View (visible on mobile only) -->
                <div class="md:hidden space-y-4">
                    @foreach($logs as $log)
                    <div class="modern-card p-4">
                        <!-- User Info -->
                        <div class="flex items-center mb-3 pb-3 border-b border-gray-200">
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white text-sm font-bold mr-3"
                                 style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                                {{ substr($log->user->name, 0, 2) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="text-sm font-bold text-gray-900 truncate">{{ $log->user->name }}</div>
                                <div class="text-xs text-gray-500 truncate">{{ $log->user->email }}</div>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded-md text-xs font-bold border ml-2
                                @if($log->action_color == 'green') bg-green-50 text-green-700 border-green-200
                                @elseif($log->action_color == 'blue') bg-blue-50 text-blue-700 border-blue-200
                                @elseif($log->action_color == 'yellow') bg-yellow-50 text-yellow-700 border-yellow-200
                                @else bg-gray-50 text-gray-700 border-gray-200
                                @endif">
                                {{ ucfirst($log->action) }}
                            </span>
                        </div>

                        <!-- Details Grid -->
                        <div class="space-y-2 mb-3">
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-semibold text-gray-600">Type:</span>
                                <span class="text-sm font-medium text-gray-900">{{ $log->model_type }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-semibold text-gray-600">Name:</span>
                                <span class="text-sm text-gray-900 truncate ml-2">{{ $log->model_name ?? 'N/A' }}</span>
                            </div>
                            <div class="flex justify-between items-center">
                                <span class="text-xs font-semibold text-gray-600">Date:</span>
                                <span class="text-sm text-gray-900">{{ $log->created_at->format('M d, Y h:i A') }}</span>
                            </div>
                        </div>

                        <!-- Action Button -->
                        <button @click="openViewModal({
                            user_name: '{{ $log->user->name }}',
                            user_email: '{{ $log->user->email }}',
                            action: '{{ ucfirst($log->action) }}',
                            action_color: '{{ $log->action_color }}',
                            model_type: '{{ $log->model_type }}',
                            model_name: '{{ $log->model_name ?? "N/A" }}',
                            created_at: '{{ $log->created_at->format("F d, Y \a\\t h:i A") }}',
                            old_values: {{ json_encode($log->old_values) }},
                            new_values: {{ json_encode($log->new_values) }}
                        })" 
                           class="block w-full text-center px-3 py-1.5 text-blue-700 hover:bg-blue-50 rounded-lg transition-colors font-medium border border-blue-200 text-xs">
                            <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                            View Details
                        </button>
                    </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($logs->hasPages())
                <div class="mt-6">
                    {{ $logs->links() }}
                </div>
                @endif
            @endif

        </div>

        <!-- View Details Modal -->
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
                                <h3 class="text-base font-bold text-white">Activity Details</h3>
                                <p class="text-blue-100 text-xs">View activity information</p>
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
                        <div class="space-y-3" x-show="selectedLog">
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Performed By</label>
                                <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedLog?.user_name + ' (' + selectedLog?.user_email + ')'"></div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Action</label>
                                <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedLog?.action"></div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Type</label>
                                <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedLog?.model_type"></div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Item Name</label>
                                <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedLog?.model_name"></div>
                            </div>
                            
                            <div>
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Date & Time</label>
                                <div class="w-full px-3 py-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedLog?.created_at"></div>
                            </div>

                            <!-- Changes Section - Only show changed fields -->
                            <div x-show="selectedLog?.action === 'Updated' && selectedLog?.old_values && selectedLog?.new_values">
                                <label class="block text-xs font-semibold text-gray-700 mb-1.5">Changes Made</label>
                                <div class="space-y-2">
                                    <template x-for="(newValue, key) in selectedLog?.new_values" :key="key">
                                        <template x-if="selectedLog?.old_values && selectedLog.old_values[key] !== newValue">
                                            <div>
                                                <div class="text-xs font-semibold text-gray-700 mb-1" x-text="key.replace(/_/g, ' ').replace(/\b\w/g, l => l.toUpperCase())"></div>
                                                <div class="grid grid-cols-2 gap-2">
                                                    <!-- Before -->
                                                    <div class="w-full px-3 py-2 bg-gradient-to-r from-red-50 to-red-50 border border-red-200 rounded-xl text-gray-900 font-medium text-sm" x-text="selectedLog.old_values[key] === null ? 'None' : (typeof selectedLog.old_values[key] === 'boolean' ? (selectedLog.old_values[key] ? 'Yes' : 'No') : selectedLog.old_values[key])"></div>
                                                    <!-- After -->
                                                    <div class="w-full px-3 py-2 bg-gradient-to-r from-green-50 to-green-50 border border-green-200 rounded-xl text-gray-900 font-medium text-sm" x-text="newValue === null ? 'None' : (typeof newValue === 'boolean' ? (newValue ? 'Yes' : 'No') : newValue)"></div>
                                                </div>
                                            </div>
                                        </template>
                                    </template>
                                </div>
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

    </div>
</x-app-layout>
