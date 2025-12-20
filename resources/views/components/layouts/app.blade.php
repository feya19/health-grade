<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'HealthGrade Dashboard' }}</title>
    
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-hg-bg font-sans text-hg-dark antialiased" x-data="{ sidebarOpen: false }">

    <div class="md:hidden flex items-center justify-between bg-white border-b border-gray-200 px-6 py-4">
        <div class="font-bold text-lg text-hg-primary">HealthGrade</div>
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
        </button>
    </div>

    <div class="flex min-h-screen">
        
        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'" class="fixed inset-y-0 left-0 z-50 w-64 bg-white border-r border-gray-200 transition-transform duration-300 md:relative md:translate-x-0">
            <div class="h-20 flex items-center px-8 border-b border-gray-100">
                <div class="w-8 h-8 bg-hg-primary rounded-lg flex items-center justify-center mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 2a10 10 0 0 0-7.75 14.65L2 22l5.35-2.25A10 10 0 1 0 12 2z"/>
                        <path d="M8 12h8"/>
                        <path d="M12 8v8"/>
                    </svg>
                </div>
                <span class="text-xl font-bold text-hg-dark">HealthGrade</span>
            </div>

            <nav class="p-4 space-y-2 mt-4">
                <a href="/dashboard" wire:navigate class="{{ request()->is('dashboard') ? 'bg-hg-primary/10 text-hg-primary' : 'text-gray-500 hover:bg-gray-50 hover:text-hg-dark' }} flex items-center gap-3 px-4 py-3 rounded-xl transition-colors font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"></path></svg>
                    Dashboard
                </a>
                
                <a href="/scan" class="text-gray-500 hover:bg-gray-50 hover:text-hg-dark flex items-center gap-3 px-4 py-3 rounded-xl transition-colors font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                    Scan Barcode
                </a>

                <a href="/riwayat-nutrisi" class="text-gray-500 hover:bg-gray-50 hover:text-hg-dark flex items-center gap-3 px-4 py-3 rounded-xl transition-colors font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Riwayat Nutrisi
                </a>

                 <a href="/profile" class="text-gray-500 hover:bg-gray-50 hover:text-hg-dark flex items-center gap-3 px-4 py-3 rounded-xl transition-colors font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profile
                </a>
            </nav>

            <div class="absolute bottom-0 w-full p-4 border-t border-gray-100">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-hg-secondary/10 flex items-center justify-center text-hg-secondary font-bold">
                        {{ substr(auth()->user()->name ?? 'U', 0, 1) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-bold text-hg-dark truncate">{{ auth()->user()->name ?? 'Guest User' }}</p>
                        <p class="text-xs text-gray-400 truncate">{{ auth()->user()->email ?? 'guest@example.com' }}</p>
                    </div>
                </div>
            </div>
        </aside>

        <div x-show="sidebarOpen" @click="sidebarOpen = false" class="fixed inset-0 bg-black/50 z-40 md:hidden"></div>

        <main class="flex-1 p-6 md:p-10 overflow-y-auto h-screen">
            {{ $slot }}
        </main>
    </div>
</body>
</html>