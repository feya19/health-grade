<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    {{-- Viewport disesuaikan untuk PWA agar tidak bisa di-zoom (aplikasi native feel) --}}
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    
    @PwaHead
    <title>{{ $title ?? 'HealthGrade' }}</title>
    
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-hg-light font-sans text-hg-dark antialiased selection:bg-hg-primary selection:text-white">

    {{-- Form Logout Hidden (Tetap disimpan untuk fungsi logout via button di halaman lain) --}}
    <form method="POST" action="{{ route('logout') }}" id="logout-form" class="hidden">
        @csrf
    </form>

    {{-- MAIN CONTENT WRAPPER --}}
    {{-- Kita hapus Sidebar (<aside>) dan Topbar mobile --}}
    {{-- Kita hapus padding (p-6) agar komponen Livewire bisa Full Screen --}}
    <main class="min-h-screen w-full relative">
        {{ $slot }}
    </main>

    @RegisterServiceWorkerScript
</body>
</html>