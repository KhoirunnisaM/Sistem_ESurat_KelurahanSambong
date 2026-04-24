<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Carbon\Carbon;

class WargaController extends Controller
{
    public function index()
    {
        $riwayat_surat = Surat::where('citizen_id', session('warga_id'))
                            ->orderBy('created_at', 'desc')
                            ->get();
        return view('warga.dashboard', compact('riwayat_surat'));
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

    // Data teks biasa
    $updateData = [
        'keperluan' => $request->keperluan,
        'keterangan' => $request->keterangan,
    ];

    // Logika ganti gambar Scan Pengantar RT
    if ($request->hasFile('scan_pengantar_rt')) {
        // Hapus file lama jika ada agar storage tidak penuh
        if ($surat->scan_pengantar_rt) {
            Storage::disk('public')->delete($surat->scan_pengantar_rt);
        }
        $updateData['scan_pengantar_rt'] = $request->file('scan_pengantar_rt')->store('uploads/surat/rt', 'public');
    }

    // Logika ganti gambar Scan KTP/KK
    if ($request->hasFile('scan_ktp_kk')) {
        if ($surat->scan_ktp_kk) {
            Storage::disk('public')->delete($surat->scan_ktp_kk);
        }
        $updateData['scan_ktp_kk'] = $request->file('scan_ktp_kk')->store('uploads/surat/ktp_kk', 'public');
    }

    $surat->update($updateData);

    return redirect()->route('warga.surat.detail', $id)->with('success', 'Pengajuan berhasil diperbarui.');
}

public function batalkan($id)
    {
        $surat = Surat::where('id', $id)
                      ->where('citizen_id', session('warga_id'))
                      ->where('status', 'Diajukan')
                      ->firstOrFail();

        $surat->update(['status' => 'Dibatalkan']);
        return back()->with('success', 'Pengajuan surat berhasil dibatalkan.');
    }
}