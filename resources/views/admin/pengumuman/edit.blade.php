@extends('layouts.admin')

@section('admin_content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0" style="border-radius: 15px;">
            <div class="card-header bg-white p-4 border-0">
                <h5 class="fw-bold m-0 text-primary">Edit Pengumuman</h5>
            </div>
            <div class="card-body p-4 pt-0">
                <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    <div class="mb-3">
                        <label class="small fw-bold mb-2 text-uppercase">Judul</label>
                        <input type="text" name="judul" value="{{ $pengumuman->judul }}" class="form-control border-0 bg-light py-2 shadow-none" required>
                    </div>
                        <div class="col-md-6">
                            <label class="small fw-bold mb-2 text-uppercase">Lampiran Baru (Opsional)</label>
                            <input type="file" name="lampiran" class="form-control border-0 bg-light shadow-none">
                            @if($pengumuman->lampiran)
                                <small class="text-muted d-block mt-1">File saat ini: {{ basename($pengumuman->lampiran) }}</small>
                            @endif
                        </div>
                    <div class="mb-3">
                        <label class="small fw-bold mb-2 text-uppercase">Isi Konten</label>
                        <textarea name="konten" rows="8" class="form-control border-0 bg-light shadow-none" required>{{ $pengumuman->konten }}</textarea>
                    </div>
                    <div class="mb-4 d-flex align-items-center">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="status" id="status" {{ $pengumuman->status ? 'checked' : '' }}>
                            <label class="form-check-label fw-bold small" for="status">Publikasikan Pengumuman</label>
                        </div>
                    </div>
                    <div class="text-end">
                        <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-light px-4 border me-2">Batal</a>
                        <button type="submit" class="btn btn-success px-4 shadow-sm">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection