@extends('layouts.admin')

@section('admin_content')
<div id="realtime-container" class="container-fluid px-2 px-md-3">
    {{-- 1. HEADER HALAMAN --}}
    <div class="mb-4">
        <h4 class="fw-bold text-dark responsive-title">Daftar Surat Masuk</h4>
        <p class="text-muted small responsive-sub">Semua permohonan surat dengan status <b>DIAJUKAN</b> dan <b>DIPROSES</b>.</p>
    </div>

    {{-- 2. FILTER KAPSUL STATUS (Scrollable di Mobile) --}}
    <div class="d-flex flex-nowrap overflow-auto gap-2 mb-4 pb-2" style="scrollbar-width: none; -ms-overflow-style: none;">
        @php $currentStatus = request('status', 'semua'); @endphp
        <a href="{{ route('admin.surat.masuk', ['status' => 'semua', 'search' => request('search'), 'tanggal' => request('tanggal')]) }}" 
           class="btn btn-sm rounded-pill px-3 flex-shrink-0 {{ !request('status') || request('status') == 'semua' ? 'btn-dark' : 'btn-outline-dark' }}">
           Semua
        </a>
        <a href="{{ route('admin.surat.masuk', ['status' => 'Diajukan', 'search' => request('search'), 'tanggal' => request('tanggal')]) }}" 
           class="btn btn-sm rounded-pill px-3 flex-shrink-0 {{ request('status') == 'Diajukan' ? 'btn-warning text-white' : 'btn-outline-warning' }}">
           Diajukan
        </a>
        <a href="{{ route('admin.surat.masuk', ['status' => 'Diproses', 'search' => request('search'), 'tanggal' => request('tanggal')]) }}" 
           class="btn btn-sm rounded-pill px-3 flex-shrink-0 {{ request('status') == 'Diproses' ? 'btn-primary' : 'btn-outline-primary' }}">
           Diproses
        </a>
    </div>

    {{-- 3. BAGIAN TABEL DATA --}}
    <div class="card card-custom bg-white border-0 shadow-sm overflow-hidden">
        <div class="card-body p-3 p-md-4">
            <div class="d-flex flex-column d-md-flex flex-md-row justify-content-between align-items-md-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1 responsive-h6">Permintaan Aktif</h5>
                    <p class="text-muted small mb-0 responsive-text">Kelola surat yang perlu segera ditindaklanjuti.</p>
                </div>
                
                <div class="mt-3 mt-md-0">
                    <form action="{{ route('admin.surat.masuk') }}" method="GET" class="d-flex flex-wrap flex-md-nowrap gap-2">
                        <input type="hidden" name="status" value="{{ request('status', 'semua') }}">
                        
                        <input type="date" name="tanggal" class="form-control form-control-sm border-0 bg-light px-3 rounded-pill" 
                               value="{{ request('tanggal') }}" style="max-width: 150px;">

                        <div class="input-group input-group-sm flex-nowrap" style="min-width: 180px;">
                            <input type="text" name="search" class="form-control border-0 bg-light px-3 rounded-start-pill" 
                                   placeholder="Cari NIK, Nama..." value="{{ request('search') }}">
                            <button type="submit" class="btn btn-success rounded-end-pill px-3">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>

                        @if(request('search') || request('tanggal') || (request('status') && request('status') != 'semua'))
                            <a href="{{ route('admin.surat.masuk') }}" class="btn btn-sm btn-outline-secondary rounded-pill d-flex align-items-center">Reset</a>
                        @endif
                    </form>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-muted small text-uppercase" style="font-size: 0.65rem;">
                            <th class="ps-3">No</th>
                            <th>Pemohon</th>
                            <th>Layanan & Nomor Surat</th>
                            <th>Waktu Pengajuan</th>
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
                                <div class="fw-bold text-dark text-truncate" style="max-width: 150px;">{{ $s->warga->nama_lengkap }}</div>
                                <small class="text-muted d-block" style="font-size: 0.7rem;">NIK: {{ $s->warga->nik }}</small>
                            </td>
                            <td>
                                <div class="fw-medium text-dark text-uppercase" style="font-size: 0.75rem;">{{ $s->jenisSurat->nama_jenis }}</div>
                                @if($s->status !== 'Diajukan' && $s->nomor_surat)
                                    <small class="text-primary" style="font-size: 0.65rem;"><i class="bi bi-hash"></i> {{ $s->nomor_surat }}</small>
                                @elseif($s->status !== 'Diajukan' && !$s->nomor_surat)
                                    <small class="text-danger fst-italic" style="font-size: 0.65rem;">* Nomor surat belum diisi</small>
                                @endif
                            </td>
                            <td>
                                <div class="text-dark fw-medium" style="font-size: 0.75rem;">{{ $s->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted" style="font-size: 0.65rem;">{{ $s->created_at->format('H:i') }} WIB</small>
                            </td>
                            <td>
                                @php
                                    $statusColor = [
                                        'Diajukan' => 'text-warning',
                                        'Diproses' => 'text-primary',
                                        'Selesai'  => 'text-success',
                                        'Ditolak'  => 'text-danger',
                                        'Dibatalkan' => 'text-secondary'
                                    ];
                                    $currentColor = $statusColor[$s->status] ?? 'text-muted';
                                @endphp
                                <span class="{{ $currentColor }} fw-bold" style="font-size: 0.65rem;">{{ strtoupper($s->status) }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.surat.show', $s->id) }}?from=masuk" class="btn btn-sm btn-outline-dark rounded-pill px-2 py-0" style="font-size: 0.7rem;">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted small">Tidak ada surat yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if($data->hasPages())
            <div class="mt-4 d-flex flex-column d-md-flex flex-md-row justify-content-between align-items-center gap-3 pt-3 border-top">
                <div class="text-muted small responsive-text text-center text-md-start">
                    Menampilkan <b>{{ $data->firstItem() }}</b> - <b>{{ $data->lastItem() }}</b> dari <b>{{ $data->total() }}</b> data
                </div>
                <div class="custom-pagination">
                    {{ $data->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
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

    /* ─── RESPONSIVE TYPOGRAPHY (Clamp) ─── */
    .responsive-title { font-size: clamp(1.1rem, 2.5vw, 1.4rem); }
    .responsive-sub { font-size: clamp(0.7rem, 1.5vw, 0.85rem); }
    .responsive-h6 { font-size: clamp(0.85rem, 1.8vw, 1rem); }
    .responsive-text { font-size: clamp(0.7rem, 1.2vw, 0.8rem); }

    .card-custom { border-radius: 12px; }
    
    .table-custom thead th { 
        padding: 12px 8px; 
        background-color: #f8f9fa; 
        border-bottom: 2px solid #edf2f7;
    }

    /* ─── MOBILE OPTIMIZATION ─── */
    @media (max-width: 576px) {
        .container-fluid { padding-left: 0.5rem !important; padding-right: 0.5rem !important; }
        .card-body { padding: 1rem !important; }
        .table-responsive { border: 0; }
        .btn-sm { font-size: 0.7rem; padding: 4px 8px; }
        .overflow-auto::-webkit-scrollbar { display: none; }
    }
</style>
@endsection