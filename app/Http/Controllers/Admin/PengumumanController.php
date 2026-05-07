<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PengumumanController extends Controller
{
    public function index() {
        $pengumuman = Pengumuman::latest()->get();
        return view('admin.pengumuman.index', compact('pengumuman'));
    }

    public function create()
    {
        return view('admin.pengumuman.create');
    }

    public function store(Request $request) {
        $request->validate([
            'judul' => 'required',
            'konten' => 'required',
            'lampiran' => 'nullable|mimes:jpg,jpeg,png,pdf|max:5000',
        ]);

        $pengumuman = $request->all();
        if ($request->hasFile('lampiran')) {
            $pengumuman['lampiran'] = $request->file('lampiran')->store('pengumuman', 'public');
        }

        Pengumuman::create($pengumuman);
    return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diterbitkan!');
    }

   public function edit($id) 
{
    // Gunakan findOrFail agar jika ID tidak ada, muncul error 404 bukan error code
    $pengumuman = Pengumuman::findOrFail($id);
    return view('admin.pengumuman.edit', compact('pengumuman'));
}

public function update(Request $request, $id) 
{
    $request->validate([
        'judul' => 'required',
        'konten' => 'required',
        'lampiran' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5000'
    ]);

    // 1. Cari data aslinya dulu dari database
    $pengumuman = Pengumuman::findOrFail($id);

    // 2. Ambil semua input dari form
    $data = $request->all();

    // 3. Set status (checkbox logic)
    $data['status'] = $request->has('status') ? 1 : 0;

    // 4. Proses File Lampiran
    if ($request->hasFile('lampiran')) {
        // Hapus file lama jika ada
        if ($pengumuman->lampiran) {
            Storage::disk('public')->delete($pengumuman->lampiran);
        }
        // Simpan file baru
        $data['lampiran'] = $request->file('lampiran')->store('pengumuman', 'public');
    }

    // 5. Update object pengumuman dengan data baru
    $pengumuman->update($data);

    return redirect()->route('admin.pengumuman.index')->with('success', 'Pengumuman berhasil diperbarui');
}

    public function show(Pengumuman $pengumuman)
{
    return view('admin.pengumuman.show', compact('pengumuman'));
}

    public function destroy($id) {
        $item = Pengumuman::findOrFail($id);
        if($item->lampiran) Storage::disk('public')->delete($item->lampiran);
        $item->delete();
        return back()->with('success', 'Pengumuman dihapus.');
    }
}