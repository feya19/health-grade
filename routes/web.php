<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\History;
use App\Livewire\ScanDetail;
use App\Livewire\ScanBarcode;
use App\Livewire\AiConsultation;
use App\Livewire\Bio;
use App\Http\Controllers\Api\ProductController;

Route::view('/', 'welcome');

Route::get('/products/{barcode}', [ProductController::class, 'show'])->name('products.show');
Route::get('/scan', ScanBarcode::class)->name('scan.barcode');
Route::get('/bio', Bio::class)->middleware(['auth'])->name('bio');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', Dashboard::class)->name('dashboard');
    Route::get('/history', History::class)->name('history');
    Route::get('/scan/{id}', ScanDetail::class)->name('scan.detail');
    Route::get('/assistant', AiConsultation::class)->name('assistant');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/google/redirect', [App\Http\Controllers\GoogleLoginController::class, 'redirectToGoogle'])->name('google.redirect');
Route::get('/google/callback', [App\Http\Controllers\GoogleLoginController::class, 'handleGoogleCallback'])->name('google.callback');

require __DIR__ . '/auth.php';
