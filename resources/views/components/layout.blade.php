<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? 'The Blog' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js', ...(isset($js) ? [$js] : [])])
    @endif
    {{ $head ?? '' }}
</head>
<body class="bg-stone-50 min-h-screen" style="font-family: 'Inter', sans-serif;"
    data-require-auth="{{ isset($requireAuth) && $requireAuth ? 'true' : 'false' }}">

    <x-navbar/>

    {{ $slot }}

    {{-- Login Modal --}}
    <x-modal id="login-modal" title="Welcome back" on-close="closeLoginModal">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                <input id="login-email" type="email" placeholder="you@example.com"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                <input id="login-password" type="password" placeholder="••••••••"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
            </div>
            <p id="login-error" class="text-red-500 text-xs font-medium"></p>
        </div>

        <x-slot:footer>
            <button onclick="closeLoginModal()"
                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                Cancel
            </button>
            <button id="login-submit" onclick="submitLogin()"
                class="flex-1 px-4 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-semibold hover:bg-gray-700 transition-colors">
                Login
            </button>
        </x-slot:footer>
    </x-modal>

    {{-- Register Modal --}}
    <x-modal id="register-modal" title="Create an account" on-close="closeRegisterModal">
        <div class="space-y-4">
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Name</label>
                <input id="register-name" type="text" placeholder="Your name"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
                <input id="register-email" type="email" placeholder="you@example.com"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
            </div>
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
                <input id="register-password" type="password" placeholder="Min. 8 characters"
                    class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
            </div>
            <p id="register-error" class="text-red-500 text-xs font-medium"></p>
        </div>

        <x-slot:footer>
            <button onclick="closeRegisterModal()"
                class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
                Cancel
            </button>
            <button id="register-submit" onclick="submitRegister()"
                class="flex-1 px-4 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-semibold hover:bg-gray-700 transition-colors">
                Register
            </button>
        </x-slot:footer>
    </x-modal>

</body>
</html>
