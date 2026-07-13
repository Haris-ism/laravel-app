<form method="POST" action="{{ route('auth.register') }}" class="space-y-4" novalidate>
    @csrf

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Name</label>
        <input id="register-name" name="name" type="text" value="{{ old('name') }}" placeholder="Your name"
            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
        @error('name', 'register')
            <p class="text-red-500 text-xs font-medium mt-1.5">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Email</label>
        <input id="register-email" name="email" type="email" value="{{ old('email') }}" placeholder="you@example.com"
            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
        @error('email', 'register')
            <p class="text-red-500 text-xs font-medium mt-1.5">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <label class="block text-sm font-semibold text-gray-700 mb-1.5">Password</label>
        <input id="register-password" name="password" type="password" placeholder="••••••••"
            class="w-full border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-900 focus:border-transparent transition">
        @error('password', 'register')
            <p class="text-red-500 text-xs font-medium mt-1.5">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex gap-3 pt-2">
        <button type="button" data-close="closeRegisterModal"
            class="flex-1 px-4 py-2.5 border border-gray-200 rounded-xl text-sm font-semibold text-gray-600 hover:bg-gray-50 transition-colors">
            Cancel
        </button>
        <button type="submit"
            class="flex-1 px-4 py-2.5 bg-gray-900 text-white rounded-xl text-sm font-semibold hover:bg-gray-700 transition-colors">
            Register
        </button>
    </div>
</form>
