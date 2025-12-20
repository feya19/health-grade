<div class="max-w-xl mx-auto relative p-6 flex flex-col justify-center">

    {{-- Scanner Section --}}
    <div id="scanner-section">
        {{-- Back Button --}}
        <a href="{{ route('dashboard') }}" wire:navigate class="inline-flex items-center gap-1 text-gray-500 hover:text-hg-dark text-sm font-medium mb-4 transition">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
            Kembali
        </a>
        
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

            <video id="reader" class="w-full h-full object-cover"></video>

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

            <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
                <p class="text-sm text-gray-600 mb-3 font-medium">Atau upload foto barcode:</p>
                <label for="barcode-upload" class="cursor-pointer">
                    <div class="flex items-center justify-center gap-3 bg-hg-primary hover:bg-hg-secondary text-white py-3 px-6 rounded-xl transition font-medium">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>Pilih Gambar</span>
                    </div>
                </label>
                <input type="file" id="barcode-upload" accept="image/*" capture="environment" class="hidden">
            </div>
        </div>
    </div>

    {{-- Product Result Section --}}
    <div id="product-section" style="display: none;">
        <div class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200 mb-6">
            <p class="text-sm text-gray-500 mb-2">Barcode:</p>
            <p id="barcode-display" class="text-2xl font-bold text-hg-primary"></p>
        </div>

        <div id="product-loading" class="bg-white rounded-2xl p-8 shadow-lg border border-gray-200">
            <div class="flex flex-col items-center">
                <svg class="w-12 h-12 animate-spin text-hg-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p id="loading-text" class="mt-4 text-gray-600 font-medium">Memuat data produk...</p>
            </div>
        </div>

        {{-- Product Info (Grading Page) --}}
        <div id="product-info" style="display: none;" class="bg-white rounded-2xl p-6 shadow-lg border border-gray-200">
            <div class="flex gap-4 mb-6">
                <img id="product-image" src="" alt="Product" class="w-24 h-24 object-cover rounded-lg">
                <div class="flex-1">
                    <h3 id="product-name" class="text-lg font-bold text-hg-dark mb-1"></h3>
                    <p id="product-brands" class="text-sm text-gray-500"></p>
                </div>
            </div>

            {{-- Grade Display - Colors set dynamically by JS --}}
            <div id="grade-display" class="text-center p-6 rounded-2xl mb-6 bg-gray-100">
                <p class="text-sm mb-2 opacity-80">Health Grade</p>
                <p id="final-grade" class="text-6xl font-bold"></p>
            </div>

            <p class="mt-4 text-center text-xs text-gray-500">
                Semua nilai gizi ditampilkan <strong>per 100g/100ml</strong>
            </p>
            <div id="nutrition-facts" class="space-y-2"></div>

            {{-- Consume Section --}}
            <div class="mt-6 p-4 bg-green-50 rounded-xl border border-green-200">
                <div class="text-center mb-4">
                    <p class="text-sm text-green-700 font-medium">Catat sebagai dikonsumsi?</p>
                    <p id="serving-info" class="text-xs text-gray-500 mt-1"></p>
                </div>
                
                {{-- Quantity Input - Vertical Stack for Mobile --}}
                <div class="flex flex-col items-center gap-3">
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-600 whitespace-nowrap">Porsi:</label>
                        <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden bg-white">
                            <button id="qty-minus" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold flex items-center justify-center">−</button>
                            <input type="number" id="consume-qty" value="1" min="0.1" max="10" step="0.1" class="w-16 h-10 text-center border-0 focus:ring-0 text-base font-medium">
                            <button id="qty-plus" class="w-10 h-10 bg-gray-100 hover:bg-gray-200 text-gray-600 font-bold flex items-center justify-center">+</button>
                        </div>
                    </div>
                    
                    <button id="consume-btn" class="w-full max-w-[200px] py-2.5 bg-green-500 hover:bg-green-600 text-white rounded-lg font-medium transition flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Konsumsi
                    </button>
                </div>
                
                <p id="estimated-calories" class="text-xs text-center text-gray-500 mt-3"></p>
                <p id="consume-success" style="display: none;" class="text-green-600 text-sm text-center mt-2 font-medium">✓ Tercatat!</p>
            </div>

            {{-- Grading Page Action --}}
            <div class="flex justify-center gap-4 mt-6">
                <button id="scan-again-btn" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-xl font-medium transition">
                    Scan Lagi
                </button>
                <a href="{{ route('assistant') }}" class="px-6 py-3 bg-hg-primary hover:bg-hg-secondary text-white rounded-xl font-medium transition flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                    </svg>
                    Chat ke AI
                </a>
            </div>
        </div>

        {{-- AI Vision Section (No back/scan buttons during acquisition) --}}
        <div id="ai-vision-section" style="display: none;" class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-2xl p-6 border border-amber-200">
            <div class="text-center mb-4">
                <div class="w-16 h-16 bg-amber-100 rounded-full flex items-center justify-center mx-auto mb-3">
                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                </div>
                <h3 id="ai-vision-title" class="text-lg font-bold text-amber-800">Data Nutrisi Tidak Lengkap</h3>
                <p class="text-sm text-amber-600 mt-1">Foto tabel nutrisi pada kemasan untuk melengkapi data.</p>
            </div>

            {{-- Editable Product Info --}}
            <div id="product-name-input-section" class="mb-4 space-y-3">
                <div>
                    <label class="block text-sm font-medium text-amber-700 mb-1">Nama Produk</label>
                    <input type="text" id="input-product-name" class="w-full px-4 py-2 border border-amber-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" placeholder="Masukkan nama produk...">
                </div>
                <div>
                    <label class="block text-sm font-medium text-amber-700 mb-1">Brand/Merek</label>
                    <input type="text" id="input-product-brand" class="w-full px-4 py-2 border border-amber-300 rounded-lg focus:ring-2 focus:ring-amber-500 focus:border-amber-500" placeholder="Masukkan merek produk...">
                </div>
            </div>

            <label for="nutrition-label-upload" class="cursor-pointer block">
                <div class="flex items-center justify-center gap-3 bg-amber-500 hover:bg-amber-600 text-white py-4 px-6 rounded-xl transition font-medium">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <span>Foto Tabel Nutrisi</span>
                </div>
            </label>
            <input type="file" id="nutrition-label-upload" accept="image/*" capture="environment" class="hidden">

            <div id="ai-extracting" style="display: none;" class="mt-4 text-center">
                <svg class="w-8 h-8 animate-spin text-amber-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <p class="text-amber-600 font-medium mt-2">AI sedang mengekstrak data nutrisi...</p>
            </div>
        </div>

        {{-- AI Confirm Section --}}
        <div id="ai-confirm-section" style="display: none;" class="bg-green-50 rounded-2xl p-6 border border-green-200">
            <h3 class="text-lg font-bold text-green-800 mb-4 text-center">✓ Data Berhasil Diekstrak</h3>
            <div id="ai-extracted-data" class="space-y-2 mb-4"></div>
            <div class="flex gap-3">
                <button id="ai-confirm-btn" class="flex-1 py-3 bg-green-500 hover:bg-green-600 text-white rounded-xl font-medium transition">
                    Simpan & Lihat Grade
                </button>
                <button id="ai-retry-btn" class="py-3 px-4 bg-gray-200 hover:bg-gray-300 text-gray-700 rounded-xl font-medium transition">
                    Ulangi
                </button>
            </div>
        </div>

        {{-- Error State --}}
        <div id="product-error" style="display: none;" class="bg-red-50 rounded-2xl p-6 border border-red-200">
            <p class="text-red-600 font-medium text-center">❌ Terjadi kesalahan. Silakan coba lagi.</p>
            <div class="flex justify-center mt-4">
                <button id="error-scan-again" class="px-6 py-3 bg-red-500 hover:bg-red-600 text-white rounded-xl font-medium transition">
                    Scan Lagi
                </button>
            </div>
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
            let currentBarcode = null;
            let extractedNutrition = null;
            let partialProductData = null;
            let currentProductData = null; // Store product for calorie calculation

            document.addEventListener('DOMContentLoaded', init);
            document.addEventListener('livewire:navigated', init);

            function init() {
                if (isInitialized) return;
                isInitialized = true;

                startScanner();

                document.getElementById('barcode-upload')?.addEventListener('change', handleImageUpload);
                document.getElementById('scan-again-btn')?.addEventListener('click', resetScanner);
                document.getElementById('error-scan-again')?.addEventListener('click', resetScanner);
                document.getElementById('nutrition-label-upload')?.addEventListener('change', handleNutritionLabelUpload);
                document.getElementById('ai-confirm-btn')?.addEventListener('click', confirmAIExtraction);
                document.getElementById('ai-retry-btn')?.addEventListener('click', retryAIExtraction);
                
                // Consume button handlers
                document.getElementById('consume-btn')?.addEventListener('click', handleConsume);
                document.getElementById('qty-minus')?.addEventListener('click', () => {
                    const input = document.getElementById('consume-qty');
                    const val = parseFloat(input.value) || 1;
                    if (val > 0.5) {
                        input.value = (val - 0.5).toFixed(1);
                        updateEstimatedCalories();
                    }
                });
                document.getElementById('qty-plus')?.addEventListener('click', () => {
                    const input = document.getElementById('consume-qty');
                    const val = parseFloat(input.value) || 1;
                    if (val < 10) {
                        input.value = (val + 0.5).toFixed(1);
                        updateEstimatedCalories();
                    }
                });
                document.getElementById('consume-qty')?.addEventListener('change', updateEstimatedCalories);
                document.getElementById('consume-qty')?.addEventListener('input', updateEstimatedCalories);
                
                // Auto-stop camera when navigating away or page becomes hidden
                document.addEventListener('livewire:navigating', cleanupCamera);
                window.addEventListener('beforeunload', cleanupCamera);
                window.addEventListener('pagehide', cleanupCamera);
            }
            
            function cleanupCamera() {
                stopScanner();
                isInitialized = false;
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
                    if (videoElement.paused) await videoElement.play();

                    if (loadingEl) loadingEl.style.display = 'none';

                    isScanning = true;

                    // Decode dengan interval lebih cepat dan tryInverted untuk barcode terbalik
                    codeReader.timeBetweenDecodingAttempts = 300; // 300ms lebih cepat

                    codeReader.decodeFromVideoElement(videoElement, (result, err) => {
                        if (!isScanning) return;
                        if (result) {
                            stopScanner();
                            onScanSuccess(result.getText());
                        }
                    });
                } catch (err) {
                    console.error('Camera error:', err);
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
                if (videoElement) videoElement.srcObject = null;
                codeReader = null;
            }

            function onScanSuccess(decodedText) {
                currentBarcode = decodedText;
                
                document.getElementById('scanner-section').style.display = 'none';
                document.getElementById('product-section').style.display = 'block';
                document.getElementById('barcode-display').textContent = decodedText;

                fetchProduct(decodedText);
            }

            async function fetchProduct(barcode) {
                showLoading('Memuat data produk...');

                try {
                    const response = await fetch(`/products/${barcode}`);
                    const data = await response.json();

                    console.log('API Response:', data);

                    if (data.needs_ai_vision) {
                        partialProductData = data.partial_data;
                        showAIVisionSection(data.partial_data);
                    } else if (data.product_name) {
                        displayProduct(data);
                    } else {
                        showError();
                    }
                } catch (error) {
                    console.error('API Error:', error);
                    showError();
                }
            }

            function showLoading(text) {
                document.getElementById('product-loading').style.display = 'block';
                document.getElementById('loading-text').textContent = text;
                document.getElementById('product-info').style.display = 'none';
                document.getElementById('ai-vision-section').style.display = 'none';
                document.getElementById('ai-confirm-section').style.display = 'none';
                document.getElementById('product-error').style.display = 'none';
            }

            function showAIVisionSection(partialData) {
                document.getElementById('product-loading').style.display = 'none';
                document.getElementById('ai-vision-section').style.display = 'block';

                // Pre-fill product name and brand if available
                const nameInput = document.getElementById('input-product-name');
                const brandInput = document.getElementById('input-product-brand');
                
                if (partialData) {
                    if (partialData.product_name) nameInput.value = partialData.product_name;
                    if (partialData.brands) brandInput.value = partialData.brands;
                }
            }

            function displayProduct(product) {
                document.getElementById('product-loading').style.display = 'none';
                document.getElementById('product-info').style.display = 'block';
                
                // Store for calorie calculation
                currentProductData = product;

                document.getElementById('product-image').src = product.image || '/images/no-image.png';
                document.getElementById('product-name').textContent = product.product_name || 'Unknown Product';
                document.getElementById('product-brands').textContent = product.brands || '';
                
                // Set grade with matching colors from history page
                const grade = product.health_grade?.final_grade || 'N/A';
                document.getElementById('final-grade').textContent = grade;
                
                const gradeDisplay = document.getElementById('grade-display');
                gradeDisplay.className = 'text-center p-6 rounded-2xl mb-6 ';
                switch(grade) {
                    case 'A':
                        gradeDisplay.className += 'bg-green-100 text-green-700';
                        break;
                    case 'B':
                        gradeDisplay.className += 'bg-lime-100 text-lime-700';
                        break;
                    case 'C':
                        gradeDisplay.className += 'bg-orange-100 text-orange-700';
                        break;
                    case 'D':
                        gradeDisplay.className += 'bg-red-100 text-red-700';
                        break;
                    default:
                        gradeDisplay.className += 'bg-gray-100 text-gray-500';
                }

                const nutrition = product.nutrition || {};
                const saltValue = nutrition.salt_100g || nutrition.sodium_100g;
                
                // Show serving size info
                const servingSizeG = product.serving_size_g || 100;
                const servingSize = product.serving_size || `${servingSizeG}g`;
                document.getElementById('serving-info').textContent = `1 porsi = ${servingSize}`;
                
                // Calculate and show estimated calories
                updateEstimatedCalories();
                
                document.getElementById('nutrition-facts').innerHTML = `
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Energi</span>
                        <span class="font-medium">${nutrition.energy_kcal_100g || 0} kcal</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Gula</span>
                        <span class="font-medium">${nutrition.sugars_100g || 0} g</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Lemak Jenuh</span>
                        <span class="font-medium">${nutrition.saturated_fat_100g || 0} g</span>
                    </div>
                    <div class="flex justify-between py-2 border-b">
                        <span class="text-gray-600">Protein</span>
                        <span class="font-medium">${nutrition.proteins_100g || 0} g</span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span class="text-gray-600">Garam</span>
                        <span class="font-medium">${saltValue} g</span>
                    </div>
                `;
            }
            
            function updateEstimatedCalories() {
                if (!currentProductData) return;
                
                const qty = parseFloat(document.getElementById('consume-qty').value) || 1;
                const servingSizeG = currentProductData.serving_size_g || 100;
                const caloriesPer100g = currentProductData.nutrition?.energy_kcal_100g || 0;
                const caloriesPerServing = (caloriesPer100g / 100) * servingSizeG;
                const totalCalories = Math.round(caloriesPerServing * qty);
                
                document.getElementById('estimated-calories').textContent = 
                    `Estimasi: ${totalCalories} kcal (${qty} × ${Math.round(caloriesPerServing)} kcal/porsi)`;
            }

            async function handleNutritionLabelUpload(event) {
                const file = event.target.files[0];
                if (!file) return;

                document.getElementById('ai-extracting').style.display = 'block';

                try {
                    const base64 = await fileToBase64(file);
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    const response = await fetch('{{ route("assistant.response") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({
                            messages: [
                                {
                                    role: 'system',
                                    content: `Extract the "Takaran Saji" (Serving Size) and the values from the "JUMLAH PER SAJIAN" column exactly as shown in the image. Do not perform any math. Return raw numbers.

Important:
For "Takaran Saji", extract the numeric value and the unit (g or ml) separately.
Nutrients are always weight-based (g or mg), even for liquids.

Mapping:
Lemak Total -> fat
Lemak Jenuh -> saturated_fat
Karbohidrat Total -> carbohydrates
Gula -> sugars
Protein -> protein
Garam (Natrium) -> sodium

Output JSON:
{
"serving": {"amount": number, "unit": "string"},
"per_serving": {
"energy_kcal": number,
"fat_g": number,
"saturated_fat_g": number,
"carbohydrates_g": number,
"sugars_g": number,
"protein_g": number,
"sodium_mg": number
}
}`
                                },
                                {
                                    role: 'user',
                                    content: [
                                        { type: 'text', text: 'Ekstrak data nutrisi dari label ini:' },
                                        { type: 'image_url', image_url: { url: base64 } }
                                    ]
                                }
                            ]
                        })
                    });

                    const result = await response.json();
                    console.log('AI Result:', result);
                    
                    if (result.success && result.content) {
                        const jsonMatch = result.content.match(/\{[\s\S]*\}/);
                        if (jsonMatch) {
                            const rawData = JSON.parse(jsonMatch[0]);
                            extractedNutrition = convertToNutritionFormat(rawData);
                            showAIConfirmation(extractedNutrition);
                        } else {
                            throw new Error('Invalid AI response format');
                        }
                    } else {
                        throw new Error(result.message || 'AI extraction failed');
                    }
                } catch (error) {
                    console.error('AI Extraction error:', error);
                    alert('Gagal mengekstrak data. Pastikan foto tabel nutrisi jelas dan coba lagi.');
                    document.getElementById('ai-extracting').style.display = 'none';
                }

                event.target.value = '';
            }

            function convertToNutritionFormat(rawData) {
                // Safety check untuk objek kosong
                const serving = rawData.serving || {};
                const perServing = rawData.per_serving || {};
                
                // Pastikan servingAmount tidak 0 untuk menghindari Infinity
                const servingAmount = serving.amount || 100;
                
                // Faktor konversi ke 100g
                // Contoh: Jika saji 20g -> factor = 5.
                const factor = 100 / servingAmount;
                
                // LOGIKA KHUSUS SODIUM/GARAM
                // 1. Ambil nilai mentah. Prompt kita menghasilkan 'sodium_mg' (miligram).
                // 2. Jika input adalah mg, kita WAJIB membagi 1000 agar menjadi gram.
                // 3. Database standar (OFF) menyimpan sodium_100g dalam satuan GRAM.
                let sodiumInGrams = 0;
                
                if (perServing.sodium_mg !== undefined && perServing.sodium_mg !== null) {
                    sodiumInGrams = perServing.sodium_mg / 1000; // Konversi mg -> g
                } else if (perServing.sodium_g !== undefined) {
                    sodiumInGrams = perServing.sodium_g; // Sudah gram
                }

                // Helper untuk mengambil elemen DOM dengan aman
                const getValue = (id) => {
                    const el = document.getElementById(id);
                    return el ? el.value : null;
                };

                console.log({
                    product_name: getValue('input-product-name') || 'Unknown Product',
                    brand: getValue('input-product-brand') || null,
                    
                    // Menyimpan info serving size asli untuk referensi
                    serving_size: servingAmount,
                    serving_unit: serving.unit || 'g',

                    // Energi (Kcal biasanya bulat)
                    energy_kcal_100g: Math.round((perServing.energy_kcal || 0) * factor),

                    // Makro Utama (Desimal 1 atau 2 cukup)
                    fat_100g: ((perServing.fat_g || 0) * factor).toFixed(2),
                    saturated_fat_100g: ((perServing.saturated_fat_g || 0) * factor).toFixed(2),
                    carbohydrates_100g: ((perServing.carbohydrates_g || 0) * factor).toFixed(2),
                    sugars_100g: ((perServing.sugars_g || 0) * factor).toFixed(2),
                    proteins_100g: ((perServing.protein_g || 0) * factor).toFixed(2),

                    // Sodium (PENTING: Gunakan presisi tinggi, misal 4 desimal)
                    // Contoh: 0.125g sodium
                    sodium_100g: (sodiumInGrams * factor).toFixed(4),
                })

                return {
                    product_name: getValue('input-product-name') || 'Unknown Product',
                    brand: getValue('input-product-brand') || null,
                    
                    // Menyimpan info serving size asli untuk referensi
                    serving_size: servingAmount,
                    serving_unit: serving.unit || 'g',

                    // Energi (Kcal biasanya bulat)
                    energy_kcal_100g: Math.round((perServing.energy_kcal || 0) * factor),

                    // Makro Utama (Desimal 1 atau 2 cukup)
                    fat_100g: ((perServing.fat_g || 0) * factor).toFixed(2),
                    saturated_fat_100g: ((perServing.saturated_fat_g || 0) * factor).toFixed(2),
                    carbohydrates_100g: ((perServing.carbohydrates_g || 0) * factor).toFixed(2),
                    sugars_100g: ((perServing.sugars_g || 0) * factor).toFixed(2),
                    proteins_100g: ((perServing.protein_g || 0) * factor).toFixed(2),

                    // Sodium (PENTING: Gunakan presisi tinggi, misal 4 desimal)
                    // Contoh: 0.125g sodium
                    sodium_100g: (sodiumInGrams * factor).toFixed(4),
                };
            }

            function showAIConfirmation(nutrition) {
                document.getElementById('ai-vision-section').style.display = 'none';
                document.getElementById('ai-confirm-section').style.display = 'block';
                document.getElementById('ai-extracting').style.display = 'none';

                document.getElementById('ai-extracted-data').innerHTML = `
                    <div class="flex justify-between py-1 text-sm">
                        <span class="text-gray-600">Nama</span>
                        <span class="font-medium">${nutrition.product_name}</span>
                    </div>
                    <div class="flex justify-between py-1 text-sm">
                        <span class="text-gray-600">Gula</span>
                        <span class="font-medium text-amber-600">${nutrition.sugars_100g} g/100g</span>
                    </div>
                    <div class="flex justify-between py-1 text-sm">
                        <span class="text-gray-600">Lemak Jenuh</span>
                        <span class="font-medium">${nutrition.saturated_fat_100g} g/100g</span>
                    </div>
                    <div class="flex justify-between py-1 text-sm">
                        <span class="text-gray-600">Garam</span>
                        <span class="font-medium">${nutrition.sodium_100g} g/100g</span>
                    </div>
                    <div class="flex justify-between py-1 text-sm">
                        <span class="text-gray-600">Kalori</span>
                        <span class="font-medium">${nutrition.energy_kcal_100g} kcal</span>
                    </div>
                `;
            }

            async function confirmAIExtraction() {
                if (!extractedNutrition || !currentBarcode) return;

                showLoading('Menyimpan data...');

                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    
                    // Include image URL from partial data if available
                    const dataToSave = {
                        ...extractedNutrition,
                        image_url: partialProductData?.image || null
                    };
                    
                    await fetch(`/products/${currentBarcode}/store-ai`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify(dataToSave)
                    });
                    
                    await fetchProduct(currentBarcode);
                } catch (error) {
                    console.error('Save error:', error);
                    showError();
                }
            }

            function retryAIExtraction() {
                document.getElementById('ai-confirm-section').style.display = 'none';
                document.getElementById('ai-vision-section').style.display = 'block';
                extractedNutrition = null;
            }

            async function handleConsume() {
                if (!currentBarcode) return;
                
                const btn = document.getElementById('consume-btn');
                const successMsg = document.getElementById('consume-success');
                const qty = parseFloat(document.getElementById('consume-qty').value) || 1;
                
                btn.disabled = true;
                btn.innerHTML = '<svg class="w-5 h-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path></svg>';
                
                try {
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    
                    const response = await fetch(`/products/${currentBarcode}/consume`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                        },
                        body: JSON.stringify({ quantity: qty })
                    });
                    
                    const data = await response.json();
                    
                    if (data.success) {
                        successMsg.style.display = 'block';
                        btn.innerHTML = '✓ Tercatat';
                        btn.classList.remove('bg-green-500', 'hover:bg-green-600');
                        btn.classList.add('bg-gray-400');
                    }
                } catch (error) {
                    console.error('Consume error:', error);
                    btn.disabled = false;
                    btn.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Konsumsi';
                }
            }

            function showError() {
                document.getElementById('product-loading').style.display = 'none';
                document.getElementById('product-error').style.display = 'block';
            }

            function resetScanner() {
                stopScanner();
                currentBarcode = null;
                extractedNutrition = null;
                partialProductData = null;
                currentProductData = null;

                const msgEl = document.getElementById('scan-message');
                if (msgEl) {
                    msgEl.innerText = 'Pastikan ruangan cukup cahaya.';
                    msgEl.className = 'text-sm text-gray-500 bg-white py-3 px-6 rounded-full shadow-sm inline-block border border-gray-100';
                }

                document.getElementById('barcode-upload').value = '';
                document.getElementById('nutrition-label-upload').value = '';
                document.getElementById('input-product-name').value = '';
                document.getElementById('input-product-brand').value = '';
                document.getElementById('consume-qty').value = '1';
                document.getElementById('consume-success').style.display = 'none';
                document.getElementById('product-loading').style.display = 'block';
                document.getElementById('product-info').style.display = 'none';
                document.getElementById('ai-vision-section').style.display = 'none';
                document.getElementById('ai-confirm-section').style.display = 'none';
                document.getElementById('product-error').style.display = 'none';
                document.getElementById('product-section').style.display = 'none';
                document.getElementById('scanner-section').style.display = 'block';
                
                // Reset consume button
                const consumeBtn = document.getElementById('consume-btn');
                if (consumeBtn) {
                    consumeBtn.disabled = false;
                    consumeBtn.innerHTML = '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Konsumsi';
                    consumeBtn.classList.remove('bg-gray-400');
                    consumeBtn.classList.add('bg-green-500', 'hover:bg-green-600');
                }

                setTimeout(() => startScanner(), 300);
            }

            function fileToBase64(file) {
                return new Promise((resolve, reject) => {
                    const reader = new FileReader();
                    reader.onload = () => resolve(reader.result);
                    reader.onerror = reject;
                    reader.readAsDataURL(file);
                });
            }

            async function handleImageUpload(event) {
                const file = event.target.files[0];
                if (!file) return;

                stopScanner();
                const msgEl = document.getElementById('scan-message');
                if (msgEl) {
                    msgEl.innerText = "⏳ Membaca barcode...";
                    msgEl.className = 'text-sm text-blue-600 font-bold bg-white py-3 px-6 rounded-full shadow-sm inline-block border border-gray-100';
                }

                try {
                    const imageData = await fileToBase64(file);
                    const img = await loadImage(imageData);
                    const canvas = resizeImage(img, 1920);

                    const { BrowserMultiFormatReader } = window.ZXing || ZXing;
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
                    if (msgEl) {
                        msgEl.innerText = "❌ Barcode tidak terdeteksi";
                        msgEl.className = 'text-sm text-red-500 bg-white py-3 px-6 rounded-full shadow-sm inline-block border border-gray-100';
                    }
                }
                event.target.value = '';
            }

            function loadImage(src) {
                return new Promise((resolve, reject) => {
                    const img = new Image();
                    img.onload = () => resolve(img);
                    img.onerror = reject;
                    img.src = src;
                });
            }

            function resizeImage(img, maxSize) {
                const canvas = document.createElement('canvas');
                let width = img.width, height = img.height;
                if (width > maxSize || height > maxSize) {
                    if (width > height) { height = (height / width) * maxSize; width = maxSize; }
                    else { width = (width / height) * maxSize; height = maxSize; }
                }
                canvas.width = width;
                canvas.height = height;
                canvas.getContext('2d').drawImage(img, 0, 0, width, height);
                return canvas;
            }
        </script>
    @endscript

    @assets
        <style>
            @keyframes scan {
                0% { top: 10%; opacity: 0; }
                50% { opacity: 1; }
                100% { top: 90%; opacity: 0; }
            }
            .animate-scan { animation: scan 2s linear infinite; }
            #reader video { object-fit: cover; width: 100% !important; height: 100% !important; border-radius: 1.5rem; }
        </style>
    @endassets
</div>
