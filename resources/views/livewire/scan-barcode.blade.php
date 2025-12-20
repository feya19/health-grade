<div class="max-w-xl mx-auto relative h-[calc(100vh-100px)] flex flex-col justify-center">

    <div class="text-center mb-6">
        <h1 class="text-2xl font-bold text-hg-dark">Scan Barcode</h1>
        <p class="text-gray-500 text-sm">Arahkan kamera ke barcode produk makanan.</p>
    </div>

    <div class="relative w-full aspect-[4/3] bg-black rounded-3xl overflow-hidden shadow-2xl border-4 border-white">

        <div id="camera-loading" class="absolute inset-0 flex flex-col items-center justify-center text-white z-10">
            <svg class="w-10 h-10 animate-spin mb-3 text-hg-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                </circle>
                <path class="opacity-75" fill="currentColor"
                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                </path>
            </svg>
            <p class="text-sm font-medium">Meminta izin kamera...</p>
        </div>

        <video id="reader" class="w-full h-full object-cover"></video>

        <div class="absolute inset-0 z-20 pointer-events-none">
            <div class="absolute top-8 left-8 w-12 h-12 border-t-4 border-l-4 border-hg-primary rounded-tl-xl"></div>
            <div class="absolute top-8 right-8 w-12 h-12 border-t-4 border-r-4 border-hg-primary rounded-tr-xl"></div>
            <div class="absolute bottom-8 left-8 w-12 h-12 border-b-4 border-l-4 border-hg-primary rounded-bl-xl"></div>
            <div class="absolute bottom-8 right-8 w-12 h-12 border-b-4 border-r-4 border-hg-primary rounded-br-xl">
            </div>

            <div
                class="absolute top-1/2 left-8 right-8 h-0.5 bg-red-500 shadow-[0_0_10px_rgba(239,68,68,0.8)] animate-scan">
            </div>
        </div>
    </div>

    <div class="mt-8 text-center space-y-4">
        <div id="scan-message"
            class="text-sm text-gray-500 bg-white py-3 px-6 rounded-full shadow-sm inline-block border border-gray-100">
            Pastikan ruangan cukup cahaya.
        </div>

        {{-- Upload Gambar Alternative --}}
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
            <p class="text-sm text-gray-600 mb-3 font-medium">Atau upload foto barcode:</p>
            <label for="barcode-upload" class="cursor-pointer">
                <div
                    class="flex items-center justify-center gap-3 bg-hg-primary hover:bg-hg-secondary text-white py-3 px-6 rounded-xl transition font-medium">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span>Pilih Gambar</span>
                </div>
            </label>
            <input type="file" id="barcode-upload" accept="image/*" capture="environment" class="hidden"
                onchange="handleImageUpload(event)">
        </div>

        <div class="flex justify-center gap-4">
            <a href="{{ route('dashboard') }}" class="text-gray-400 hover:text-hg-dark text-sm font-medium transition">
                Kembali
            </a>
            <button onclick="window.location.reload()"
                class="text-hg-primary hover:text-hg-secondary text-sm font-medium transition">
                Refresh Kamera
            </button>
        </div>
    </div>

    {{-- Load Library --}}
    <script src="https://unpkg.com/@zxing/library@latest"></script>
    <script>
        let codeReader = null;
        let videoStream = null;
        let isScanning = false;

        document.addEventListener('DOMContentLoaded', startScanner);
        document.addEventListener('livewire:navigated', startScanner);

        async function startScanner() {
            const videoElement = document.getElementById('reader');
            if (!videoElement || isScanning) return;

            console.log('🎬 startScanner called');

            // PASTIKAN BENAR-BENAR STOP SEBELUM START
            stopScanner();

            const msgEl = document.getElementById('scan-message');
            const loadingEl = document.getElementById('camera-loading');

            try {
                const {
                    BrowserMultiFormatReader
                } = ZXing;
                codeReader = new BrowserMultiFormatReader();

                videoStream = await navigator.mediaDevices.getUserMedia({
                    video: {
                        facingMode: 'environment'
                    }
                });

                videoElement.srcObject = videoStream;

                // ❗ JANGAN play jika sudah jalan
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
                        stopScanner();
                        onScanSuccess(result.getText());
                    }
                });

            } catch (err) {
                console.error('❌ Camera error:', err);
                if (msgEl) msgEl.innerText = '❌ Kamera tidak tersedia';
            }
        }

        function stopScanner() {
            console.log('🛑 stopScanner');

            isScanning = false;

            // STOP CAMERA
            if (videoStream) {
                videoStream.getTracks().forEach(track => track.stop());
                videoStream = null;
            }

            const videoElement = document.getElementById('reader');
            if (videoElement) {
                videoElement.srcObject = null;
            }

            // HAPUS reader TANPA reset()
            codeReader = null;
        }

        function onScanSuccess(decodedText) {
            const msgEl = document.getElementById('scan-message');
            if (msgEl) {
                msgEl.innerText = '✓ Barcode terdeteksi, memuat data...';
                msgEl.classList.add('text-green-600', 'font-bold');
            }

            @this.handleScan(decodedText);
        }

        // Handle upload gambar barcode
        async function handleImageUpload(event) {
            const file = event.target.files[0];
            if (!file) return;

            // Stop video scanner saat upload
            stopScanner();

            const msgEl = document.getElementById('scan-message');
            if (msgEl) {
                msgEl.innerText = "⏳ Membaca barcode dari gambar...";
                msgEl.classList.remove('text-green-600', 'text-red-500', 'text-gray-500');
                msgEl.classList.add('text-blue-600', 'font-bold');
            }

            try {
                const reader = new FileReader();

                const imageData = await new Promise((resolve, reject) => {
                    reader.onload = (e) => resolve(e.target.result);
                    reader.onerror = () => reject(new Error('Failed to read file'));
                    reader.readAsDataURL(file);
                });

                const img = await new Promise((resolve, reject) => {
                    const image = new Image();
                    image.onload = () => resolve(image);
                    image.onerror = () => reject(new Error('Failed to load image'));
                    image.src = imageData;
                });

                // Buat canvas untuk decode
                const canvas = document.createElement('canvas');
                const ctx = canvas.getContext('2d');

                // Resize jika terlalu besar (max 1920px)
                let width = img.width;
                let height = img.height;
                const maxSize = 1920;

                if (width > maxSize || height > maxSize) {
                    if (width > height) {
                        height = (height / width) * maxSize;
                        width = maxSize;
                    } else {
                        width = (width / height) * maxSize;
                        height = maxSize;
                    }
                }

                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(img, 0, 0, width, height);

                // Decode dari canvas
                const {
                    BrowserMultiFormatReader
                } = window.ZXing || ZXing;
                const barcodeReader = new BrowserMultiFormatReader();

                try {
                    const result = await barcodeReader.decodeFromCanvas(canvas);
                    console.log('✓ Barcode from image:', result.getText());
                    onScanSuccess(result.getText());
                } catch (decodeError) {
                    console.log('Decode failed:', decodeError.name || 'Unknown');
                    if (msgEl) {
                        msgEl.innerText = "❌ Barcode tidak terdeteksi. Pastikan foto fokus dan jelas.";
                        msgEl.classList.remove('text-blue-600', 'font-bold');
                        msgEl.classList.add('text-red-500');
                    }
                    event.target.value = '';
                }
            } catch (error) {
                console.log('Image processing failed:', error.message);
                if (msgEl) {
                    msgEl.innerText = "❌ Gagal memproses gambar";
                    msgEl.classList.remove('text-blue-600', 'font-bold');
                    msgEl.classList.add('text-red-500');
                }
                event.target.value = '';
            }
        }
    </script>



    <style>
        /* Animasi Garis Merah */
        @keyframes scan {
            0% {
                top: 10%;
                opacity: 0;
            }

            50% {
                opacity: 1;
            }

            100% {
                top: 90%;
                opacity: 0;
            }
        }

        .animate-scan {
            animation: scan 2s linear infinite;
        }

        /* Styling Video agar memenuhi kotak rounded */
        #reader video {
            object-fit: cover;
            width: 100% !important;
            height: 100% !important;
            border-radius: 1.5rem;
            /* sesuaikan dengan rounded-3xl container */
        }
    </style>
</div>
