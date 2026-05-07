<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuratController extends Controller
{
    public function create($tipe)
    {
        // Mencari jenis surat berdasarkan slug atau nama yang sesuai di database
        // Kita asumsikan pencarian berdasarkan 'nama_jenis' yang di-slug-kan atau mencocokkan teks
        $jenisSurat = JenisSurat::where('nama_jenis', 'LIKE', '%' . str_replace('-', ' ', $tipe) . '%')->first();

        if (!$jenisSurat) {
            return redirect()->route('warga.dashboard')->with('error', 'Jenis surat tidak valid.');
        }

        $nama_surat = $jenisSurat->nama_jenis;
        $jenis_surat_id = $jenisSurat->id;

        return view('warga.surat.form_surat', compact('tipe', 'nama_surat', 'jenis_surat_id'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_surat_id' => 'required|exists:jenis_surat,id',
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
            'jenis_surat_id' => $request->jenis_surat_id,
            'keperluan' => $request->keperluan,
            'keterangan' => $request->keterangan,
            
            // Form Khusus
            'nama_lembaga' => $request->nama_lembaga,
            'penanggung_jawab' => $request->penanggung_jawab,
            'jabatan_penanggung_jawab' => $request->jabatan,
            'alamat_lembaga' => $request->alamat_lembaga,

            'scan_pengantar_rt' => $file_rt,
            'scan_ktp_kk' => $file_ktp_kk,
            'status' => 'Diajukan',
        ]);

        return redirect()->route('warga.dashboard')->with('success', 'Pengajuan surat berhasil dikirim!');
    }
}