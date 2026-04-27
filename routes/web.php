<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\WargaAuthController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\WargaController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminSuratController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\AdminWargaController;

// --- LANDING PAGE ---
Route::get('/', function () {
    return view('landing');
})->name('landing');

//WARGA

// --- AUTHENTICATION WARGA ---
Route::get('/register', [WargaAuthController::class, 'showRegister'])->name('register.warga');
Route::post('/register', [WargaAuthController::class, 'register'])->name('register.warga.store');
Route::get('/login', [WargaAuthController::class, 'showLogin'])->name('login.warga');
Route::post('/login', [WargaAuthController::class, 'login'])->name('login.warga.submit');
Route::post('/logout', [WargaAuthController::class, 'logout'])->name('logout.warga');

// --- GROUP ROUTE WARGA (Proteksi Middleware) ---
Route::middleware(['warga_auth'])->group(function () {
    
    // DASHBOARD 
    Route::get('/dashboard', [WargaController::class, 'index'])->name('warga.dashboard');
    Route::get('/profil', function () {
        return view('warga.profil'); 
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


//ADMIN
// Redirect halaman depan admin ke login
Route::get('/admin', function () {
    return redirect()->route('admin.login');
});

Route::prefix('admin')->group(function () {
    
    // --- AUTHENTICATION ---
    Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('admin.login');
    Route::post('/login', [AdminAuthController::class, 'login'])->name('admin.login.submit');
    Route::post('/logout', [AdminAuthController::class, 'logout'])->name('admin.logout');

    // --- PROTECTED ROUTES (Harus Login) ---
    Route::middleware('auth:admin')->group(function () {
        
        // 1. Dashboard Utama
        Route::get('/dashboard', [AdminSuratController::class, 'dashboard'])->name('admin.dashboard');
        
        // 2. Manajemen Surat (Index, Detail, Proses, Tolak)
        Route::get('/surat', [AdminSuratController::class, 'index'])->name('admin.surat.index');
        Route::get('/surat/{id}', [AdminSuratController::class, 'show'])->name('admin.surat.show');
        Route::post('/surat/proses/{id}', [AdminSuratController::class, 'proses'])->name('admin.surat.proses');
        Route::post('/surat/tolak/{id}', [AdminSuratController::class, 'tolak'])->name('admin.surat.tolak');
        
        // 3. Manajemen Pegawai (Data Master Pejabat)
        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('admin.pegawai.index');
        Route::post('/pegawai', [PegawaiController::class, 'store'])->name('admin.pegawai.store');
        Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('admin.pegawai.update');
        Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('admin.pegawai.destroy');

        // 4. Manajemen Warga (Data Master Warga)
        // 4. Manajemen Warga (Data Master Warga)
        Route::get('/warga', [AdminWargaController::class, 'index'])->name('admin.warga.index');
        Route::get('/warga/{id}', [AdminWargaController::class, 'show'])->name('admin.warga.show');
        Route::put('/warga/{id}', [AdminWargaController::class, 'update'])->name('admin.warga.update'); // Tambahkan ini untuk edit
        Route::delete('/warga/{id}', [AdminWargaController::class, 'destroy'])->name('admin.warga.destroy');
        
        // 5. Fitur Cetak (Akan kita buat selanjutnya)
        // Gunakan AdminSuratController sesuai nama class di file Controller Anda
        Route::post('admin/surat/{id}/proses', [AdminSuratController::class, 'proses'])->name('admin.surat.proses');
        Route::post('admin/surat/{id}/selesai', [AdminSuratController::class, 'selesai'])->name('admin.surat.updateStatus');
        Route::get('/surat/cetak/{id}', [AdminSuratController::class, 'cetak'])->name('admin.surat.cetak');
    });
    
});