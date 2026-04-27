<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Surat;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; 

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
            'ditolak'  => Surat::where('status', 'Ditolak')->count(),
            'selesai'  => Surat::where('status', 'Selesai')->count(),
        ];

        // Mengambil 5 surat terbaru untuk tabel dashboard
        $surat_terbaru = Surat::with('warga')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'surat_terbaru'));
    }

    public function index(Request $request)
    {
        $query = Surat::with('warga');

        // 1. Filter Status
        if ($request->filter == 'masuk') {
            $query->whereIn('status', ['Diajukan', 'Diproses']);
        } elseif ($request->filter == 'riwayat') {
            $query->whereIn('status', ['Ditolak', 'Selesai']);
        }

        // 2. Filter Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('jenis_surat', 'LIKE', "%$search%")
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
    public function tolak(Request $request, $id)
    {
        $request->validate([
            'alasan_ditolak' => 'required|string|min:5',
        ]);

        $surat = Surat::findOrFail($id);
        
        $surat->update([
            'status' => 'Ditolak',
            'alasan_ditolak' => $request->alasan_ditolak,
        ]);

        return redirect()->route('admin.surat.index')->with('error', 'Pengajuan surat telah ditolak.');
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
    public function selesai($id)
    {
        $surat = Surat::findOrFail($id);
        $surat->update(['status' => 'Selesai']);

        return redirect()->back()->with('success', 'Status surat diperbarui menjadi Selesai.');
    }
}