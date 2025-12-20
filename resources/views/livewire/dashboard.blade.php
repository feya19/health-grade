{{-- PERBAIKAN: Gunakan fixed inset-0 agar menutupi Sidebar layout utama --}}
<div class="fixed inset-0 bg-white overflow-y-auto pb-28">
    
    {{-- 1. TOP BAR (Mobile Header) --}}
    {{-- Menggunakan sticky top-0 agar tetap terlihat saat scroll --}}
    <div class="bg-white px-6 pt-8 pb-6  shadow-sm sticky top-0 z-30">
        <div class="flex justify-between items-center">
            <div>
                <p class="text-sm text-gray-400 font-medium">Selamat Datang,</p>
                <h1 class="text-2xl font-bold text-hg-dark truncate max-w-[200px]">{{ auth()->user()->name ?? 'User' }}! 👋</h1>
            </div>
            {{-- <div class="w-10 h-10 rounded-full bg-gray-100 border-2 border-white shadow-sm overflow-hidden">
                {{-- Placeholder Avatar --}}
                {{-- <svg class="w-full h-full text-gray-400 p-1" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg> --}}
            {{-- </div> --}}
        </div>
    </div>

    <div class="px-4 mt-6 space-y-6 max-w-lg mx-auto">
        
        {{-- 2. CALORIE CARD (Main Focus) --}}
        <div class="bg-hg-dark rounded-3xl p-6 text-white shadow-xl shadow-hg-dark/20 relative overflow-hidden">
            <div class="absolute top-0 right-0 -mt-6 -mr-6 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
            <div class="absolute bottom-0 left-0 -mb-6 -ml-6 w-24 h-24 bg-hg-primary/20 rounded-full blur-xl"></div>

            <div class="relative z-10">
                <div class="flex justify-between items-start mb-4">
                    <div>
                        <p class="text-hg-primary font-bold text-sm uppercase tracking-wider">Kalori Harian</p>
                        <p class="text-xs text-gray-300 mt-1">Target: {{ number_format($stats['calories_target']) }} kkal</p>
                    </div>
                    <div class="bg-white/10 backdrop-blur-md px-3 py-1 rounded-full text-xs font-medium">
                        {{ $stats['calories_target'] > 0 ? round(($stats['calories_current'] / $stats['calories_target']) * 100) : 0 }}% Terisi
                    </div>
                </div>

                <div class="flex items-end gap-2 mb-4">
                    <span class="text-5xl font-black tracking-tight">{{ number_format($stats['calories_current']) }}</span>
                    <span class="text-lg text-gray-400 mb-2 font-medium">kkal</span>
                </div>

                <div class="w-full bg-white/10 rounded-full h-3 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-hg-primary to-green-400 transition-all duration-1000" 
                         style="width: {{ $stats['calories_target'] > 0 ? min(100, ($stats['calories_current'] / $stats['calories_target']) * 100) : 0 }}%">
                    </div>
                </div>
                
                <div class="mt-2 text-right">
                    <span class="text-xs text-gray-400">Sisa: {{ max(0, $stats['calories_target'] - $stats['calories_current']) }} kkal</span>
                </div>
            </div>
        </div>

        {{-- 3. NUTRIENT CARDS (Gula, Garam & Lemak) --}}
        <div class="grid grid-cols-3 gap-3">
            {{-- Card Gula --}}
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                <p class="text-xs text-gray-400 font-bold uppercase">Gula</p>
                <div class="mt-2 flex items-end justify-between">
                    <span class="text-xl font-bold text-hg-dark">{{ round($stats['gula_consumed'], 1) }}<span class="text-xs font-normal text-gray-400">g</span></span>
                    
                    @if(($stats['gula_consumed'] / $stats['gula_limit']) * 100 > 100)
                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    @else
                        <span class="text-[10px] font-bold text-orange-400">{{ round(($stats['gula_consumed'] / $stats['gula_limit']) * 100) }}%</span>
                    @endif
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                    <div class="bg-orange-400 h-1.5 rounded-full" style="width: {{ min(100, ($stats['gula_consumed'] / $stats['gula_limit']) * 100) }}%"></div>
                </div>
                <p class="text-[10px] text-gray-400 mt-1">Maks {{ $stats['gula_limit'] }}g/hari</p>
            </div>

            {{-- Card Garam --}}
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                <p class="text-xs text-gray-400 font-bold uppercase">Garam</p>
                <div class="mt-2 flex items-end justify-between">
                    <span class="text-xl font-bold text-hg-dark">{{ round($stats['garam_consumed']) }}<span class="text-xs font-normal text-gray-400">mg</span></span>
                    
                    @if(($stats['garam_consumed'] / $stats['garam_limit']) * 100 > 100)
                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    @else
                        <span class="text-[10px] font-bold text-blue-400">{{ round(($stats['garam_consumed'] / $stats['garam_limit']) * 100) }}%</span>
                    @endif
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                    <div class="bg-blue-400 h-1.5 rounded-full" style="width: {{ min(100, ($stats['garam_consumed'] / $stats['garam_limit']) * 100) }}%"></div>
                </div>
                <p class="text-[10px] text-gray-400 mt-1">Maks {{ number_format($stats['garam_limit']) }}mg/hari</p>
            </div>

            {{-- Card Lemak --}}
            <div class="bg-white p-4 rounded-2xl shadow-sm border border-gray-100 relative overflow-hidden">
                <p class="text-xs text-gray-400 font-bold uppercase">Lemak</p>
                <div class="mt-2 flex items-end justify-between">
                    <span class="text-xl font-bold text-hg-dark">{{ round($stats['lemak_consumed'], 1) }}<span class="text-xs font-normal text-gray-400">g</span></span>
                    
                    @if(($stats['lemak_consumed'] / $stats['lemak_limit']) * 100 > 100)
                        <svg class="w-4 h-4 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    @else
                        <span class="text-[10px] font-bold text-yellow-400">{{ round(($stats['lemak_consumed'] / $stats['lemak_limit']) * 100) }}%</span>
                    @endif
                </div>
                <div class="w-full bg-gray-100 rounded-full h-1.5 mt-2">
                    <div class="bg-yellow-400 h-1.5 rounded-full" style="width: {{ min(100, ($stats['lemak_consumed'] / $stats['lemak_limit']) * 100) }}%"></div>
                </div>
                <p class="text-[10px] text-gray-400 mt-1">Maks {{ $stats['lemak_limit'] }}g/hari</p>
            </div>
        </div>

        {{-- 4. RECENT HISTORY --}}
        <div>
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-hg-dark text-lg">Terakhir Discan</h3>
                <a href="{{ route('history') }}" wire:navigate class="text-sm text-hg-primary font-medium">Lihat Semua</a>
            </div>

            <div class="bg-white rounded-3xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="divide-y divide-gray-100">
                    @forelse($recentScans as $scan)
                        {{-- CLICKABLE ROW --}}
                        <div 
                            class="p-4 flex items-center gap-4 hover:bg-gray-50 transition cursor-pointer active:scale-[0.98] duration-150"
                            @click="Livewire.navigate('{{ route('scan.detail', ['id' => $scan->food->id]) }}')"
                        >
                            {{-- Grade --}}
                            @php
                                $grade = $scan->food->grade ?? '-';
                                $bgClass = match($grade) {
                                    'A' => 'bg-green-100 text-green-700',
                                    'B' => 'bg-lime-100 text-lime-700',
                                    'C' => 'bg-orange-100 text-orange-700',
                                    'D' => 'bg-red-100 text-red-700',
                                    default => 'bg-gray-100 text-gray-500'
                                };
                            @endphp
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center {{ $bgClass }} font-bold text-lg shrink-0 shadow-sm">
                                {{ $grade }}
                            </div>

                            {{-- Info --}}
                            <div class="flex-1 min-w-0">
                                <h4 class="font-bold text-hg-dark truncate">{{ $scan->food->name ?? 'Produk Dihapus' }}</h4>
                                <p class="text-xs text-gray-400 truncate">{{ $scan->created_at->diffForHumans() }} • {{ floatval($scan->total_calories_intaken) }} kkal</p>
                            </div>

                            {{-- Icon Chevron --}}
                            <svg class="w-5 h-5 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                        </div>
                    @empty
                        <div class="p-8 text-center text-gray-400 text-sm">
                            Belum ada riwayat.
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    {{-- 5. BOTTOM NAVIGATION BAR (PWA Style - Fixed) --}}
    <div class="fixed bottom-0 w-full bg-white border-t border-gray-100 px-6 py-3 pb-safe z-50 shadow-[0_-4px_20px_rgba(0,0,0,0.03)] ">
        <div class="flex justify-between items-center max-w-lg mx-auto relative">
            
            {{-- Home (Active) --}}
            <a href="{{ route('dashboard') }}" wire:navigate class="flex flex-col items-center gap-1 text-hg-primary">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.1L1 12h3v9h7v-6h2v6h7v-9h3L12 2.1zm0 2.69l6 5.4V19h-3v-6H9v6H6v-8.81l6-5.4z"/></svg>
                <span class="text-[10px] font-bold">Home</span>
            </a>

            {{-- History --}}
            <a href="{{ route('history') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-hg-dark transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-[10px] font-medium">Riwayat</span>
            </a>

            {{-- SCAN BUTTON (Center Floating) --}}
            <div class="relative -top-8">
                <a href="{{ route('scan.barcode') }}" wire:navigate class="flex items-center justify-center w-16 h-16 bg-hg-dark rounded-full text-white shadow-xl shadow-hg-primary/40 border-4 border-hg-light hover:scale-105 transition transform active:scale-95">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </a>
            </div>

            {{-- AI Assistant --}}
            <a href="{{ route('assistant') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-hg-dark transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                <span class="text-[10px] font-medium">Asisten</span>
            </a>

            {{-- Profile (Optional Link) --}}
            <a href="{{ route('profile') }}" class="flex flex-col items-center gap-1 text-gray-400 hover:text-hg-dark transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span class="text-[10px] font-medium">Profil</span>
            </a>

        </div>
    </div>

</div>