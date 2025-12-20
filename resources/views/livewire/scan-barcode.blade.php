<div class="max-w-xl mx-auto relative h-[calc(100vh-100px)] flex flex-col justify-center">
    
    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-hg-dark">Scan Barcode</h1>
        <p class="text-gray-500 text-sm">Arahkan kamera ke barcode produk makanan.</p>
    </div>

    <div class="relative w-full aspect-[4/3] bg-black rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
        
        <div id="camera-loading" class="absolute inset-0 flex flex-col items-center justify-center text-white z-10">
            <svg class="w-10 h-10 animate-spin mb-3 text-hg-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <p class="text-sm font-medium">Meminta izin kamera...</p>
        </div>

        <div id="reader" class="w-full h-full object-cover"></div>

        <div class="absolute inset-0 z-20 pointer-events-none">
            <div class="absolute top-8 left-8 w-12 h-12 border-t-4 border-l-4 border-hg-primary rounded-tl-xl"></div>
            <div class="absolute top-8 right-8 w-12 h-12 border-t-4 border-r-4 border-hg-primary rounded-tr-xl"></div>
            <div class="absolute bottom-8 left-8 w-12 h-12 border-b-4 border-l-4 border-hg-primary rounded-bl-xl"></div>
            <div class="absolute bottom-8 right-8 w-12 h-12 border-b-4 border-r-4 border-hg-primary rounded-br-xl"></div>
            
            <div class="absolute top-1/2 left-8 right-8 h-0.5 bg-red-500 shadow-[0_0_10px_rgba(239,68,68,0.8)] animate-scan"></div>
        </div>
    </div>

    <div class="mt-8 text-center space-y-4">
        <div id="scan-message" class="text-sm text-gray-500 bg-white py-3 px-6 rounded-full shadow-sm inline-block border border-gray-100">
            Pastikan ruangan cukup cahaya.
        </div>

        <div class="flex justify-center gap-4">
             <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-hg-dark text-sm font-medium transition">
                Kembali
            </a>
            <button onclick="window.location.reload()" class="text-hg-primary hover:text-hg-secondary text-sm font-medium transition">
                Refresh Kamera
            </button>
        </div>
    </div>

    {{-- Load Library --}}
    <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
    
    <script>
        // Variabel global untuk scanner
        let html5QrCode;

        // Listener untuk inisialisasi saat navigasi Livewire
        document.addEventListener('livewire:navigated', startScanner);
        document.addEventListener('DOMContentLoaded', startScanner);

        function startScanner() {
            // 1. Cek apakah elemen reader ada
            if (!document.getElementById('reader')) return;

            // 2. Bersihkan instance lama jika ada (mencegah duplikasi kamera)
            if (html5QrCode) {
                html5QrCode.stop().then(() => {
                    html5QrCode.clear();
                    initCoreScanner();
                }).catch(err => {
                    console.log("Stop failed: ", err);
                    initCoreScanner(); // Tetap coba init meski stop gagal
                });
            } else {
                initCoreScanner();
            }
        }

        function initCoreScanner() {
            // Gunakan class Html5Qrcode (bukan Scanner) untuk kontrol penuh
            html5QrCode = new Html5Qrcode("reader");

            const config = { 
                fps: 10, 
                qrbox: { width: 250, height: 250 },
                aspectRatio: 1.0
            };

            // Meminta akses kamera belakang ('environment') secara langsung
            html5QrCode.start(
                { facingMode: "environment" }, 
                config, 
                onScanSuccess, 
                onScanFailure
            ).then(() => {
                // Sukses: Kamera jalan -> Sembunyikan loading spinner kita
                const loadingEl = document.getElementById('camera-loading');
                if(loadingEl) loadingEl.style.display = 'none';
            }).catch(err => {
                // Gagal: Izin ditolak atau kamera tidak ada
                console.error("Error starting camera: ", err);
                document.getElementById('camera-loading').innerHTML = 
                    `<p class="text-red-500 font-bold px-4">Gagal akses kamera.<br>Pastikan izin diberikan.</p>`;
            });
        }

        const onScanSuccess = (decodedText, decodedResult) => {
            console.log(`Scan result: ${decodedText}`);
            
            // UI Feedback
            const msgEl = document.getElementById('scan-message');
            if(msgEl) {
                msgEl.innerText = "Berhasil: " + decodedText;
                msgEl.classList.add('text-green-600', 'font-bold');
            }

            // Stop Camera & Panggil Backend Livewire
            html5QrCode.stop().then(() => {
                 @this.handleScan(decodedText);
            });
        }

        const onScanFailure = (error) => {
            // Biarkan kosong agar console tidak penuh warning saat mencari QR
        }
    </script>

    <style>
        /* Animasi Garis Merah */
        @keyframes scan {
            0% { top: 10%; opacity: 0; }
            50% { opacity: 1; }
            100% { top: 90%; opacity: 0; }
        }
        .animate-scan {
            animation: scan 2s linear infinite;
        }

        /* Styling Video agar memenuhi kotak rounded */
        #reader video {
            object-fit: cover;
            width: 100% !important;
            height: 100% !important;
            border-radius: 1.5rem; /* sesuaikan dengan rounded-3xl container */
        }
    </style>
</div>