<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\WargaAuthController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\WargaController;

// --- LANDING PAGE ---
Route::get('/', function () {
    return view('landing');
})->name('landing');

// --- AUTHENTICATION WARGA ---
Route::get('/register', [WargaAuthController::class, 'showRegister'])->name('register.warga');
Route::post('/register', [WargaAuthController::class, 'register'])->name('register.warga.store');
Route::get('/login', [WargaAuthController::class, 'showLogin'])->name('login.warga');
Route::post('/login', [WargaAuthController::class, 'login'])->name('login.warga.submit');
Route::post('/logout', [WargaAuthController::class, 'logout'])->name('logout.warga');

// --- GROUP ROUTE WARGA (Proteksi Middleware) ---
Route::middleware(['warga_auth'])->group(function () {
    
    // DASHBOARD (Sekarang menggunakan Controller)
    Route::get('/dashboard', [WargaController::class, 'index'])->name('warga.dashboard');

    Route::get('/profil', function () {
        return view('warga.profil'); // Pastikan file view ada
    })->name('warga.profil');


// Route Detail, Batal, Edit
// Route untuk Detail Surat (AJAX)
// Route Batalkan Surat
    Route::post('/warga/surat/batal/{id}', [WargaController::class, 'batalkan'])->name('warga.surat.batal');
// Placeholder Edit (sesuaikan dengan controller edit Anda nantinya)
//Route::get('/warga/surat/edit/{id}', [WargaController::class, 'edit'])->name('warga.surat.edit');
//Route::put('/warga/surat/update/{id}', [WargaController::class, 'update'])->name('warga.surat.update'); 
//Route::get('/warga/surat/detail/{id}', [WargaController::class, 'showDetail']);

Route::get('/warga/surat/detail/{id}', [WargaController::class, 'showDetail'])->name('warga.surat.detail');
Route::get('/warga/surat/edit/{id}', [WargaController::class, 'edit'])->name('warga.surat.edit');
Route::put('/warga/surat/update/{id}', [WargaController::class, 'update'])->name('warga.surat.update');

    // --- PROSES PENGAJUAN SURAT ---
    Route::get('/buat-surat/{tipe}', [SuratController::class, 'create'])->name('surat.buat');
    Route::post('/simpan-surat', [SuratController::class, 'store'])->name('surat.store');
});