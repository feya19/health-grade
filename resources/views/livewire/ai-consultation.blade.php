<div class="fixed inset-0 bg-gray-50 flex flex-col h-full" 
     x-data="{ 
        scrollToBottom() { 
            const container = document.getElementById('chat-container');
            if (container) {
                container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
            }
        } 
     }"
     x-init="setTimeout(() => scrollToBottom(), 100)"
     x-on:livewire:navigated="setTimeout(() => scrollToBottom(), 100)" 
     >

    {{-- 1. TOP HEADER (Sticky with Back Button) --}}
    <div class="bg-white px-4 py-3 border-b border-gray-100 flex items-center justify-between shrink-0 z-30">
        <div class="flex items-center gap-2">
            {{-- Tombol Back --}}
            <a href="{{ route('dashboard') }}" wire:navigate class="p-2 -ml-2 mr-1 rounded-full text-gray-500 hover:bg-gray-100 hover:text-hg-primary transition">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
                </svg>
            </a>

            {{-- Avatar AI --}}
            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-hg-primary to-hg-secondary flex items-center justify-center text-white shadow-lg shadow-hg-primary/30">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25z" />
                </svg>
            </div>
            
            {{-- Title --}}
            <div>
                <h1 class="font-bold text-hg-dark text-lg leading-tight">AI Nutritionist</h1>
                <p class="text-xs text-gray-500 flex items-center gap-1">
                    <span class="w-1.5 h-1.5 rounded-full bg-green-500 animate-pulse"></span> Online
                </p>
            </div>
        </div>

        {{-- Tombol Hapus Chat --}}
        <button wire:click="$refresh" class="text-gray-400 hover:text-hg-primary p-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
        </button>
    </div>

    {{-- 2. CHAT AREA --}}
    {{-- pb-24: Memberi ruang untuk Input Bar yang menempel di bawah --}}
    <div id="chat-container" class="flex-1 overflow-y-auto px-4 py-6 space-y-6 pb-24 scroll-smooth">
        
        {{-- Welcome Bubble --}}
        <div class="flex gap-3 max-w-3xl mx-auto">
            <div class="w-8 h-8 rounded-full bg-hg-primary/10 flex items-center justify-center text-hg-primary shrink-0 mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M9 4.5a.75.75 0 01.721.544l.813 2.846a3.75 3.75 0 002.576 2.576l2.846.813a.75.75 0 010 1.442l-2.846.813a3.75 3.75 0 00-2.576 2.576l-.813 2.846a.75.75 0 01-1.442 0l-.813-2.846a3.75 3.75 0 00-2.576-2.576l-2.846-.813a.75.75 0 010-1.442l2.846-.813a3.75 3.75 0 002.576-2.576l.813-2.846A.75.75 0 019 4.5zM6.97 15.03a.75.75 0 10-1.06 1.06l.75.75-.75.75a.75.75 0 101.06 1.06l.75-.75.75.75a.75.75 0 101.06-1.06l-.75-.75.75-.75a.75.75 0 10-1.06-1.06l-.75.75-.75-.75z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="space-y-1 max-w-[85%]">
                <div class="bg-white border border-gray-100 p-3.5 rounded-2xl rounded-tl-none shadow-sm text-hg-dark text-sm leading-relaxed">
                    Halo! Saya HealthGrade AI. 👋 <br>
                    Tanyakan tentang kalori makanan atau tips diet sehat.
                </div>
            </div>
        </div>

        @foreach($chatHistory as $chat)
            {{-- User Bubble --}}
            <div class="flex flex-row-reverse gap-3 max-w-3xl mx-auto group">
                <div class="space-y-1 text-right max-w-[85%]">
                    <div class="bg-hg-dark text-white px-4 py-3 rounded-2xl rounded-tr-none shadow-md text-sm leading-relaxed text-left inline-block">
                        {{ $chat->user_prompt }}
                    </div>
                    <div class="text-[10px] text-gray-400 pr-1">{{ $chat->created_at->format('H:i') }}</div>
                </div>
            </div>

            {{-- AI Bubble --}}
            <div class="flex gap-3 max-w-3xl mx-auto">
                <div class="w-8 h-8 rounded-full bg-hg-primary/10 flex items-center justify-center text-hg-primary shrink-0 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M9 4.5a.75.75 0 01.721.544l.813 2.846a3.75 3.75 0 002.576 2.576l2.846.813a.75.75 0 010 1.442l-2.846.813a3.75 3.75 0 00-2.576 2.576l-.813 2.846a.75.75 0 01-1.442 0l-.813-2.846a3.75 3.75 0 00-2.576-2.576l-2.846-.813a.75.75 0 010-1.442l2.846-.813a3.75 3.75 0 002.576-2.576l.813-2.846A.75.75 0 019 4.5zM6.97 15.03a.75.75 0 10-1.06 1.06l.75.75-.75.75a.75.75 0 101.06 1.06l.75-.75.75.75a.75.75 0 101.06-1.06l-.75-.75.75-.75a.75.75 0 10-1.06-1.06l-.75.75-.75-.75z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="space-y-1 max-w-[90%]">
                    <div class="bg-white border border-gray-100 px-4 py-3 rounded-2xl rounded-tl-none shadow-sm text-hg-dark text-sm leading-relaxed prose prose-sm">
                        {!! nl2br(e($chat->ai_response)) !!}
                    </div>
                </div>
            </div>
        @endforeach

        {{-- Loading Indicator --}}
        <div wire:loading wire:target="sendMessage" class="flex gap-3 max-w-3xl mx-auto">
            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse"></div>
            </div>
            <div class="bg-white border border-gray-100 px-4 py-3 rounded-2xl rounded-tl-none shadow-sm flex items-center gap-1.5 w-fit">
                <span class="w-1.5 h-1.5 bg-hg-primary rounded-full animate-bounce"></span>
                <span class="w-1.5 h-1.5 bg-hg-primary rounded-full animate-bounce delay-75"></span>
                <span class="w-1.5 h-1.5 bg-hg-primary rounded-full animate-bounce delay-150"></span>
            </div>
        </div>

    </div>

    {{-- 3. INPUT AREA (Attached to Bottom) --}}
    {{-- Menggunakan background putih penuh di bawah agar terlihat seperti keyboard tray --}}
    <div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-100 px-4 py-3 pb-safe z-40">
        <div class="max-w-3xl mx-auto">
            <form wire:submit="sendMessage" class="relative flex items-center gap-2 bg-gray-100 p-1.5 rounded-3xl border border-transparent focus-within:border-hg-primary/30 focus-within:bg-white focus-within:shadow-md transition-all">
                
                {{-- Input Field --}}
                <input 
                    type="text" 
                    wire:model="prompt"
                    placeholder="Ketik pesan..." 
                    class="w-full bg-transparent border-none focus:ring-0 text-hg-dark placeholder-gray-400 pl-4 py-2 text-sm"
                    @keydown.enter="$wire.sendMessage(); setTimeout(() => scrollToBottom(), 100);"
                    autocomplete="off"
                >
                
                {{-- Tombol Send --}}
                <button 
                    type="submit" 
                    class="p-2.5 bg-hg-dark text-white rounded-full hover:bg-hg-primary transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed shrink-0"
                    wire:loading.attr="disabled"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                    </svg>
                </button>
            </form>
            <p class="text-center text-[10px] text-gray-400 mt-2">
                HealthGrade AI bisa salah. Cek dengan ahli medis.
            </p>
        </div>
    </div>

</div>