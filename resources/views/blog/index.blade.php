<x-layout title="Blog" js="resources/js/pages/blog.js">

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

       <x-loading/>

        <!-- Error -->
        <div id="error" class="hidden bg-red-50 border border-red-100 rounded-2xl p-8 text-center">
            <div class="text-4xl mb-3">⚠️</div>
            <p class="text-red-700 font-semibold mb-1">Failed to load posts</p>
            <p class="text-red-400 text-sm">Please check your connection and try again.</p>
        </div>

        <!-- Empty -->
        <div id="empty" class="hidden text-center py-24">
            <div class="text-5xl mb-4">📭</div>
            <p class="text-gray-400 font-medium">No posts yet. Check back soon.</p>
        </div>

        <!-- Blog Cards -->
        <div id="blog-list" class="hidden space-y-4"></div>

        <!-- Pagination -->
        <div id="pagination" class="hidden mt-12 flex items-center justify-between">
            <button id="prev-btn" onclick="changePage(-1)"
                class="flex items-center gap-2 px-5 py-2.5 border-[1.5px] border-gray-200 rounded-lg bg-white text-sm font-semibold text-gray-900 hover:border-gray-400 disabled:opacity-40 disabled:cursor-not-allowed transition-all">
                ← Previous
            </button>

            <div id="page-dots" class="flex gap-1.5 items-center"></div>

            <button id="next-btn" onclick="changePage(1)"
                class="flex items-center gap-2 px-5 py-2.5 border-[1.5px] border-gray-200 rounded-lg bg-white text-sm font-semibold text-gray-900 hover:border-gray-400 disabled:opacity-40 disabled:cursor-not-allowed transition-all">
                Next →
            </button>
        </div>

        <p id="page-info" class="hidden text-center text-xs text-gray-400 mt-4"></p>

    </div>

</x-layout>
