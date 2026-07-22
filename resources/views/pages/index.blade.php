<x-layout title="Blog">
    <x-hero/>
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
                    <a href="{{ route('blog.blogDetailPage', $post->title) }}" class="block no-underline">
                        <article class="bg-white border border-gray-100 rounded-2xl p-7 hover:-translate-y-1 hover:shadow-xl transition-all duration-200 cursor-pointer">
                            <div class="flex items-center gap-2.5 mb-4">
                                <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-sm font-bold text-gray-500">
                                    {{ strtoupper(substr($post->author->name, 0, 1)) }}
                                </div>
                                <span class="text-xs text-gray-400 font-medium">{{ $post->author->name }} · {{ $post->created_at?->format('F j, Y') }}</span>
                            </div>
                            <h2 class="text-lg font-bold text-gray-900 tracking-tight leading-snug mb-2">
                                {{ $post->title }}
                            </h2>
                            <p class="text-gray-500 text-sm leading-relaxed line-clamp-3">
                                {{ $post->content }}
                            </p>
                            <div class="mt-5 pt-4 border-t border-gray-50 flex justify-end">
                                <span class="text-xs font-semibold text-gray-900 flex items-center gap-1">
                                    Read blogs →
                                </span>
                            </div>
                        </article>
                    </a>
                @endforeach
            </div>

            <!-- Pagination -->
            <x-pagination :pagination="$data"/>
        @endif
    </div>
</x-layout>
