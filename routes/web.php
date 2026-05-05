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
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [WargaAuthController::class, 'showRegister'])->name('register.warga');
    Route::post('/register', [WargaAuthController::class, 'register'])->name('register.warga.store');
    Route::get('/login', [WargaAuthController::class, 'showLogin'])->name('login.warga');
    Route::post('/login', [WargaAuthController::class, 'login'])->name('login.warga.submit');
    // Tambahkan di dalam group middleware warga_auth
    Route::get('/api/stats-realtime', [WargaController::class, 'getStatsRealtime'])->name('warga.stats.realtime');
});

// --- AUTHENTICATED ROUTES (Sudah Login) ---
Route::middleware(['warga_auth'])->group(function () {
    
    // Logika Logout
    Route::post('/logout', [WargaAuthController::class, 'logout'])->name('logout.warga');

    // 1. Dashboard Utama
    Route::get('/dashboard', [WargaController::class, 'dashboard'])->name('warga.dashboard');

    // 2. Halaman Ajukan Surat (Pilihan Jenis Surat)
    Route::get('/ajukan-surat', [WargaController::class, 'ajukanSurat'])->name('warga.ajukan');

    // 3. Halaman Riwayat Surat (Daftar Semua Surat)
    Route::get('/riwayat-surat', [WargaController::class, 'riwayatSurat'])->name('warga.riwayat');

    // 4. Halaman Profil Lengkap
    Route::get('/profil-saya', [WargaController::class, 'profil'])->name('warga.profil');
    Route::put('/profile/update', [WargaController::class, 'updateProfile'])->name('warga.profile.update');

    // --- MANAJEMEN SURAT (DETAIL, EDIT, BATAL) ---
    Route::prefix('warga/surat')->name('warga.surat.')->group(function() {
        Route::get('/detail/{id}', [WargaController::class, 'showDetail'])->name('detail');
        Route::get('/edit/{id}', [WargaController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [WargaController::class, 'update'])->name('update');
        Route::post('/batal/{id}', [WargaController::class, 'batalkan'])->name('batal');
    });

    // --- PROSES FORM INPUT SURAT (LOGIC DARI SURATCONTROLLER) ---
    Route::get('/form-surat/{tipe}', [SuratController::class, 'create'])->name('surat.buat');
    Route::post('/simpan-surat', [SuratController::class, 'store'])->name('surat.store');
});

// Redirect root ke dashboard jika sudah login, atau ke login jika belum
Route::get('/', function () {
    return session()->has('warga_logged_in') ? redirect()->route('warga.dashboard') : redirect()->route('login.warga');
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
        //Route::put('/warga/{id}', [AdminWargaController::class, 'update'])->name('admin.warga.update'); // Tambahkan ini untuk edit
        //Route::delete('/warga/{id}', [AdminWargaController::class, 'destroy'])->name('admin.warga.destroy');
        // 4. Manajemen Warga (Hanya Lihat dan Aktivasi)
        // Rute khusus untuk mengubah status Aktif/Nonaktif
        Route::post('/warga/toggle-status/{id}', [AdminWargaController::class, 'toggleStatus'])->name('admin.warga.toggle-status');


        // 5. Fitur Cetak (Akan kita buat selanjutnya)
        // Gunakan AdminSuratController sesuai nama class di file Controller Anda
        Route::post('admin/surat/{id}/proses', [AdminSuratController::class, 'proses'])->name('admin.surat.proses');
        Route::post('admin/surat/{id}/selesai', [AdminSuratController::class, 'selesai'])->name('admin.surat.updateStatus');
        Route::get('/surat/cetak/{id}', [AdminSuratController::class, 'cetak'])->name('admin.surat.cetak');
    });
    
});