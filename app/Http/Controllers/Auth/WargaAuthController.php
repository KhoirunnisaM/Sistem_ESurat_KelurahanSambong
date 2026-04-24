<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use Illuminate\Http\Request;

class WargaAuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register_warga');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nik' => 'required|numeric|digits:16|unique:warga,nik',
            'no_kk' => 'required|numeric|digits:16',
            'tempat_lahir' => 'required',
            'tanggal_lahir' => 'required|date',
            'alamat_lengkap' => 'required',
            'rt' => 'required|string|max:3',
            'rw' => 'required|string|max:3',
            'agama' => 'required',
            'jenis_kelamin' => 'required',
            'status_perkawinan' => 'required',
            'pekerjaan' => 'required',
        ], [
            'nik.unique' => 'NIK ini sudah terdaftar dalam sistem.',
            'nik.digits' => 'NIK harus tepat 16 digit angka.',
            'no_kk.digits' => 'Nomor KK harus tepat 16 digit angka.',
            'required' => 'Kolom :attribute wajib diisi.'
        ]);

        Warga::create($request->all());

        return redirect()->route('login.warga')->with('success', 'Pendaftaran berhasil! Silakan login.');
    }

    public function showLogin()
    {
        return view('auth.login_warga');
    }

   public function login(Request $request)
{
    $request->validate([
        'nik' => 'required|numeric|digits:16',
        'tanggal_lahir' => 'required|date',
    ]);

    $warga = Warga::where('nik', $request->nik)
                  ->where('tanggal_lahir', $request->tanggal_lahir)
                  ->first();

    if ($warga) {
        // SIMPAN SEMUA DATA KE SESSION
        session([
            'warga_logged_in' => true,
            'warga_id'        => $warga->id,
            'nama_lengkap'    => $warga->nama_lengkap, // Gunakan nama_lengkap
            'nik'             => $warga->nik,
            'no_kk'           => $warga->no_kk,
            'tempat_lahir'    => $warga->tempat_lahir,
            'tanggal_lahir'   => $warga->tanggal_lahir,
            'alamat_lengkap'  => $warga->alamat_lengkap, 
            'rt'              => $warga->rt,
            'rw'              => $warga->rw,
            'agama'           => $warga->agama,
            'pekerjaan'       => $warga->pekerjaan,
            'jenis_kelamin'   => $warga->jenis_kelamin,
            'kelurahan'       => $warga->kelurahan ?? 'Sambong',
            'kecamatan'       => $warga->kecamatan ?? 'Batang',
            'kabupaten'       => $warga->kabupaten ?? 'Batang'
        ]);
        
        return redirect()->route('warga.dashboard');
    }

    return back()->with('error', 'NIK atau Tanggal Lahir salah.');
}

    public function logout()
    {
        session()->flush();
        return redirect('/')->with('success', 'Anda telah keluar.');
    }
}