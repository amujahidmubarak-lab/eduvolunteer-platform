<div {{ $attributes->merge(['class' => 'bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden']) }}>
    @if(isset($header))
        <div class="p-6 sm:p-8 border-b border-gray-100 bg-gray-50/30">
            {{ $header }}
        </div>
    @endif
    
    <div class="p-6 sm:p-8">
        {{ $slot }}
    </div>

    @if(isset($footer))
        <div class="p-6 sm:p-8 border-t border-gray-100 bg-gray-50/50">
            {{ $footer }}
        </div>
    @endif
</div>
