<x-app-layout>
    <!-- Modern Page Header -->
    <div class="mb-6 sm:mb-8">
        <div class="flex items-center space-x-3 sm:space-x-4">
            <div class="w-10 h-10 sm:w-14 sm:h-14 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0"
                 style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                <svg class="w-5 h-5 sm:w-8 sm:h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl sm:text-4xl font-bold text-amber-700">Profile Settings</h1>
                <p class="text-gray-600 mt-1 text-sm sm:text-base">Manage your account information and security</p>
            </div>
        </div>
    </div>

    <div class="space-y-4 sm:space-y-6">
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="p-4 sm:p-8">
                <div class="max-w-3xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="p-4 sm:p-8">
                <div class="max-w-3xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>

        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow duration-200">
            <div class="p-4 sm:p-8">
                <div class="max-w-3xl">
                    @include('profile.partials.two-factor-authentication-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
