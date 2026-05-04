<style>
    html { overflow-y: scroll; }
    .modern-card { background: white; border: 1px solid #e5e7eb; border-radius: 16px; box-shadow: 0 1px 3px 0 rgba(0,0,0,0.1), 0 1px 2px 0 rgba(0,0,0,0.06); transition: all 0.2s ease-in-out; }
    .modern-card:hover { box-shadow: 0 10px 15px -3px rgba(0,0,0,0.1), 0 4px 6px -2px rgba(0,0,0,0.05); transform: translateY(-2px); }
    .modern-button { padding: 12px 24px; border-radius: 12px; font-weight: 600; transition: all 0.2s ease-in-out; }
    .modern-button:hover { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }
    .animated-button { position: relative; overflow: hidden; }
    .animated-button::before { content: ''; position: absolute; top: 0; left: -100%; width: 100%; height: 100%; background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent); transition: left 0.5s; }
    .animated-button:hover::before { left: 100%; }
    .modal-container { animation: modalSlideIn 0.3s ease-out; }
    @keyframes modalSlideIn { from { opacity: 0; transform: scale(0.95) translateY(20px); } to { opacity: 1; transform: scale(1) translateY(0); } }
    .modal-header-gradient { position: relative; overflow: hidden; }
    .modal-header-gradient::before { content: ''; position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: linear-gradient(45deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0.05) 100%); pointer-events: none; }
    .modern-input { background: white; transition: all 0.2s ease-in-out; font-weight: 500; }
    .modern-input:focus { transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
    .modern-input:hover:not(:focus) { box-shadow: 0 2px 8px rgba(0,0,0,0.05); }
    .backdrop-blur-sm { backdrop-filter: blur(4px); -webkit-backdrop-filter: blur(4px); }
</style>

<div x-data="{ 
    createModal: false,
    viewModal: false,
    editModal: false,
    deleteModal: false,
    searchModal: false,
    selectedUser: null,
    deleteUserId: null,
    deleteUserName: '',
    formData: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        role: '',
        department: ''
    },
    formErrors: {
        name: '',
        email: '',
        password: '',
        password_confirmation: '',
        role: '',
        department: ''
    },
    validateForm() {
        this.formErrors = { name: '', email: '', password: '', password_confirmation: '', role: '', department: '' };
        let isValid = true;
        if (!this.formData.name || this.formData.name.trim().length < 2) { this.formErrors.name = 'Name must be at least 2 characters long'; isValid = false; }
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!this.formData.email || !emailRegex.test(this.formData.email)) { this.formErrors.email = 'Please enter a valid email address'; isValid = false; }
        if (!this.formData.password || this.formData.password.length < 8) { this.formErrors.password = 'Password must be at least 8 characters long'; isValid = false; }
        if (this.formData.password !== this.formData.password_confirmation) { this.formErrors.password_confirmation = 'Passwords do not match'; isValid = false; }
        if (!this.formData.role) { this.formErrors.role = 'Please select a role'; isValid = false; }
        if (!this.formData.department) { this.formErrors.department = 'Please select a department'; isValid = false; }
        return isValid;
    },
    resetForm() {
        this.formData = { name: '', email: '', password: '', password_confirmation: '', role: '', department: '' };
        this.formErrors = { name: '', email: '', password: '', password_confirmation: '', role: '', department: '' };
    }
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
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-2xl sm:text-4xl font-bold mb-1 text-amber-700">User Management</h1>
                        <p class="text-gray-600 text-sm sm:text-lg font-medium hidden sm:block">Manage system users and their permissions</p>
                        <div class="flex items-center gap-4 mt-1 sm:mt-3 text-sm text-gray-500">
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-green-500 rounded-full mr-2"></div>
                                <span class="font-medium">{{ $users->count() }} Users</span>
                            </div>
                            <div class="flex items-center">
                                <div class="w-2 h-2 bg-blue-500 rounded-full mr-2"></div>
                                <span class="font-medium">{{ $users->where('is_active', true)->count() }} Active</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex items-center">
                    <button @click="resetForm(); createModal = true" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold" style="border: 1px solid #D4AF37; color: #3D2914;">
                        <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        <span class="hidden sm:inline">Add New User</span>
                    </button>
                </div>
            </div>

            <!-- Search & Filter Bar -->
            <div class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6 sm:mb-8">
                <div class="flex flex-wrap gap-2">
                    <button @click="searchModal = true" class="inline-flex items-center px-3 sm:px-6 py-2 sm:py-3 bg-white rounded-xl transition-all duration-200 shadow-lg hover:shadow-xl text-sm font-semibold" style="border: 1px solid #D4AF37; color: #3D2914;">
                        <svg class="w-4 h-4 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span class="hidden sm:inline">Search Users</span>
                    </button>
                </div>
                @if(request('search') || request('role'))
                    <div class="text-sm text-gray-600 sm:ml-auto">
                        @if(request('search'))Results for: <span class="font-semibold" style="color: #D4AF37;">"{{ request('search') }}"</span>@endif
                        <a href="{{ route('users.index') }}" class="ml-2" style="color: #D4AF37;">Clear</a>
                    </div>
                @endif
            </div>

            @include('users.partials.table')

        </div>

        @include('users.partials.create-modal')

        @include('users.partials.edit-modal')

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
                            <h3 class="text-base font-bold text-white">Search Users</h3>
                            <p class="text-amber-100 text-xs">Find users by name, email, or department</p>
                        </div>
                    </div>
                    <button @click="searchModal = false" class="text-white hover:text-amber-200 p-1.5 hover:bg-white hover:bg-opacity-10 rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>
                <form method="GET" action="{{ route('users.index') }}" class="p-4">
                    <div class="space-y-3">
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Search Term</label>
                            <input type="text" name="search" value="{{ request('search') }}" autofocus
                                   placeholder="Name, email, or department..."
                                   class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-gray-700 mb-1.5">Filter by Role</label>
                            <select name="role" class="modern-input w-full px-3 py-2 border border-gray-300 rounded-xl text-sm focus:ring-2 focus:ring-amber-500 focus:border-amber-500">
                                <option value="">All Roles</option>
                                <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="staff" {{ request('role') === 'staff' ? 'selected' : '' }}>Staff</option>
                            </select>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-3 mt-4 pt-4 border-t border-gray-200">
                        <button type="button" @click="searchModal = false" class="px-4 py-2 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl font-medium text-sm">Cancel</button>
                        <button type="submit" class="animated-button px-6 py-2 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transform hover:scale-105 text-sm" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                            <svg class="w-4 h-4 mr-1.5 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                            Search Users
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Auto-open modal if there are validation errors -->
@if ($errors->any() && old('_token'))
<script>
document.addEventListener('DOMContentLoaded', function() {
    const createModal = document.querySelector('[x-data]').__x.$data.createModal;
    if (typeof createModal !== 'undefined') {
        document.querySelector('[x-data]').__x.$data.createModal = true;
    }
});
</script>
@endif
</div>
