<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class PegawaiController extends Controller
{
    public function index(Request $request)
    {
        $query = Pegawai::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_lengkap', 'LIKE', "%$search%")
                  ->orWhere('nip', 'LIKE', "%$search%")
                  ->orWhere('nipppk', 'LIKE', "%$search%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('kategori', $request->kategori);
        }

        $pegawais = $query->oldest()->paginate(10);
        return view('admin.pegawai.index', compact('pegawais'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kategori' => 'required|in:Pegawai,Staff',
            'nama_lengkap' => 'required|string|max:255',
            'jabatan' => 'required|string|max:255',
            'nip' => 'nullable|string|max:50',
            'nipppk' => 'nullable|string|max:50',
        ]);

        Pegawai::create($validated);
        return back()->with('success', 'Data berhasil ditambahkan.');
    }

    public function update(Request $request, $id)
{
    $pegawai = Pegawai::findOrFail($id);
    $pegawai->update($request->all()); // Ini akan mengambil semua data dari form modal
    return back()->with('success', 'Data berhasil diperbarui.');
}

    public function destroy($id)
    {
        try {
            $pegawai = Pegawai::findOrFail($id);
            $pegawai->delete();
            return back()->with('success', 'Data berhasil dihapus.');
        } catch (QueryException $e) {
            // Jika error 23000 (Integrity constraint violation)
            if ($e->getCode() == "23000") {
                return back()->with('error', 'Gagal menghapus! Pegawai ini masih terhubung dengan data Surat. Hapus atau ubah data surat terkait terlebih dahulu.');
            }
            return back()->with('error', 'Terjadi kesalahan sistem.');
        }
    }
}