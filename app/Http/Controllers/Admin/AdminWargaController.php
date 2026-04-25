<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use Illuminate\Http\Request;

class AdminWargaController extends Controller
{
    public function index(Request $request)
{

// Tambahkan baris ini untuk ngetes:
    //return "Halo, saya adalah halaman admin warga";

    $query = Warga::query();

    // Filter jika datang dari menu "Warga Terdaftar Akun"
    if ($request->filter_akun == 'terdaftar') {
        $query->where('status_akun', true);
    }

    // Pencarian
    if ($request->filled('search')) {
        $s = $request->search;
        $query->where(function($q) use ($s) {
            $q->where('nama_lengkap', 'LIKE', "%$s%")
              ->orWhere('nik', 'LIKE', "%$s%");
        });
    }

    $wargas = $query->latest()->paginate(10);
    return view('admin.warga.index', compact('wargas'));
}

    public function store(Request $request)
    {
        $request->validate([
            'nik' => 'required|unique:warga,nik|digits:16',
            'no_kk' => 'required|digits:16',
            'nama_lengkap' => 'required',
            'agama' => 'required',
            'jenis_kelamin' => 'required',
        ]);

        Warga::create($request->all());
        return back()->with('success', 'Data warga berhasil disimpan.');
    }

    public function update(Request $request, $id)
    {
        $warga = Warga::findOrFail($id);
        
        $request->validate([
            'nik' => 'required|digits:16|unique:warga,nik,'.$id,
            'no_kk' => 'required|digits:16',
        ]);

        $warga->update($request->all());
        return back()->with('success', 'Data warga berhasil diperbarui.');
    }

    public function destroy($id)
    {
        Warga::destroy($id);
        return back()->with('success', 'Data warga telah dihapus.');
    }
}