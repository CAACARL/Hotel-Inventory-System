<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Too Many Requests - {{ config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glass-effect {
            background: rgba(255, 255, 255, 0.25);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.18);
        }
        
        .hotel-gradient {
            background: linear-gradient(135deg, #3D2914 0%, #D4AF37 100%);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="max-w-md w-full mx-4">
        <div class="glass-effect rounded-2xl shadow-2xl p-8 text-center">
            <!-- Logo -->
            <div class="w-16 h-16 hotel-gradient rounded-xl flex items-center justify-center mx-auto mb-6 shadow-lg">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                </svg>
            </div>

            <!-- Error Message -->
            <h1 class="text-2xl font-bold text-white mb-4">Too Many Attempts</h1>
            <p class="text-white/80 mb-6 leading-relaxed">
                You've made too many login attempts. Please wait a moment before trying again.
            </p>

            <!-- Security Info -->
            <div class="bg-white/10 rounded-xl p-4 mb-6 border border-white/20">
                <div class="flex items-center justify-center mb-2">
                    <svg class="w-5 h-5 text-yellow-300 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                    <span class="text-sm font-semibold text-white">Security Protection</span>
                </div>
                <p class="text-xs text-white/70">
                    This limit helps protect against unauthorized access attempts.
                </p>
            </div>

            <!-- Countdown Timer -->
            <div class="mb-6">
                <p class="text-sm text-white/80 mb-2">You can try again in:</p>
                <div id="countdown" class="text-2xl font-bold text-yellow-300">60 seconds</div>
            </div>

            <!-- Actions -->
            <div class="space-y-3">
                <button onclick="window.location.reload()" 
                        class="w-full px-6 py-3 hotel-gradient text-white font-semibold rounded-xl hover:shadow-lg transition-all duration-200 disabled:opacity-50 disabled:cursor-not-allowed"
                        id="retryButton" disabled>
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Try Again
                </button>
                
                <a href="{{ route('password.request') }}" 
                   class="block w-full px-6 py-3 bg-white/20 text-white font-medium rounded-xl hover:bg-white/30 transition-all duration-200 border border-white/30">
                    Forgot Password?
                </a>
                
                <a href="{{ url('/') }}" 
                   class="block text-sm text-white/70 hover:text-white transition-colors duration-200">
                    ← Back to Home
                </a>
            </div>
        </div>

        <!-- Additional Info -->
        <div class="mt-6 text-center">
            <p class="text-white/60 text-xs">
                Rate limiting: 5 attempts per minute for login
            </p>
        </div>
    </div>

    <script>
        // Countdown timer
        let timeLeft = 60;
        const countdownElement = document.getElementById('countdown');
        const retryButton = document.getElementById('retryButton');
        
        const timer = setInterval(() => {
            timeLeft--;
            countdownElement.textContent = timeLeft + ' seconds';
            
            if (timeLeft <= 0) {
                clearInterval(timer);
                countdownElement.textContent = 'Ready!';
                retryButton.disabled = false;
                retryButton.classList.remove('disabled:opacity-50', 'disabled:cursor-not-allowed');
            }
        }, 1000);
        
        // Auto-refresh after countdown
        setTimeout(() => {
            retryButton.textContent = 'Redirecting...';
            window.location.href = '{{ route('login') }}';
        }, 61000);
    </script>
</body>
</html>