<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center text-green-600 hover:text-green-700 font-semibold text-sm transition-all duration-200']) }}>
    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
    </svg>
    {{ $slot }}
</button>
