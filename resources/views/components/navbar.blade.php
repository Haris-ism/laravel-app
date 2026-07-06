@php $path = request()->path(); @endphp

<nav class="bg-white border-b border-gray-100">
    <div class="max-w-4xl mx-auto px-6 h-16 flex items-center justify-between">
        <a href="/blog" class="text-xl font-extrabold text-gray-900 tracking-tight">The Blog</a>

        <div class="flex items-center gap-6">
            <a href="/blog"
                class="text-sm font-medium transition-colors {{ $path === 'blog' ? 'text-gray-900 border-b-2 border-gray-900 pb-0.5' : 'text-gray-400 hover:text-gray-900' }}">
                Articles
            </a>
            <a href="/blog/manage" data-auth="manage"
                class="text-sm font-medium transition-colors {{ $path === 'blog/manage' ? 'text-gray-900 border-b-2 border-gray-900 pb-0.5' : 'text-gray-400 hover:text-gray-900' }}"
                style="display: none;">
                Manage
            </a>

            <!-- Guest buttons -->
            <div data-auth="guest" class="flex items-center gap-2">
                <button onclick="openLoginModal()"
                    class="text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">
                    Login
                </button>
                <button onclick="openRegisterModal()"
                    class="text-sm font-semibold bg-gray-900 text-white px-4 py-1.5 rounded-lg hover:bg-gray-700 transition-colors">
                    Register
                </button>
            </div>

            <!-- Auth user -->
            <div data-auth="user" class="items-center gap-3" style="display: none;">
                <button onclick="logout()"
                    class="text-sm font-medium text-gray-400 hover:text-gray-900 transition-colors">
                    Logout
                </button>
            </div>
        </div>
    </div>
</nav>
