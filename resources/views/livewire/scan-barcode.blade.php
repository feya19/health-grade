<div class="max-w-xl mx-auto relative h-[calc(100vh-100px)] flex flex-col justify-center">

    {{-- Scanner Section --}}
    <div id="scanner-section">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-hg-dark">Scan Barcode</h1>
            <p class="text-gray-500 text-sm">Arahkan kamera ke barcode produk makanan.</p>
        </div>

        <div class="relative w-full aspect-[4/3] bg-black rounded-3xl overflow-hidden shadow-2xl border-4 border-white">
            <div id="camera-loading" class="absolute inset-0 flex flex-col items-center justify-center text-white z-10">
                <svg class="w-10 h-10 animate-spin mb-3 text-hg-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <p class="text-sm font-medium">Meminta izin kamera...</p>
            </div>

            <video id="reader" class="w-full h-full object-cover"></video>

            <div class="absolute inset-0 z-20 pointer-events-none">
                <div class="absolute top-8 left-8 w-12 h-12 border-t-4 border-l-4 border-hg-primary rounded-tl-xl">
                </div>
                <div class="absolute top-8 right-8 w-12 h-12 border-t-4 border-r-4 border-hg-primary rounded-tr-xl">
                </div>
                <div class="absolute bottom-8 left-8 w-12 h-12 border-b-4 border-l-4 border-hg-primary rounded-bl-xl">
                </div>
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
                <input type="file" id="barcode-upload" accept="image/*" capture="environment" class="hidden">
            </div>

            <div class="flex justify-center gap-4">
                <a href="{{ route('dashboard') }}"
                    class="text-gray-400 hover:text-hg-dark text-sm font-medium transition">Kembali</a>
                <button onclick="window.location.reload()"
                    class="text-hg-primary hover:text-hg-secondary text-sm font-medium transition">Refresh
                    Kamera</button>
            </div>
        </div>
    </div>

    {{-- Product Result Section --}}
    <div id="product-section" style="display: none;">

        {{-- Barcode Display --}}
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200 mb-6">
            <p class="text-sm text-gray-500 mb-2">Barcode:</p>
            <p id="barcode-display" class="text-2xl font-bold text-hg-primary"></p>
        </div>

        {{-- Loading State --}}
        <div id="product-loading" class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200">
            <div class="flex flex-col items-center">
                <svg class="w-12 h-12 animate-spin text-hg-primary" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                        stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <p class="mt-4 text-gray-600 font-medium">Memuat data produk...</p>
            </div>
        </div>

        {{-- Product Info --}}
        <div id="product-info" style="display: none;" class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
            <div class="flex gap-4 mb-6">
                <img id="product-image" src="" alt="Product" class="w-24 h-24 object-cover rounded-lg">
                <div class="flex-1">
                    <h3 id="product-name" class="text-lg font-bold text-hg-dark mb-1"></h3>
                    <p id="product-brands" class="text-sm text-gray-500"></p>
                </div>
            </div>

            {{-- Final Grade --}}
            <div class="text-center p-6 bg-gradient-to-r from-hg-primary to-hg-secondary rounded-2xl mb-6">
                <p class="text-white text-sm mb-2">Health Grade</p>
                <p id="final-grade" class="text-6xl font-bold text-white"></p>
            </div>

            <p class="mt-4 text-center text-xs text-gray-500">
                Semua nilai gizi ditampilkan <strong>per 100 ml sajian</strong>
            </p>
            {{-- Nutrition Facts --}}
            <div id="nutrition-facts" class="space-y-2"></div>
        </div>

        {{-- Error State --}}
        <div id="product-error" style="display: none;" class="bg-red-50 rounded-2xl p-6 border border-red-200">
            <p class="text-red-600 font-medium text-center">❌ Produk tidak ditemukan</p>
        </div>

        {{-- Actions --}}
        <div class="flex justify-center gap-4 mt-6">
            <button id="scan-again-btn"
                class="px-6 py-3 bg-hg-primary hover:bg-hg-secondary text-white rounded-xl font-medium transition">
                Scan Lagi
            </button>

            <a href="{{ route('dashboard') }}"
                class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition">
                Kembali
            </a>
        </div>
    </div>

    @assets
        <script src="https://unpkg.com/@zxing/library@latest"></script>
    @endassets

    @script
        <script>
            let codeReader = null;
            let videoStream = null;
            let isScanning = false;
            let isInitialized = false;

            document.addEventListener('DOMContentLoaded', init);
            document.addEventListener('livewire:navigated', init);

            function init() {
                if (isInitialized) return;
                isInitialized = true;

                startScanner();

                const uploadInput = document.getElementById('barcode-upload');
                if (uploadInput) {
                    uploadInput.addEventListener('change', handleImageUpload);
                }

                const scanAgainBtn = document.getElementById('scan-again-btn');
                if (scanAgainBtn) {
                    scanAgainBtn.addEventListener('click', resetScanner);
                }
            }

            async function startScanner() {
                const videoElement = document.getElementById('reader');
                if (!videoElement || isScanning) return;

                stopScanner();

                const msgEl = document.getElementById('scan-message');
                const loadingEl = document.getElementById('camera-loading');

                try {
                    const {
                        BrowserMultiFormatReader
                    } = ZXing;

                    codeReader = new BrowserMultiFormatReader();

                    // Request video dengan resolusi optimal untuk kecepatan
                    videoStream = await navigator.mediaDevices.getUserMedia({
                        video: {
                            facingMode: 'environment',
                            width: {
                                ideal: 1280
                            },
                            height: {
                                ideal: 720
                            }
                        }
                    });

                    videoElement.srcObject = videoStream;

                    if (videoElement.paused) {
                        await videoElement.play();
                    }

                    if (loadingEl) loadingEl.style.display = 'none';
                    if (msgEl) msgEl.innerText = '📷 Arahkan kamera ke barcode';

                    isScanning = true;

                    // Decode dengan interval lebih cepat dan tryInverted untuk barcode terbalik
                    codeReader.timeBetweenDecodingAttempts = 300; // 300ms lebih cepat

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
                    msgEl.innerText = '✓ Barcode terdeteksi, memuat data...';
                    msgEl.classList.add('text-green-600', 'font-bold');
                }

                document.getElementById('scanner-section').style.display = 'none';
                document.getElementById('product-section').style.display = 'block';
                document.getElementById('barcode-display').textContent = decodedText;

                fetchProduct(decodedText);
            }

            async function fetchProduct(barcode) {
                const loadingEl = document.getElementById('product-loading');
                const infoEl = document.getElementById('product-info');
                const errorEl = document.getElementById('product-error');

                loadingEl.style.display = 'block';
                infoEl.style.display = 'none';
                errorEl.style.display = 'none';

                try {
                    const response = await fetch(`/products/${barcode}`);
                    const data = await response.json();

                    console.log('API Response:', data);

                    if (data && data.product_name) {
                        displayProduct(data);
                    } else {
                        showError();
                    }
                } catch (error) {
                    console.error('API Error:', error);
                    showError();
                }
            }

            function displayProduct(product) {
                document.getElementById('product-loading').style.display = 'none';
                document.getElementById('product-info').style.display = 'block';

                document.getElementById('product-image').src =
                    product.image || '/images/no-image.png';

                document.getElementById('product-name').textContent =
                    product.product_name || 'Unknown Product';

                document.getElementById('product-brands').textContent =
                    product.brands || 'No brand';

                document.getElementById('final-grade').textContent =
                    product.health_grade?.final_grade || 'N/A';

                const nutrition = product.nutrition || {};
                document.getElementById('nutrition-facts').innerHTML = `

                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Energy</span>
                    <span class="font-medium">${nutrition.energy_kcal_100g || 0} kcal</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Sugars</span>
                    <span class="font-medium">${nutrition.sugars_100g || 0} g</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Saturated Fat</span>
                    <span class="font-medium">${nutrition.saturated_fat_100g || 0} g</span>
                </div>
                <div class="flex justify-between py-2 border-b">
                    <span class="text-gray-600">Proteins</span>
                    <span class="font-medium">${nutrition.proteins_100g || 0} g</span>
                </div>
                <div class="flex justify-between py-2">
                    <span class="text-gray-600">Sodium</span>
                    <span class="font-medium">${nutrition.sodium_100g || 0} g</span>
                </div>
            `;
            }

            function showError() {
                document.getElementById('product-loading').style.display = 'none';
                document.getElementById('product-error').style.display = 'block';
            }

            function resetScanner() {
                // Stop current scanner
                stopScanner();

                // Reset UI states
                const msgEl = document.getElementById('scan-message');
                if (msgEl) {
                    msgEl.innerText = 'Pastikan ruangan cukup cahaya.';
                    msgEl.className =
                        'text-sm text-gray-500 bg-white py-3 px-6 rounded-full shadow-sm inline-block border border-gray-100';
                }

                // Reset file input
                const uploadInput = document.getElementById('barcode-upload');
                if (uploadInput) uploadInput.value = '';

                // Reset product section
                document.getElementById('product-loading').style.display = 'block';
                document.getElementById('product-info').style.display = 'none';
                document.getElementById('product-error').style.display = 'none';

                // Show scanner section
                document.getElementById('product-section').style.display = 'none';
                document.getElementById('scanner-section').style.display = 'block';

                // Start fresh scanner
                setTimeout(() => startScanner(), 300);
            }

            async function handleImageUpload(event) {
                const file = event.target.files[0];
                if (!file) return;

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

                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');

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

                    const {
                        BrowserMultiFormatReader
                    } = window.ZXing || ZXing;
                    const barcodeReader = new BrowserMultiFormatReader();

                    // Fungsi helper untuk coba berbagai orientasi
                    const tryDecode = async (sourceCanvas, angle = 0, flipH = false, flipV = false) => {
                        const testCanvas = document.createElement('canvas');
                        const testCtx = testCanvas.getContext('2d');

                        if (angle === 90 || angle === 270) {
                            testCanvas.width = height;
                            testCanvas.height = width;
                        } else {
                            testCanvas.width = width;
                            testCanvas.height = height;
                        }

                        testCtx.save();

                        // Translate ke center
                        testCtx.translate(testCanvas.width / 2, testCanvas.height / 2);

                        // Rotate
                        if (angle) testCtx.rotate((angle * Math.PI) / 180);

                        // Flip
                        if (flipH) testCtx.scale(-1, 1);
                        if (flipV) testCtx.scale(1, -1);

                        // Draw dengan offset ke center
                        testCtx.drawImage(sourceCanvas, -width / 2, -height / 2, width, height);
                        testCtx.restore();

                        return await barcodeReader.decodeFromCanvas(testCanvas);
                    };

                    // Coba berbagai orientasi: normal, 90°, 180°, 270°, flip horizontal, flip vertical
                    const orientations = [{
                            angle: 0,
                            flipH: true,
                            flipV: true,
                            label: 'normal'
                        },
                        {
                            angle: 90,
                            flipH: true,
                            flipV: true,
                            label: '90°'
                        },
                        {
                            angle: 180,
                            flipH: true,
                            flipV: true,
                            label: '180°'
                        },
                        {
                            angle: 270,
                            flipH: true,
                            flipV: true,
                            label: '270°'
                        },
                        {
                            angle: 0,
                            flipH: true,
                            flipV: false,
                            label: 'flip horizontal'
                        },
                        {
                            angle: 0,
                            flipH: false,
                            flipV: true,
                            label: 'flip vertical'
                        }
                    ];

                    for (const orientation of orientations) {
                        try {
                            const result = await tryDecode(canvas, orientation.angle, orientation.flipH, orientation.flipV);
                            console.log(`✓ Barcode detected (${orientation.label}):`, result.getText());
                            onScanSuccess(result.getText());
                            return;
                        } catch (err) {
                            // Continue ke orientasi berikutnya
                        }
                    }

                    // Jika semua orientasi gagal
                    console.log('Decode failed: No barcode found in any orientation');
                    if (msgEl) {
                        msgEl.innerText = "❌ Barcode tidak terdeteksi. Pastikan foto fokus dan jelas.";
                        msgEl.classList.remove('text-blue-600', 'font-bold');
                        msgEl.classList.add('text-red-500');
                    }
                    event.target.value = '';
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
    @endscript

    @assets
        <style>
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

            #reader video {
                object-fit: cover;
                width: 100% !important;
                height: 100% !important;
                border-radius: 1.5rem;
            }
        </style>
    @endassets
</div>
