<div class="min-h-screen bg-hg-light pb-28">
    
    {{-- 1. TOP HEADER (Sticky) --}}
    <div class="bg-white px-4 py-4 sticky top-0 z-30 shadow-sm flex items-center gap-3">
        <a href="{{ route('history') }}" wire:navigate class="p-2 -ml-2 rounded-full hover:bg-gray-50 text-gray-500 transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <h1 class="text-lg font-bold text-hg-dark truncate">Detail Produk</h1>
    </div>

    <div class="px-4 py-6 space-y-6">
        
        {{-- 2. PRODUCT CARD (Image & Grade) --}}
        <div class="bg-white rounded-[2rem] p-6 shadow-sm border border-gray-100 relative overflow-hidden">
            <div class="flex flex-col items-center">
                {{-- Image --}}
                <div class="w-32 h-32 mb-6 relative">
                    @if($food->image_url)
                        <img src="{{ $food->image_url }}" alt="{{ $food->name }}" class="w-full h-full object-contain drop-shadow-md">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-50 rounded-2xl text-gray-300">
                            <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        </div>
                    @endif
                </div>

                {{-- Name & Brand --}}
                <h2 class="text-2xl font-bold text-hg-dark text-center leading-tight mb-1">{{ $food->name }}</h2>
                <p class="text-gray-400 text-sm font-medium mb-6">{{ $food->brand ?? 'Tanpa Merk' }}</p>

                {{-- Grade Badge (Large) --}}
                @php
                    $gradeColor = match($food->grade) {
                        'A' => ['bg' => 'bg-green-100 text-green-700 border-green-200', 'label' => 'Sangat Sehat'],
                        'B' => ['bg' => 'bg-lime-100 text-lime-700 border-lime-200', 'label' => 'Sehat'],
                        'C' => ['bg' => 'bg-orange-100 text-orange-700 border-orange-200', 'label' => 'Cukup'],
                        'D' => ['bg' => 'bg-red-100 text-red-700 border-red-200', 'label' => 'Kurang Sehat'],
                        default => ['bg' => 'bg-gray-100 text-gray-500 border-gray-200', 'label' => 'Belum Dinilai'],
                    };
                @endphp
                <div class="flex items-center gap-3 px-5 py-3 rounded-2xl border {{ $gradeColor['bg'] }}">
                    <span class="text-3xl font-black">{{ $food->grade ?? '?' }}</span>
                    <div class="h-8 w-px bg-current opacity-20"></div>
                    <span class="text-sm font-bold uppercase tracking-wider">{{ $gradeColor['label'] }}</span>
                </div>
            </div>
        </div>

        {{-- 3. NUTRITION GRID --}}
        <div>
            <h3 class="font-bold text-hg-dark text-lg mb-3 px-2">Informasi Nilai Gizi</h3>
            <div class="grid grid-cols-2 gap-3">
                {{-- Kalori --}}
                <div class="p-4 rounded-2xl bg-white border border-gray-100 shadow-sm text-center">
                    <p class="text-xs text-gray-400 mb-1 font-medium uppercase">Kalori</p>
                    <p class="text-xl font-bold text-hg-dark">{{ floatval($food->calories) }}</p>
                    <p class="text-[10px] text-gray-400">kkal</p>
                </div>

                {{-- Gula --}}
                <div class="p-4 rounded-2xl bg-white border {{ $food->sugar_g > 10 ? 'border-red-200 bg-red-50' : 'border-gray-100' }} shadow-sm text-center">
                    <p class="text-xs {{ $food->sugar_g > 10 ? 'text-red-500' : 'text-gray-400' }} mb-1 font-medium uppercase">Gula</p>
                    <p class="text-xl font-bold {{ $food->sugar_g > 10 ? 'text-red-600' : 'text-hg-dark' }}">{{ floatval($food->sugar_g) }}</p>
                    <p class="text-[10px] text-gray-400">gram</p>
                </div>

                {{-- Lemak --}}
                <div class="p-4 rounded-2xl bg-white border border-gray-100 shadow-sm text-center">
                    <p class="text-xs text-gray-400 mb-1 font-medium uppercase">Lemak</p>
                    <p class="text-xl font-bold text-hg-dark">{{ floatval($food->fat_total_g) }}</p>
                    <p class="text-[10px] text-gray-400">gram</p>
                </div>

                {{-- Garam --}}
                <div class="p-4 rounded-2xl bg-white border {{ $food->salt_mg > 400 ? 'border-red-200 bg-red-50' : 'border-gray-100' }} shadow-sm text-center">
                    <p class="text-xs {{ $food->salt_mg > 400 ? 'text-red-500' : 'text-gray-400' }} mb-1 font-medium uppercase">Garam</p>
                    <p class="text-xl font-bold {{ $food->salt_mg > 400 ? 'text-red-600' : 'text-hg-dark' }}">{{ floatval($food->salt_mg) }}</p>
                    <p class="text-[10px] text-gray-400">mg</p>
                </div>
            </div>
            <p class="text-xs text-center text-gray-400 mt-3">Per sajian: {{ $food->serving_size ?? '1 porsi' }}</p>
        </div>

        {{-- 4. AI CONSULTANT --}}
        <div class="bg-gradient-to-br from-hg-primary/10 to-hg-secondary/5 rounded-[2rem] p-5 border border-hg-primary/10">
            <div class="flex items-center gap-3 mb-4">
                <div class="w-10 h-10 bg-white text-hg-primary rounded-xl flex items-center justify-center shadow-sm">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.384-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>
                </div>
                <div>
                    <h3 class="font-bold text-hg-dark">Tanya AI</h3>
                    <p class="text-xs text-gray-500">Aman untuk dietmu?</p>
                </div>
            </div>

            @if($aiResponse)
                <div class="bg-white p-4 rounded-2xl text-hg-dark text-sm leading-relaxed border border-gray-100 shadow-sm mb-4 animate-fade-in-up">
                    {!! nl2br(e($aiResponse)) !!}
                </div>
            @elseif($chatHistory && $chatHistory->count() > 0)
                 <div class="bg-white p-4 rounded-2xl text-hg-dark text-sm leading-relaxed border border-gray-100 shadow-sm mb-4">
                    <span class="text-xs font-bold text-gray-400 uppercase">Analisis Terakhir</span>
                    <p class="mt-1">{{ $chatHistory->first()->ai_response }}</p>
                </div>
            @endif

            <form wire:submit="askAi" class="relative">
                <input 
                    type="text" 
                    wire:model="userPrompt" 
                    placeholder="Ketik pertanyaan..." 
                    class="w-full pl-4 pr-12 py-3 bg-white border border-gray-200 rounded-xl focus:ring-2 focus:ring-hg-primary focus:border-hg-primary text-sm shadow-sm transition"
                >
                <button type="submit" wire:loading.attr="disabled" class="absolute right-2 top-2 p-1.5 bg-hg-dark text-white rounded-lg hover:bg-hg-primary transition disabled:opacity-50 shadow-md">
                    <svg wire:loading.remove class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    <svg wire:loading class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                </button>
            </form>
        </div>

    </div>

    {{-- 5. BOTTOM NAVIGATION BAR (Fixed) --}}
    <div class="fixed bottom-0 w-full bg-white border-t border-gray-100 px-6 py-3 pb-safe z-50 shadow-[0_-4px_20px_rgba(0,0,0,0.03)] rounded-t-[2rem]">
        <div class="flex justify-between items-center max-w-lg mx-auto relative">
            
            {{-- Home --}}
            <a href="{{ route('dashboard') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-hg-dark transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-[10px] font-medium">Home</span>
            </a>

            {{-- History (Active Context) --}}
            <a href="{{ route('history') }}" wire:navigate class="flex flex-col items-center gap-1 text-hg-primary">
                <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 14h-2v-2h2v2zm0-4h-2V7h2v5z"/></svg>
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