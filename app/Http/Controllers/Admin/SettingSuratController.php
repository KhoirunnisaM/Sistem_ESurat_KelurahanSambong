<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SettingSurat;
use App\Models\JenisSurat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingSuratController extends Controller
{
    public function index()
    {
        $profil = SettingSurat::first();
        $jenisSurat = JenisSurat::all();
        return view('admin.setting.index', compact('profil', 'jenisSurat'));
    }

    public function updateProfil(Request $request)
    {
        $profil = SettingSurat::first();
        $data = $request->validate([
            'nama_lembaga' => 'required',
            'instansi_level_1' => 'required',
            'instansi_level_2' => 'required',
            'alamat_jalan' => 'required',
            'no_telp' => 'required',
            'kode_pos' => 'required',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($request->hasFile('logo')) {
            if ($profil->logo) Storage::disk('public')->delete($profil->logo);
            $data['logo'] = $request->file('logo')->store('assets/logo', 'public');
        }

        $profil->update($data);
        return back()->with('success', 'Profil Kop Surat berhasil diperbarui!');
    }

    public function updatePenutup(Request $request, $id)
    {
        $jenis = JenisSurat::findOrFail($id);
        $jenis->update(['kalimat_penutup' => $request->kalimat_penutup]);
        return back()->with('success', 'Kalimat penutup surat berhasil diperbarui!');
    }
}