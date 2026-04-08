<!-- Global Success Toast Notification -->
@if(session('success'))
<div x-data="{ show: true }" 
     x-show="show"
     x-init="setTimeout(() => show = false, 4000)"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-x-full"
     x-transition:enter-end="opacity-100 translate-x-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-x-0"
     x-transition:leave-end="opacity-0 translate-x-full"
     class="fixed top-4 right-4 z-[100] max-w-sm w-full pointer-events-auto">
    
    <div class="bg-white rounded-2xl shadow-2xl border border-green-200 overflow-hidden">
        <div class="p-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-green-500 to-emerald-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-900">Success!</h4>
                    <p class="text-sm text-gray-600">{{ session('success') }}</p>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 ml-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Progress bar -->
        <div class="bg-gray-200 h-1">
            <div class="bg-gradient-to-r from-green-500 to-emerald-600 h-1 animate-pulse" style="width: 100%; animation: shrink 4s linear;"></div>
        </div>
    </div>
</div>
@endif

<!-- Global Error Toast Notification -->
@if(session('error'))
<div x-data="{ show: true }" 
     x-show="show"
     x-init="setTimeout(() => show = false, 5000)"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-x-full"
     x-transition:enter-end="opacity-100 translate-x-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-x-0"
     x-transition:leave-end="opacity-0 translate-x-full"
     class="fixed top-4 right-4 z-[100] max-w-sm w-full pointer-events-auto">
    
    <div class="bg-white rounded-2xl shadow-2xl border border-red-200 overflow-hidden">
        <div class="p-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-red-500 to-pink-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-900">Error!</h4>
                    <p class="text-sm text-gray-600">{{ session('error') }}</p>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 ml-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Progress bar -->
        <div class="bg-gray-200 h-1">
            <div class="bg-gradient-to-r from-red-500 to-pink-600 h-1 animate-pulse" style="width: 100%; animation: shrink 5s linear;"></div>
        </div>
    </div>
</div>
@endif

<!-- Global Warning Toast Notification -->
@if(session('warning'))
<div x-data="{ show: true }" 
     x-show="show"
     x-init="setTimeout(() => show = false, 4500)"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0 translate-x-full"
     x-transition:enter-end="opacity-100 translate-x-0"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100 translate-x-0"
     x-transition:leave-end="opacity-0 translate-x-full"
     class="fixed top-4 right-4 z-[100] max-w-sm w-full pointer-events-auto">
    
    <div class="bg-white rounded-2xl shadow-2xl border border-orange-200 overflow-hidden">
        <div class="p-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-gradient-to-br from-orange-500 to-amber-600 rounded-full flex items-center justify-center mr-3 flex-shrink-0">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01M12 17h.01"></path>
                    </svg>
                </div>
                <div class="flex-1">
                    <h4 class="text-sm font-bold text-gray-900">Warning!</h4>
                    <p class="text-sm text-gray-600">{{ session('warning') }}</p>
                </div>
                <button @click="show = false" class="text-gray-400 hover:text-gray-600 transition-colors duration-200 ml-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
        </div>
        <!-- Progress bar -->
        <div class="bg-gray-200 h-1">
            <div class="bg-gradient-to-r from-orange-500 to-amber-600 h-1 animate-pulse" style="width: 100%; animation: shrink 4.5s linear;"></div>
        </div>
    </div>
</div>
@endif

<style>
    @keyframes shrink {
        from { width: 100%; }
        to { width: 0%; }
    }
    
    /* Page Loading Animation */
    .page-loader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, rgba(61, 41, 20, 0.95) 0%, rgba(212, 175, 55, 0.95) 100%);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        opacity: 0;
        visibility: hidden;
        transition: all 0.3s ease;
    }
    
    .page-loader.active {
        opacity: 1;
        visibility: visible;
    }
    
    .loader-content {
        text-align: center;
        color: white;
    }
    
    /* Box Stacking Animation */
    .box-stack-loader {
        width: 80px;
        height: 80px;
        position: relative;
        margin: 0 auto 20px;
    }
    
    .inventory-box {
        width: 22px;
        height: 16px;
        position: absolute;
        border: 2px solid white;
        border-radius: 2px;
        opacity: 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
    }
    
    /* Storage box handle */
    .inventory-box::before {
        content: '';
        position: absolute;
        top: -2px;
        left: 50%;
        transform: translateX(-50%);
        width: 8px;
        height: 2px;
        background: rgba(255, 255, 255, 0.9);
        border-radius: 1px;
        border: 1px solid rgba(255, 255, 255, 0.7);
    }
    
    /* X mark for storage */
    .inventory-box::after {
        content: '×';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: rgba(255, 255, 255, 0.8);
        font-size: 10px;
        font-weight: bold;
        line-height: 1;
    }
    
    .box-1 {
        bottom: 0;
        left: 29px;
        background: linear-gradient(145deg, #8B4513, #A0522D);
        animation: stackBox1 2s ease-in-out infinite;
    }
    
    .box-2 {
        bottom: 0;
        left: 29px;
        background: linear-gradient(145deg, #DC2626, #EF4444);
        animation: stackBox2 2s ease-in-out infinite;
        animation-delay: 0.3s;
    }
    
    .box-3 {
        bottom: 0;
        left: 29px;
        background: linear-gradient(145deg, #D4AF37, #F4E4BC);
        animation: stackBox3 2s ease-in-out infinite;
        animation-delay: 0.6s;
    }
    
    .box-4 {
        bottom: 0;
        left: 29px;
        background: linear-gradient(145deg, #2563EB, #3B82F6);
        animation: stackBox4 2s ease-in-out infinite;
        animation-delay: 0.9s;
    }
    
    @keyframes stackBox1 {
        0% { opacity: 0; transform: translateY(60px) scale(0.8); }
        20% { opacity: 1; transform: translateY(0px) scale(1); }
        80% { opacity: 1; transform: translateY(0px) scale(1); }
        100% { opacity: 0; transform: translateY(0px) scale(1); }
    }
    
    @keyframes stackBox2 {
        0% { opacity: 0; transform: translateY(60px) scale(0.8); }
        20% { opacity: 1; transform: translateY(-22px) scale(1); }
        80% { opacity: 1; transform: translateY(-22px) scale(1); }
        100% { opacity: 0; transform: translateY(-22px) scale(1); }
    }
    
    @keyframes stackBox3 {
        0% { opacity: 0; transform: translateY(60px) scale(0.8); }
        20% { opacity: 1; transform: translateY(-44px) scale(1); }
        80% { opacity: 1; transform: translateY(-44px) scale(1); }
        100% { opacity: 0; transform: translateY(-44px) scale(1); }
    }
    
    @keyframes stackBox4 {
        0% { opacity: 0; transform: translateY(60px) scale(0.8); }
        20% { opacity: 1; transform: translateY(-66px) scale(1); }
        80% { opacity: 1; transform: translateY(-66px) scale(1); }
        100% { opacity: 0; transform: translateY(-66px) scale(1); }
    }
    
    .loader-text {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 8px;
    }
    
    .loader-subtext {
        font-size: 14px;
        opacity: 0.8;
    }
    
    /* Inline Box Loading Animation for Buttons */
    .inline-box-loader {
        display: inline-block;
        width: 16px;
        height: 16px;
        position: relative;
        margin-right: 8px;
    }
    
    .inline-box {
        width: 5px;
        height: 4px;
        background: currentColor;
        position: absolute;
        border-radius: 1px;
        opacity: 0;
        border: 1px solid currentColor;
        box-shadow: 0 1px 1px rgba(0, 0, 0, 0.2);
    }
    
    /* Mini storage box handle */
    .inline-box::before {
        content: '';
        position: absolute;
        top: -1px;
        left: 50%;
        transform: translateX(-50%);
        width: 2px;
        height: 1px;
        background: currentColor;
        opacity: 0.8;
        border-radius: 0.5px;
    }
    
    /* Mini X mark for storage */
    .inline-box::after {
        content: '×';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        color: currentColor;
        font-size: 3px;
        font-weight: bold;
        line-height: 1;
        opacity: 0.7;
    }
    
    .inline-box-1 {
        bottom: 0;
        left: 6px;
        animation: inlineStack1 1.5s ease-in-out infinite;
    }
    
    .inline-box-2 {
        bottom: 0;
        left: 6px;
        animation: inlineStack2 1.5s ease-in-out infinite;
        animation-delay: 0.2s;
    }
    
    .inline-box-3 {
        bottom: 0;
        left: 6px;
        animation: inlineStack3 1.5s ease-in-out infinite;
        animation-delay: 0.4s;
    }
    
    @keyframes inlineStack1 {
        0% { opacity: 0; transform: translateY(12px) scale(0.8); }
        25% { opacity: 1; transform: translateY(0px) scale(1); }
        75% { opacity: 1; transform: translateY(0px) scale(1); }
        100% { opacity: 0; transform: translateY(0px) scale(1); }
    }
    
    @keyframes inlineStack2 {
        0% { opacity: 0; transform: translateY(12px) scale(0.8); }
        25% { opacity: 1; transform: translateY(-5px) scale(1); }
        75% { opacity: 1; transform: translateY(-5px) scale(1); }
        100% { opacity: 0; transform: translateY(-5px) scale(1); }
    }
    
    @keyframes inlineStack3 {
        0% { opacity: 0; transform: translateY(12px) scale(0.8); }
        25% { opacity: 1; transform: translateY(-10px) scale(1); }
        75% { opacity: 1; transform: translateY(-10px) scale(1); }
        100% { opacity: 0; transform: translateY(-10px) scale(1); }
    }
    
    /* Loading Progress Bar */
    .loading-progress {
        position: fixed;
        top: 0;
        left: 0;
        width: 0%;
        height: 3px;
        background: linear-gradient(90deg, #D4AF37, #F4E4BC);
        z-index: 10000;
        transition: width 0.3s ease;
    }
</style>
