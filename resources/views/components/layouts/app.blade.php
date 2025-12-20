<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    {{-- Viewport disesuaikan untuk PWA agar tidak bisa di-zoom (aplikasi native feel) --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">

    @PwaHead
    <title>{{ $title ?? 'HealthGrade' }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-white font-sans text-hg-dark antialiased" x-data="{ sidebarOpen: false }">

    {{-- Form Logout Hidden (Tetap disimpan untuk fungsi logout via button di halaman lain) --}}
    <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
        @csrf
    </form>

    <main class="flex-1 overflow-y-auto h-screen">
        {{ $slot }}
    </main>
    @RegisterServiceWorkerScript
</body>

</html>
