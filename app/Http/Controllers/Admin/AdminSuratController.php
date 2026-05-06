<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 
use Carbon\Carbon; 

class AdminSuratController extends Controller
{
    /**
     * Menampilkan daftar semua pengajuan surat
     */

    public function dashboard()
{
    // Mengambil statistik untuk kotak dashboard
    $stats = [
        'diajukan' => Surat::where('status', 'Diajukan')->count(),
        'diproses' => Surat::where('status', 'Diproses')->count(),
        // Menggunakan whereIn untuk mengambil beberapa status sekaligus
        'ditolak'  => Surat::whereIn('status', ['Ditolak', 'Dibatalkan'])->count(),
        'selesai'  => Surat::where('status', 'Selesai')->count(),
    ];

    // Mengambil 5 surat terbaru untuk tabel dashboard
$surat_terbaru = Surat::with('warga')
    ->whereDate('created_at', \Carbon\Carbon::today()) // Filter khusus hari ini
    ->orderBy('created_at', 'desc')
    ->take(7) // Limit untuk tampilan dashboard
    ->get();

    return view('admin.dashboard', compact('stats', 'surat_terbaru'));
}

    public function index(Request $request)
{
    $query = Surat::with('warga');

    // --- LOGIKA TAMBAHAN UNTUK DASHBOARD UTAMA (HARI INI) ---
    // Jika tidak ada filter dan tidak ada search, tampilkan hanya yang masuk hari ini
    if (!$request->filled('filter') && !$request->filled('search')) {
        $query->whereDate('created_at', \Carbon\Carbon::today());
    }
    // -------------------------------------------------------

    // 1. Filter Status (Fungsi Asli Tetap Ada)
    if ($request->filter == 'masuk') {
        $query->whereIn('status', ['Diajukan', 'Diproses']);
    } elseif ($request->filter == 'riwayat') {
        $query->whereIn('status', ['Ditolak', 'Selesai']);
    }

    // Filter Status (Kapsul)
if ($request->filled('status') && $request->status != 'semua') {
    $query->where('status', $request->status);
}

// Pencarian Tunggal (Jenis, Nomor, Tanggal, Nama, NIK)
if ($request->filled('search')) {
    $search = $request->search;
    $query->where(function($q) use ($search) {
        $q->where('jenis_surat', 'LIKE', "%$search%")
          ->orWhere('nomor_surat', 'LIKE', "%$search%")
          ->orWhere('created_at', 'LIKE', "%$search%")
          ->orWhereHas('warga', function($w) use ($search) {
              $w->where('nama_lengkap', 'LIKE', "%$search%")
                ->orWhere('nik', 'LIKE', "%$search%");
          });
    });
}

    // 3. Urutan & Paginasi
    $surat_terbaru = $query->oldest()->paginate(10);

    // Statistik
    $stats = [
        'diajukan' => Surat::where('status', 'Diajukan')->count(),
        'diproses' => Surat::where('status', 'Diproses')->count(),
        'ditolak'  => Surat::where('status', 'Ditolak')->count(),
        'selesai'  => Surat::where('status', 'Selesai')->count(),
    ];

    return view('admin.dashboard', compact('surat_terbaru', 'stats'));
}

    /**
     * Menampilkan detail surat dan form validasi
     */
    public function show($id)
    {
        $surat = Surat::with('warga')->findOrFail($id);
        $pegawai = Pegawai::all(); 

        return view('admin.surat.detail', compact('surat', 'pegawai'));
    }

   public function suratHariIni(Request $request)
{
    $query = Surat::with('warga')->whereDate('created_at', \Carbon\Carbon::today());

    // Filter Status (Kapsul)
    if ($request->filled('status') && $request->status != 'semua') {
        $query->where('status', $request->status);
    }

    // Filter Tanggal (Kalender) - Jika ingin mencari di hari ini tetap spesifik
    if ($request->filled('tanggal')) {
        $query->whereDate('created_at', $request->tanggal);
    }

    // Pencarian Tunggal
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('jenis_surat', 'LIKE', "%$search%")
              ->orWhere('nomor_surat', 'LIKE', "%$search%")
              ->orWhereHas('warga', function($w) use ($search) {
                  $w->where('nama_lengkap', 'LIKE', "%$search%")
                    ->orWhere('nik', 'LIKE', "%$search%");
              });
        });
    }

    $data = $query->latest()->paginate(200);
    return view('admin.surat.surat_hari_ini', compact('data'));
}

public function suratMasuk(Request $request)
{
    // Mengambil status 'Diajukan' dan 'Diproses' dari semua hari
    $query = Surat::with('warga')
        ->whereIn('status', ['Diajukan', 'Diproses']);

    // Filter Status (Kapsul: Semua, Diajukan, Diproses)
    if ($request->filled('status') && $request->status != 'semua') {
        $query->where('status', $request->status);
    }

    // Filter Tanggal (Dari Input Kalender)
    if ($request->filled('tanggal')) {
        $query->whereDate('created_at', $request->tanggal);
    }

    // Pencarian Tunggal (Jenis, Nomor, Nama, NIK)
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('jenis_surat', 'LIKE', "%$search%")
                ->orWhere('nomor_surat', 'LIKE', "%$search%")
                ->orWhereHas('warga', function($w) use ($search) {
                    $w->where('nama_lengkap', 'LIKE', "%$search%")
                        ->orWhere('nik', 'LIKE', "%$search%");
                });
        });
    }

    $data = $query->latest()->paginate(200);
    
    // Kita arahkan ke file khusus surat masuk
    return view('admin.surat.surat_masuk', compact('data'));
}

public function riwayatSurat(Request $request)
{
    $search = $request->get('search');
    $status = $request->get('status');
    $tanggal = $request->get('tanggal'); // Ambil input tanggal

    $query = Surat::with('warga')
        ->whereIn('status', ['Selesai', 'Ditolak', 'Dibatalkan']);

    // Filter Status
    if ($status && $status != 'semua') {
        $query->where('status', $status);
    }

    // Filter Tanggal (Kalender)
    if ($tanggal) {
        $query->whereDate('created_at', $tanggal);
    }

    // Pencarian Tunggal
    if ($search) {
        $query->where(function($q) use ($search) {
            $q->where('jenis_surat', 'LIKE', "%$search%")
              ->orWhere('nomor_surat', 'LIKE', "%$search%")
              ->orWhereHas('warga', function($w) use ($search) {
                  $w->where('nama_lengkap', 'LIKE', "%$search%")
                    ->orWhere('nik', 'LIKE', "%$search%");
              });
        });
    }

    $data = $query->orderBy('updated_at', 'desc')->paginate(200);

    return view('admin.surat.riwayat', compact('data'));
}


    /**
     * Memproses surat
     */
    public function proses(Request $request, $id)
    {
        $request->validate([
            'nomor_surat' => 'required|string',
            'tanggal_surat_ttd' => 'required|date',
            'officer_id' => 'required|exists:pegawai,id',
        ], [
            'nomor_surat.required' => 'Nomor surat wajib diisi.',
            'officer_id.required' => 'Pilih pejabat yang menandatangani.',
        ]);

        $surat = Surat::findOrFail($id);
        
        $surat->update([
            'status' => 'Diproses',
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat_ttd' => $request->tanggal_surat_ttd,
            'officer_id' => $request->officer_id,
        ]);

        return redirect()->back()->with('success', 'Surat berhasil divalidasi!');
    }

    /**
     * Menolak pengajuan surat
     */
    /**
     * Menolak pengajuan surat dengan alasan
     */
    public function tolak(Request $request, $id)
{
    $request->validate([
        'alasan_ditolak' => 'required|string|min:5',
    ]);

    $surat = Surat::findOrFail($id);
    $surat->update([
        'status' => 'Ditolak',
        'alasan_ditolak' => $request->alasan_ditolak,
        'nomor_surat' => null 
    ]);

    // Arahkan ke riwayat atau dashboard
    return redirect()->back()->with('success', 'Surat telah ditolak.');
}

    /**
     * Menandai surat telah selesai (pindah ke riwayat)
     */
    public function selesai($id)
    {
        $surat = Surat::findOrFail($id);
        
        $surat->update([
            'status' => 'Selesai'
        ]);

        return redirect()->back()->with('success', 'Surat berhasil diselesaikan dan diarsipkan.');
    }

    public function cetak($id)
    {
        // Ambil data surat, warga, dan pegawai yang TTD
        $surat = Surat::with(['warga', 'pegawai'])->findOrFail($id);

        // Langsung return view agar menjadi halaman HTML yang memicu window.print()
        return view('admin.surat.print_layout', compact('surat'));
    }

    /**
     * Menandai surat telah selesai
     */
    public function updateCetak($id) {
    $surat = Surat::findOrFail($id);
    $surat->update(['is_cetak' => true]); // Pastikan kolom is_cetak ada di database
    return response()->json(['success' => true]);
}

}