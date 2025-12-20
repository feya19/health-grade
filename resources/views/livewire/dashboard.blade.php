<div class="max-w-6xl mx-auto space-y-8 py-8 px-4 sm:px-6">
    
    {{-- 1. HEADER --}}
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-hg-dark">Selamat Datang, {{ auth()->user()->name ?? 'User' }}! 👋</h1>
            <p class="text-gray-500">Berikut adalah ringkasan nutrisi harian Anda.</p>
        </div>
        {{-- Pastikan route 'scan' atau 'scan.barcode' sesuai dengan routes.php Anda --}}
        <a href="{{ route('scan.barcode') }}" wire:navigate class="flex items-center gap-2 bg-hg-primary hover:bg-hg-secondary text-white px-5 py-2.5 rounded-xl font-medium transition shadow-lg shadow-hg-primary/20">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
            Scan Produk Baru
        </a>
    </div>

    {{-- 2. STATS GRID (GULA & LEMAK) --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        
        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden group hover:border-hg-primary/30 transition-all">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <svg class="w-20 h-20 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
            </div>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Konsumsi Gula</p>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-hg-dark">{{ number_format($stats['gula_consumed']) }}g</span>
                <span class="text-sm text-gray-400">/ {{ $stats['gula_limit'] }}g</span>
            </div>
            
            @php $gulaPercent = ($stats['gula_consumed'] / $stats['gula_limit']) * 100; @endphp
            <div class="w-full bg-gray-100 rounded-full h-2 mt-4">
                <div class="{{ $gulaPercent > 100 ? 'bg-red-500' : 'bg-orange-400' }} h-2 rounded-full transition-all duration-1000" style="width: {{ min(100, $gulaPercent) }}%"></div>
            </div>
            
            @if($gulaPercent > 100)
                <p class="text-xs text-red-500 mt-2 font-medium">Melebihi batas ({{ round($gulaPercent) }}%)</p>
            @else
                <p class="text-xs text-orange-600 mt-2 font-medium">Terisi {{ round($gulaPercent) }}% batas harian</p>
            @endif
        </div>

        <div class="bg-white p-6 rounded-2xl border border-gray-100 shadow-sm relative overflow-hidden group hover:border-hg-primary/30 transition-all">
            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition">
                <svg class="w-20 h-20 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <p class="text-sm font-semibold text-gray-500 uppercase tracking-wide">Konsumsi Lemak</p>
            <div class="mt-2 flex items-baseline gap-2">
                <span class="text-3xl font-bold text-hg-dark">{{ number_format($stats['lemak_consumed']) }}g</span>
                <span class="text-sm text-gray-400">/ {{ $stats['lemak_limit'] }}g</span>
            </div>
            
            @php $lemakPercent = ($stats['lemak_consumed'] / $stats['lemak_limit']) * 100; @endphp
            <div class="w-full bg-gray-100 rounded-full h-2 mt-4">
                <div class="{{ $lemakPercent > 100 ? 'bg-red-500' : 'bg-yellow-400' }} h-2 rounded-full transition-all duration-1000" style="width: {{ min(100, $lemakPercent) }}%"></div>
            </div>
             
            @if($lemakPercent > 100)
                <p class="text-xs text-red-500 mt-2 font-medium">Melebihi batas ({{ round($lemakPercent) }}%)</p>
            @else
                <p class="text-xs text-green-600 mt-2 font-medium">Terisi {{ round($lemakPercent) }}% batas harian</p>
            @endif
        </div>

        <div class="bg-gradient-to-br from-hg-primary to-hg-secondary p-6 rounded-2xl shadow-lg text-white relative overflow-hidden">
            <div class="absolute bottom-0 right-0 -mb-4 -mr-4 opacity-20">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2a10 10 0 0 0-7.75 14.65L2 22l5.35-2.25A10 10 0 1 0 12 2z"/></svg>
            </div>
            <p class="text-sm font-medium text-white/80 uppercase tracking-wide">Total Produk Discan</p>
            <h3 class="text-4xl font-bold mt-1">{{ $stats['total_scan'] }}</h3>
            <div class="mt-4 flex items-center gap-2 bg-white/20 w-fit px-3 py-1 rounded-full backdrop-blur-sm text-xs font-medium">
                <span>Total Riwayat</span>
            </div>
        </div>
    </div>

    {{-- 3. KALORI SECTION --}}
     <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 md:p-8 relative overflow-hidden group">
         <div class="absolute top-0 right-0 -mt-4 -mr-4 w-32 h-32 bg-red-500/5 rounded-full blur-3xl group-hover:bg-red-500/10 transition-colors"></div>
         
         <div class="relative z-10 flex flex-col md:flex-row gap-8 items-center">
             
             <div class="flex-1 w-full">
                 <div class="flex items-center gap-3 mb-2">
                     <div class="p-2 bg-red-50 rounded-lg text-red-500">
                         <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path></svg>
                     </div>
                     <h3 class="font-bold text-lg text-hg-dark">Target Kalori Harian</h3>
                 </div>
                 <p class="text-gray-500 text-sm mb-6">
                     Dihitung berdasarkan profil tubuh Anda ({{ $stats['user_weight'] }}kg / {{ $stats['user_height'] }}cm). <br>
                     Jagalah asupan kalori agar tetap bertenaga namun ideal.
                 </p>
 
                 <div class="flex items-end gap-1">
                     <span class="text-4xl font-extrabold text-hg-dark">{{ number_format($stats['calories_current']) }}</span>
                     <span class="text-lg text-gray-400 font-medium mb-1">/ {{ number_format($stats['calories_target']) }} kkal</span>
                 </div>
             </div>
 
             <div class="w-full md:w-1/2">
                 <div class="flex justify-between text-sm font-medium mb-2">
                     <span class="{{ $stats['calories_current'] > $stats['calories_target'] ? 'text-red-500' : 'text-hg-primary' }}">
                         {{ round(($stats['calories_current'] / $stats['calories_target']) * 100) }}% Terpenuhi
                     </span>
                     <span class="text-gray-400">Sisa: {{ max(0, $stats['calories_target'] - $stats['calories_current']) }} kkal</span>
                 </div>
                 
                 <div class="w-full bg-gray-100 rounded-full h-4 overflow-hidden">
                     <div class="h-full rounded-full transition-all duration-1000 ease-out relative 
                         {{ $stats['calories_current'] > $stats['calories_target'] ? 'bg-red-500' : 'bg-gradient-to-r from-orange-400 to-red-500' }}" 
                         style="width: {{ min(100, ($stats['calories_current'] / $stats['calories_target']) * 100) }}%">
                         
                         <div class="absolute inset-0 bg-white/30 w-full animate-[shimmer_2s_infinite] skew-x-12 -translate-x-full"></div>
                     </div>
                 </div>
                 
                 @if($stats['calories_current'] > $stats['calories_target'])
                     <p class="text-xs text-red-500 mt-2 font-medium flex items-center gap-1">
                         <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                         Anda telah melebihi batas kalori harian.
                     </p>
                 @else
                     <p class="text-xs text-gray-400 mt-2">Tetap pantau asupan Gula & Lemak meski kalori masih aman.</p>
                 @endif
             </div>
         </div>
     </div>

    {{-- 4. RECENT SCANS TABLE --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
            <h3 class="font-bold text-hg-dark text-lg">Riwayat Scan Terakhir</h3>
            <a href="{{ route('history') }}" wire:navigate class="text-sm text-hg-primary font-medium hover:underline">Lihat Semua</a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead class="bg-gray-50/50 text-gray-500 text-xs uppercase font-semibold">
                    <tr>
                        <th class="px-6 py-4 text-center">Grade</th>
                        <th class="px-6 py-4">Produk</th>
                        <th class="px-6 py-4">Waktu</th>
                        <th class="px-6 py-4">Kalori</th>
                        {{-- <th class="px-6 py-4 text-right">Aksi</th>  <-- DIHAPUS --}}
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 text-sm">
                    @forelse($recentScans as $scan)
                    <tr class="hover:bg-gray-50/50 transition cursor-pointer group" 
                        @click="Livewire.navigate('{{ route('scan.detail', ['id' => $scan->food->id]) }}')"
                    >
                    <td class="px-6 py-4 text-center">
                        @php
                            $grade = $scan->food->grade ?? '-';
                            $badgeColor = match($grade) {
                                'A' => 'bg-green-100 text-green-700 border-green-200',
                                'B' => 'bg-lime-100 text-lime-700 border-lime-200',
                                'C' => 'bg-orange-100 text-orange-700 border-orange-200',
                                'D' => 'bg-red-100 text-red-700 border-red-200',
                                default => 'bg-gray-100 text-gray-700'
                            };
                        @endphp
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-full border {{ $badgeColor }} font-bold text-sm">
                            {{ $grade }}
                        </span>
                    </td>
                        <td class="px-6 py-4">
                                <span class="font-semibold text-gray-700 group-hover:text-hg-primary transition">{{ $scan->food->name ?? 'Produk Dihapus' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ $scan->created_at->diffForHumans() }}
                        </td>
                        <td class="px-6 py-4 text-gray-500">
                            {{ floatval($scan->total_calories_intaken) }} kkal
                        </td>
                        {{-- Kolom Aksi dihapus --}}
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-8 text-center text-gray-500">
                            Belum ada riwayat scan. Mulai hidup sehat dengan <a href="{{ route('scan.barcode') }}" class="text-hg-primary font-bold hover:underline">scan produk pertamamu!</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 5. FLOATING AI BUTTON --}}
    <div class="fixed bottom-8 right-8 z-50">
        <a href="{{ route('assistant') }}" wire:navigate 
           class="group flex items-center gap-3 bg-hg-dark text-white pl-5 pr-6 py-4 rounded-full shadow-2xl shadow-hg-dark/30 hover:shadow-hg-primary/50 hover:bg-hg-primary hover:-translate-y-1 transition-all duration-300 ease-out border border-white/10"
        >
            <div class="relative flex items-center justify-center">
                <svg class="w-6 h-6 group-hover:animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                </svg>
                
                <span class="absolute -top-1 -right-1 flex h-3 w-3">
                  <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-hg-primary opacity-75"></span>
                  <span class="relative inline-flex rounded-full h-3 w-3 bg-hg-primary"></span>
                </span>
            </div>

            <div class="text-left">
                <span class="block text-xs text-white/70 font-medium leading-none mb-0.5">Asisten</span>
                <span class="block font-bold text-sm tracking-wide leading-none">HealthGrade AI</span>
            </div>
        </a>
    </div>

</div>