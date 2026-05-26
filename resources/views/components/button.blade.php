@props(['type' => 'submit', 'color' => 'blue', 'icon' => null])

@php
    $colorClasses = [
        'blue' => 'bg-blue-600 hover:bg-blue-700 shadow-blue-500/25 text-white',
        'yellow' => 'bg-yellow-400 hover:bg-yellow-500 shadow-yellow-500/30 text-gray-900',
        'red' => 'bg-red-500 hover:bg-red-600 shadow-red-500/25 text-white',
        'white' => 'bg-white hover:bg-gray-50 border border-gray-200 text-gray-700 shadow-sm',
    ][$color] ?? 'bg-blue-600 hover:bg-blue-700 shadow-blue-500/25 text-white';
@endphp

<button type="{{ $type }}" 
        {{ $attributes->merge(['class' => "flex items-center justify-center gap-2 font-medium py-3.5 px-6 rounded-2xl shadow-lg transition-all hover:shadow-xl hover:-translate-y-0.5 disabled:opacity-70 disabled:cursor-not-allowed $colorClasses"]) }}>
    
    <!-- Loading Spinner (shown when Alpine's 'loading' is true) -->
    <template x-if="typeof loading !== 'undefined' && loading">
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    </template>

    <!-- Normal Icon -->
    <template x-if="typeof loading === 'undefined' || !loading">
        @if($icon)
            <i data-lucide="{{ $icon }}" class="w-4 h-4"></i>
        @endif
    </template>

    <span>{{ $slot }}</span>
</button>
