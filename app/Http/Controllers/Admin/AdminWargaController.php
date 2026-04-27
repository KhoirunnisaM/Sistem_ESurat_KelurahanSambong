<?php 

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Warga;
use Illuminate\Http\Request;

class AdminWargaController extends Controller
{
    public function index(Request $request)
    {
        $query = Warga::query();

        // Pencarian Nama atau NIK
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function($q) use ($s) {
                $q->where('nama_lengkap', 'LIKE', "%$s%")
                  ->orWhere('nik', 'LIKE', "%$s%");
            });
        }

        // withQueryString() penting agar filter tidak hilang saat ganti halaman pagination
        $wargas = $query->latest()->paginate(10)->withQueryString();
        
        return view('admin.warga.index', compact('wargas'));
    }

    public function toggleStatus($id)
    {
        $warga = Warga::findOrFail($id);
        
        // Membalikkan nilai boolean (1 jadi 0, 0 jadi 1)
        $warga->status_akun = !$warga->status_akun;
        $warga->save();

        $statusTeks = $warga->status_akun ? 'diaktifkan' : 'dinonaktifkan';
        $namaPalingRapi = ucwords(strtolower($warga->nama_lengkap));
        
        return back()->with('success', "Akun warga $namaPalingRapi berhasil $statusTeks.");
    }
}