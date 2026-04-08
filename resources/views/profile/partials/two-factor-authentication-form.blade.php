<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            {{ __('Two-Factor Authentication') }}
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            {{ __('Add additional security to your account using two-factor authentication.') }}
        </p>
    </header>

    <div class="mt-6 space-y-6">
        @if (auth()->user()->two_factor_enabled)
            <!-- 2FA Enabled -->
            <div class="flex items-center p-4 bg-green-50 border border-green-200 rounded-lg">
                <svg class="w-5 h-5 text-green-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <p class="text-sm font-medium text-green-800">Two-factor authentication is enabled</p>
                    <p class="text-sm text-green-700">Your account is protected with email-based verification codes.</p>
                </div>
            </div>

            <form method="post" action="{{ route('two-factor.disable') }}">
                @csrf
                <x-danger-button>
                    {{ __('Disable Two-Factor Authentication') }}
                </x-danger-button>
            </form>
        @else
            <!-- 2FA Disabled -->
            <div class="flex items-center p-4 bg-yellow-50 border border-yellow-200 rounded-lg">
                <svg class="w-5 h-5 text-yellow-600 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                </svg>
                <div>
                    <p class="text-sm font-medium text-yellow-800">Two-factor authentication is disabled</p>
                    <p class="text-sm text-yellow-700">Enable 2FA to add an extra layer of security to your account.</p>
                </div>
            </div>

            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-900 mb-2">How it works:</h3>
                <ul class="text-sm text-gray-600 space-y-1">
                    <li>• A 6-digit code will be sent to your email when you sign in from a new device</li>
                    <li>• Codes expire after 10 minutes for security</li>
                    <li>• Trusted devices won't require 2FA again</li>
                    <li>• You can manage your trusted devices below</li>
                </ul>
            </div>

            <form method="post" action="{{ route('two-factor.enable') }}">
                @csrf
                <button type="submit" class="inline-flex items-center text-green-600 hover:text-green-700 font-semibold text-sm transition-all duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path>
                    </svg>
                    {{ __('Enable Two-Factor Authentication') }}
                </button>
            </form>
        @endif
    </div>

    <!-- Trusted Devices Section -->
    @if (auth()->user()->two_factor_enabled && $trustedDevices->count() > 0)
        <div class="mt-8 pt-6 border-t border-gray-200">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Trusted Devices</h3>
            <p class="text-sm text-gray-600 mb-4">
                These devices won't require two-factor authentication when you sign in. Remove any devices you don't recognize.
            </p>
            
            <div class="space-y-3">
                @foreach ($trustedDevices as $device)
                    <div class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-lg">
                        <div class="flex items-center">
                            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                                @if (str_contains($device->device_name, 'Chrome'))
                                    <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0zm5.568 7.568l-3.778 6.568c-.456.793-1.309 1.28-2.234 1.28-.933 0-1.799-.513-2.234-1.28L5.544 7.568c-.456-.793-.456-1.767 0-2.56C6.001 4.215 6.854 3.728 7.778 3.728h8.444c.924 0 1.777.487 2.234 1.28.456.793.456 1.767 0 2.56z"/>
                                    </svg>
                                @elseif (str_contains($device->device_name, 'Firefox'))
                                    <svg class="w-5 h-5 text-orange-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0z"/>
                                    </svg>
                                @elseif (str_contains($device->device_name, 'Safari'))
                                    <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 0C5.373 0 0 5.373 0 12s5.373 12 12 12 12-5.373 12-12S18.627 0 12 0z"/>
                                    </svg>
                                @else
                                    <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $device->device_name }}</p>
                                <p class="text-xs text-gray-500">
                                    Last used {{ $device->last_used_at->diffForHumans() }}
                                    @if ($device->ip_address)
                                        from {{ $device->ip_address }}
                                    @endif
                                </p>
                            </div>
                        </div>
                        
                        <form method="post" action="{{ route('profile.remove-trusted-device', $device->id) }}" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" 
                                    class="text-red-600 hover:text-red-800 text-sm font-medium"
                                    onclick="return confirm('Are you sure you want to remove this trusted device? You will need to verify with 2FA the next time you sign in from this device.')">
                                Remove
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</section>