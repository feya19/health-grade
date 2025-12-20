<div class="max-w-5xl mx-auto space-y-6">
    
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold text-hg-dark">Riwayat Scan</h1>
            <p class="text-gray-500 text-sm">Semua produk yang pernah Anda analisis.</p>
        </div>

        <div class="flex gap-2">
            <div class="relative">
                <input wire:model.live="search" type="text" placeholder="Cari nama produk..." class="pl-10 pr-4 py-2 rounded-xl border border-gray-200 focus:border-hg-primary focus:ring-hg-primary text-sm w-full md:w-64 transition">
                <svg class="w-4 h-4 text-gray-400 absolute left-3 top-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
            </div>

            <select wire:model.live="filterGrade" class="pl-3 pr-8 py-2 rounded-xl border border-gray-200 focus:border-hg-primary focus:ring-hg-primary text-sm bg-white transition cursor-pointer">
                <option value="all">Semua Grade</option>
                <option value="A">Grade A (Sehat)</option>
                <option value="B">Grade B</option>
                <option value="C">Grade C</option>
                <option value="D">Grade D (Kurangi)</option>
            </select>
        </div>
    </div>

    @if($history->isEmpty())
        <div class="text-center py-20 bg-white rounded-3xl border border-gray-100 border-dashed">
            <div class="inline-flex p-4 rounded-full bg-gray-50 mb-4 text-gray-400">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <p class="text-gray-500 font-medium">Tidak ada produk ditemukan.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($history as $item)
                <a href="{{ route('scan.detail', $item['id']) }}" wire:navigate class="group bg-white p-4 rounded-2xl border border-gray-100 shadow-sm hover:shadow-md hover:border-hg-primary/30 transition-all flex items-center gap-4">
                    
                    <div class="w-16 h-16 bg-gray-50 rounded-xl flex items-center justify-center flex-shrink-0 text-gray-300 group-hover:bg-hg-bg group-hover:text-hg-primary transition">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>

                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-hg-dark truncate group-hover:text-hg-primary transition">{{ $item['name'] }}</h3>
                        <p class="text-xs text-gray-400 mb-2">{{ $item['date'] }} • {{ $item['calories'] }} kkal</p>
                        
                        @php
                            $colors = match($item['grade']) {
                                'A' => 'bg-green-100 text-green-700 border-green-200',
                                'B' => 'bg-lime-100 text-lime-700 border-lime-200',
                                'C' => 'bg-orange-100 text-orange-700 border-orange-200',
                                'D' => 'bg-red-100 text-red-700 border-red-200',
                                default => 'bg-gray-100 text-gray-500'
                            };
                        @endphp
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-md text-xs font-bold border {{ $colors }}">
                            Grade {{ $item['grade'] }}
                        </span>
                    </div>

                    <div class="text-gray-300 group-hover:translate-x-1 transition-transform">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </div>
                </a>
            @endforeach
        </div>
    @endif
</div>