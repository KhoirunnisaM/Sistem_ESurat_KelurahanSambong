@extends('layouts.admin')

@section('admin_content')
<div class="container-fluid px-2 px-md-3">
    {{-- TOMBOL KEMBALI --}}
    <div class="mb-4">
        <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-white border-0 shadow-sm btn-sm rounded-pill px-3 mb-3 text-muted">
            <i class="bi bi-arrow-left me-1"></i> Kembali
        </a>
        
        <div class="d-flex flex-column d-md-flex flex-md-row justify-content-between align-items-md-start gap-3">
            <div>
                <h3 class="fw-bold text-dark mb-1 responsive-title">{{ $pengumuman->judul }}</h3>
                <div class="d-flex align-items-center flex-wrap gap-2 responsive-sub text-muted">
                    <span>Diterbitkan pada {{ $pengumuman->created_at->translatedFormat('d F Y') }}</span>
                    <span class="d-none d-md-inline">•</span>
                    <div class="d-flex align-items-center">
                        Status: 
                        @if($pengumuman->status)
                            <span class="text-success fw-bold ms-1" style="font-size: 0.7rem;">
                                 PUBLIK
                            </span>
                        @else
                            <span class="text-secondary fw-bold ms-1" style="font-size: 0.7rem;">
                                <i class="bi bi-circle-fill me-1" style="font-size: 0.4rem;"></i> DRAFT
                            </span>
                        @endif
                    </div>
                </div>
            </div>
            <div class="ms-md-auto">
                <a href="{{ route('admin.pengumuman.edit', $pengumuman->id) }}" class="btn btn-primary shadow-sm rounded-pill px-4 btn-sm-block">
                    <i class="bi bi-pencil-square me-2"></i>Edit Pengumuman
                </a>
            </div>
        </div>
    </div>

    <div class="row g-4">
        {{-- ISI PENGUMUMAN --}}
        <div class="col-lg-8">
            <div class="card card-custom border-0 shadow-sm overflow-hidden mb-4">
                <div class="card-body p-4">
                    <h6 class="fw-bold text-dark mb-3 responsive-h6">Konten Utama</h6>
                    <div class="pengumuman-body text-dark" style="line-height: 1.8; white-space: pre-line; font-size: 0.9rem;">
                        {{ $pengumuman->konten }}
                    </div>
                </div>
            </div>
        </div>

        {{-- MEDIA & LAMPIRAN --}}
        <div class="col-lg-4">
            <div class="card card-custom border-0 shadow-sm mb-4">
                <div class="card-header bg-white fw-bold border-0 pt-4 px-4 responsive-h6">
                    Lampiran & Media
                </div>
                <div class="card-body px-4 pb-4">
                    @if($pengumuman->lampiran)
                        @php 
                            $ekstensi = pathinfo($pengumuman->lampiran, PATHINFO_EXTENSION); 
                            $nama_file = basename($pengumuman->lampiran);
                        @endphp

                        @if(in_array($ekstensi, ['jpg', 'jpeg', 'png', 'webp']))
                            <div class="mb-3">
                                <img src="{{ asset('storage/'.$pengumuman->lampiran) }}" class="img-fluid rounded shadow-sm border object-fit-cover w-100" style="max-height: 300px;">
                            </div>
                        @else
                            <div class="bg-light-danger rounded p-3 d-flex align-items-center mb-3">
                                <i class="bi bi-file-earmark-pdf-fill fs-2 text-danger me-3"></i>
                                <div class="text-truncate">
                                    <span class="d-block small fw-bold text-dark text-truncate">{{ $nama_file }}</span>
                                    <span class="text-muted small text-uppercase" style="font-size: 0.65rem;">{{ $ekstensi }} File</span>
                                </div>
                            </div>
                        @endif

                        <div class="d-grid gap-2">
                            <a href="{{ asset('storage/'.$pengumuman->lampiran) }}" target="_blank" class="btn btn-outline-success btn-sm rounded-pill">
                                <i class="bi bi-eye me-1"></i> Lihat / Buka
                            </a>
                            <a href="{{ asset('storage/'.$pengumuman->lampiran) }}" download class="btn btn-light border btn-sm rounded-pill text-muted">
                                <i class="bi bi-download me-1"></i> Unduh File
                            </a>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="bi bi-file-earmark-x text-muted fs-1 d-block mb-2 opacity-25"></i>
                            <span class="text-muted small">Tidak ada lampiran</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@section('styles')
<style>
    /* ─── KESELURUHAN & TRANSISI ─── */
    .container-fluid, .card, .row { transition: all 0.3s ease; }

    /* ─── RESPONSIVE TYPOGRAPHY ─── */
    .responsive-title { font-size: clamp(1.2rem, 3vw, 1.8rem); }
    .responsive-sub { font-size: clamp(0.7rem, 1.5vw, 0.85rem); }
    .responsive-h6 { font-size: clamp(0.85rem, 1.8vw, 1rem); }

    /* ─── STYLING KHAS DASHBOARD ─── */
    .card-custom { border-radius: 12px; }
    .btn-white { background-color: #fff; }
    .bg-light-danger { 
        background-color: #ffebee !important; 
        border: 1px solid #dc3545; 
    }

    /* ─── MOBILE OPTIMIZATION ─── */
    @media (max-width: 576px) {
        .container-fluid { padding-left: 0.5rem !important; padding-right: 0.5rem !important; }
        .card-body { padding: 1.25rem !important; }
        .btn-sm-block { width: 100%; display: block; }
    }
</style>
@endsection