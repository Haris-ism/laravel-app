<x-layout title="Manage Blog" js="resources/js/pages/blog-manage.js" :require-auth="true">

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
                                <th class="px-6 py-3.5 text-right text-xs font-semibold text-gray-400 uppercase tracking-wider">Action</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @foreach ($data as $post)
                                @php $edit = $pending[$post->id] ?? null; @endphp
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
                                    <td class="px-6 py-4 text-right">
                                        <a href="{{ route('blog.edit', $post->id) }}"
                                            class="text-xs font-semibold text-gray-900 border border-gray-200 px-3 py-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                                            Edit
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

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
    </div>

    <!-- Save Button (fixed bottom right) -->
    <form method="POST" action="{{ route('blog.save-pending') }}" class="fixed bottom-8 right-8 flex items-center gap-3">
        @csrf
        <button type="submit" @if (empty($pending)) disabled @endif
            class="relative flex items-center gap-2 px-6 py-3 bg-gray-900 text-white text-sm font-semibold rounded-xl shadow-lg hover:bg-gray-700 disabled:opacity-40 disabled:cursor-not-allowed transition-all">
            <span>Save Changes</span>
            @if (! empty($pending))
                <span class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center">{{ count($pending) }}</span>
            @endif
        </button>
    </form>

    <x-modal id="create-modal" title="New Blog" on-close="closeCreateModal">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Title</label>
                <input id="create-title" type="text" placeholder="Enter blog title"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Content</label>
                <textarea id="create-content" rows="5" placeholder="Write your blog content..."
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition resize-none"></textarea>
            </div>
            <p id="create-error" class="text-red-500 text-xs font-medium"></p>
        </div>

        <x-slot:footer>
            <button onclick="closeCreateModal()"
                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                Cancel
            </button>
            <button id="create-submit" onclick="submitCreate()"
                class="flex-1 px-4 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-semibold hover:bg-gray-700 transition-colors">
                Create
            </button>
        </x-slot:footer>
    </x-modal>

    <!-- Toast -->
    <div id="toast"
        class="fixed bottom-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-sm font-medium px-5 py-3 rounded-xl shadow-lg opacity-0 translate-y-4 transition-all duration-300 pointer-events-none">
    </div>

</x-layout>
