<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        {{-- PWA Viewport Settings --}}
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
        <title>HealthGrade - Scan Nutrisi & Grade Makanan AI</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxStyles
    </head>
    <body class="min-h-screen bg-hg-light text-hg-dark font-sans antialiased selection:bg-hg-primary selection:text-white pb-24 md:pb-0">

        {{-- 1. NAVBAR (Desktop: Full, Mobile: Minimal) --}}
        <nav class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-gray-100">
            <div class="container mx-auto px-6 h-16 md:h-20 flex justify-between items-center">
                {{-- Logo --}}
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 md:w-10 md:h-10 bg-hg-primary rounded-xl flex items-center justify-center shadow-lg shadow-hg-primary/20 text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 md:h-6 md:w-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2a10 10 0 0 0-7.75 14.65L2 22l5.35-2.25A10 10 0 1 0 12 2z"/>
                            <path d="M8 12h8"/><path d="M12 8v8"/>
                        </svg>
                    </div>
                    <span class="text-lg md:text-xl font-bold tracking-tight text-hg-dark">HealthGrade</span>
                </div>

                {{-- Desktop Menu --}}
                <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-500">
                    <a href="#carakerja" class="hover:text-hg-primary transition-colors">Cara Kerja</a>
                    <a href="#sistemgrade" class="hover:text-hg-primary transition-colors">Sistem Grade</a>
                    <a href="#fiturai" class="hover:text-hg-primary transition-colors">Peran AI</a>
                </div>

                {{-- Desktop Buttons --}}
                <div class="hidden md:flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <flux:button href="{{ url('/dashboard') }}" class="!bg-hg-primary !text-white hover:!bg-hg-secondary !border-0 !rounded-full !px-6">
                                Dashboard
                            </flux:button>
                        @else
                            <flux:button href="{{ route('login') }}" variant="ghost" class="!text-hg-dark hover:!bg-gray-100 !rounded-full">
                                Masuk
                            </flux:button>
                            @if (Route::has('register'))
                                <flux:button href="{{ route('register') }}" class="!bg-hg-dark !text-white hover:!bg-hg-secondary !border-0 !rounded-full shadow-md">
                                    Daftar
                                </flux:button>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        {{-- 2. HERO SECTION --}}
        <header class="pt-32 pb-16 md:pt-48 md:pb-32 container mx-auto px-6 text-center">
            
            {{-- Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white border border-hg-primary/20 shadow-sm mb-8 animate-fade-in-up">
                <span class="relative flex h-2 w-2">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-hg-primary opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-2 w-2 bg-hg-primary"></span>
                </span>
                <span class="text-[10px] md:text-xs font-bold tracking-wide text-hg-primary uppercase">AI Nutrition Scanner</span>
            </div>

            {{-- Headline --}}
            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-hg-dark mb-6 leading-tight max-w-4xl mx-auto">
                Jangan Asal Makan, <br />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-hg-primary to-hg-secondary">
                    Pahami Nutrisi.
                </span>
            </h1>

            <p class="text-base md:text-xl text-gray-500 mb-10 max-w-2xl mx-auto leading-relaxed px-4">
                Scan barcode makanan kemasan dan dapatkan <strong>Nutri-Grade (A-D)</strong> instan berbasis AI. Kendalikan asupan gula dan lemak Anda sekarang.
            </p>

            {{-- ACTION BUTTONS --}}
            <div class="flex flex-col sm:flex-row justify-center items-center gap-4">
                <flux:button 
                    href="{{ route('dashboard') }}" 
                    class="!bg-white !text-teal-500 !border-2 !border-teal-500 hover:!bg-teal-50 !h-14 !px-8 !text-lg !rounded-2xl shadow-lg shadow-teal-500/10 transition-transform hover:-translate-y-1"
                >
                    Dashboard
                </flux:button>
            </div>
        </header>

        {{-- 3. FITUR CARDS (Responsive Grid) --}}
        <section id="carakerja" class="py-16 md:py-24 bg-white rounded-t-[3rem] shadow-[0_-10px_40px_rgba(0,0,0,0.03)] relative z-10">
            <div class="container mx-auto px-6">
                <div class="text-center mb-12">
                    <h2 class="text-2xl md:text-3xl font-bold text-hg-dark mb-3">Cara Kerja Simpel</h2>
                    <p class="text-sm md:text-base text-gray-500">Tiga langkah mudah untuk hidup lebih sehat.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-6 md:gap-8">
                    {{-- Step 1 --}}
                    <div class="p-6 md:p-8 rounded-[2rem] bg-hg-bg border border-gray-100 text-center">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-sm text-hg-primary">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold mb-2 text-hg-dark">1. Scan Barcode</h3>
                        <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Buka aplikasi dan arahkan kamera ke barcode pada kemasan makanan.</p>
                    </div>

                    {{-- Step 2 --}}
                    <div class="p-6 md:p-8 rounded-[2rem] bg-hg-bg border border-gray-100 text-center">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-sm text-hg-primary">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold mb-2 text-hg-dark">2. Analisis AI</h3>
                        <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Sistem mengenali produk atau membaca nilai gizi secara otomatis (OCR).</p>
                    </div>

                    {{-- Step 3 --}}
                    <div class="p-6 md:p-8 rounded-[2rem] bg-hg-bg border border-gray-100 text-center">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mx-auto mb-5 shadow-sm text-hg-primary">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        </div>
                        <h3 class="text-lg font-bold mb-2 text-hg-dark">3. Cek Grade</h3>
                        <p class="text-xs md:text-sm text-gray-500 leading-relaxed">Lihat Nutri-Grade (A-D) dan putuskan apakah aman untuk dikonsumsi.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- 4. STICKY BOTTOM ACTION BAR (Mobile Only - PWA Feel) --}}
        <div class="md:hidden fixed bottom-0 w-full bg-white border-t border-gray-100 p-4 pb-safe z-50 shadow-[0_-4px_20px_rgba(0,0,0,0.05)] rounded-t-[2rem]">
            <div class="flex gap-3">   
                    <a href="{{ route('scan.barcode') }}" class="flex-[1.5] bg-teal-500 text-white text-center font-bold py-3.5 rounded-xl shadow-lg shadow-teal-500/30 active:scale-95 transition-transform">
                        Scan Sekarang
                    </a>
            </div>
        </div>

        {{-- Footer --}}
        <footer class="bg-hg-dark text-white py-12 md:py-20 mb-20 md:mb-0">
            <div class="container mx-auto px-6 text-center">
                <span class="text-2xl font-bold tracking-tight">HealthGrade</span>
                <p class="text-white/60 text-sm mt-2">© {{ date('Y') }} HealthGrade Inc. Malang, Indonesia.</p>
            </div>
        </footer>

        @fluxScripts
    </body>
</html>