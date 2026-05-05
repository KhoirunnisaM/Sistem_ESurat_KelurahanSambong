<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WargaController extends Controller
{
    public function dashboard()
    {
        $citizen_id = session('warga_id');
        
        // Data Statistik (KPI)
        $stats = [
            'diajukan' => Surat::where('citizen_id', $citizen_id)->where('status', 'Diajukan')->count(),
            'diproses'   => Surat::where('citizen_id', $citizen_id)->where('status', 'diproses')->count(),
            'selesai'  => Surat::where('citizen_id', $citizen_id)->where('status', 'Selesai')->count(),
            'ditolak'  => Surat::where('citizen_id', $citizen_id)->where('status', 'Ditolak')->count(), // 'Batal/Ditolak'
        ];

        // 5 Surat Terbaru
        $terbaru = Surat::where('citizen_id', $citizen_id)
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();

        return view('warga.dashboard', compact('stats', 'terbaru'));
    }

    public function ajukanSurat()
    {
        return view('warga.ajukan_surat');
    }

    public function riwayatSurat(Request $request)
{
    $citizen_id = session('warga_id');
    $query = Surat::where('citizen_id', $citizen_id);

    // Filter berdasarkan status kapsul
    if ($request->status && $request->status != 'semua') {
        $query->where('status', $request->status);
    }

    // Filter berdasarkan tanggal
    if ($request->tanggal) {
        $query->whereDate('created_at', $request->tanggal);
    }

    // Filter berdasarkan pencarian jenis surat
    if ($request->cari) {
        $query->where('jenis_surat', 'LIKE', '%' . $request->cari . '%');
    }

    $riwayat = $query->orderBy('created_at', 'desc')->get();

    return view('warga.riwayat_surat', compact('riwayat'));
}

    public function profil()
    {
        // Data diambil dari session sesuai permintaan
        $warga = (object) session()->all(); 
        return view('warga.profil', compact('warga'));
    }

    public function updateProfile(Request $request)
{
    // 1. Validasi Input
    $request->validate([
        'nama_lengkap'   => 'required|string|max:255',
        'pekerjaan'      => 'required|string|max:255',
        'alamat_lengkap' => 'required|string',
        'rt'             => 'required|numeric',
        'rw'             => 'required|numeric',
        'kelurahan'      => 'required|string|max:100',
        'kecamatan'      => 'required|string|max:100',
        'kabupaten'      => 'required|string|max:100',
        'provinsi'       => 'required|string|max:100',
    ]);

    // 2. AMBIL DATA DARI DATABASE (Cari berdasarkan NIK yang login)
    $nik = session('nik');
    $warga = \App\Models\Warga::where('nik', $nik)->first();

    if (!$warga) {
        return redirect()->back()->with('error', 'Data warga tidak ditemukan di database.');
    }

    // 3. UPDATE KE DATABASE
    $warga->update([
        'nama_lengkap'   => $request->nama_lengkap,
        'pekerjaan'      => $request->pekerjaan,
        'alamat_lengkap' => $request->alamat_lengkap,
        'rt'             => $request->rt,
        'rw'             => $request->rw,
        // Jika kolom kelurahan dkk belum ada di tabel 'warga', 
        // pastikan sudah membuat migrasinya dan menambahkannya di $fillable Model Warga
    ]);

    // 4. Update juga di Session (agar tampilan langsung berubah tanpa relogin)
    session([
        'nama_lengkap'   => $request->nama_lengkap,
        'pekerjaan'      => $request->pekerjaan,
        'alamat_lengkap' => $request->alamat_lengkap,
        'rt'             => $request->rt,
        'rw'             => $request->rw,
        'kelurahan'      => $request->kelurahan,
        'kecamatan'      => $request->kecamatan,
        'kabupaten'      => $request->kabupaten,
        'provinsi'       => $request->provinsi,
    ]);

    return redirect()->back()->with('success', 'Profil berhasil disimpan ke database!');
}

 public function showDetail($id)
    {
        // 1. Ambil data surat milik warga yang login
        $surat = Surat::where('id', $id)
                      ->where('citizen_id', session('warga_id'))
                      ->firstOrFail();
        
        // 2. Format nomor surat mmyy-ID
        $no_surat_format = Carbon::parse($surat->created_at)->format('my') . '-' . str_pad($surat->id, 3, '0', STR_PAD_LEFT);

        // 3. Siapkan data warga dari session untuk ditampilkan di view
        $warga = [
            'nama_lengkap'   => session('nama_lengkap'), 
            'nik'            => session('nik'),
            'tempat_lahir'   => session('tempat_lahir'),
            'tanggal_lahir'  => session('tanggal_lahir'),
            'agama'          => session('agama'),
            'pekerjaan'      => session('pekerjaan'),
            'alamat_lengkap' => session('alamat_lengkap'), 
            'rt'             => session('rt'),
            'rw'             => session('rw'),
            'kelurahan'      => session('kelurahan'),
            'kecamatan'      => session('kecamatan'),
            'kabupaten'      => session('kabupaten'),
        ];

        // RETURN KE VIEW (Bukan JSON lagi)
        return view('warga.detail_surat', compact('surat', 'no_surat_format', 'warga'));
    }

    public function edit($id)
    {
        // Hanya bisa diedit jika status masih 'Diajukan'
        $surat = Surat::where('id', $id)
                      ->where('citizen_id', session('warga_id'))
                      ->where('status', 'Diajukan') 
                      ->firstOrFail();

        // RETURN KE VIEW EDIT
        return view('warga.edit_surat', compact('surat'));
    }

    public function update(Request $request, $id)
{
    $surat = Surat::findOrFail($id);

    // Validasi
    $request->validate([
        'keperluan' => 'required|string|max:255',
        'scan_pengantar_rt' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
        'scan_ktp_kk' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
        // Tambahkan validasi opsional untuk data usaha
        'nama_lembaga' => 'nullable|string|max:255',
        'penanggung_jawab' => 'nullable|string|max:255',
        'jabatan_penanggung_jawab' => 'nullable|string|max:255',
        'alamat_lembaga' => 'nullable|string',
    ]);

    // Update data teks utama
    $surat->keperluan = $request->keperluan;
    $surat->keterangan = $request->keterangan;

    // KHUSUS DOMISILI USAHA: Update data lembaga/usaha
    if (Str::slug($surat->jenis_surat) == 'domisili-usaha' || $surat->jenis_surat == 'Domisili Usaha') {
        $surat->nama_lembaga = $request->nama_lembaga;
        $surat->penanggung_jawab = $request->penanggung_jawab;
        $surat->jabatan_penanggung_jawab = $request->jabatan_penanggung_jawab;
        $surat->alamat_lembaga = $request->alamat_lembaga;
    }

    // Logika Ganti File Pengantar RT
    if ($request->hasFile('scan_pengantar_rt')) {
        if ($surat->scan_pengantar_rt && Storage::exists('public/' . $surat->scan_pengantar_rt)) {
            Storage::delete('public/' . $surat->scan_pengantar_rt);
        }
        $surat->scan_pengantar_rt = $request->file('scan_pengantar_rt')->store('surat/lampiran', 'public');
    }

    // Logika Ganti File KK/KTP
    if ($request->hasFile('scan_ktp_kk')) {
        if ($surat->scan_ktp_kk && Storage::exists('public/' . $surat->scan_ktp_kk)) {
            Storage::delete('public/' . $surat->scan_ktp_kk);
        }
        $surat->scan_ktp_kk = $request->file('scan_ktp_kk')->store('surat/lampiran', 'public');
    }

    $surat->save();

    return redirect()->route('warga.surat.detail', $id)->with('success', 'Data pengajuan berhasil diperbarui!');
}

public function batalkan($id)
    {
        $surat = Surat::where('id', $id)
                      ->where('citizen_id', session('warga_id'))
                      ->where('status', 'Diajukan')
                      ->firstOrFail();

        $surat->update(['status' => 'Ditolak']);
        return back()->with('success', 'Pengajuan surat berhasil dibatalkan.');
    }

    // Tambahkan di WargaController.php
public function getStatsRealtime()
{
    $citizen_id = session('warga_id');
    
    // Ambil Data Angka dengan filter status yang lebih akurat
    $stats = [
        'diajukan' => \App\Models\Surat::where('citizen_id', $citizen_id)
                        ->where('status', 'Diajukan')->count(),
                        
        'diproses'   => \App\Models\Surat::where('citizen_id', $citizen_id)
                        ->where('status', 'diproses')->count(), // Pastikan di DB 'diproses', bukan 'Diproses'
                        
        'selesai'  => \App\Models\Surat::where('citizen_id', $citizen_id)
                        ->where('status', 'Selesai')->count(),
                        
        'ditolak'  => \App\Models\Surat::where('citizen_id', $citizen_id)
                        ->where('status', 'Ditolak')->count(), // Sesuaikan dengan fungsi batalkan() Anda
    ];

    // Ambil 5 Surat Terbaru
    $terbaru = \App\Models\Surat::where('citizen_id', $citizen_id)
                                ->orderBy('created_at', 'desc')
                                ->take(5)
                                ->get();

    // Render file partial menjadi string HTML
    $htmlList = view('warga.partials.list_terbaru', compact('terbaru'))->render();

    return response()->json([
        'stats' => $stats,
        'html'  => $htmlList
    ]);
}
}