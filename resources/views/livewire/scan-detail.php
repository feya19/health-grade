<div class="max-w-4xl mx-auto pb-10">
    
    <div class="flex items-center justify-between mb-6">
        <a href="{{ route('history') }}" wire:navigate class="flex items-center text-sm text-gray-500 hover:text-hg-primary transition gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Riwayat
        </a>
        <button wire:click="delete" wire:confirm="Yakin ingin menghapus data ini?" class="text-sm text-red-500 hover:text-red-700 font-medium">
            Hapus Data
        </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <div class="md:col-span-1 space-y-6">
            <div class="aspect-square bg-white rounded-3xl border border-gray-100 shadow-sm flex items-center justify-center p-8 relative overflow-hidden">
                <div class="absolute inset-0 bg-gradient-to-tr from-gray-50 to-transparent"></div>
                <svg class="w-32 h-32 text-gray-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            </div>

            @php
                $gradeColor = match($product['grade']) {
                    'A' => ['bg' => 'bg-green-600', 'text' => 'text-green-600', 'label' => 'Sangat Sehat'],
                    'B' => ['bg' => 'bg-lime-500', 'text' => 'text-lime-500', 'label' => 'Sehat'],
                    'C' => ['bg' => 'bg-orange-500', 'text' => 'text-orange-500', 'label' => 'Cukup'],
                    'D' => ['bg' => 'bg-red-600', 'text' => 'text-red-600', 'label' => 'Kurang Sehat'],
                    default => ['bg' => 'bg-gray-400', 'text' => 'text-gray-400', 'label' => 'Unknown'],
                };
            @endphp
            
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 {{ $gradeColor['bg'] }}"></div>
                <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-2">Nutri-Grade</p>
                <div class="flex items-center justify-center gap-2">
                    <span class="text-6xl font-black {{ $gradeColor['text'] }}">{{ $product['grade'] }}</span>
                </div>
                <p class="mt-2 font-medium {{ $gradeColor['text'] }}">{{ $gradeColor['label'] }}</p>
            </div>
        </div>

        <div class="md:col-span-2 space-y-6">
            
            <div>
                <h1 class="text-3xl font-bold text-hg-dark mb-1">{{ $product['name'] }}</h1>
                <p class="text-gray-500 flex items-center gap-2">
                    <span>{{ $product['brand'] }}</span>
                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                    <span>Scanned: {{ $product['date_scanned'] }}</span>
                </p>
            </div>

            <div class="bg-gradient-to-br from-hg-primary/5 to-hg-secondary/10 rounded-2xl p-6 border border-hg-primary/10 relative">
                <div class="flex gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-hg-primary text-white rounded-full flex items-center justify-center shadow-lg shadow-hg-primary/20">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                    </div>
                    <div>
                        <h3 class="font-bold text-hg-dark mb-1">Analisis Asisten AI</h3>
                        <div class="text-gray-600 text-sm leading-relaxed prose-sm">
                            {!! Str::markdown($product['ai_analysis']) !!}
                        </div>
                    </div>
                </div>
            </div>

            <h3 class="font-bold text-hg-dark text-lg mt-8">Informasi Nilai Gizi</h3>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                
                <div class="p-4 rounded-2xl bg-white border border-gray-100 shadow-sm text-center">
                    <p class="text-xs text-gray-400 mb-1">Kalori</p>
                    <p class="text-xl font-bold text-gray-800">{{ $product['nutrition']['calories'] }}</p>
                    <p class="text-[10px] text-gray-400">kkal</p>
                </div>

                <div class="p-4 rounded-2xl bg-white border {{ $product['nutrition']['sugar'] > 10 ? 'border-red-200 bg-red-50' : 'border-gray-100' }} shadow-sm text-center">
                    <p class="text-xs {{ $product['nutrition']['sugar'] > 10 ? 'text-red-500' : 'text-gray-400' }} mb-1">Gula</p>
                    <p class="text-xl font-bold {{ $product['nutrition']['sugar'] > 10 ? 'text-red-600' : 'text-gray-800' }}">{{ $product['nutrition']['sugar'] }}</p>
                    <p class="text-[10px] text-gray-400">gram</p>
                </div>

                <div class="p-4 rounded-2xl bg-white border border-gray-100 shadow-sm text-center">
                    <p class="text-xs text-gray-400 mb-1">Lemak</p>
                    <p class="text-xl font-bold text-gray-800">{{ $product['nutrition']['fat'] }}</p>
                    <p class="text-[10px] text-gray-400">gram</p>
                </div>

                 <div class="p-4 rounded-2xl bg-white border border-gray-100 shadow-sm text-center">
                    <p class="text-xs text-gray-400 mb-1">Garam</p>
                    <p class="text-xl font-bold text-gray-800">{{ $product['nutrition']['salt'] }}</p>
                    <p class="text-[10px] text-gray-400">mg</p>
                </div>
            </div>

            <div class="bg-gray-50 rounded-2xl p-5 text-sm text-gray-500 mt-4">
                <p><strong>Barcode:</strong> {{ $product['barcode'] }}</p>
                <p class="mt-1">Data nutrisi di atas dihitung per sajian (serving size). Pastikan Anda menyesuaikan dengan jumlah yang Anda konsumsi.</p>
            </div>

        </div>
    </div>
</div>