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

            @include('users.partials.table')

        </div>

        @include('users.partials.create-modal')

        @include('users.partials.edit-modal')

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
