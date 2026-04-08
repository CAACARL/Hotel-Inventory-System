<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Profile Information') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __("Update your account's profile information and email address.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="mt-6 space-y-6" enctype="multipart/form-data">
        @csrf
        @method('patch')

        <!-- Profile Picture Section -->
        <div>
            <x-input-label for="profile_picture" :value="__('Profile Picture')" />
            <div class="mt-2 flex items-center space-x-4">
                <!-- Current Profile Picture or Default Avatar -->
                <div class="w-16 h-16 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center">
                    @if($user->getProfilePictureUrl())
                        <img src="{{ $user->getProfilePictureUrl() }}" alt="Profile Picture" class="w-full h-full object-cover">
                    @else
                        @php $avatar = $user->getDefaultAvatar(); @endphp
                        <div class="w-full h-full {{ $avatar['color'] }} flex items-center justify-center text-white font-semibold">
                            {{ $avatar['initials'] }}
                        </div>
                    @endif
                </div>
                
                <!-- File Input -->
                <div class="flex-1">
                    <input type="file" 
                           id="profile_picture" 
                           name="profile_picture" 
                           accept="image/*"
                           class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100" />
                    <p class="mt-1 text-sm text-gray-600">JPG, PNG, GIF up to 2MB</p>
                </div>
            </div>
            <x-input-error class="mt-2" :messages="$errors->get('profile_picture')" />
        </div>

        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-gray-800">
                        {{ __('Your email address is unverified.') }}

                        <button form="send-verification" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Click here to re-send the verification email.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('A new verification link has been sent to your email address.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <!-- Password Confirmation (shown when email is changed) -->
        <div id="password-confirmation" style="display: none;">
            <x-input-label for="current_password" :value="__('Current Password')" />
            <x-text-input id="current_password" name="current_password" type="password" class="mt-1 block w-full" autocomplete="current-password" />
            <x-input-error class="mt-2" :messages="$errors->get('current_password')" />
            <p class="mt-1 text-sm text-gray-600">{{ __('Please confirm your password to change your email address.') }}</p>
        </div>

        <div class="flex items-center gap-4">
            <x-primary-button>{{ __('Save') }}</x-primary-button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const emailInput = document.getElementById('email');
            const passwordConfirmation = document.getElementById('password-confirmation');
            const originalEmail = '{{ $user->email }}';
            
            function togglePasswordField() {
                if (emailInput.value !== originalEmail) {
                    passwordConfirmation.style.display = 'block';
                    document.getElementById('current_password').required = true;
                } else {
                    passwordConfirmation.style.display = 'none';
                    document.getElementById('current_password').required = false;
                    document.getElementById('current_password').value = '';
                }
            }
            
            emailInput.addEventListener('input', togglePasswordField);
            emailInput.addEventListener('change', togglePasswordField);
            
            // Check on page load in case of validation errors
            togglePasswordField();
        });
    </script>
</section>
