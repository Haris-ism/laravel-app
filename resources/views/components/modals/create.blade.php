<form wire:submit="createBlog()" class="space-y-4">
    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Title</label>
        <input name="title" type="text" wire:model="newTitle" placeholder="Enter blog title"
            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
        @error('newTitle')
            <p class="text-red-500 text-xs font-medium mt-1.5">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Content</label>
        <textarea name="content" rows="5" wire:model="newContent"  placeholder="Write your blog content..."
            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition resize-none">{{ old('content') }}</textarea>
        @error('newContent')
            <p class="text-red-500 text-xs font-medium mt-1.5">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex gap-3 pt-2">
        <button type="button" onclick="closeCreateModal()"
            class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
            Cancel
        </button>
        <button type="submit"
            class="flex-1 px-4 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-semibold hover:bg-gray-700 transition-colors">
            Create
        </button>
    </div>
</form>
