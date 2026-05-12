<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\WargaAuthController;
use App\Http\Controllers\SuratController;
use App\Http\Controllers\Warga\WargaController;
use App\Http\Controllers\Warga\PengumumanWargaController;
use App\Http\Controllers\Auth\AdminAuthController;
use App\Http\Controllers\Admin\AdminSuratController;
use App\Http\Controllers\Admin\PegawaiController;
use App\Http\Controllers\Admin\AdminWargaController;
use App\Http\Controllers\Admin\SettingSuratController;
use App\Http\Controllers\Admin\PengumumanController;
use App\Http\Controllers\Admin\LaporanController;



//WARGA

// --- LANDING PAGE ---
Route::get('/', function () {
    return view('landing');
})->name('landing');

// --- AUTHENTICATION WARGA ---
Route::middleware(['guest'])->group(function () {
    Route::get('/register', [WargaAuthController::class, 'showRegister'])->name('register.warga');
    Route::post('/register', [WargaAuthController::class, 'register'])->name('register.warga.store');
    Route::get('/login', [WargaAuthController::class, 'showLogin'])->name('login.warga');
    Route::post('/login', [WargaAuthController::class, 'login'])->name('login.warga.submit');
    
    // API ini dipindahkan ke sini agar bisa diakses landing page jika perlu data realtime
    Route::get('/api/stats-realtime', [WargaController::class, 'getStatsRealtime'])->name('warga.stats.realtime');
});

// --- AUTHENTICATED ROUTES (Sudah Login) ---
Route::middleware(['warga_auth'])->group(function () {
    
    // Pastikan WargaAuthController@logout melakukan: return redirect()->route('landing');
    Route::post('/logout', [WargaAuthController::class, 'logout'])->name('logout.warga');

    Route::get('/dashboard', [WargaController::class, 'dashboard'])->name('warga.dashboard');
    Route::get('/ajukan-surat', [WargaController::class, 'ajukanSurat'])->name('warga.ajukan');
    Route::get('/riwayat-surat', [WargaController::class, 'riwayatSurat'])->name('warga.riwayat');
    Route::get('/profil-saya', [WargaController::class, 'profil'])->name('warga.profil');
    Route::put('/profile/update', [WargaController::class, 'updateProfile'])->name('warga.profile.update');

    Route::prefix('warga/surat')->name('warga.surat.')->group(function() {
        Route::get('/detail/{id}', [WargaController::class, 'showDetail'])->name('detail');
        Route::get('/edit/{id}', [WargaController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [WargaController::class, 'update'])->name('update');
        Route::post('/batal/{id}', [WargaController::class, 'batalkan'])->name('batal');
    });

    Route::get('/form-surat/{tipe}', [SuratController::class, 'create'])->name('surat.buat');
    Route::post('/simpan-surat', [SuratController::class, 'store'])->name('surat.store');
});
Route::get('/pengumuman', [PengumumanWargaController::class, 'index'])->name('warga.pengumuman.index');
Route::get('/pengumuman/{id}', [PengumumanWargaController::class, 'show'])->name('warga.pengumuman.show');





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
        Route::get('/surat-hari-ini', [AdminSuratController::class, 'suratHariIni'])->name('admin.surat.hari-ini');
        Route::post('/surat/proses/{id}', [AdminSuratController::class, 'proses'])->name('admin.surat.proses');
        Route::post('/surat/tolak/{id}', [AdminSuratController::class, 'tolak'])->name('admin.surat.tolak');
        Route::get('/admin/surat-masuk', [AdminSuratController::class, 'suratMasuk'])->name('admin.surat.masuk');
        Route::get('/admin/riwayat-surat', [AdminSuratController::class, 'riwayatSurat'])->name('admin.surat.riwayat');
        
        // 3. Manajemen Pegawai (Data Master Pejabat)
        Route::get('/pegawai', [PegawaiController::class, 'index'])->name('admin.pegawai.index');
        Route::post('/pegawai', [PegawaiController::class, 'store'])->name('admin.pegawai.store');
        Route::put('/pegawai/{id}', [PegawaiController::class, 'update'])->name('admin.pegawai.update');
        Route::delete('/pegawai/{id}', [PegawaiController::class, 'destroy'])->name('admin.pegawai.destroy');

        // 4. Manajemen Warga (Data Master Warga)
        Route::get('/warga', [AdminWargaController::class, 'index'])->name('admin.warga.index');
        Route::get('/warga/{id}', [AdminWargaController::class, 'show'])->name('admin.warga.show');
        Route::post('/warga/toggle-status/{id}', [AdminWargaController::class, 'toggleStatus'])->name('admin.warga.toggle-status');

        // 5. Fitur Cetak (Akan kita buat selanjutnya)
        Route::post('admin/surat/{id}/proses', [AdminSuratController::class, 'proses'])->name('admin.surat.proses');
        Route::post('admin/surat/{id}/selesai', [AdminSuratController::class, 'selesai'])->name('admin.surat.selesai');
        Route::get('/surat/cetak/{id}', [AdminSuratController::class, 'cetak'])->name('admin.surat.cetak');
        Route::post('/admin/surat/{id}/update-cetak', [SuratController::class, 'updateCetak'])->name('admin.surat.update-cetak');

        // 6. Fitur Setting Surat
        Route::get('/setting', [SettingSuratController::class, 'index'])->name('admin.setting.index');
        Route::post('/setting/profil', [SettingSuratController::class, 'updateProfil'])->name('admin.setting.updateProfil');
        Route::post('/setting/penutup/{id}', [SettingSuratController::class, 'updatePenutup'])->name('admin.setting.updatePenutup');

        // 7. laporan
        Route::get('/laporan', [LaporanController::class, 'index'])->name('admin.laporan.index');
        Route::get('/laporan/preview', [LaporanController::class, 'preview'])->name('admin.laporan.preview');
        Route::get('/laporan/export', [LaporanController::class, 'exportExcel'])->name('admin.laporan.export');

      });
      Route::resource('pengumuman', PengumumanController::class)->names([
    'index'   => 'admin.pengumuman.index',
    'create'  => 'admin.pengumuman.create',
    'store'   => 'admin.pengumuman.store',
    'edit'    => 'admin.pengumuman.edit',
    'update'  => 'admin.pengumuman.update',
    'show'    => 'admin.pengumuman.show',
    'destroy' => 'admin.pengumuman.destroy',
]);

});


