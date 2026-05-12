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
                        <i class="bi bi-megaphone-fill text-success me-2"></i>Buat Pengumuman Baru
                    </h5>
                    <p class="text-muted small mb-0 mt-1">Isi formulir di bawah ini untuk menerbitkan informasi baru.</p>
                </div>

                <div class="card-body p-4 pt-2">
                    <form action="{{ route('admin.pengumuman.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        {{-- INPUT JUDUL --}}
                        <div class="mb-4">
                            <label class="stat-label text-muted text-uppercase mb-2 d-block">Judul Pengumuman</label>
                            <input type="text" name="judul" class="form-control form-control-custom bg-light border-0 px-3 shadow-none" 
                                   placeholder="Contoh: Jadwal Kerja Bakti Mingguan..." required>
                        </div>

                        {{-- INPUT LAMPIRAN --}}
                        <div class="mb-4">
                            <label class="stat-label text-muted text-uppercase mb-2 d-block">Lampiran (Gambar/PDF)</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-0 text-muted"><i class="bi bi-paperclip"></i></span>
                                <input type="file" name="lampiran" class="form-control form-control-custom bg-light border-0 shadow-none">
                            </div>
                            <small class="text-muted" style="font-size: 0.65rem;">Maksimal ukuran file: 2MB</small>
                        </div>

                        {{-- INPUT ISI KONTEN --}}
                        <div class="mb-4">
                            <label class="stat-label text-muted text-uppercase mb-2 d-block">Isi Pengumuman</label>
                            <textarea name="konten" rows="10" class="form-control form-control-custom bg-light border-0 px-3 shadow-none" 
                                      placeholder="Tuliskan detail informasi di sini..." required style="resize: none;"></textarea>
                        </div>

                        <hr class="my-4 opacity-25">

                        {{-- ACTION BUTTONS --}}
                        <div class="d-flex flex-column d-md-flex flex-md-row justify-content-end gap-2">
                            <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-light text-muted rounded-pill px-4 btn-sm-block border-0">
                                Batal
                            </a>
                            <button type="submit" class="btn btn-success shadow-sm rounded-pill px-4 btn-sm-block">
                                <i class="bi bi-send-fill me-2"></i>Simpan & Terbitkan
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

    .btn-white { background-color: #fff; }

    /* ─── MOBILE OPTIMIZATION ─── */
    @media (max-width: 576px) {
        .container-fluid { padding-left: 0.5rem !important; padding-right: 0.5rem !important; }
        .card-body { padding: 1.5rem !important; }
        .btn-sm-block { width: 100%; display: block; }
        .responsive-h6 { font-size: 1rem; }
    }
</style>
@endsection