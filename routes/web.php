<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\History;
use App\Livewire\ScanDetail;
use App\Livewire\ScanBarcode;
use App\Livewire\AiConsultation;
use App\Livewire\Bio;
use App\Http\Controllers\Api\ProductController;
use App\Livewire\Profile;

Route::view('/', 'welcome');

Route::get('/products/{barcode}', [ProductController::class, 'show'])->name('products.show');
Route::post('/products/{barcode}/store-ai', [ProductController::class, 'storeFromAI'])->name('products.store-ai');
Route::post('/products/{barcode}/consume', [ProductController::class, 'consume'])->middleware('auth')->name('products.consume');

Route::get('/scan', ScanBarcode::class)->name('scan.barcode');
Route::get('/bio', Bio::class)->middleware(['auth'])->name('bio');
Route::post('/assistant/response', [App\Http\Controllers\ChatStreamController::class, 'response'])->name('assistant.response');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/history', History::class)->name('history');
    Route::get('/scan/{id}', ScanDetail::class)->name('scan.detail');
    Route::get('/assistant', AiConsultation::class)->name('assistant');
    Route::post('/assistant/stream', [App\Http\Controllers\ChatStreamController::class, 'stream'])->name('assistant.stream');
    Route::get('/profile', Profile::class)->name('profile');
});

Route::get('/google/redirect', [App\Http\Controllers\GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [App\Http\Controllers\GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

require __DIR__ . '/auth.php';