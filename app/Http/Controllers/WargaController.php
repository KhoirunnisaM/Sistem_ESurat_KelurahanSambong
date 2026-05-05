<?php

namespace App\Http\Controllers;

use App\Models\Surat;
use App\Models\Warga;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class WargaController extends Controller
{
    public function dashboard()
    {
        $citizen_id = session('warga_id');
        
        // Data Statistik (KPI) - Menggabungkan Ditolak dan Dibatalkan
        $stats = [
            'diajukan' => Surat::where('citizen_id', $citizen_id)->where('status', 'Diajukan')->count(),
            'diproses' => Surat::where('citizen_id', $citizen_id)->where('status', 'diproses')->count(),
            'selesai'  => Surat::where('citizen_id', $citizen_id)->where('status', 'Selesai')->count(),
            'ditolak'  => Surat::where('citizen_id', $citizen_id)
                                ->whereIn('status', ['Ditolak', 'Dibatalkan'])->count(), 
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

        if ($request->status && $request->status != 'semua') {
            $query->where('status', $request->status);
        }

        if ($request->tanggal) {
            $query->whereDate('created_at', $request->tanggal);
        }

        if ($request->cari) {
            $query->where('jenis_surat', 'LIKE', '%' . $request->cari . '%');
        }

        $riwayat = $query->orderBy('created_at', 'desc')->get();

        return view('warga.riwayat_surat', compact('riwayat'));
    }

    public function profil()
    {
        $warga = (object) session()->all(); 
        return view('warga.profil', compact('warga'));
    }

    public function updateProfile(Request $request)
    {
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

        $nik = session('nik');
        $warga = Warga::where('nik', $nik)->first();

        if (!$warga) {
            return redirect()->back()->with('error', 'Data warga tidak ditemukan di database.');
        }

        $warga->update([
            'nama_lengkap'   => $request->nama_lengkap,
            'pekerjaan'      => $request->pekerjaan,
            'alamat_lengkap' => $request->alamat_lengkap,
            'rt'             => $request->rt,
            'rw'             => $request->rw,
        ]);

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
    $surat = Surat::where('id', $id)
                  ->where('citizen_id', session('warga_id'))
                  ->firstOrFail();
    
    // Ambil URL sebelumnya
    $previousUrl = url()->previous();

    // Cek apakah user datang dari dashboard atau riwayat (bukan dari halaman edit atau simpan)
    // Kita simpan ke session agar 'kompas' kembali tidak berubah meski warga pindah ke halaman edit
    if (str_contains($previousUrl, 'dashboard') || str_contains($previousUrl, 'riwayat')) {
        session(['url_asal_surat' => $previousUrl]);
    }
    
    $no_surat_format = Carbon::parse($surat->created_at)->format('my') . '-' . str_pad($surat->id, 3, '0', STR_PAD_LEFT);

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

    return view('warga.detail_surat', compact('surat', 'no_surat_format', 'warga'));
}

    public function edit($id)
    {
        $surat = Surat::where('id', $id)
                      ->where('citizen_id', session('warga_id'))
                      ->where('status', 'Diajukan') 
                      ->firstOrFail();

        return view('warga.edit_surat', compact('surat'));
    }

    public function update(Request $request, $id)
    {
        $surat = Surat::findOrFail($id);

        $request->validate([
            'keperluan' => 'required|string|max:255',
            'scan_pengantar_rt' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
            'scan_ktp_kk' => 'nullable|image|mimes:jpeg,png,jpg,pdf|max:2048',
            'nama_lembaga' => 'nullable|string|max:255',
            'penanggung_jawab' => 'nullable|string|max:255',
            'jabatan_penanggung_jawab' => 'nullable|string|max:255',
            'alamat_lembaga' => 'nullable|string',
        ]);

        $surat->keperluan = $request->keperluan;
        $surat->keterangan = $request->keterangan;

        if (Str::slug($surat->jenis_surat) == 'domisili-usaha' || $surat->jenis_surat == 'Domisili Usaha') {
            $surat->nama_lembaga = $request->nama_lembaga;
            $surat->penanggung_jawab = $request->penanggung_jawab;
            $surat->jabatan_penanggung_jawab = $request->jabatan_penanggung_jawab;
            $surat->alamat_lembaga = $request->alamat_lembaga;
        }

        if ($request->hasFile('scan_pengantar_rt')) {
            if ($surat->scan_pengantar_rt && Storage::exists('public/' . $surat->scan_pengantar_rt)) {
                Storage::delete('public/' . $surat->scan_pengantar_rt);
            }
            $surat->scan_pengantar_rt = $request->file('scan_pengantar_rt')->store('surat/lampiran', 'public');
        }

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

        // Diubah menjadi Dibatalkan (oleh warga)
        $surat->update(['status' => 'Dibatalkan']);
        return back()->with('success', 'Pengajuan surat berhasil dibatalkan.');
    }

    public function getStatsRealtime()
    {
        $citizen_id = session('warga_id');
        
        $stats = [
            'diajukan' => Surat::where('citizen_id', $citizen_id)
                                ->where('status', 'Diajukan')->count(),
                                
            'diproses' => Surat::where('citizen_id', $citizen_id)
                                ->where('status', 'diproses')->count(),
                                
            'selesai'  => Surat::where('citizen_id', $citizen_id)
                                ->where('status', 'Selesai')->count(),
                                
            'ditolak'  => Surat::where('citizen_id', $citizen_id)
                                ->whereIn('status', ['Ditolak', 'Dibatalkan'])->count(), // Gabungan KPI
        ];

        $terbaru = Surat::where('citizen_id', $citizen_id)
                        ->orderBy('created_at', 'desc')
                        ->take(5)
                        ->get();

        $htmlList = view('warga.partials.list_terbaru', compact('terbaru'))->render();

        return response()->json([
            'stats' => $stats,
            'html'  => $htmlList
        ]);
    }
}