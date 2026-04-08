<x-guest-layout>
    <!-- Session Status -->
    @if (session('success'))
        <div class="mb-6 p-4 rounded-xl text-white text-sm flex items-center" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%); border: 1px solid #D4AF37;">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 rounded-xl text-white text-sm flex items-center bg-red-600 border border-red-500">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
            </svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="text-center mb-6">
        <div class="w-16 h-16 mx-auto mb-4 rounded-xl flex items-center justify-center shadow-lg" style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
            </svg>
        </div>
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Two-Factor Authentication</h2>
        <p class="text-gray-600">We've sent a 6-digit code to your email address</p>
        <p class="text-sm text-gray-500 mt-1">{{ auth()->user()->email }}</p>
    </div>

    <form method="POST" action="{{ route('two-factor.verify') }}" class="space-y-6">
        @csrf

        <!-- Verification Code -->
        <div>
            <label for="code" class="block text-sm font-semibold text-gray-700 mb-2">
                <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path>
                </svg>
                Verification Code
            </label>
            <input id="code" 
                   type="text" 
                   name="code" 
                   value="{{ old('code') }}" 
                   required 
                   autofocus 
                   maxlength="6"
                   pattern="[0-9]{6}"
                   class="w-full px-4 py-3 border border-gray-300 rounded-xl transition-all duration-200 bg-white/50 backdrop-blur-sm text-center text-2xl font-mono tracking-widest" 
                   style="focus:ring-2; focus:ring-color: #D4AF37; focus:border-color: #D4AF37;"
                   placeholder="000000">
            @error('code')
                <p class="mt-2 text-sm text-red-600 flex items-center">
                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    {{ $message }}
                </p>
            @enderror
        </div>

        <!-- Verify Button -->
        <div>
            <button type="submit" 
                    class="w-full text-white font-semibold py-3 px-6 rounded-xl shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center justify-center" 
                    style="background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                Verify Code
            </button>
        </div>
    </form>

    <!-- Resend Code -->
    <div class="mt-6 text-center">
        <p class="text-sm text-gray-600 mb-3">Didn't receive the code?</p>
        <form method="POST" action="{{ route('two-factor.resend') }}" class="inline">
            @csrf
            <button type="submit" 
                    class="text-sm font-medium hover:underline transition-colors duration-200" 
                    style="color: #D4AF37;" 
                    onmouseover="this.style.color='#3D2914'" 
                    onmouseout="this.style.color='#D4AF37'">
                Resend Code
            </button>
        </form>
    </div>

    <!-- Logout Option -->
    <div class="mt-6 text-center">
        <form method="POST" action="{{ route('logout') }}" class="inline">
            @csrf
            <button type="submit" class="text-sm text-gray-500 hover:text-gray-700 transition-colors duration-200">
                Sign out instead
            </button>
        </form>
    </div>

    <script>
        // Auto-format code input
        document.getElementById('code').addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            if (value.length > 6) value = value.slice(0, 6);
            e.target.value = value;
        });

        // Auto-submit when 6 digits entered
        document.getElementById('code').addEventListener('input', function(e) {
            if (e.target.value.length === 6) {
                e.target.form.submit();
            }
        });
    </script>
</x-guest-layout>