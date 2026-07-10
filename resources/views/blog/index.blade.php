<x-layout title="Blog">

    <!-- Hero -->
    <div class="bg-white border-b border-gray-100 py-16 px-6">
        <div class="max-w-4xl mx-auto">
            <span class="inline-block bg-gray-900 text-white text-xs font-bold tracking-widest uppercase px-3 py-1 rounded mb-6">Latest Posts</span>
            <h1 class="text-5xl font-extrabold text-gray-900 tracking-tight leading-tight mb-4">
                Ideas worth<br>
                <span class="text-gray-400">reading.</span>
            </h1>
            <p class="text-gray-500 text-base">Thoughts on technology, design, and the world.</p>
        </div>
    </div>

    <div class="max-w-4xl mx-auto px-6 py-12">

        @if ($data->isEmpty())
            <!-- Empty -->
            <div class="text-center py-24">
                <div class="text-5xl mb-4">📭</div>
                <p class="text-gray-400 font-medium">No posts yet. Check back soon.</p>
            </div>
        @else
            <!-- Blog Cards -->
            <div class="space-y-4">
                @foreach ($data as $post)
                    <a href="{{ route('blog.show', $post->title) }}" class="block no-underline">
                        <article class="bg-white border border-gray-100 rounded-2xl p-7 hover:-translate-y-1 hover:shadow-xl transition-all duration-200 cursor-pointer">
                            <div class="flex items-center gap-2.5 mb-4">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-sm font-bold text-gray-500">
                                    {{ strtoupper(substr($post->title, 0, 1)) }}
                                </div>
                                <span class="text-xs text-gray-400 font-medium">{{ $post->created_at?->format('F j, Y') }}</span>
                            </div>
                            <h2 class="text-lg font-bold text-gray-900 tracking-tight leading-snug mb-2">
                                {{ $post->title }}
                            </h2>
                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-3">
                                {{ $post->content }}
                            </p>
                            <div class="mt-5 pt-4 border-t border-gray-50 flex justify-end">
                                <span class="text-xs font-semibold text-gray-900 flex items-center gap-1">
                                    Read article →
                                </span>
                            </div>
                        </article>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            @if ($data->lastPage() > 1)
                <div class="mt-12 flex items-center justify-between">
                    <a href="{{ $data->previousPageUrl() ?? '#' }}"
                        class="flex items-center gap-2 px-5 py-2.5 border-[1.5px] border-gray-200 rounded-lg bg-white text-sm font-semibold text-gray-900 hover:border-gray-400 {{ $data->onFirstPage() ? 'opacity-40 pointer-events-none' : '' }} transition-all">
                        ← Previous
                    </a>

                    <div class="flex gap-1.5 items-center">
                        @for ($p = 1; $p <= $data->lastPage(); $p++)
                            <a href="{{ $data->url($p) }}"
                                class="h-2 rounded-full transition-all duration-200 {{ $p === $data->currentPage() ? 'w-6 bg-gray-900' : 'w-2 bg-gray-300 hover:bg-gray-400' }}"></a>
                        @endfor
                    </div>

                    <a href="{{ $data->nextPageUrl() ?? '#' }}"
                        class="flex items-center gap-2 px-5 py-2.5 border-[1.5px] border-gray-200 rounded-lg bg-white text-sm font-semibold text-gray-900 hover:border-gray-400 {{ $data->hasMorePages() ? '' : 'opacity-40 pointer-events-none' }} transition-all">
                        Next →
                    </a>
                </div>

                <p class="text-center text-xs text-gray-400 mt-4">
                    {{ $data->currentPage() }} of {{ $data->lastPage() }} pages · {{ $data->total() }} posts
                </p>
            @endif
        @endif

    </div>

</x-layout>
