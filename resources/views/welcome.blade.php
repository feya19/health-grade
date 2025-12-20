<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>HealthGrade - Scan Nutrisi & Grade Makanan AI</title>

        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
        @fluxStyles
    </head>
    <body class="min-h-screen bg-hg-bg text-hg-dark font-sans antialiased selection:bg-hg-primary selection:text-white">

        {{-- Navbar --}}
        <nav class="fixed top-0 w-full z-50 bg-hg-bg/80 backdrop-blur-md border-b border-gray-200/50">
            <div class="container mx-auto px-6 h-20 flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-hg-primary rounded-xl flex items-center justify-center shadow-lg shadow-hg-primary/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M12 2a10 10 0 0 0-7.75 14.65L2 22l5.35-2.25A10 10 0 1 0 12 2z"/>
                            <path d="M8 12h8"/>
                            <path d="M12 8v8"/>
                        </svg>
                    </div>
                    <span class="text-xl font-bold tracking-tight text-hg-dark">HealthGrade</span>
                </div>

                <div class="hidden md:flex items-center gap-8 text-sm font-medium text-hg-dark/70">
                    <a href="#carakerja" class="hover:text-hg-primary transition-colors">Cara Kerja</a>
                    <a href="#sistemgrade" class="hover:text-hg-primary transition-colors">Sistem Grade</a>
                    <a href="#fiturai" class="hover:text-hg-primary transition-colors">Peran AI</a>
                </div>

                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <flux:button href="{{ url('/dashboard') }}" class="!bg-hg-primary !text-white hover:!bg-hg-secondary !border-0 !rounded-full">
                                Dashboard
                            </flux:button>
                        @else
                            <flux:button href="{{ route('login') }}" variant="ghost" class="!text-hg-dark hover:!bg-gray-100 !rounded-full">
                                Masuk
                            </flux:button>
                            @if (Route::has('register'))
                                <flux:button href="{{ route('register') }}" class="!bg-hg-dark !text-white hover:!bg-hg-secondary !border-0 !rounded-full shadow-md">
                                    Daftar Sekarang
                                </flux:button>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </nav>

        {{-- ================= HERO SECTION ================= --}}
        <header class="pt-32 pb-20 md:pt-48 md:pb-32 container mx-auto px-6 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full bg-white border border-gray-200 shadow-sm mb-8 animate-fade-in-up">
                <span class="flex h-2 w-2 relative">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-hg-primary opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-hg-primary"></span>
                </span>
                <span class="text-xs font-semibold tracking-wide text-gray-500 uppercase">AI-Powered Nutrition Scanner</span>
            </div>

            <h1 class="text-4xl md:text-6xl font-extrabold tracking-tight text-hg-dark mb-8 leading-tight max-w-5xl mx-auto">
                Jangan Asal Makan, <br class="hidden md:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-hg-primary to-hg-secondary">
                    Pahami Nutrisi.
                </span>
            </h1>

            <p class="text-lg md:text-xl text-gray-500 mb-12 max-w-2xl mx-auto leading-relaxed">
                HealthGrade menggunakan teknologi OCR dan kecerdasan buatan untuk menganalisis kandungan <strong>Gula, Garam, dan Lemak</strong> pada kemasan, memberikan Anda <strong>Nutri-Grade (A-D)</strong> yang akurat secara instan.
            </p>

            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <flux:button href="{{ route('scan.barcode') }}" class="!bg-hg-primary !text-white hover:!bg-hg-secondary !border-0 !h-14 !px-8 !text-lg !rounded-2xl shadow-xl shadow-hg-primary/20 transition-transform hover:-translate-y-1">
                    Mulai Scan Sekarang
                </flux:button>
                {{-- <flux:button href="#carakerja" variant="subtle" class="!bg-white !text-hg-dark !border-gray-200 hover:!border-hg-primary hover:!text-hg-primary !h-14 !px-8 !text-lg !rounded-2xl">
                    Pelajari Cara Kerja
                </flux:button> --}}
            </div>

             {{-- Product Scan Preview Mockup --}}
             <div class="mt-20 relative max-w-4xl mx-auto animate-fade-in-up delay-200">
                <div class="absolute -inset-1 bg-gradient-to-r from-hg-primary to-hg-secondary rounded-[2.5rem] blur opacity-20"></div>
                <div class="relative bg-white/80 border border-white/60 p-4 rounded-[2.5rem] shadow-2xl backdrop-blur-sm">
                    <div class="bg-gray-50 rounded-[2rem] aspect-[16/9] md:aspect-[21/9] overflow-hidden flex items-center justify-center relative">
                        <div class="flex flex-col items-center z-10">
                            <div class="w-16 h-16 mb-4 bg-white rounded-full flex items-center justify-center shadow-lg text-hg-primary">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            </div>
                            <div class="bg-white px-8 py-4 rounded-2xl shadow-md border border-gray-100 flex items-center gap-6">
                                <div class="text-left">
                                    <p class="text-xs text-gray-400 font-semibold uppercase">Hasil Scan AI</p>
                                    <p class="text-hg-dark font-bold text-lg">Minuman Soda Manis</p>
                                    <p class="text-sm text-gray-500">Gula: 12g | Lemak Jenuh: 0g</p>
                                </div>
                                <div class="h-12 w-px bg-gray-200"></div>
                                <div class="text-center relative top-1">
                                    <div class="flex items-center justify-center w-14 h-8 bg-red-600 text-white font-black text-xl rounded-r-full rounded-l-lg relative">
                                        D <span class="text-[10px] absolute right-1 top-2 leading-none">12%<br>sugar</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="absolute inset-0 bg-[radial-gradient(#e5e7eb_1px,transparent_1px)] [background-size:16px_16px] opacity-50"></div>
                    </div>
                </div>
            </div>
        </header>

        {{-- ================= SECTION 1: CARA KERJA (Sesuai Flowchart) ================= --}}
        <section id="carakerja" class="py-24 bg-white relative border-t border-gray-100">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-hg-dark mb-4">Cara Kerja Sistem</h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">Proses dari pemindaian hingga analisis AI, sesuai dengan alur sistem kami.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8 relative">
                    <div class="hidden md:block absolute top-1/2 left-1/3 w-1/3 h-px bg-gray-200 -z-10"></div>
                    <div class="hidden md:block absolute top-1/2 right-1/3 w-1/3 h-px bg-gray-200 -z-10"></div>

                    <div class="p-8 rounded-3xl bg-hg-bg border border-gray-100 text-center relative z-10">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm text-hg-primary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-hg-dark">1. Login & Pindai</h3>
                        <p class="text-gray-500 leading-relaxed text-sm">Setelah masuk ke Main Page, berikan izin kamera dan pindai barcode produk makanan Anda.</p>
                    </div>

                    <div class="p-8 rounded-3xl bg-hg-bg border border-gray-100 text-center relative z-10">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm text-hg-primary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-hg-dark">2. Identifikasi & Proses Data</h3>
                        <p class="text-gray-500 leading-relaxed text-sm">Sistem mengecek database. Jika produk baru, AI akan memproses data nutrisi dari gambar (OCR).</p>
                    </div>

                    <div class="p-8 rounded-3xl bg-hg-bg border border-gray-100 text-center relative z-10">
                        <div class="w-16 h-16 bg-white rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm text-hg-primary">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-hg-dark">3. Hasil Score & Asisten AI</h3>
                        <p class="text-gray-500 leading-relaxed text-sm">Kalkulasi skor ditampilkan. Butuh info lanjut? Asisten AI siap memberikan analisis mendalam sebelum selesai.</p>
                    </div>
                </div>
            </div>
        </section>

        {{-- ================= SECTION 2: SISTEM GRADE (Sesuai Tabel Image) ================= --}}
        <section id="sistemgrade" class="py-24 bg-hg-bg relative border-t border-gray-200">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-hg-dark mb-4">Sistem Nutri-Grade</h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">Klasifikasi berdasarkan ambang batas kandungan Gula dan Lemak Jenuh per 100g/ml.</p>
                </div>

                <div class="grid md:grid-cols-4 gap-6">
                    <div class="bg-white p-6 rounded-2xl shadow-sm border-t-4 border-green-600">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-8 bg-green-600 text-white font-black text-lg rounded-r-full rounded-l-md">A</div>
                            <span class="text-green-700 font-bold text-sm uppercase">Sangat Sehat</span>
                        </div>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li class="flex items-start"><svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Gula: ≤ 1g</li>
                            <li class="flex items-start"><svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Lemak Jenuh: ≤ 0.7g</li>
                            <li class="flex items-start"><svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>Tanpa pemanis buatan</li>
                        </ul>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border-t-4 border-lime-500">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-8 bg-lime-500 text-white font-black text-lg rounded-r-full rounded-l-md">B</div>
                            <span class="text-lime-600 font-bold text-sm uppercase">Sehat</span>
                        </div>
                         <ul class="text-sm text-gray-600 space-y-2">
                            <li>Gula: 1g - 5g</li>
                            <li>Lemak Jenuh: 0.7g - 1.2g</li>
                        </ul>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border-t-4 border-orange-500">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-8 bg-orange-500 text-white font-black text-lg rounded-r-full rounded-l-md">C</div>
                            <span class="text-orange-600 font-bold text-sm uppercase">Konsumsi Sedang</span>
                        </div>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li>Gula: 5g - 10g</li>
                            <li>Lemak Jenuh: 1.2g - 2.8g</li>
                        </ul>
                    </div>

                    <div class="bg-white p-6 rounded-2xl shadow-sm border-t-4 border-red-600">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center justify-center w-12 h-8 bg-red-600 text-white font-black text-lg rounded-r-full rounded-l-md">D</div>
                            <span class="text-red-700 font-bold text-sm uppercase">Kurangi Konsumsi</span>
                        </div>
                        <ul class="text-sm text-gray-600 space-y-2">
                            <li class="flex items-start"><svg class="w-4 h-4 text-red-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>Gula: > 10g</li>
                            <li class="flex items-start"><svg class="w-4 h-4 text-red-500 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>Lemak Jenuh: > 2.8g</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- ================= SECTION 3: FITUR UNGGULAN & PERAN AI ================= --}}
        <section id="fiturai" class="py-24 bg-white relative border-t border-gray-100">
            <div class="container mx-auto px-6">
                <div class="text-center mb-16">
                    <h2 class="text-3xl font-bold text-hg-dark mb-4">Fitur & Peran AI</h2>
                    <p class="text-gray-500 max-w-2xl mx-auto">Teknologi yang menjadikan HealthGrade lebih dari sekadar pemindai barcode.</p>
                </div>

                <div class="grid md:grid-cols-3 gap-8">
                    <div class="p-8 rounded-3xl bg-hg-bg hover:bg-white hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-transparent hover:border-gray-100 group">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm text-hg-primary group-hover:bg-hg-primary group-hover:text-white transition-colors">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-hg-dark">Teknologi OCR Canggih</h3>
                        <p class="text-gray-500 leading-relaxed">Jika data produk belum ada, AI kami mampu membaca teks pada tabel informasi nilai gizi di kemasan secara otomatis.</p>
                    </div>

                    <div class="p-8 rounded-3xl bg-hg-bg hover:bg-white hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-transparent hover:border-gray-100 group">
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm text-hg-primary group-hover:bg-hg-primary group-hover:text-white transition-colors">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-hg-dark">Kalkulasi Grade Instan</h3>
                        <p class="text-gray-500 leading-relaxed">Algoritma kami langsung menghitung data gula dan lemak jenuh untuk memberikan Nutri-Grade A-D dalam hitungan detik.</p>
                    </div>

                    <div class="p-8 rounded-3xl bg-gradient-to-br from-hg-bg to-hg-primary/10 hover:bg-white hover:shadow-xl hover:-translate-y-1 transition-all duration-300 border border-transparent hover:border-hg-primary/20 group relative overflow-hidden">
                        <div class="absolute -top-10 -right-10 w-32 h-32 bg-hg-primary/20 blur-3xl rounded-full pointer-events-none"></div>
                        
                        <div class="w-14 h-14 bg-white rounded-2xl flex items-center justify-center mb-6 shadow-sm text-hg-primary group-hover:bg-hg-primary group-hover:text-white transition-colors relative z-10">
                            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                        <h3 class="text-xl font-bold mb-3 text-hg-dark relative z-10">Peran AI</h3>
                        <p class="text-gray-600 font-medium leading-relaxed relative z-10">
                            Bertindak sebagai asisten pribadi Anda untuk melacak akumulasi nutrisi harian dan memberikan analisis kesehatan yang dipersonalisasi saat Anda membutuhkan informasi lebih lanjut.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Footer --}}
        <footer class="bg-hg-dark text-white py-12 border-t border-white/10">
            <div class="container mx-auto px-6">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div>
                        <span class="text-2xl font-bold tracking-tight">HealthGrade</span>
                        <p class="text-white/60 text-sm mt-2">© {{ date('Y') }} HealthGrade Inc. Malang, Indonesia.</p>
                    </div>
                    {{-- <div class="flex gap-6">
                         <a href="#" class="text-white/60 hover:text-white transition">Kebijakan Privasi</a>
                         <a href="#" class="text-white/60 hover:text-white transition">Syarat & Ketentuan</a>
                    </div> --}}
                </div>
            </div>
        </footer>

        @fluxScripts
    </body>
</html>