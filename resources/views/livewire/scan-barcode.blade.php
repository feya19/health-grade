<div class="fixed inset-0 z-50 bg-hg-light flex flex-col">
    
    {{-- 1. HEADER TITLE (Simple) --}}
    <div class="pt-8 pb-4 text-center px-6">
        <h1 class="text-2xl font-bold text-hg-dark">Scan Produk</h1>
        <p class="text-xs text-gray-500 mt-1">Arahkan kamera ke barcode kemasan</p>
    </div>

    {{-- 2. CAMERA AREA (Flexible Height) --}}
    <div class="flex-1 px-4 pb-28 flex flex-col justify-center">
        
        <div class="relative w-full aspect-[4/3] max-h-[60vh] bg-black rounded-[2rem] overflow-hidden shadow-2xl border-4 border-white mx-auto max-w-md">
            
            {{-- Loading State --}}
            <div id="camera-loading" class="absolute inset-0 flex flex-col items-center justify-center text-white z-10 bg-black/80">
                <svg class="w-10 h-10 animate-spin mb-3 text-hg-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="text-sm font-medium animate-pulse">Menyalakan kamera...</p>
            </div>

            {{-- Video Element --}}
            <video id="reader" class="w-full h-full object-cover"></video>

            {{-- Overlay Markers --}}
            <div class="absolute inset-0 z-20 pointer-events-none">
                <div class="absolute top-6 left-6 w-10 h-10 border-t-4 border-l-4 border-hg-primary rounded-tl-xl opacity-80"></div>
                <div class="absolute top-6 right-6 w-10 h-10 border-t-4 border-r-4 border-hg-primary rounded-tr-xl opacity-80"></div>
                <div class="absolute bottom-6 left-6 w-10 h-10 border-b-4 border-l-4 border-hg-primary rounded-bl-xl opacity-80"></div>
                <div class="absolute bottom-6 right-6 w-10 h-10 border-b-4 border-r-4 border-hg-primary rounded-br-xl opacity-80"></div>
                <div class="absolute top-1/2 left-6 right-6 h-0.5 bg-red-500 shadow-[0_0_15px_rgba(239,68,68,1)] animate-scan"></div>
            </div>
        </div>

        {{-- Status Message & Upload --}}
        <div class="mt-6 text-center space-y-4">
            <div id="scan-message" class="text-xs font-medium text-gray-500 bg-white py-2 px-4 rounded-full shadow-sm inline-block border border-gray-100">
                Pastikan cahaya cukup terang
            </div>

            <div class="flex justify-center gap-4">
                <label for="barcode-upload" class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl shadow-sm text-sm font-medium text-gray-600 active:scale-95 transition cursor-pointer">
                    <svg class="w-5 h-5 text-hg-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    Upload Foto
                </label>
                <input type="file" id="barcode-upload" accept="image/*" class="hidden" onchange="handleImageUpload(event)">

                <button onclick="window.location.reload()" class="flex items-center gap-2 px-4 py-2.5 bg-white border border-gray-200 rounded-xl shadow-sm text-sm font-medium text-gray-600 active:scale-95 transition">
                    <svg class="w-5 h-5 text-hg-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                    Reset
                </button>
            </div>
        </div>
    </div>

    {{-- 3. BOTTOM NAVIGATION BAR (Fixed) --}}
    <div class="fixed bottom-0 w-full bg-white border-t border-gray-100 px-6 py-3 pb-safe z-50 shadow-[0_-4px_20px_rgba(0,0,0,0.03)] rounded-t-[2rem]">
        <div class="flex justify-between items-center max-w-lg mx-auto relative">
            
            {{-- Home --}}
            <a href="{{ route('dashboard') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-hg-dark transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                <span class="text-[10px] font-medium">Home</span>
            </a>

            {{-- History --}}
            <a href="{{ route('history') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-hg-dark transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                <span class="text-[10px] font-medium">Riwayat</span>
            </a>

            {{-- SCAN BUTTON (Active State) --}}
            <div class="relative -top-8">
                <div class="flex items-center justify-center w-16 h-16 bg-hg-primary rounded-full text-white shadow-xl shadow-hg-primary/40 border-4 border-hg-light scale-110">
                    {{-- Ikon Loading jika sedang scan --}}
                    <svg class="w-8 h-8 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path></svg>
                </div>
            </div>

            {{-- AI Assistant --}}
            <a href="{{ route('assistant') }}" wire:navigate class="flex flex-col items-center gap-1 text-gray-400 hover:text-hg-dark transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path></svg>
                <span class="text-[10px] font-medium">Asisten</span>
            </a>

            {{-- Profile --}}
            <a href="#" class="flex flex-col items-center gap-1 text-gray-400 hover:text-hg-dark transition">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                <span class="text-[10px] font-medium">Profil</span>
            </a>

        </div>
    </div>

    {{-- SCRIPT SCANNER (ZXing) --}}
    <script src="https://unpkg.com/@zxing/library@latest"></script>
    <script>
        let codeReader = null;
        let videoStream = null;
        let isScanning = false;

        document.addEventListener('DOMContentLoaded', startScanner);
        document.addEventListener('livewire:navigated', startScanner);

        // Bersihkan kamera saat meninggalkan halaman (penting untuk SPA/Livewire)
        document.addEventListener('livewire:navigating', stopScanner);

        async function startScanner() {
            const videoElement = document.getElementById('reader');
            if (!videoElement || isScanning) return;

            console.log('🎬 startScanner called');
            stopScanner(); // Reset clean

            const msgEl = document.getElementById('scan-message');
            const loadingEl = document.getElementById('camera-loading');

            try {
                const { BrowserMultiFormatReader } = ZXing;
                codeReader = new BrowserMultiFormatReader();

                videoStream = await navigator.mediaDevices.getUserMedia({
                    video: { facingMode: 'environment' }
                });

                videoElement.srcObject = videoStream;
                videoElement.setAttribute("playsinline", true); // Wajib untuk iOS Safari

                if (videoElement.paused) {
                    await videoElement.play();
                }

                if (loadingEl) loadingEl.style.display = 'none';
                if (msgEl) msgEl.innerText = '📷 Arahkan kamera ke barcode';

                isScanning = true;

                codeReader.decodeFromVideoElement(videoElement, (result, err) => {
                    if (!isScanning) return;
                    if (result) {
                        console.log('🎉 Barcode detected:', result.getText());
                        stopScanner(); // Matikan kamera segera setelah detect
                        onScanSuccess(result.getText());
                    }
                });

            } catch (err) {
                console.error('❌ Camera error:', err);
                if (msgEl) msgEl.innerText = '❌ Gagal akses kamera';
                if (loadingEl) loadingEl.innerHTML = '<p class="text-red-400">Izin kamera ditolak</p>';
            }
        }

        function stopScanner() {
            console.log('🛑 stopScanner');
            isScanning = false;

            if (videoStream) {
                videoStream.getTracks().forEach(track => track.stop());
                videoStream = null;
            }

            const videoElement = document.getElementById('reader');
            if (videoElement) {
                videoElement.srcObject = null;
            }
            codeReader = null;
        }

        function onScanSuccess(decodedText) {
            const msgEl = document.getElementById('scan-message');
            if (msgEl) {
                msgEl.innerText = '✓ Barcode: ' + decodedText;
                msgEl.className = 'text-xs font-bold text-green-600 bg-green-50 py-2 px-4 rounded-full border border-green-200 inline-block';
            }
            // Kirim ke backend Livewire
            @this.handleScan(decodedText);
        }

        // Handle Upload Gambar Manual (PWA Feature)
        function handleImageUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = (e) => {
                const img = new Image();
                img.onload = () => {
                    const codeReader = new ZXing.BrowserMultiFormatReader();
                    codeReader.decodeFromImage(img).then((result) => {
                        console.log(result);
                        onScanSuccess(result.getText());
                    }).catch((err) => {
                        console.error(err);
                        alert("Barcode tidak ditemukan pada gambar.");
                    });
                };
                img.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    </script>

    <style>
        @keyframes scan {
            0% { top: 10%; opacity: 0; }
            50% { opacity: 1; }
            100% { top: 90%; opacity: 0; }
        }
        .animate-scan {
            animation: scan 2s linear infinite;
        }
    </style>
</div>