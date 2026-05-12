@extends('layouts.admin')

@section('admin_content')
<div class="container-fluid px-2 px-md-3">
    {{-- TOMBOL KEMBALI --}}
    <div class="mb-4">
        <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-white border-0 shadow-sm btn-sm rounded-pill px-3 mb-3 text-muted">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
        </a>
    </div>

    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card card-custom border-0 shadow-sm overflow-hidden">
                {{-- HEADER FORM --}}
                <div class="card-header bg-white p-4 border-0">
                    <h5 class="fw-bold text-dark m-0 responsive-h6">
                        <i class="bi bi-pencil-square text-primary me-2"></i>Edit Pengumuman
                    </h5>
                    <p class="text-muted small mb-0 mt-1">Perbarui detail informasi atau status publikasi pengumuman ini.</p>
                </div>

                <div class="card-body p-4 pt-2">
                    <form action="{{ route('admin.pengumuman.update', $pengumuman->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf 
                        @method('PUT')
                        
                        {{-- INPUT JUDUL --}}
                        <div class="mb-4">
                            <label class="stat-label text-muted text-uppercase mb-2 d-block">Judul Pengumuman</label>
                            <input type="text" name="judul" value="{{ $pengumuman->judul }}" 
                                   class="form-control form-control-custom bg-light border-0 px-3 shadow-none" 
                                   placeholder="Masukkan judul..." required>
                        </div>

                        {{-- INPUT LAMPIRAN --}}
                        <div class="mb-4">
                            <label class="stat-label text-muted text-uppercase mb-2 d-block">Lampiran Baru (Opsional)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-paperclip"></i></span>
                                <input type="file" name="lampiran" class="form-control form-control-custom bg-light border-0 shadow-none">
                            </div>
                            
                            @if($pengumuman->lampiran)
                                <div class="mt-2 d-inline-flex align-items-center p-2 px-3 bg-light rounded-pill border shadow-sm">
                                    <i class="bi bi-file-earmark-check text-success me-2"></i>
                                    <span class="text-muted" style="font-size: 0.75rem;">
                                        File saat ini: <strong class="text-dark">{{ basename($pengumuman->lampiran) }}</strong>
                                    </span>
                                </div>
                            @endif
                            <small class="text-muted d-block mt-2" style="font-size: 0.65rem;">Biarkan kosong jika tidak ingin mengganti lampiran.</small>
                        </div>

                        {{-- INPUT ISI KONTEN --}}
                        <div class="mb-4">
                            <label class="stat-label text-muted text-uppercase mb-2 d-block">Isi Pengumuman</label>
                            <textarea name="konten" rows="10" class="form-control form-control-custom bg-light border-0 px-3 shadow-none" 
                                      placeholder="Tuliskan detail informasi di sini..." required style="resize: none;">{{ $pengumuman->konten }}</textarea>
                        </div>

                        {{-- STATUS PUBLIKASI (SWITCH) --}}
                        <div class="mb-4">
                            <label class="stat-label text-muted text-uppercase mb-3 d-block">Pengaturan Publikasi</label>
                            <div class="form-check form-switch custom-switch p-0 d-flex align-items-center gap-3">
                                <input class="form-check-input ms-0 shadow-none" type="checkbox" name="status" id="status" 
                                       style="width: 2.8rem; height: 1.4rem; cursor: pointer;" {{ $pengumuman->status ? 'checked' : '' }}>
                                <label class="form-check-label fw-bold text-dark" for="status" style="font-size: 0.85rem; cursor: pointer;">
                                    Tampilkan di halaman publik
                                </label>
                            </div>
                            <small class="text-muted d-block mt-1 ms-1" style="font-size: 0.7rem;">Geser untuk mengubah antara status <b>Publik</b> atau <b>Draft</b>.</small>
                        </div>

                        <hr class="my-4 opacity-25">

                        {{-- ACTION BUTTONS --}}
                        <div class="d-flex flex-column d-md-flex flex-md-row justify-content-end gap-2">
                            <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-light text-muted rounded-pill px-4 btn-sm-block border-0">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-success shadow-sm rounded-pill px-4 btn-sm-block">
                                <i class="bi bi-check-circle-fill me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* ─── KESELURUHAN & TRANSISI ─── */
    .container-fluid, .card { transition: all 0.3s ease; }

    /* ─── RESPONSIVE TYPOGRAPHY ─── */
    .responsive-h6 { font-size: clamp(0.9rem, 2vw, 1.1rem); }
    .stat-label { font-size: 0.7rem; font-weight: 700; letter-spacing: 0.5px; }

    /* ─── FORM STYLING ─── */
    .card-custom { border-radius: 12px; }
    .form-control-custom {
        border-radius: 10px;
        font-size: 0.85rem;
        padding: 10px 15px;
    }
    .form-control-custom:focus {
        background-color: #f1f3f5 !important;
        box-shadow: 0 0 0 0.2rem rgba(25, 135, 84, 0.1) !important;
    }

    /* Switch Styling */
    .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }

    .btn-white { background-color: #fff; }

    /* ─── MOBILE OPTIMIZATION ─── */
    @media (max-width: 576px) {
        .container-fluid { padding-left: 0.5rem !important; padding-right: 0.5rem !important; }
        .card-body { padding: 1.5rem !important; }
        .btn-sm-block { width: 100%; display: block; }
    }
</style>
@endsection