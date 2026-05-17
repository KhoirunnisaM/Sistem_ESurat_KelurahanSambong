@extends('layouts.app')

@section('content')
<style>
    :root {
        --hijau-keraton: #1e4d3a;
    }

    /* Konsistensi Font Clamp */
    .responsive-td-title { font-size: clamp(0.75rem, 1.2vw, 0.85rem); }
    .responsive-td-date { font-size: clamp(0.75rem, 1.2vw, 0.9rem); }
    .responsive-td-sub { font-size: clamp(0.65rem, 1vw, 0.75rem); }
    .responsive-td-extra { font-size: clamp(0.6rem, 0.9vw, 0.7rem); }
    .responsive-badge { font-size: clamp(0.55rem, 0.8vw, 0.65rem); letter-spacing: 0.5px; }

    /* Card & Container */
    .card-custom { border-radius: 20px; background: #ffffff; }
    
    /* Scroll Filter Kapsul (Mobile Friendly) */
    .filter-scroll::-webkit-scrollbar { display: none; }
    .filter-scroll { -ms-overflow-style: none; scrollbar-width: none; white-space: nowrap; }

    /* Button Styling Kapsul */
    .btn-kapsul {
        border-radius: 30px;
        padding: 4px 11px; /* Mengecilkan padding default agar lebih proporsional */
        font-size: 0.55rem; /* Ukuran font mobile-first */
        font-weight: 600;
        transition: all 0.2s ease;
        background: white;
        text-decoration: none;
        display: inline-block;
        border: 1px solid;
    }

    /* Media Query untuk Desktop (Layar sedang ke atas) */
    @media (min-width: 768px) {
        .btn-kapsul {
            padding: 8px 22px;
            font-size: 0.85rem;
        }
    }

    /* State: Default Outline */
    .btn-outline-semua { border-color: #212529; color: #212529; }
    .btn-outline-diajukan { border-color: #ffc107; color: #ffc107; }
    .btn-outline-diproses { border-color: #0d6efd; color: #0d6efd; }
    .btn-outline-selesai { border-color: #198754; color: #198754; }
    .btn-outline-ditolak { border-color: #dc3545; color: #dc3545; }
    .btn-outline-dibatalkan { border-color: #6c757d; color: #6c757d; }

    /* State: Active (Solid Background) */
    .active-semua { background: #212529 !important; color: white !important; }
    .active-diajukan { background: #ffc107 !important; color: white !important; }
    .active-diproses { background: #0d6efd !important; color: white !important; }
    .active-selesai { background: #198754 !important; color: white !important; }
    .active-ditolak { background: #dc3545 !important; color: white !important; }
    .active-dibatalkan { background: #6c757d !important; color: white !important; }

    /* Input & Search Styling - Responsive */
    .input-group-custom {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        overflow: hidden;
    }
    .input-group-custom .form-control {
        font-size: clamp(0.7rem, 1.5vw, 0.85rem); /* Ukuran teks input mengecil di mobile */
        padding: 0.5rem 0.6rem;
    }
    @media (max-width: 576px) {
        .input-group-custom .form-control {
            padding: 0.4rem 0.4rem;
        }
        .input-group-custom .input-group-text {
            padding: 0.4rem 0.5rem;
        }
    }

    /* Status Text Colors */
    .status-diajukan { color: #ffc107 !important; }
    .status-diproses { color: #0d6efd !important; }
    .status-selesai { color: #198754 !important; }
    .status-ditolak { color: #dc3545 !important; }
    .status-dibatalkan { color: #6c757d !important; }

    /* Custom Pagination */
    .custom-pagination .page-item .page-link { 
        border: none; border-radius: 8px !important; padding: 6px 12px; 
        color: #4b5563; font-weight: 600; font-size: 0.8rem; background: #f3f4f6;
    }
    .custom-pagination .page-item.active .page-link { background-color: var(--hijau-keraton); color: white; }

    /* RESPONSIVE ADJUSTMENTS */
    @media (max-width: 576px) {
        .header-section { flex-direction: column-reverse; align-items: stretch !important; gap: 15px; }
        .btn-kembali { 
            width: fit-content; 
            padding: 5px 15px !important; 
            font-size: 0.75rem !important; 
        }
        .header-title h4 { font-size: 1.1rem; }
        .table > :not(caption) > * > * { padding: 0.75rem 0.5rem !important; }
    }
</style>

<div class="container py-3 py-md-4">
    <div class="card card-custom border-0 shadow-sm p-3 p-md-4">
        
        <div class="d-flex justify-content-between align-items-start mb-4 header-section">
            <div class="header-title">
                <h4 class="fw-bold mb-0 text-dark" style="letter-spacing: -0.5px;">Riwayat Pengajuan</h4>
                <p class="text-muted small mb-0 d-none d-sm-block">Daftar seluruh permohonan surat Anda</p>
            </div>
            <a href="{{ route('warga.dashboard') }}" class="btn btn-light bg-white border rounded-pill px-3 py-1 btn-kembali d-flex align-items-center shadow-sm">
                <i class="bi bi-arrow-left me-2"></i> Kembali
            </a>
        </div>

        <div class="d-flex overflow-auto pb-3 mb-3 filter-scroll gap-2 flex-nowrap">
            @php $currStatus = strtolower(request('status', 'semua')); @endphp
            
            <a href="{{ route('warga.riwayat', ['status' => 'semua']) }}" 
               class="btn-kapsul btn-outline-semua {{ $currStatus == 'semua' ? 'active-semua' : '' }}">Semua</a>
            
            <a href="{{ route('warga.riwayat', ['status' => 'diajukan']) }}" 
               class="btn-kapsul btn-outline-diajukan {{ $currStatus == 'diajukan' ? 'active-diajukan' : '' }}">Diajukan</a>
            
            <a href="{{ route('warga.riwayat', ['status' => 'diproses']) }}" 
               class="btn-kapsul btn-outline-diproses {{ $currStatus == 'diproses' ? 'active-diproses' : '' }}">Diproses</a>
            
            <a href="{{ route('warga.riwayat', ['status' => 'selesai']) }}" 
               class="btn-kapsul btn-outline-selesai {{ $currStatus == 'selesai' ? 'active-selesai' : '' }}">Selesai</a>
            
            <a href="{{ route('warga.riwayat', ['status' => 'ditolak']) }}" 
               class="btn-kapsul btn-outline-ditolak {{ $currStatus == 'ditolak' ? 'active-ditolak' : '' }}">Ditolak</a>
            
            <a href="{{ route('warga.riwayat', ['status' => 'dibatalkan']) }}" 
               class="btn-kapsul btn-outline-dibatalkan {{ $currStatus == 'dibatalkan' ? 'active-dibatalkan' : '' }}">Dibatalkan</a>
        </div>

        <form action="{{ route('warga.riwayat') }}" method="GET" class="row g-2 mb-4">
            <input type="hidden" name="status" value="{{ request('status') }}">
            <div class="col-6 col-md-3">
                <div class="input-group input-group-custom">
                    <span class="input-group-text pe-1"><i class="bi bi-calendar3 small"></i></span>
                    <input type="date" name="tanggal" class="form-control ps-1" value="{{ request('tanggal') }}">
                </div>
            </div>
            <div class="col-6 col-md-6">
                <div class="input-group input-group-custom">
                    <span class="input-group-text pe-1"><i class="bi bi-search small"></i></span>
                    <input type="text" name="cari" class="form-control ps-1" placeholder="Cari..." value="{{ request('cari') }}">
                </div>
            </div>
            <div class="col-12 col-md-3 d-flex gap-2">
                <button type="submit" class="btn btn-dark w-100 fw-bold rounded-3 py-2 shadow-sm" style="background: var(--hijau-keraton); border: none; font-size: clamp(0.75rem, 1.5vw, 0.85rem);">
                    <i class="bi bi-filter"></i> Filter
                </button>
                @if(request('status') || request('tanggal') || request('cari'))
                <a href="{{ route('warga.riwayat') }}" class="btn btn-outline-danger rounded-3 px-3 d-flex align-items-center">
                    <i class="bi bi-x-lg"></i>
                </a>
                @endif
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <th class="px-2 px-md-3 py-3 border-bottom text-muted fw-bold" style="width: 45%; font-size: clamp(0.6rem, 1vw, 0.75rem); letter-spacing: 0.5px;">LAYANAN & DETAIL</th>
                        <th class="py-3 border-bottom text-muted fw-bold" style="width: 30%; font-size: clamp(0.6rem, 1vw, 0.75rem); letter-spacing: 0.5px;">WAKTU</th>
                        <th class="py-3 text-center border-bottom text-muted fw-bold" style="width: 25%; font-size: clamp(0.6rem, 1vw, 0.75rem); letter-spacing: 0.5px;">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $r)
                    <tr onclick="window.location='{{ route('warga.surat.detail', $r->id) }}';" style="cursor: pointer;">
                        <td class="px-2 px-md-3 py-3">
                            <div class="fw-bold text-dark mb-1 responsive-td-title">
                                {{ strtoupper($r->JenisSurat->nama_jenis) }}
                            </div>
                            @if(in_array(ucfirst(strtolower($r->status)), ['Selesai', 'Diproses']) && $r->nomor_surat)
                                <span class="text-success fw-medium responsive-td-sub">
                                    <i class="bi bi-hash"></i> {{ $r->nomor_surat }}
                                </span>
                            @elseif($r->status == 'Ditolak' && $r->alasan_ditolak)
                                <small class="text-danger d-block lh-sm fst-italic responsive-td-extra">* {{ $r->alasan_ditolak }}</small>
                            @elseif($r->status == 'Dibatalkan')
                                <small class="text-muted fst-italic responsive-td-extra">* Dibatalkan oleh warga</small>
                            @endif
                        </td>
                        <td class="py-3">
                            <div class="text-dark fw-medium responsive-td-date">{{ $r->created_at->format('d/m/Y') }}</div>
                            <div class="text-muted responsive-td-sub">{{ $r->created_at->format('H:i') }}</div>
                        </td>
                        <td class="py-3 text-center">
                            @php
                                $statusKey = ucfirst(strtolower($r->status));
                                $statusColorMap = [
                                    'Diajukan'   => 'status-diajukan',
                                    'Diproses'   => 'status-diproses',
                                    'Ditolak'    => 'status-ditolak',
                                    'Selesai'    => 'status-selesai',
                                    'Dibatalkan' => 'status-dibatalkan'
                                ];
                                $currentColorClass = $statusColorMap[$statusKey] ?? 'text-muted';
                            @endphp
                            <span class="{{ $currentColorClass }} fw-bold responsive-badge">
                                {{ strtoupper($r->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" class="text-center py-5 text-muted small">Tidak ada riwayat.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($riwayat->hasPages())
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top gap-3">
            <div class="text-muted small d-none d-md-block">
                Menampilkan <b>{{ $riwayat->firstItem() }}</b> - <b>{{ $riwayat->lastItem() }}</b> dari <b>{{ $riwayat->total() }}</b>
            </div>
            <nav class="custom-pagination">
                {{ $riwayat->appends(request()->query())->links('pagination::bootstrap-4') }}
            </nav>
        </div>
        @endif
    </div>
</div>
@endsection