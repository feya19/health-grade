<div class="max-w-4xl mx-auto pb-24 px-4 sm:px-6">
    
    <!-- {{-- 1. HEADER & NAVIGASI --}} -->
    <div class="flex items-center justify-between mb-6 pt-6">
        <a href="{{ route('history') }}" wire:navigate class="flex items-center text-sm text-gray-500 hover:text-hg-primary transition gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali ke Riwayat
        </a>
        
        <!-- {{-- Opsi Hapus dihapus untuk keamanan master data, atau bisa diganti "Hapus dari Favorit" --}} -->
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        
        <!-- {{-- 2. KOLOM KIRI: GAMBAR & GRADE --}} -->
        <div class="md:col-span-1 space-y-6">
            <div class="aspect-square bg-white rounded-3xl border border-gray-100 shadow-sm flex items-center justify-center p-4 relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-tr from-gray-50 to-transparent"></div>
                
                @if($food->image_url)
                    <img src="{{ $food->image_url }}" alt="{{ $food->name }}" class="w-full h-full object-contain relative z-10 transition group-hover:scale-105">
                @else
                    <svg class="w-32 h-32 text-gray-300 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                @endif
            </div>

            @php
                $gradeColor = match($food->grade) {
                    'A' => ['bg' => 'bg-green-600', 'text' => 'text-green-600', 'label' => 'Sangat Sehat'],
                    'B' => ['bg' => 'bg-lime-500', 'text' => 'text-lime-500', 'label' => 'Sehat'],
                    'C' => ['bg' => 'bg-orange-500', 'text' => 'text-orange-500', 'label' => 'Cukup'],
                    'D' => ['bg' => 'bg-red-600', 'text' => 'text-red-600', 'label' => 'Kurang Sehat'],
                    default => ['bg' => 'bg-gray-400', 'text' => 'text-gray-400', 'label' => 'Belum Dinilai'],
                };
            @endphp
            
            <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-sm text-center relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-2 {{ $gradeColor['bg'] }}"></div>
                <p class="text-xs text-gray-400 uppercase tracking-widest font-semibold mb-2">Nutri-Grade</p>
                <div class="flex items-center justify-center gap-2">
                    <span class="text-6xl font-black {{ $gradeColor['text'] }}">{{ $food->grade ?? '?' }}</span>
                </div>
                <p class="mt-2 font-medium {{ $gradeColor['text'] }}">{{ $gradeColor['label'] }}</p>
            </div>
        </div>

        <!-- {{-- 3. KOLOM KANAN: DETAIL & ACTION --}} -->
        <div class="md:col-span-2 space-y-8">
            
            <!-- {{-- Info Produk --}} -->
            <div>
                <h1 class="text-3xl font-bold text-hg-dark mb-2">{{ $food->name }}</h1>
                <p class="text-gray-500 flex items-center gap-2 text-sm">
                    <span class="font-semibold bg-gray-100 px-2 py-1 rounded">{{ $food->brand ?? 'Tanpa Merk' }}</span>
                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                    <span>{{ $food->serving_size ?? 'Per Sajian' }}</span>
                    <span class="w-1 h-1 bg-gray-300 rounded-full"></span>
                    <span>Barcode: {{ $food->barcode }}</span>
                </p>
            </div>

            <!-- {{-- ACTION: CATAT MAKAN (Penting untuk Tracker Kalori) --}} -->
            {{-- <div class="bg-white p-6 rounded-2xl border border-hg-primary/20 shadow-sm flex flex-col sm:flex-row items-center justify-between gap-4">
                <div>
                    <h3 class="font-bold text-hg-dark">Catat Konsumsi</h3>
                    <p class="text-xs text-gray-500">Masukkan ke perhitungan harian</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="flex items-center border border-gray-200 rounded-lg overflow-hidden">
                        <button wire:click="$decrement('quantity')" class="px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600">-</button>
                        <input type="number" wire:model="quantity" class="w-12 text-center border-none focus:ring-0 text-hg-dark font-bold p-0">
                        <button wire:click="$increment('quantity')" class="px-3 py-2 bg-gray-50 hover:bg-gray-100 text-gray-600">+</button>
                    </div>
                    <button wire:click="consume" class="bg-hg-primary hover:bg-hg-secondary text-white px-6 py-2.5 rounded-xl font-bold shadow-lg shadow-hg-primary/20 transition flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                        Makan
                    </button>
                </div>
            </div> --}}

            <!-- {{-- INFORMASI NILAI GIZI --}} -->
            <div>
                <h3 class="font-bold text-hg-dark text-lg mb-4">Informasi Nilai Gizi</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    
                    <!-- {{-- Kalori --}} -->
                    <div class="p-4 rounded-2xl bg-white border border-gray-100 shadow-sm text-center group hover:border-hg-primary/30 transition">
                        <p class="text-xs text-gray-400 mb-1">Kalori</p>
                        <p class="text-xl font-bold text-gray-800">{{ floatval($food->calories) }}</p>
                        <p class="text-[10px] text-gray-400">kkal</p>
                    </div>

                    <!-- {{-- Gula --}} -->
                    <div class="p-4 rounded-2xl bg-white border {{ $food->sugar_g > 10 ? 'border-red-200 bg-red-50' : 'border-gray-100' }} shadow-sm text-center">
                        <p class="text-xs {{ $food->sugar_g > 10 ? 'text-red-500' : 'text-gray-400' }} mb-1">Gula</p>
                        <p class="text-xl font-bold {{ $food->sugar_g > 10 ? 'text-red-600' : 'text-gray-800' }}">{{ floatval($food->sugar_g) }}</p>
                        <p class="text-[10px] text-gray-400">gram</p>
                    </div>

                    <!-- {{-- Lemak --}} -->
                    <div class="p-4 rounded-2xl bg-white border border-gray-100 shadow-sm text-center">
                        <p class="text-xs text-gray-400 mb-1">Lemak Total</p>
                        <p class="text-xl font-bold text-gray-800">{{ floatval($food->fat_total_g) }}</p>
                        <p class="text-[10px] text-gray-400">gram</p>
                    </div>

                    <!-- {{-- Garam --}} -->
                     <div class="p-4 rounded-2xl bg-white border {{ $food->salt_mg > 400 ? 'border-red-200 bg-red-50' : 'border-gray-100' }} shadow-sm text-center">
                        <p class="text-xs {{ $food->salt_mg > 400 ? 'text-red-500' : 'text-gray-400' }} mb-1">Garam</p>
                        <p class="text-xl font-bold {{ $food->salt_mg > 400 ? 'text-red-600' : 'text-gray-800' }}">{{ floatval($food->salt_mg) }}</p>
                        <p class="text-[10px] text-gray-400">mg</p>
                    </div>
                </div>
            </div>

            <!-- {{-- AI ASSISTANT SECTION (Dynamic) --}} -->
            <div class="bg-gradient-to-br from-hg-primary/5 to-hg-secondary/10 rounded-3xl p-6 border border-hg-primary/10 relative overflow-hidden">
                <div class="relative z-10">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-8 h-8 bg-hg-primary text-white rounded-full flex items-center justify-center shadow-md">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                        </div>
                        <h3 class="font-bold text-hg-dark">Konsultasi AI</h3>
                    </div>

                    <!-- {{-- Tampilkan Chat Terakhir / Response --}} -->
                    @if($aiResponse)
                        <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl text-hg-dark text-sm leading-relaxed border border-white/50 mb-4 animate-fade-in-up">
                            {!! nl2br(e($aiResponse)) !!}
                        </div>
                    @elseif($chatHistory && $chatHistory->count() > 0)
                         <div class="bg-white/80 backdrop-blur-sm p-4 rounded-xl text-hg-dark text-sm leading-relaxed border border-white/50 mb-4">
                            <strong>Analisis Terakhir:</strong> <br>
                            {{ $chatHistory->first()->ai_response }}
                        </div>
                    @else
                        <p class="text-sm text-gray-500 mb-4">
                            Ragu dengan produk ini? Tanyakan pada AI apakah ini aman untuk diet Anda.
                        </p>
                    @endif

                    <!-- {{-- Input Form AI --}} -->
                    <form wire:submit="askAi" class="relative">
                        <input 
                            type="text" 
                            wire:model="userPrompt" 
                            placeholder="Contoh: Aman gak buat diet keto?" 
                            class="w-full pl-4 pr-12 py-3 bg-white border border-hg-primary/20 rounded-xl focus:ring-2 focus:ring-hg-primary focus:border-hg-primary text-sm shadow-sm"
                        >
                        <button type="submit" wire:loading.attr="disabled" class="absolute right-2 top-2 p-1.5 bg-hg-dark text-white rounded-lg hover:bg-hg-primary transition disabled:opacity-50">
                            <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            <svg wire:loading class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>