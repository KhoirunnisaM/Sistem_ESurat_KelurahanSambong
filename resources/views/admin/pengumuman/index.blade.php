@extends('layouts.admin')

@section('admin_content')

<div class="container-fluid px-2 px-md-3">
    {{-- 1. HEADER HALAMAN --}}
    <div class="d-flex flex-column d-md-flex flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-dark mb-1 responsive-title">Pengumuman</h4>
            <p class="text-muted small mb-0 responsive-sub">Kelola informasi, agenda, dan berita untuk warga.</p>
        </div>
        <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-success shadow-sm rounded-pill px-4 btn-sm-block">
            <i class="bi bi-plus-lg me-2"></i>Tambah Pengumuman
        </a>
    </div>

    {{-- 2. BAGIAN TABEL DATA --}}
    <div class="card card-custom bg-white border-0 shadow-sm overflow-hidden">
        <div class="card-body p-3 p-md-4">
            <div class="table-responsive">
                <table class="table table-hover table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-muted small text-uppercase" style="font-size: 0.65rem;">
                            <th class="ps-3" style="width: 80px;">Media</th>
                            <th>Informasi</th>
                            <th>Status</th>
                            <th>Tanggal Post</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pengumuman as $p)
                        <tr style="font-size: 0.85rem;">
                            <td class="ps-3">
                                @if($p->lampiran)
                                    @php $ekstensi = pathinfo($p->lampiran, PATHINFO_EXTENSION); @endphp
                                    @if(in_array($ekstensi, ['jpg', 'jpeg', 'png', 'webp']))
                                        <img src="{{ asset('storage/'.$p->lampiran) }}" class="rounded shadow-sm img-thumbnail-custom">
                                    @else
                                        <div class="bg-light-danger rounded d-flex align-items-center justify-content-center img-thumbnail-custom">
                                            <i class="bi bi-file-earmark-pdf fs-5 text-danger"></i>
                                        </div>
                                    @endif
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center img-thumbnail-custom">
                                        <i class="bi bi-megaphone fs-5 text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="fw-bold text-dark text-truncate" style="max-width: 250px;">{{ $p->judul }}</div>
                                <small class="text-muted d-block text-truncate" style="font-size: 0.7rem; max-width: 250px;">
                                    {{ strip_tags($p->konten) }}
                                </small>
                            </td>
                            <td>
                                @if($p->status)
                                    <span class="text-success fw-bold" style="font-size: 0.65rem;">
                                        <i class="bi bi-circle-fill me-1" style="font-size: 0.4rem;"></i> PUBLIK
                                    </span>
                                @else
                                    <span class="text-secondary fw-bold" style="font-size: 0.65rem;">
                                        <i class="bi bi-circle-fill me-1" style="font-size: 0.4rem;"></i> DRAFT
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="text-dark fw-medium" style="font-size: 0.75rem;">{{ $p->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted" style="font-size: 0.65rem;">{{ $p->created_at->translatedFormat('H:i') }} WIB</small>
                            </td>
                            <td class="text-center">
                                <div class="btn-group shadow-sm rounded-pill overflow-hidden">
                                    <a href="{{ route('admin.pengumuman.show', $p->id) }}" class="btn btn-sm btn-white border-end px-2" title="Detail">
                                        <i class="bi bi-eye text-info"></i>
                                    </a>
                                    <a href="{{ route('admin.pengumuman.edit', $p->id) }}" class="btn btn-sm btn-white border-end px-2" title="Edit">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </a>
                                    <form action="{{ route('admin.pengumuman.destroy', $p->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-white px-2" onclick="return confirm('Hapus pengumuman ini?')" title="Hapus">
                                            <i class="bi bi-trash3 text-danger"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted small">
                                <i class="bi bi-megaphone fs-1 d-block mb-3 opacity-25"></i>
                                Belum ada pengumuman yang diterbitkan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
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
    .responsive-title { font-size: clamp(1.1rem, 2.5vw, 1.4rem); }
    .responsive-sub { font-size: clamp(0.7rem, 1.5vw, 0.85rem); }
    
    /* ─── CUSTOM ELEMENT ─── */
    .card-custom { border-radius: 12px; }
    .bg-light-danger { background-color: #ffebee !important; border: 1px solid #dc3545; }
    .btn-white { background-color: #fff; }
    .btn-white:hover { background-color: #f8f9fa; }

    .img-thumbnail-custom {
        width: 60px;
        height: 45px;
        object-fit: cover;
    }

    .table-custom thead th { 
        padding: 12px 8px; 
        background-color: #f8f9fa; 
        border-bottom: 2px solid #edf2f7;
    }

    /* ─── MOBILE OPTIMIZATION ─── */
    @media (max-width: 576px) {
        .container-fluid { padding-left: 0.5rem !important; padding-right: 0.5rem !important; }
        .card-body { padding: 1rem !important; }
        .btn-sm-block { width: 100%; }
        .img-thumbnail-custom { width: 45px; height: 35px; }
    }
</style>
@endsection