@props(['post'])
<form wire:submit="stageEdit({{ $post->id }})" class="space-y-5">

    <div>
        <label for="title" class="block text-sm font-semibold text-gray-700 mb-1.5">Title</label>
        <input id="title" type="text" wire:model="edit.title.{{ $post->id }}"
            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
        @error('edit.' . 'title.' . $post->id)
            <p class="text-red-500 text-xs font-medium mt-1.5">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label for="content" class="block text-sm font-semibold text-gray-700 mb-1.5">Content</label>
        <textarea id="content" rows="8" wire:model="edit.content.{{ $post->id }}"
            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition resize-none"></textarea>
        @error('edit.' . 'content.' . $post->id)
            <p class="text-red-500 text-xs font-medium mt-1.5">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-3 pt-2">
        <button type="button" onclick="closeEditModal()"
            class="flex-1 text-center px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
            Cancel
        </button>
        <button type="submit"
            class="flex-1 px-4 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-semibold hover:bg-gray-700 transition-colors">
            Save Changes
        </button>
    </div>
</form>
