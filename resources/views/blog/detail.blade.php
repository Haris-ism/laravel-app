<x-layout title="{{ $title }}">
    <x-slot:head>
        <meta name="page-title" content="{{ $title }}">
    </x-slot:head>

    <div class="max-w-3xl mx-auto px-6 py-12">

        @if (empty($data))
            <!-- Error -->
            <div id="error" class="bg-red-50 border border-red-100 rounded-2xl p-10 text-center">
                <div class="text-5xl mb-4">404</div>
                <p class="text-red-700 font-semibold text-lg mb-2">Article not found</p>
                <p class="text-red-400 text-sm mb-6">The article you're looking for doesn't exist or has been removed.</p>
                <a href="/blog" class="inline-block px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-lg hover:bg-gray-700 transition-colors">
                    ← Back to Blog
                </a>
            </div>
        @else
            <!-- Post -->
            <article id="post">
                <!-- Header -->
                <div class="mb-10">
                    <div class="flex items-center gap-3 mb-6">
                        <div id="post-avatar" class="w-10 h-10 rounded-full bg-gray-900 text-white flex items-center justify-center text-sm font-bold">{{ strtoupper(substr($data->title, 0, 1)) }}</div>
                        <div>
                            <p class="text-sm font-semibold text-gray-900">Author</p>
                            <p id="post-date" class="text-xs text-gray-400">{{ $data->created_at?->format('F j, Y') }}</p>
                        </div>
                    </div>

                    <h1 id="post-title" class="text-4xl font-extrabold text-gray-900 tracking-tight leading-tight mb-4">{{$data->title}}</h1>

                    <div class="h-1 w-16 bg-gray-900 rounded-full"></div>
                </div>

                <!-- Divider -->
                <div class="border-t border-gray-100 mb-10"></div>

                <!-- Content -->
                <div id="post-content" class="text-gray-600 text-lg leading-relaxed whitespace-pre-line">{{ $data->content}}</div>

                <!-- Footer -->
                <div class="mt-16 pt-10 border-t border-gray-100 flex items-center justify-between">
                    <a href="/blog" class="inline-flex items-center gap-2 text-sm font-semibold text-gray-900 hover:underline">
                        ← Back to articles
                    </a>
                    <span class="text-xs text-gray-400">The Blog</span>
                </div>

            </article>
        @endif
    </div>

</x-layout>
