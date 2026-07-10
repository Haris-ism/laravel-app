<x-layout title="Edit Post">

    <div class="max-w-2xl mx-auto px-6 py-12">

        <a href="{{ route('blog.manage') }}" class="inline-flex items-center gap-2 text-sm text-gray-400 font-medium hover:text-gray-900 transition-colors mb-8">
            ← Back to Manage
        </a>

        <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight mb-8">Edit Post</h1>

        <form method="POST" action="{{ route('blog.update', $post->id) }}" class="space-y-5">
            @csrf
            @method('PUT')

            <div>
                <label for="title" class="block text-sm font-semibold text-gray-700 mb-1.5">Title</label>
                <input id="title" name="title" type="text" value="{{ old('title', $post->title) }}"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
                @error('title')
                    <p class="text-red-500 text-xs font-medium mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="content" class="block text-sm font-semibold text-gray-700 mb-1.5">Content</label>
                <textarea id="content" name="content" rows="8"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition resize-none">{{ old('content', $post->content) }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs font-medium mt-1.5">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center gap-3 pt-2">
                <a href="{{ route('blog.manage') }}"
                    class="flex-1 text-center px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                    Cancel
                </a>
                <button type="submit"
                    class="flex-1 px-4 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-semibold hover:bg-gray-700 transition-colors">
                    Save Changes
                </button>
            </div>
        </form>
    </div>

</x-layout>
