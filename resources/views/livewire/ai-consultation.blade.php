<div class="fixed inset-0 bg-white flex flex-col h-full" x-data="chatStream()">

    {{-- 1. TOP HEADER --}}
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
                    <span class="w-1.5 h-1.5 rounded-full" :class="$wire.isStreaming ? 'bg-yellow-500 animate-pulse' : 'bg-green-500'"></span>
                    <span x-text="$wire.isStreaming ? 'Typing...' : 'Online'"></span>
                </p>
            </div>
        </div>

        {{-- Tombol Hapus Chat --}}
        <button 
            wire:click="clearChat" 
            class="text-gray-400 hover:text-red-500 p-2 transition"
            :disabled="$wire.isStreaming"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
            </svg>
        </button>
    </div>

    {{-- 2. CHAT AREA --}}
    <div id="chat-container" class="flex-1 overflow-y-auto px-4 py-6 space-y-4 pb-36 scroll-smooth">
        
        {{-- Welcome Message (jika kosong) --}}
        @if(count($messages) === 0)
        <div class="flex gap-3 max-w-3xl mx-auto">
            <div class="w-8 h-8 rounded-full bg-hg-primary/10 flex items-center justify-center text-hg-primary shrink-0 mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M9 4.5a.75.75 0 01.721.544l.813 2.846a3.75 3.75 0 002.576 2.576l2.846.813a.75.75 0 010 1.442l-2.846.813a3.75 3.75 0 00-2.576 2.576l-.813 2.846a.75.75 0 01-1.442 0l-.813-2.846a3.75 3.75 0 00-2.576-2.576l-2.846-.813a.75.75 0 010-1.442l2.846-.813a3.75 3.75 0 002.576-2.576l.813-2.846A.75.75 0 019 4.5z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="space-y-1 max-w-[85%]">
                <div class="bg-white border border-gray-100 p-3.5 rounded-2xl rounded-tl-none shadow-sm text-hg-dark text-sm leading-relaxed">
                    Halo! Saya HealthGrade AI. 👋 <br>
                    Tanyakan tentang kalori makanan, tips diet sehat, atau upload foto makanan untuk dianalisis!
                </div>
            </div>
        </div>
        @endif

        {{-- Chat Messages --}}
        @foreach($messages as $index => $message)
            @if($message['role'] === 'user')
                {{-- User Bubble --}}
                <div class="flex flex-row-reverse gap-3 max-w-3xl mx-auto">
                    <div class="space-y-1 text-right max-w-[85%]">
                        {{-- Image Preview jika ada --}}
                        @if(is_array($message['content']) && isset($message['content'][1]['image_url']['url']))
                        <img 
                            src="{{ $message['content'][1]['image_url']['url'] }}" 
                            alt="Uploaded" 
                            class="rounded-xl max-h-40 object-contain ml-auto border border-gray-200 shadow-sm mb-1"
                        >
                        @endif
                        <div class="bg-hg-dark text-white px-4 py-3 rounded-2xl rounded-tr-none shadow-md text-sm leading-relaxed text-left inline-block">
                            {{ is_array($message['content']) ? $message['content'][0]['text'] : $message['content'] }}
                        </div>
                    </div>
                </div>
            @else
                {{-- AI Bubble --}}
                <div class="flex gap-3 max-w-3xl mx-auto">
                    <div class="w-8 h-8 rounded-full bg-hg-primary/10 flex items-center justify-center text-hg-primary shrink-0 mt-1">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                            <path fill-rule="evenodd" d="M9 4.5a.75.75 0 01.721.544l.813 2.846a3.75 3.75 0 002.576 2.576l2.846.813a.75.75 0 010 1.442l-2.846.813a3.75 3.75 0 00-2.576 2.576l-.813 2.846a.75.75 0 01-1.442 0l-.813-2.846a3.75 3.75 0 00-2.576-2.576l-2.846-.813a.75.75 0 010-1.442l2.846-.813a3.75 3.75 0 002.576-2.576l.813-2.846A.75.75 0 019 4.5z" clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="space-y-1 max-w-[90%]">
                        <div class="bg-white border border-gray-100 px-4 py-3 rounded-2xl rounded-tl-none shadow-sm text-hg-dark text-sm leading-relaxed whitespace-pre-wrap">
                            {{ $message['content'] }}
                        </div>
                    </div>
                </div>
            @endif
        @endforeach

        {{-- Streaming Message --}}
        <div x-show="streamingMessage" class="flex gap-3 max-w-3xl mx-auto" style="display: none;">
            <div class="w-8 h-8 rounded-full bg-hg-primary/10 flex items-center justify-center text-hg-primary shrink-0 mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-5 h-5">
                    <path fill-rule="evenodd" d="M9 4.5a.75.75 0 01.721.544l.813 2.846a3.75 3.75 0 002.576 2.576l2.846.813a.75.75 0 010 1.442l-2.846.813a3.75 3.75 0 00-2.576 2.576l-.813 2.846a.75.75 0 01-1.442 0l-.813-2.846a3.75 3.75 0 00-2.576-2.576l-2.846-.813a.75.75 0 010-1.442l2.846-.813a3.75 3.75 0 002.576-2.576l.813-2.846A.75.75 0 019 4.5z" clip-rule="evenodd" />
                </svg>
            </div>
            <div class="space-y-1 max-w-[90%]">
                <div class="bg-white border border-gray-100 px-4 py-3 rounded-2xl rounded-tl-none shadow-sm text-hg-dark text-sm leading-relaxed whitespace-pre-wrap" x-text="streamingMessage"></div>
            </div>
        </div>

        {{-- Loading Indicator --}}
        <div x-show="$wire.isStreaming && !streamingMessage" class="flex gap-3 max-w-3xl mx-auto" style="display: none;">
            <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center shrink-0">
                <div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse"></div>
            </div>
            <div class="bg-white border border-gray-100 px-4 py-3 rounded-2xl rounded-tl-none shadow-sm flex items-center gap-1.5 w-fit">
                <span class="w-1.5 h-1.5 bg-hg-primary rounded-full animate-bounce"></span>
                <span class="w-1.5 h-1.5 bg-hg-primary rounded-full animate-bounce" style="animation-delay: 75ms"></span>
                <span class="w-1.5 h-1.5 bg-hg-primary rounded-full animate-bounce" style="animation-delay: 150ms"></span>
            </div>
        </div>
    </div>

    {{-- 3. INPUT AREA --}}
    <div class="fixed bottom-0 left-0 w-full bg-white border-t border-gray-100 px-4 py-3 pb-safe z-40">
        <div class="max-w-3xl mx-auto space-y-2">
            
            {{-- Image Preview --}}
            @if($imagePreview)
            <div class="relative inline-block">
                <img 
                    src="{{ $imagePreview }}" 
                    alt="Preview" 
                    class="rounded-xl max-h-20 object-contain border-2 border-hg-primary shadow-sm"
                >
                <button 
                    wire:click="removeImage" 
                    type="button"
                    class="absolute -top-2 -right-2 bg-red-500 hover:bg-red-600 text-white rounded-full w-5 h-5 flex items-center justify-center text-xs shadow-md"
                >
                    ×
                </button>
            </div>
            @endif

            <form wire:submit.prevent="sendMessage" class="relative flex items-center gap-2 bg-gray-100 p-1.5 rounded-3xl border border-transparent focus-within:border-hg-primary/30 focus-within:bg-white focus-within:shadow-md transition-all">
                
                {{-- Image Upload Button --}}
                <label class="p-2.5 text-gray-500 hover:text-hg-primary hover:bg-white rounded-full transition cursor-pointer shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <input 
                        type="file" 
                        wire:model="image" 
                        accept="image/*"
                        class="hidden"
                        :disabled="$wire.isStreaming"
                    >
                </label>

                {{-- Input Field --}}
                <input 
                    type="text" 
                    wire:model="prompt"
                    placeholder="Ketik pesan..." 
                    class="w-full bg-transparent border-none focus:ring-0 text-hg-dark placeholder-gray-400 py-2 text-sm"
                    :disabled="$wire.isStreaming"
                    @keydown.enter.prevent="if (!$wire.isStreaming) $wire.sendMessage()"
                    autocomplete="off"
                >
                
                {{-- Send Button --}}
                <button 
                    type="submit" 
                    class="p-2.5 bg-hg-dark text-white rounded-full hover:bg-hg-primary active:scale-95 transition shadow-sm disabled:opacity-50 disabled:cursor-not-allowed shrink-0"
                    :disabled="$wire.isStreaming"
                >
                    <span x-show="!$wire.isStreaming">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                            <path d="M3.478 2.405a.75.75 0 00-.926.94l2.432 7.905H13.5a.75.75 0 010 1.5H4.984l-2.432 7.905a.75.75 0 00.926.94 60.519 60.519 0 0018.445-8.986.75.75 0 000-1.218A60.517 60.517 0 003.478 2.405z" />
                        </svg>
                    </span>
                    <span x-show="$wire.isStreaming" style="display: none;">
                        <svg class="animate-spin w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </span>
                </button>
            </form>

            @error('image') 
            <p class="text-red-500 text-xs">{{ $message }}</p>
            @enderror

            <p class="text-center text-[10px] text-gray-400">
                HealthGrade AI bisa salah. Cek dengan ahli medis.
            </p>
        </div>
    </div>
</div>

<script>
    function chatStream() {
        return {
            streamingMessage: '',
            
            init() {
                this.$wire.on('start-streaming', (event) => {
                    this.startStreaming(event.messages);
                });
                
                this.$nextTick(() => {
                    this.scrollToBottom();
                });
            },
            
            async startStreaming(messages) {
                this.streamingMessage = '';
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                
                if (!csrfToken) {
                    this.$wire.dispatch('streaming-error', { 
                        error: 'CSRF token tidak ditemukan. Silakan refresh halaman.' 
                    });
                    return;
                }
                
                try {
                    const response = await fetch('{{ route('assistant.stream') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'Accept': 'text/event-stream',
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        credentials: 'same-origin',
                        body: JSON.stringify({ messages })
                    });

                    if (!response.ok) {
                        const errorText = await response.text();
                        throw new Error(`HTTP ${response.status}: ${errorText}`);
                    }

                    const reader = response.body.getReader();
                    const decoder = new TextDecoder('utf-8', { stream: true });
                    let buffer = '';
                    
                    while (true) {
                        const { done, value } = await reader.read();
                        if (done) break;
                        
                        const chunk = decoder.decode(value, { stream: true });
                        buffer += chunk;
                        
                        const lines = buffer.split('\n');
                        buffer = lines.pop() || '';
                        
                        for (const line of lines) {
                            const trimmedLine = line.trim();
                            
                            if (trimmedLine.startsWith('data: ')) {
                                const data = trimmedLine.slice(6).trim();
                                
                                if (data === '[DONE]') {
                                    this.$wire.dispatch('streaming-complete', { 
                                        content: this.streamingMessage 
                                    });
                                    this.streamingMessage = '';
                                    return;
                                }
                                
                                try {
                                    const parsed = JSON.parse(data);
                                    const content = parsed.choices?.[0]?.delta?.content;
                                    
                                    if (content) {
                                        this.streamingMessage += content;
                                        this.scrollToBottom();
                                    }
                                } catch (e) {
                                    console.debug('Skipping invalid JSON:', data);
                                }
                            }
                        }
                    }
                    
                    // Process remaining buffer
                    if (buffer.trim()) {
                        const trimmedLine = buffer.trim();
                        if (trimmedLine.startsWith('data: ')) {
                            const data = trimmedLine.slice(6).trim();
                            if (data !== '[DONE]') {
                                try {
                                    const parsed = JSON.parse(data);
                                    const content = parsed.choices?.[0]?.delta?.content;
                                    if (content) {
                                        this.streamingMessage += content;
                                    }
                                } catch (e) {
                                    console.debug('Skipping invalid JSON in buffer:', data);
                                }
                            }
                        }
                    }
                    
                    this.$wire.dispatch('streaming-complete', { 
                        content: this.streamingMessage 
                    });
                    this.streamingMessage = '';
                    
                } catch (error) {
                    console.error('Streaming error:', error);
                    this.$wire.dispatch('streaming-error', { 
                        error: error.message 
                    });
                    this.streamingMessage = '';
                }
            },
            
            scrollToBottom() {
                this.$nextTick(() => {
                    const container = document.getElementById('chat-container');
                    if (container) {
                        container.scrollTo({ top: container.scrollHeight, behavior: 'smooth' });
                    }
                });
            }
        }
    }

    document.addEventListener('livewire:navigated', () => {
        const chatContainer = document.getElementById('chat-container');
        if (chatContainer) {
            chatContainer.scrollTo({ top: chatContainer.scrollHeight, behavior: 'smooth' });
        }
    });
</script>