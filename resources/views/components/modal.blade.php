@props(['name', 'title' => 'Modal', 'icon' => 'box', 'iconColor' => 'blue'])

@php
    $bgColors = [
        'blue' => 'bg-blue-100 text-blue-600',
        'yellow' => 'bg-yellow-100 text-yellow-600',
        'red' => 'bg-red-100 text-red-600',
        'green' => 'bg-green-100 text-green-600',
    ][$iconColor] ?? 'bg-blue-100 text-blue-600';
@endphp

<div x-show="{{ $name }}" x-transition.opacity x-cloak class="fixed inset-0 bg-gray-900/60 backdrop-blur-sm z-50 flex items-center justify-center p-4 overflow-y-auto">
    <div @click.away="{{ $name }} = false" class="bg-white rounded-[2.5rem] shadow-2xl border border-gray-100 max-w-2xl w-full p-6 sm:p-8 my-8 relative">
        <button @click="{{ $name }} = false" class="absolute top-6 right-6 p-2 rounded-xl text-gray-400 hover:bg-gray-100 transition-colors">
            <i data-lucide="x" class="w-6 h-6"></i>
        </button>

        <div class="flex items-center gap-4 border-b border-gray-100 pb-4 mb-6">
            <div class="w-12 h-12 rounded-2xl flex items-center justify-center shrink-0 {{ $bgColors }}">
                <i data-lucide="{{ $icon }}" class="w-6 h-6"></i>
            </div>
            <div>
                <h3 class="font-poppins font-bold text-gray-900 text-xl">{{ $title }}</h3>
                @if(isset($subtitle))
                    <p class="text-xs text-gray-500">{{ $subtitle }}</p>
                @endif
            </div>
        </div>

        {{ $slot }}
    </div>
</div>
