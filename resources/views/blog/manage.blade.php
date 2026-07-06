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

        <x-loading/>

        <!-- Empty -->
        <div id="empty" class="hidden text-center py-32">
            <div class="text-5xl mb-4">📭</div>
            <p class="text-gray-400 font-medium mb-4">No blogs yet.</p>
            <button onclick="openCreateModal()"
                class="px-5 py-2.5 bg-gray-900 text-white text-sm font-semibold rounded-xl hover:bg-gray-700 transition-colors">
                Create your first post
            </button>
        </div>

        <!-- Table -->
        <div id="table-wrap" class="hidden">
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
                    <tbody id="table-body"></tbody>
                </table>
            </div>
        </div>

    </div>

    <!-- Save Button (fixed bottom right) -->
    <div class="fixed bottom-8 right-8 flex items-center gap-3">
        <button id="save-btn" onclick="saveAll()" disabled
            class="relative flex items-center gap-2 px-6 py-3 bg-gray-900 text-white text-sm font-semibold rounded-xl shadow-lg hover:bg-gray-700 disabled:opacity-40 disabled:cursor-not-allowed transition-all">
            <span id="save-btn-text">Save Changes</span>
            <span id="save-badge" style="display:none;" class="absolute -top-2 -right-2 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center"></span>
        </button>
    </div>

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

    <x-modal id="update-modal" title="Edit Post" on-close="closeUpdateModal">
        <input id="update-id" type="hidden">

        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Title</label>
                <input id="update-title" type="text" placeholder="Enter post title"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Content</label>
                <textarea id="update-content" rows="5" placeholder="Write your post content..."
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition resize-none"></textarea>
            </div>
            <p id="update-error" class="text-red-500 text-xs font-medium"></p>
        </div>

        <p class="text-xs text-amber-600 bg-amber-50 border border-amber-100 rounded-lg px-3 py-2 mt-4">
            Changes are staged — click <strong>Save Changes</strong> to persist to database.
        </p>

        <x-slot:footer>
            <button onclick="closeUpdateModal()"
                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                Cancel
            </button>
            <button onclick="submitUpdate()"
                class="flex-1 px-4 py-2.5 bg-amber-500 text-white rounded-xl text-sm font-semibold hover:bg-amber-600 transition-colors">
                Stage Edit
            </button>
        </x-slot:footer>
    </x-modal>

    <!-- Toast -->
    <div id="toast"
        class="fixed bottom-8 left-1/2 -translate-x-1/2 bg-gray-900 text-white text-sm font-medium px-5 py-3 rounded-xl shadow-lg opacity-0 translate-y-4 transition-all duration-300 pointer-events-none">
    </div>

</x-layout>
