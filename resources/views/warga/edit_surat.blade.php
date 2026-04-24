@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                <div class="card-header bg-white py-3">
                    <h5 class="fw-bold mb-0 text-primary"><i class="bi bi-pencil-square me-2"></i>Edit Pengajuan</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('warga.surat.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label fw-bold">Keperluan Surat</label>
                            <input type="text" name="keperluan" class="form-control @error('keperluan') is-invalid @enderror" value="{{ old('keperluan', $surat->keperluan) }}" required>
                            @error('keperluan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">Keterangan Tambahan</label>
                            <textarea name="keterangan" class="form-control" rows="4">{{ old('keterangan', $surat->keterangan) }}</textarea>
                        </div>

                        <hr class="my-4">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Ganti Surat Pengantar RT</label>
                            <input type="file" name="surat_pengantar_rt" class="form-control">
                            <div class="form-text text-muted">Upload jika ingin mengganti file sebelumnya (Max: 2MB)</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Ganti KK / KTP</label>
                            <input type="file" name="kk_ktp" class="form-control">
                            <div class="form-text text-muted">Upload jika ingin mengganti file sebelumnya (Max: 2MB)</div>
                        </div>

                        <div class="d-flex justify-content-between pt-3">
                            <a href="{{ route('warga.surat.detail', $surat->id) }}" class="btn btn-light px-4 border">Batal</a>
                            <button type="submit" class="btn btn-primary px-4 fw-bold">Simpan Perubahan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection