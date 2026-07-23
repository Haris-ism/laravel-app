@props(['pagination'])
<!-- Pagination -->
@if ($pagination->lastPage() > 1)
    <div class="mt-12 flex items-center justify-between">
        <button type="button" wire:click="previousPage" @disabled($pagination->onFirstPage())
            class="flex items-center gap-2 px-5 py-2.5 border-[1.5px] border-gray-200 rounded-lg bg-white text-sm font-semibold text-gray-900 hover:border-gray-400 disabled:opacity-40 disabled:pointer-events-none transition-all">
            ← Previous
        </button>

        <div class="flex gap-1.5 items-center">
            @for ($p = 1; $p <= $pagination->lastPage(); $p++)
                <button type="button" wire:click="gotoPage({{ $p }})"
                    class="h-2 rounded-full transition-all duration-200 {{ $p === $pagination->currentPage() ? 'w-6 bg-gray-900' : 'w-2 bg-gray-300 hover:bg-gray-400' }}"></button>
            @endfor
        </div>

        <button type="button" wire:click="nextPage" @disabled(! $pagination->hasMorePages())
            class="flex items-center gap-2 px-5 py-2.5 border-[1.5px] border-gray-200 rounded-lg bg-white text-sm font-semibold text-gray-900 hover:border-gray-400 disabled:opacity-40 disabled:pointer-events-none transition-all">
            Next →
        </button>
    </div>

    <p class="text-center text-xs text-gray-400 mt-4">
        {{ $pagination->currentPage() }} of {{ $pagination->lastPage() }} pages · {{ $pagination->total() }} posts
    </p>
@endif
