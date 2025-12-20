<div class="min-h-screen pt-24 pb-12 px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto">
    
    {{-- HEADER --}}
    <div class="flex flex-col md:flex-row justify-between items-end md:items-center gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-hg-dark">Riwayat Scan</h1>
            <p class="text-gray-500 text-sm mt-1">Daftar makanan yang telah Anda scan atau konsumsi.</p>
        </div>

        <div class="flex gap-2 w-full md:w-auto">
            <div class="relative w-full md:w-64">
                <input 
                    wire:model.live.debounce.300ms="search" 
                    type="text" 
                    placeholder="Cari makanan..." 
                    class="w-full pl-10 pr-4 py-2 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-hg-primary/20 focus:border-hg-primary outline-none transition"
                >
                <svg class="w-5 h-5 text-gray-400 absolute left-3 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </div>

            <select wire:model.live="filterGrade" class="px-4 py-2 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-hg-primary/20 focus:border-hg-primary outline-none cursor-pointer">
                <option value="all">Filter</option>
                <option value="A">Grade A</option>
                <option value="B">Grade B</option>
                <option value="C">Grade C</option>
                <option value="D">Grade D</option>
            </select>
        </div>
    </div>

    {{-- LIST CONTENT --}}
    <div class="space-y-4">
        @forelse ($history as $item)
            {{-- PERUBAHAN: Menggunakan <a> tag dengan href ke scan.detail dan wire:navigate --}}
            <a href="{{ route('scan.detail', ['id' => $item->food->id]) }}" 
               wire:navigate
               class="bg-white p-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-hg-primary/30 transition flex items-center gap-4 group block cursor-pointer relative overflow-hidden"
            >
                {{-- Efek Hover halus --}}
                <div class="absolute inset-0 bg-hg-primary/0 group-hover:bg-hg-primary/5 transition-colors duration-300"></div>

                {{-- Grade Indicator --}}
                <div class="w-12 h-12 rounded-xl flex items-center justify-center text-white font-bold text-xl shrink-0 relative z-10
                    {{ match($item->food->grade) {
                        'A' => 'bg-green-500 shadow-green-500/30',
                        'B' => 'bg-lime-500 shadow-lime-500/30',
                        'C' => 'bg-yellow-400 shadow-yellow-400/30',
                        'D' => 'bg-red-500 shadow-red-500/30',
                        default => 'bg-gray-300'
                    } }} shadow-lg">
                    {{ $item->food->grade }}
                </div>

                {{-- Product Info --}}
                <div class="flex-1 min-w-0 relative z-10">
                    <h3 class="font-bold text-hg-dark truncate text-lg group-hover:text-hg-primary transition">
                        {{ $item->food->name }}
                    </h3>
                    <p class="text-sm text-gray-400 truncate">{{ $item->food->brand ?? 'Tanpa Merk' }}</p>
                </div>

                {{-- Stats & Action --}}
                <div class="text-right flex flex-col md:flex-row items-end md:items-center gap-2 md:gap-6 relative z-10">
                    
                    <div>
                        <div class="font-bold text-hg-dark">
                            {{ floatval($item->total_calories_intaken) }} kkal
                        </div>
                        <div class="text-xs text-gray-400">
                            {{ $item->quantity }} x sajian
                        </div>
                    </div>

                    <div class="flex flex-col items-end gap-1">
                        <span class="text-xs text-gray-400">{{ $item->created_at->format('d M Y, H:i') }}</span>
                        
                        @if($item->action_type === 'consumed')
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-green-100 text-green-700">
                                Dimakan
                            </span>
                        @else
                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-gray-100 text-gray-600">
                                Scan Saja
                            </span>
                        @endif
                    </div>
                    
                    {{-- Chevron Icon (Optional: untuk memperjelas ini bisa diklik) --}}
                    <div class="hidden md:block text-gray-300 group-hover:text-hg-primary transition">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                        </svg>
                    </div>
                </div>
            </a>
        @empty
            <div class="text-center py-20">
                <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-gray-400">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                    </svg>
                </div>
                <h3 class="text-lg font-bold text-hg-dark">Tidak ada riwayat</h3>
                <p class="text-gray-500">Belum ada makanan yang discan sesuai filter ini.</p>
            </div>
        @endforelse
    </div>

    {{-- PAGINATION --}}
    <div class="mt-8">
        {{ $history->links() }} 
    </div>
</div>