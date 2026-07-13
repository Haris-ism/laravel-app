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
<body class="bg-stone-50 min-h-screen" style="font-family: 'Inter', sans-serif;">

    <x-navbar/>

    @if (session('status') || session('error'))
        <div id="snackbar"
            class="fixed bottom-6 left-1/2 -translate-x-1/2 z-50 px-5 py-3 rounded-xl shadow-lg text-sm font-medium transition-opacity duration-500 {{ session('status') ? 'bg-green-600 text-white' : 'bg-red-600 text-white' }}">
            {{ session('status') ?? session('error') }}
        </div>
    @endif

    {{ $slot }}

    <x-modals.modal id="login-modal" title="Welcome back" on-close="closeLoginModal"
        data-autoopen="{{ ($errors->login->has('email') || $errors->login->has('password')) ? 'true' : 'false' }}">
        <x-modals.login/>
    </x-modals.modal>

    <x-modals.modal id="register-modal" title="Create an account" on-close="closeRegisterModal"
        data-autoopen="{{ ($errors->register->has('name') || $errors->register->has('email') || $errors->register->has('password')) ? 'true' : 'false' }}">
        <x-modals.register/>
    </x-modals.modal>

</body>
</html>
