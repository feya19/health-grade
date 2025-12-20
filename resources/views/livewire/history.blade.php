<div class="min-h-screen bg-white pb-28">
    
    {{-- 1. TOP HEADER (Mobile Style) --}}
    <div class="bg-white px-6 pt-8 pb-4  shadow-sm sticky top-0 z-30 mb-6">
        <div class="flex items-center justify-between mb-4">
            <h1 class="text-2xl font-bold text-hg-dark">Riwayat Scan</h1>
            <div class="w-10 h-10 rounded-full bg-gray-100 border-2 border-white shadow-sm overflow-hidden">
                <svg class="w-full h-full text-gray-400 p-1" fill="currentColor" viewBox="0 0 24 24"><path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
            </div>
        </div>

        {{-- Search & Filter Bar (Sticky) --}}
        <div class="flex gap-2">
            <div class="relative flex-1">
                <input 
                    wire:model.live.debounce.300ms="search" 
                    type="text" 
                    placeholder="Cari..." 
                    class="w-full pl-9 pr-4 py-2.5 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-hg-primary/20 focus:border-hg-primary outline-none transition text-sm"
                >
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <select wire:model.live="filterGrade" class="px-3 py-2.5 bg-gray-50 border border-gray-100 rounded-xl focus:ring-2 focus:ring-hg-primary/20 focus:border-hg-primary outline-none text-sm font-medium text-gray-600">
                <option value="all">Semua</option>
                <option value="A">Grade A</option>
                <option value="B">Grade B</option>
                <option value="C">Grade C</option>
                <option value="D">Grade D</option>
            </select>
        </div>
    </div>

    {{-- 2. LIST CONTENT --}}
    <div class="px-4 space-y-3">
        @forelse ($history as $item)
            <a href="{{ route('scan.detail', ['id' => $item->food->id]) }}" 
               wire:navigate
               class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm active:scale-[0.98] transition-transform duration-150 flex items-center gap-4 group relative overflow-hidden"
            >
                {{-- Grade Indicator --}}
                @php
                    $bgClass = match($item->food->grade) {
                        'A' => 'bg-green-100 text-green-700',
                        'B' => 'bg-lime-100 text-lime-700',
                        'C' => 'bg-orange-100 text-orange-700',
                        'D' => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-500'
                    };
                @endphp
                <div class="w-12 h-12 rounded-xl flex items-center justify-center font-bold text-lg shrink-0 relative z-10 {{ $bgClass }}">
                    {{ $item->food->grade }}
                </div>

                {{-- Product Info --}}
                <div class="flex-1 min-w-0 relative z-10">
                    <h3 class="font-bold text-hg-dark truncate text-base">
                        {{ $item->food->name }}
                    </h3>
                    <p class="text-xs text-gray-400 truncate mt-0.5">
                        {{ $item->food->brand ?? 'Tanpa Merk' }} • {{ $item->created_at->format('d M') }}
                    </p>
                </div>

                {{-- Stats --}}
                <div class="text-right relative z-10">
                    <div class="font-bold text-hg-dark text-sm">
                        {{ floatval($item->total_calories_intaken) }} <span class="text-[10px] text-gray-400 font-normal">kkal</span>
                    </div>
                    
                    @if($item->action_type === 'consumed')
                        <span class="inline-block mt-1 px-1.5 py-0.5 rounded text-[9px] font-bold bg-green-50 text-green-600 border border-green-100">
                            Dimakan
                        </span>
                    @else
                        <span class="inline-block mt-1 px-1.5 py-0.5 rounded text-[9px] font-bold bg-gray-50 text-gray-400 border border-gray-100">
                            Scan
                        </span>
                    @endif
                </div>
            </a>
        @empty
            <div class="flex flex-col items-center justify-center py-20 text-center px-6">
                <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mb-4 text-gray-300">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-10 h-10">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-hg-dark mb-1">Belum ada riwayat</h3>
                <p class="text-sm text-gray-400">Scan makanan pertamamu untuk mulai melacak nutrisi.</p>
                <a href="{{ route('scan.barcode') }}" wire:navigate class="mt-6 px-6 py-2.5 bg-hg-primary text-white text-sm font-bold rounded-xl shadow-lg shadow-hg-primary/30">
                    Scan Sekarang
                </a>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="mt-6 px-4 mb-4">
        {{ $history->links() }} 
    </div>

    {{-- 3. BOTTOM NAVIGATION BAR (Fixed) --}}
    <div class="fixed bottom-0 w-full bg-white border-t border-gray-100 px-6 py-3 pb-safe z-50 shadow-[0_-4px_20px_rgba(0,0,0,0.03)] ">
        <div class="flex justify-between items-center max-w-lg mx-auto relative">
            
            {{-- Home --}}
            <a href="{{ route('dashboard') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-hg-dark transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-[10px] font-medium">Home</span>
            </a>

            {{-- History (Active) --}}
            <a href="{{ route('history') }}" wire:navigate class="flex flex-col items-center gap-1 text-hg-primary">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 14h-2v-2h2v2zm0-4h-2V7h2v5z"/></svg> {{-- Icon berbeda untuk active state --}}
                <span class="text-[10px] font-bold">Riwayat</span>
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

            {{-- Profile --}}
            <a href="{{ route('profile') }}" class="flex flex-col items-center gap-1 text-gray-400 hover:text-hg-dark transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span class="text-[10px] font-medium">Profil</span>
            </a>

        </div>
    </div>

</div>