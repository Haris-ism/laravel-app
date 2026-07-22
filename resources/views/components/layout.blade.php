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
    @livewireStyles
</head>
<body x-data="{}" class="bg-stone-50 min-h-screen" style="font-family: 'Inter', sans-serif;">

    <x-navbar/>

    <!-- snackbar notification -->
        <div x-data="{ open: false, message: '', type: '' }"
            x-on:notify.window="
                message = $event.detail.message;
                type = $event.detail.type;
                open = true;
                setTimeout(() => open = false, 2000);
            "
            x-show="open"
            x-transition:leave="transition ease-in duration-500"
            x-transition:leave-end="opacity-0"
            class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 px-5 py-3 rounded-xl shadow-lg text-sm font-medium"
            :class="type === 'status' ? 'bg-green-600 text-white' : 'bg-red-600 text-white'">
            <span x-text="message"></span>
        </div>

    {{ $slot }}

    <x-modals.modal id="login-modal" title="Welcome back"
        x-data="{ open: {{ ($errors->login->has('email') || $errors->login->has('password')) ? 'true' : 'false' }} }"
        x-show="open"
        x-on:open-login-modal.window="open=true"
        x-on:close-login-modal.window="open=false">
        <x-modals.login/>
    </x-modals.modal>

    <x-modals.modal id="register-modal" title="Create an account"
        x-data="{ open: {{ ($errors->register->has('name') || $errors->register->has('email') || $errors->register->has('password')) ? 'true' : 'false' }} }"
        x-show="open"
        x-on:open-register-modal.window="open=true"
        x-on:close-register-modal.window="open=false">
        <x-modals.register/>
    </x-modals.modal>
    @livewireScripts
</body>
</html>
