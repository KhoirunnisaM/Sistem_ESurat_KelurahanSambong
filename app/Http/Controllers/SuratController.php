<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SuratController extends Controller
{
    private function getListSurat() {
        return [
            'skck' => 'Pengantar SKCK',
            'pengantar-umum' => 'Pengantar Umum',
            'keterangan-umum' => 'Keterangan Umum',
            'keterangan-usaha' => 'Keterangan Usaha',
            'keterangan-tidak-mampu' => 'Keterangan Tidak Mampu',
            'domisili-usaha' => 'Domisili Usaha',
            'domisili-tempat-tinggal' => 'Domisili Tempat Tinggal',
        ];
    }

    public function create($tipe)
    {
        $list_surat = $this->getListSurat();

        if (!isset($list_surat[$tipe])) {
            return redirect()->route('warga.dashboard')->with('error', 'Jenis surat tidak valid.');
        }

        $nama_surat = $list_surat[$tipe];
        return view('warga.form_surat', compact('tipe', 'nama_surat'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tipe_slug' => 'required',
            'keperluan' => 'required',
            'scan_pengantar_rt' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'scan_ktp_kk' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $list_surat = $this->getListSurat();
        $nama_surat_asli = $list_surat[$request->tipe_slug] ?? 'Surat Umum';

        // Upload File
        $file_rt = $request->file('scan_pengantar_rt')->store('uploads/surat/rt', 'public');
        $file_ktp_kk = $request->file('scan_ktp_kk')->store('uploads/surat/ktp_kk', 'public');

        // Simpan ke Database
        Surat::create([
            'citizen_id' => session('warga_id'),
            'jenis_surat' => $nama_surat_asli,
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