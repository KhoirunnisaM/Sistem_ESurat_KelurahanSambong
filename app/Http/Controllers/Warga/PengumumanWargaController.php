<?php

namespace App\Http\Controllers\Warga;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;

class PengumumanWargaController extends Controller
{
    public function index()
    {
        // Hanya ambil yang statusnya Publik (1)
        $pengumuman = Pengumuman::where('status', 1)->latest()->get();
        return view('warga.pengumuman.index', compact('pengumuman'));
    }

  public function show($id)
{
    // Cari datanya dulu berdasarkan ID
    $pengumuman = Pengumuman::findOrFail($id);

    // Cek apakah statusnya aktif (1), jika tidak lempar 404
    if ($pengumuman->status != 1) {
        abort(404);
    }

    return view('warga.pengumuman.show', compact('pengumuman'));
}
}