@props(['type' => 'success', 'message'])

@php
    $classes = $type === 'success' 
        ? 'bg-green-50 text-green-700 border-green-200' 
        : 'bg-red-50 text-red-700 border-red-200';
    $icon = $type === 'success' ? 'check-circle' : 'alert-circle';
@endphp

<div x-data="{ show: true }" x-show="show" x-transition.opacity 
     class="flex items-center gap-3 p-4 mb-6 rounded-2xl border {{ $classes }}">
    <i data-lucide="{{ $icon }}" class="w-5 h-5 shrink-0"></i>
    <p class="text-sm font-medium flex-1">{{ $message }}</p>
    <button @click="show = false" type="button" class="p-1 rounded-lg hover:bg-black/5 opacity-50 hover:opacity-100 transition-all">
        <i data-lucide="x" class="w-4 h-4"></i>
    </button>
</div>
