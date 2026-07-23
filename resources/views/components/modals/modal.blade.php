@props(['id', 'title'])

<div id="{{ $id }}" {{
    $attributes->merge(['class' => $attributes->has('x-data')
        ? 'fixed inset-0 z-50 flex items-center justify-center px-4 text-left'
        : 'hidden fixed inset-0 z-50 flex items-center justify-center px-4 text-left']) }}>
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" 
         x-on:click="typeof open !== 'undefined' && (open = false)">
    </div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">{{ $title }}</h2>
            <button 
                x-on:click="typeof open !== 'undefined' && (open = false)"
                class="text-gray-400 hover:text-gray-900 transition-colors text-xl font-light">
                ✕
            </button>
        </div>

        <!-- Body -->
        {{ $slot }}

    </div>
</div>
