<div class="fixed inset-0 md:left-64 bg-gray-50 z-0 flex flex-col h-screen" 
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

    {{-- HEADER --}}
    <div class="bg-white px-6 py-4 border-b border-gray-200 flex items-center justify-between shadow-sm z-10">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-gradient-to-tr from-hg-primary to-hg-secondary flex items-center justify-center text-white shadow-lg shadow-hg-primary/30">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 3v1.5M4.5 8.25H3m18 0h-1.5M4.5 12H3m18 0h-1.5m-15 3.75H3m18 0h-1.5M8.25 19.5V21M12 3v1.5m0 15V21m3.75-18v1.5m0 15V21m-9-1.5h10.5a2.25 2.25 0 002.25-2.25V6.75a2.25 2.25 0 00-2.25-2.25H6.75A2.25 2.25 0 004.5 6.75v10.5a2.25 2.25 0 002.25 2.25z" />
                </svg>
            </div>
            <div>
                <h1 class="font-bold text-hg-dark text-lg leading-tight">AI Nutritionist</h1>
                <p class="text-xs text-gray-500 flex items-center gap-1">
                    <span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Online
                </p>
            </div>
        </div>
        <a href="{{ route('dashboard') }}" wire:navigate class="text-sm font-medium text-gray-400 hover:text-hg-dark transition">
            Kembali
        </a>
    </div>

    {{-- CHAT AREA --}}
    <div id="chat-container" class="flex-1 overflow-y-auto p-4 space-y-6 pb-32 scroll-smooth">
        
        <div class="flex gap-4 max-w-3xl mx-auto">
            <div class="w-8 h-8 rounded-full bg-hg-primary/10 flex items-center justify-center text-hg-primary shrink-0 mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M9 4.5a.75.75 0 01.721.544l.813 2.846a3.75 3.75 0 002.576 2.576l2.846.813a.75.75 0 010 1.442l-2.846.813a3.75 3.75 0 00-2.576 2.576l-.813 2.846a.75.75 0 01-1.442 0l-.813-2.846a3.75 3.75 0 00-2.576-2.576l-2.846-.813a.75.75 0 010-1.442l2.846-.813a3.75 3.75 0 002.576-2.576l.813-2.846A.75.75 0 019 4.5zM6.97 15.03a.75.75 0 10-1.06 1.06l.75.75-.75.75a.75.75 0 101.06 1.06l.75-.75.75.75a.75.75 0 101.06-1.06l-.75-.75.75-.75a.75.75 0 10-1.06-1.06l-.75.75-.75-.75z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="space-y-1">
                <div class="bg-white border border-gray-100 p-4 rounded-2xl rounded-tl-none shadow-sm text-hg-dark text-sm leading-relaxed">
                    Halo! Saya asisten pribadi HealthGrade Anda. Tanyakan saya tentang kalori, nutrisi, atau tips gaya hidup sehat.
                </div>
                <span class="text-[10px] text-gray-400 pl-1">HealthGrade AI</span>
            </div>
        </div>

        @foreach($chatHistory as $chat)
            <div class="flex flex-row-reverse gap-4 max-w-3xl mx-auto group">
                <div class="space-y-1 text-right">
                    <div class="bg-hg-dark text-white p-4 rounded-2xl rounded-tr-none shadow-md text-sm leading-relaxed text-left inline-block max-w-[85%]">
                        {{ $chat->user_prompt }}
                    </div>
                    <div class="text-[10px] text-gray-400 pr-1">{{ $chat->created_at->format('H:i') }}</div>
                </div>
            </div>

            <div class="flex gap-4 max-w-3xl mx-auto">
                <div class="w-8 h-8 rounded-full bg-hg-primary/10 flex items-center justify-center text-hg-primary shrink-0 mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path fill-rule="evenodd" d="M9 4.5a.75.75 0 01.721.544l.813 2.846a3.75 3.75 0 002.576 2.576l2.846.813a.75.75 0 010 1.442l-2.846.813a3.75 3.75 0 00-2.576 2.576l-.813 2.846a.75.75 0 01-1.442 0l-.813-2.846a3.75 3.75 0 00-2.576-2.576l-2.846-.813a.75.75 0 010-1.442l2.846-.813a3.75 3.75 0 002.576-2.576l.813-2.846A.75.75 0 019 4.5zM6.97 15.03a.75.75 0 10-1.06 1.06l.75.75-.75.75a.75.75 0 101.06 1.06l.75-.75.75.75a.75.75 0 101.06-1.06l-.75-.75.75-.75a.75.75 0 10-1.06-1.06l-.75.75-.75-.75z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="space-y-1">
                    <div class="bg-white border border-gray-100 p-4 rounded-2xl rounded-tl-none shadow-sm text-hg-dark text-sm leading-relaxed max-w-[90%]">
                        {{ $chat->ai_response }}
                    </div>
                </div>
            </div>
        @endforeach

        <div wire:loading wire:target="sendMessage" class="flex gap-4 max-w-3xl mx-auto">
            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
            </div>
            <div class="bg-white border border-gray-100 px-4 py-3 rounded-2xl rounded-tl-none shadow-sm flex items-center gap-1">
                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce"></span>
                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce delay-75"></span>
                <span class="w-1.5 h-1.5 bg-gray-400 rounded-full animate-bounce delay-150"></span>
            </div>
        </div>

    </div>

    {{-- INPUT AREA --}}
    <div class="fixed bottom-0 right-0 left-0 md:left-64 bg-white border-t border-gray-200 p-4 z-20">
        
        <div class="max-w-3xl mx-auto">
            <form wire:submit="sendMessage" class="relative flex items-center gap-2">
                
                {{-- Input Field --}}
                <input 
                    type="text" 
                    wire:model="prompt"
                    placeholder="Tanya soal diet, gula, atau kalori..." 
                    class="w-full bg-hg-light border border-transparent focus:border-hg-primary focus:ring-2 focus:ring-hg-primary/20 rounded-full py-3.5 pl-5 pr-14 text-hg-dark placeholder-gray-400 transition outline-none"
                    @keydown.enter="$wire.sendMessage(); setTimeout(() => scrollToBottom(), 100);"
                >
                
                {{-- Tombol Send --}}
                <button 
                    type="submit" 
                    class="absolute right-2 p-2 bg-hg-dark text-white rounded-full hover:bg-hg-secondary transition shadow-md disabled:opacity-50 disabled:cursor-not-allowed"
                    wire:loading.attr="disabled"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                        <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                    </svg>
                </button>
            </form>

            <p class="text-center text-[10px] text-gray-400 mt-2">
                AI dapat membuat kesalahan. Selalu verifikasi informasi kesehatan dengan dokter.
            </p>
        </div>
    </div>
</div>