@props(['id', 'title', 'onClose'])

<div id="{{ $id }}" class="hidden fixed inset-0 z-50 flex items-center justify-center px-4">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" data-close="{{ $onClose }}"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-lg p-8">

        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h2 class="text-xl font-bold text-gray-900">{{ $title }}</h2>
            <button data-close="{{ $onClose }}" class="text-gray-400 hover:text-gray-900 transition-colors text-xl font-light">✕</button>
        </div>

        <!-- Body -->
        {{ $slot }}

        <!-- Footer -->
        @isset($footer)
            <div class="flex gap-3 mt-6">
                {{ $footer }}
            </div>
        @endisset

    </div>
</div>
