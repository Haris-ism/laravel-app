<x-layout title="Manage Blog" js="resources/js/pages/blog-manage.js">

    <div class="max-w-6xl mx-auto px-6 py-10">

        <!-- Header -->
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-3xl font-extrabold text-gray-900 tracking-tight">Manage Blogs</h1>
                <p class="text-sm text-gray-400 mt-1">Create, edit, and publish blogs.</p>
            </div>
            <button onclick="openCreateModal()"
                class="flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-700 transition-colors">
                + New Blog
            </button>
        </div>

        @if ($data->isEmpty())
            <!-- Empty -->
            <div id="empty" class=" text-center py-32">
                <div class="text-5xl mb-4">📭</div>
                <p class="text-gray-400 font-medium mb-4">No blogs yet.</p>
                <button onclick="openCreateModal()"
                    class="px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-700 transition-colors">
                    Create your first post
                </button>
            </div>
        @else
            <!-- Table -->
            <div id="table-wrap" >
                <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden shadow-sm">
                    <table class="w-full">
                        <thead>
                            <tr class="border-b border-gray-100 bg-gray-50">
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider w-12">ID</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Title</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Content</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider whitespace-nowrap">Created At</th>
                                <th class="px-6 py-3.5 text-left text-xs font-semibold text-gray-400 uppercase tracking-wider">Author</th>
                                <th class="px-6 py-3.5 text-center text-xs font-semibold text-gray-400 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @foreach ($data as $post)
                                @php
                                    $edit = $pending[$post->id] ?? null;
                                    $canEdit = $post->user_id === auth()->id();
                                @endphp
                                <tr id="row-{{ $post->id }}" class="border-b border-gray-100 hover:bg-gray-50 transition-colors {{ $edit ? 'bg-amber-50' : '' }}">
                                    <td class="px-6 py-4 text-sm text-gray-400 w-12">{{$post->id}}</td>
                                    <td class="px-6 py-4">
                                        <span id="title-{{ $post->id }}" class="text-sm font-semibold text-gray-900">{{ $edit['title'] ?? $post->title }}</span>
                                        @if ($edit)
                                            <span class="text-[10px] uppercase font-bold text-amber-600 ml-2">pending</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4">
                                        <span id="content-{{ $post->id }}" class="text-sm text-gray-500 line-clamp-2">{{ $edit['content'] ?? $post->content }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-400 whitespace-nowrap">{{ $post->created_at?->format('F j, Y') }}</td>
                                    <td class="px-6 py-4 text-sm text-gray-500">{{ $post->author->name }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button @if ($canEdit) data-open-edit="{{ $post->id }}" @endif
                                                @disabled(! $canEdit)
                                                class="text-xs font-semibold text-gray-900 border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-transparent">
                                                Edit
                                            </button>
                                            <form method="POST" action="{{ route('blog.deleteBlog', $post->id) }}"
                                                onsubmit="return confirm('Confirm Delete Blog Post?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" @disabled(! $canEdit)
                                                    class="text-xs font-semibold text-red-600 border border-red-200 px-3 py-1.5 rounded-lg hover:bg-red-50 transition-colors disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-transparent">
                                                    Delete
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                <x-modals.modal id="edit-modal-{{ $post->id }}" title="Edit Post" on-close="closeEditModal"
                                    data-autoopen="{{ ($errors->stageUpdate->has('edit.title.' . $post->id) || $errors->stageUpdate->has('edit.content.' . $post->id)) ? 'true' : 'false' }}">
                                    <x-modals.edit :post="$post"/>
                                </x-modals.modal>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        <x-pagination :pagination="$data"/>
        
    </div>

    <!-- Save Button (fixed bottom right) -->
    <form method="POST" action="{{ route('blog.batchUpdate') }}" class="fixed bottom-8 right-8 flex items-center gap-3">
        @csrf
        <button type="submit" @if (empty($pending)) disabled @endif
            class="relative flex items-center gap-2 px-6 py-3 bg-gray-900 text-white text-sm font-semibold rounded-xl shadow-lg hover:bg-gray-700 disabled:opacity-40 disabled:cursor-not-allowed transition-all">
            <span>Save Changes</span>
            @if (! empty($pending))
                <span class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ count($pending) }}</span>
            @endif
        </button>
    </form>

    <x-modals.modal id="create-modal" title="New Blog" on-close="closeCreateModal"
        data-autoopen="{{ ($errors->create->has('title') || $errors->create->has('content')) ? 'true' : 'false' }}">
        <x-modals.create/>
    </x-modals.modal>

</x-layout>
