<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuratController extends Controller
{
    public function create($tipe)
    {
        $list_surat = [
            'skck' => 'Surat Pengantar SKCK',
            'pengantar-umum' => 'Surat Pengantar Umum',
            'keterangan-umum' => 'Surat Keterangan Umum',
            'keterangan-usaha' => 'Surat Keterangan Usaha',
            'keterangan-tidak-mampu' => 'Surat Keterangan Tidak Mampu (SKTM)',
            'domisili-usaha' => 'Surat Keterangan Domisili Usaha',
            'domisili-tempat-tinggal' => 'Surat Keterangan Domisili Tempat Tinggal',
        ];

        if (!isset($list_surat[$tipe])) {
            return redirect()->route('warga.dashboard')->with('error', 'Jenis surat tidak valid.');
        }

        $nama_surat = $list_surat[$tipe];
        return view('warga.form_surat', compact('tipe', 'nama_surat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keperluan' => 'required',
            'scan_pengantar_rt' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'scan_ktp_kk' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Upload File
        $file_rt = $request->file('scan_pengantar_rt')->store('uploads/surat/rt', 'public');
        $file_ktp_kk = $request->file('scan_ktp_kk')->store('uploads/surat/ktp_kk', 'public');

        // Simpan ke Database
        Surat::create([
            'citizen_id' => session('warga_id'),
            'jenis_surat' => $request->jenis_surat_nama,
            'keperluan' => $request->keperluan,
            'keterangan' => $request->keterangan,
            
            // Form Khusus Domisili Usaha
            'nama_lembaga' => $request->nama_lembaga,
            'penanggung_jawab' => $request->penanggung_jawab,
            'jabatan_penanggung_jawab' => $request->jabatan,
            'alamat_lembaga' => $request->alamat_lembaga,

            // File
            'scan_pengantar_rt' => $file_rt,
            'scan_ktp_kk' => $file_ktp_kk,
            'status' => 'Diajukan',
        ]);

        return redirect()->route('warga.dashboard')->with('success', 'Pengajuan surat berhasil dikirim!');
    }
}