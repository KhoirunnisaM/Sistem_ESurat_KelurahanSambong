<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pegawai::query();

        // Fitur Pencarian
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%$search%")
                  ->orWhere('nip', 'LIKE', "%$search%")
                  ->orWhere('nipppk', 'LIKE', "%$search%");
            });
        }

        // Fitur Filter Kategori
        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $pegawais = $query->latest()->paginate(10);
        return view('admin.pegawai.index', compact('pegawais'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kategori' => 'required|in:Pegawai,Staff',
            'nama_lengkap' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
        ]);

        Pegawai::create($request->all());
        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($request->all());
        return back()->with('success', 'Data berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Pegawai::destroy($id);
        return back()->with('success', 'Data berhasil dihapus.');
    }
}