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

    // Tambahkan Request $request di dalam kurung ini
public function dashboard(Request $request) 
{
    $stats = [
        'diajukan'  => Surat::where('status', 'Diajukan')->count(),
        'diproses'  => Surat::where('status', 'Diproses')->count(),
        'ditolak'   => Surat::where('status', 'Ditolak')->count(),
        'selesai'   => Surat::where('status', 'Selesai')->count(),
        'dibatalkan' => Surat::where('status', 'Dibatalkan')->count(),
    ];

    $query = Surat::with(['warga', 'jenisSurat'])
        ->whereDate('created_at', \Carbon\Carbon::today());

    // Memproses filter status dari kapsul
    if ($request->status) {
        $query->where('status', $request->status);
    }

    // Memproses search
    if ($request->search) {
        $query->whereHas('warga', function($q) use ($request) {
            $q->where('nama_lengkap', 'like', "%{$request->search}%")
              ->orWhere('nik', 'like', "%{$request->search}%");
        });
    }

    // Ubah angka 10 sesuai limit yang diinginkan untuk memicu tombol "Selengkapnya"
    $surat_terbaru = $query->orderBy('created_at', 'desc')->paginate(20); 

    return view('admin.dashboard', compact('stats', 'surat_terbaru'));

}

    public function index(Request $request)
{
    $query = Surat::with(['warga', 'jenisSurat']);

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

// Pencarian Tunggal (Jenis [via Relasi], Nomor, Tanggal, Nama, NIK)
if ($request->filled('search')) {
    $search = $request->search;
    $query->where(function($q) use ($search) {
        $q->where('nomor_surat', 'LIKE', "%$search%")
          ->orWhere('created_at', 'LIKE', "%$search%")
          ->orWhereHas('jenisSurat', function($js) use ($search) {
              $js->where('nama_jenis', 'LIKE', "%$search%");
          })
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
    public function show(Request $request, $id)
{
    $pegawai = \App\Models\Pegawai::all();
    $surat = Surat::findOrFail($id);
    $origin = $request->query('from');

    // Tentukan URL kembali berdasarkan parameter 'from'
    if ($origin == 'dashboard') {
        $backUrl = route('admin.dashboard');
    } elseif ($origin == 'riwayat') {
        $backUrl = route('admin.surat.riwayat'); // Sesuaikan nama route riwayat Anda
    } elseif ($origin == 'masuk') {
        $backUrl = route('admin.surat.masuk');
    } elseif ($origin == 'hari-ini') {
        $backUrl = route('admin.surat.hari-ini');
    } else {
        // Fallback jika tidak ada parameter (misal langsung ketik URL)
        $backUrl = route('admin.dashboard');
    }

    return view('admin.surat.detail', compact('surat', 'backUrl' , 'pegawai'));
}

   public function suratHariIni(Request $request)
{
    $query = Surat::with(['warga', 'jenisSurat'])->whereDate('created_at', \Carbon\Carbon::today());

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
            $q->where('nomor_surat', 'LIKE', "%$search%")
              ->orWhereHas('jenisSurat', function($js) use ($search) {
                  $js->where('nama_jenis', 'LIKE', "%$search%");
              })
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
    $query = Surat::with(['warga', 'jenisSurat'])
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
            $q->where('nomor_surat', 'LIKE', "%$search%")
                ->orWhereHas('jenisSurat', function($js) use ($search) {
                    $js->where('nama_jenis', 'LIKE', "%$search%");
                })
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

    $query = Surat::with(['warga', 'jenisSurat'])
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
            $q->where('nomor_surat', 'LIKE', "%$search%")
              ->orWhereHas('jenisSurat', function($js) use ($search) {
                  $js->where('nama_jenis', 'LIKE', "%$search%");
              })
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
        'nomor_surat' => 'required|string', // Ini menangkap angka manualnya (misal: 001)
        'tanggal_surat_ttd' => 'required|date',
        'officer_id' => 'required|exists:pegawai,id',
    ], [
        'nomor_surat.required' => 'Nomor surat wajib diisi.',
        'officer_id.required' => 'Pilih pejabat yang menandatangani.',
    ]);

    $surat = Surat::findOrFail($id);
    
    if ($surat->status == 'Dibatalkan') {
        return redirect()->back()->with('error', 'Surat tidak bisa diproses karena sudah dibatalkan oleh warga.');
    }

    // 1. Ambil bulan dan tahun dari tanggal_surat_ttd
    $bulanAngka = date('n', strtotime($request->tanggal_surat_ttd));
    $tahun = date('Y', strtotime($request->tanggal_surat_ttd));

    // 2. Fungsi konversi angka bulan ke romawi
    $romawi = [
        1 => 'I', 2 => 'II', 3 => 'III', 4 => 'IV', 5 => 'V', 6 => 'VI',
        7 => 'VII', 8 => 'VIII', 9 => 'IX', 10 => 'X', 11 => 'XI', 12 => 'XII'
    ];
    $bulanRomawi = $romawi[$bulanAngka];

    // 3. Gabungkan format: NomorManual/BulanRomawi/Tahun
    // Contoh: 001/V/2026 atau 119/I/2026
    $nomorLengkap = $request->nomor_surat . ' / ' . $bulanRomawi . ' / ' . $tahun;

    $surat->update([
        'status' => 'Diproses',
        'nomor_surat' => $nomorLengkap,
        'tanggal_surat_ttd' => $request->tanggal_surat_ttd,
        'officer_id' => $request->officer_id,
    ]);

    return redirect()->back()->with('success', 'Surat berhasil divalidasi dengan nomor: ' . $nomorLengkap);
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
        $surat = Surat::with(['warga', 'pegawai', 'jenisSurat'])->findOrFail($id);
    
        $profil = \App\Models\SettingSurat::first(); 

        // Langsung return view agar menjadi halaman HTML yang memicu window.print()
        return view('admin.surat.print_layout', compact('surat', 'profil'));
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