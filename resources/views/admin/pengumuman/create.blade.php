@extends('layouts.admin')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-header bg-white p-4 border-0">
                <h5 class="fw-bold m-0">Buat Pengumuman Baru</h5>
            </div>
            <div class="card-body p-4 pt-0">
                <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label class="small fw-bold mb-2 text-uppercase">Judul</label>
                        <input type="text" name="judul" class="form-control border-0 bg-light py-2 shadow-none" placeholder="Masukkan judul..." required>
                    </div>
                        <div class="col-md-6">
                            <label class="small fw-bold mb-2 text-uppercase">Lampiran</label>
                            <input type="file" name="lampiran" class="form-control border-0 bg-light shadow-none">
                        </div>
                    <div class="mb-3">
                        <label class="small fw-bold mb-2 text-uppercase">Isi Konten</label>
                        <textarea name="konten" rows="8" class="form-control border-0 bg-light shadow-none" placeholder="Tulis pengumuman di sini..." required></textarea>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-light px-4 border me-2">Batal</a>
                        <button type="submit" class="btn btn-primary px-4 shadow-sm">Simpan & Terbitkan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection