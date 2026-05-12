@extends('layouts.admin')

@section('admin_content')
<div class="container-fluid px-2 px-md-3">
    {{-- HEADER & NAVIGASI --}}
    <div class="mb-4">
        <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill mb-3 px-3">
            <i class="bi bi-arrow-left me-1"></i> Kembali ke Dashboard
        </a>
        <h4 class="fw-bold text-dark responsive-title">Daftar Semua Surat Hari Ini</h4>
        <p class="text-muted small responsive-sub">
            Menampilkan seluruh permohonan yang diajukan khusus hari ini, tanggal <b>{{ \Carbon\Carbon::today()->translatedFormat('d F Y') }}</b>.
        </p>
    </div>

    {{-- FILTER STATUS KAPSUL --}}
    <div class="d-flex overflow-auto pb-3 mb-4 flex-nowrap gap-2" style="scrollbar-width: none; -ms-overflow-style: none;">
        @php $currentStatus = request('status', 'semua'); @endphp
        <a href="{{ route('admin.surat.hari-ini', ['status' => 'semua', 'search' => request('search')]) }}" 
           class="btn btn-sm rounded-pill px-3 flex-shrink-0 {{ !request('status') || request('status') == 'semua' ? 'btn-dark' : 'btn-outline-dark' }}">
            Semua
        </a>
        <a href="{{ route('admin.surat.hari-ini', ['status' => 'Diajukan', 'search' => request('search')]) }}" 
           class="btn btn-sm rounded-pill px-3 flex-shrink-0 {{ request('status') == 'Diajukan' ? 'btn-warning text-white' : 'btn-outline-warning' }}">
            Diajukan
        </a>
        <a href="{{ route('admin.surat.hari-ini', ['status' => 'Diproses', 'search' => request('search')]) }}" 
           class="btn btn-sm rounded-pill px-3 flex-shrink-0 {{ request('status') == 'Diproses' ? 'btn-primary' : 'btn-outline-primary' }}">
            Diproses
        </a>
        <a href="{{ route('admin.surat.hari-ini', ['status' => 'Selesai', 'search' => request('search')]) }}" 
           class="btn btn-sm rounded-pill px-3 flex-shrink-0 {{ request('status') == 'Selesai' ? 'btn-success' : 'btn-outline-success' }}">
            Selesai
        </a>
        <a href="{{ route('admin.surat.hari-ini', ['status' => 'Ditolak', 'search' => request('search')]) }}" 
           class="btn btn-sm rounded-pill px-3 flex-shrink-0 {{ request('status') == 'Ditolak' ? 'btn-danger' : 'btn-outline-danger' }}">
            Ditolak
        </a>
        <a href="{{ route('admin.surat.hari-ini', ['status' => 'Dibatalkan', 'search' => request('search')]) }}" 
           class="btn btn-sm rounded-pill px-3 flex-shrink-0 {{ request('status') == 'Dibatalkan' ? 'btn-secondary' : 'btn-outline-secondary' }}">
            Dibatalkan
        </a>
    </div>

    {{-- CARD TABEL DATA --}}
    <div class="card card-custom bg-white border-0 shadow-sm overflow-hidden">
        <div class="card-body p-3 p-md-4">
            {{-- JUDUL TABEL & SEARCH --}}
            <div class="d-flex flex-column d-md-flex flex-md-row justify-content-between align-items-md-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1 responsive-h6">Surat Masuk Hari Ini</h5>
                    <p class="text-muted small mb-0 responsive-text">Urutan berdasarkan waktu pengajuan terbaru.</p>
                </div>
                
                <div class="mt-3 mt-md-0">
                    <form action="{{ route('admin.surat.hari-ini') }}" method="GET" class="d-flex flex-wrap flex-md-nowrap gap-2">
                        <input type="hidden" name="status" value="{{ request('status', 'semua') }}">
                        
                        <div class="d-flex gap-2 flex-grow-1">
                            <input type="text" name="search" class="form-control form-control-sm border-0 bg-light px-3 rounded-pill flex-grow-1" 
                                   placeholder="Cari..." value="{{ request('search') }}" style="min-width: 150px;">
                            
                            <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>

                        @if(request('search') || (request('status') && request('status') != 'semua'))
                            <a href="{{ route('admin.surat.hari-ini') }}" class="btn btn-sm btn-outline-secondary rounded-pill text-decoration-none d-flex align-items-center justify-content-center px-3">
                                Reset
                            </a>
                        @endif
                    </form>
                </div>
            </div>

            {{-- TABEL DATA --}}
            <div class="table-responsive">
                <table class="table table-hover table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-muted small text-uppercase" style="font-size: 0.65rem;">
                            <th class="ps-3">No</th>
                            <th>Pemohon</th>
                            <th>Layanan</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data as $index => $s)
                        <tr style="font-size: 0.85rem;">
                            <td class="ps-3 fw-medium text-muted">
                                {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                            </td>
                            <td>
                                <div class="fw-bold text-dark text-truncate" style="max-width: 150px;">{{ $s->warga->nama_lengkap ?? 'User' }}</div>
                                <small class="text-muted d-block" style="font-size: 0.7rem;">NIK: {{ $s->warga->nik ?? '-' }}</small>
                            </td>
                            <td>
                                <div class="fw-medium text-dark text-uppercase" style="font-size: 0.75rem;">{{ $s->jenisSurat->nama_jenis }}</div>
                                
                                @if(($s->status == 'Selesai' || $s->status == 'Diproses') && $s->nomor_surat)
                                    <small class="text-success" style="font-size: 0.65rem;"><i class="bi bi-hash"></i> {{ $s->nomor_surat }}</small>
                                @elseif($s->status == 'Ditolak' && $s->alasan_ditolak)
                                    <small class="text-danger d-block fst-italic text-truncate" style="font-size: 0.65rem; max-width: 200px; opacity: 0.8;">
                                        * {{ $s->alasan_ditolak }}
                                    </small>
                                @elseif($s->status == 'Dibatalkan')
                                    <small class="text-muted fst-italic" style="font-size: 0.65rem;">* Dibatalkan warga</small>
                                @endif
                            </td>
                            <td>
                                <div class="fw-medium text-dark" style="font-size: 0.75rem;">{{ $s->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted" style="font-size: 0.65rem;">{{ $s->created_at->format('H:i') }} WIB</small>
                            </td>
                            {{-- Ganti bagian kolom status di dalam tbody dengan kode ini --}}
<td>
    @php
        $statusColor = [
            'Diajukan'   => 'text-warning',
            'Diproses'   => 'text-primary',
            'Ditolak'    => 'text-danger',
            'Selesai'    => 'text-success',
            'Dibatalkan' => 'text-secondary'
        ];
        $currentColor = $statusColor[$s->status] ?? 'text-muted';
    @endphp
    <span class="{{ $currentColor }} fw-bold" style="font-size: 0.65rem;">
        {{ strtoupper($s->status) }}
    </span>
</td>
                            <td class="text-center">
                                <a href="{{ route('admin.surat.show', $s->id) }}?from=hari-ini" class="btn btn-sm btn-outline-dark px-3 rounded-pill py-0" style="font-size: 0.75rem;">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted small">Tidak ada permohonan surat ditemukan hari ini.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- PAGINATION CUSTOM --}}
            @if($data->hasPages())
            <div class="d-flex flex-column d-md-flex flex-md-row justify-content-between align-items-center mt-4 pt-3 border-top gap-3">
                <div class="text-muted small responsive-text text-center text-md-start">
                    Menampilkan <b>{{ $data->firstItem() }}</b> - <b>{{ $data->lastItem() }}</b> dari <b>{{ $data->total() }}</b> data
                </div>
                <nav class="custom-pagination overflow-auto w-100 w-md-auto d-flex justify-content-center">
                    {{ $data->appends(request()->query())->links('pagination::bootstrap-4') }}
                </nav>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* ─── KESELURUHAN & TRANSISI ─── */
    .container-fluid, .card, .row { transition: all 0.3s ease; }

    /* ─── RESPONSIVE TYPOGRAPHY (Konsisten Dashboard) ─── */
    .responsive-title { font-size: clamp(1.1rem, 2.5vw, 1.4rem); }
    .responsive-sub { font-size: clamp(0.7rem, 1.5vw, 0.85rem); }
    .responsive-h6 { font-size: clamp(0.85rem, 1.8vw, 1rem); }
    .responsive-text { font-size: clamp(0.7rem, 1.2vw, 0.8rem); }

    /* Sembunyikan scrollbar untuk filter status */
    .overflow-auto::-webkit-scrollbar { display: none; }
    
    /* Warna Status (Sesuai Dashboard) */
    .bg-light-warning { background-color: #fff8e1 !important; border: 1px solid #ffc107; }
    .bg-light-primary { background-color: #e3f2fd !important; border: 1px solid #0d6efd; }
    .bg-light-success { background-color: #e8f5e9 !important; border: 1px solid #198754; }
    .bg-light-danger { background-color: #ffebee !important; border: 1px solid #dc3545; }
    .bg-light-secondary { background-color: #f8f9fa !important; border: 1px solid #6c757d; }
    
    .table-custom thead th { 
        padding: 12px 8px; 
        background-color: #f8f9fa; 
        border-bottom: 2px solid #edf2f7;
    }
    .badge { border-width: 1px; border-style: solid; font-weight: 600; letter-spacing: 0.3px; }

    /* PAGINATION BEAUTIFIER (Konsisten Dashboard) */
    .custom-pagination .pagination { margin-bottom: 0; gap: 3px; }
    .custom-pagination .page-item .page-link {
        border: none;
        border-radius: 6px !important;
        padding: 6px 12px;
        color: #444;
        font-weight: 500;
        font-size: 0.75rem;
        background-color: #f8f9fa;
        transition: all 0.2s ease;
    }
    .custom-pagination .page-item.active .page-link {
        background-color: #198754; 
        color: white;
        box-shadow: 0 4px 10px rgba(25, 135, 84, 0.2);
    }

    /* MOBILE OPTIMIZATION */
    @media (max-width: 576px) {
        .card-body { padding: 1rem !important; }
        .table-custom thead th { padding: 8px 4px; }
        .table-custom tbody td { padding: 8px 4px; }
        .btn-sm { font-size: 0.7rem; }
    }
</style>
@endsection