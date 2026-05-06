@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
        <!-- Header dengan Tombol Kembali -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold mb-0 text-dark">Semua Riwayat Pengajuan</h4>
            <a href="{{ route('warga.dashboard') }}" class="btn btn-white bg-white border shadow-sm rounded-pill px-4">
                <i class="bi bi-arrow-left me-2"></i>Kembali
            </a>
        </div>

        <!-- Filter Status Kapsul -->
        <div class="d-flex overflow-auto pb-3 mb-4 flex-nowrap gap-2" style="scrollbar-width: none; -ms-overflow-style: none;">
            <a href="{{ route('warga.riwayat', ['status' => 'semua']) }}" 
               class="btn {{ request('status') == 'semua' || !request('status') ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill px-4 fw-bold shadow-sm">
                Semua
            </a>
            <a href="{{ route('warga.riwayat', ['status' => 'diajukan']) }}" 
               class="btn {{ request('status') == 'diajukan' ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill px-4 fw-bold shadow-sm">
                Diajukan
            </a>
            <a href="{{ route('warga.riwayat', ['status' => 'diproses']) }}" 
               class="btn {{ request('status') == 'diproses' ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill px-4 fw-bold shadow-sm">
                Diproses
            </a>
            <a href="{{ route('warga.riwayat', ['status' => 'selesai']) }}" 
               class="btn {{ request('status') == 'selesai' ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill px-4 fw-bold shadow-sm">
                Selesai
            </a>
            <a href="{{ route('warga.riwayat', ['status' => 'ditolak']) }}" 
               class="btn {{ request('status') == 'ditolak' ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill px-4 fw-bold shadow-sm">
                Ditolak
            </a>
             <a href="{{ route('warga.riwayat', ['status' => 'dibatalkan']) }}" 
               class="btn {{ request('status') == 'dibatalkan' ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill px-4 fw-bold shadow-sm">
                Dibatalkan
            </a>
        </div>

        <!-- Filter Tanggal & Pencarian Gabungan -->
        <form action="{{ route('warga.riwayat') }}" method="GET" class="row g-2 mb-4">
            <input type="hidden" name="status" value="{{ request('status') }}">
            
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-calendar3"></i></span>
                    <input type="date" name="tanggal" class="form-control border-start-0" value="{{ request('tanggal') }}">
                </div>
            </div>
            <div class="col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" name="cari" class="form-control border-start-0" placeholder="Cari jenis atau nomor surat..." value="{{ request('cari') }}">
                </div>
            </div>
            <div class="col-md-4">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 fw-bold shadow-sm">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                    
                    @if(request('status') || request('tanggal') || request('cari'))
                        <a href="{{ route('warga.riwayat') }}" class="btn btn-outline-danger w-100 fw-bold">
                            <i class="bi bi-x-circle"></i> Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>

        <!-- Tabel Riwayat -->
        <div class="table-responsive">
            <table class="table table-hover table-custom align-middle mb-0">
                <thead>
                    <tr class="text-muted small">
                        <th>TANGGAL</th>
                        <th>JENIS SURAT</th>
                        <th>STATUS</th>
                        <th class="text-end">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayat as $r)
                    <tr>
                        <td class="py-3">
                            <div class="text-dark mb-0" style="font-size: 0.9rem;">{{ $r->created_at->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $r->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $r->JenisSurat->nama_jenis }}</div>
                            @if(($r->status == 'Selesai' || $r->status == 'Diproses') && $r->nomor_surat)
                                <div class="mt-0">
                                    <span class="badge bg-light text-dark border-0 p-0 fw-normal" style="font-size: 0.7rem;">
                                        <i class="bi bi-hash text-success"></i> {{ $r->nomor_surat }}
                                    </span>
                                </div>
                            @elseif($r->status == 'Ditolak' && $r->alasan_ditolak)
                                <div class="mt-1">
                                    <small class="text-danger d-block lh-sm fst-italic" style="font-size: 0.7rem; max-width: 220px; opacity: 0.8;">
                                        * {{ $r->alasan_ditolak }}
                                    </small>    
                                </div>
                            @elseif($r->status == 'Dibatalkan')
                                <div class="mt-0">
                                    <small class="text-muted fst-italic" style="font-size: 0.7rem;">* Dibatalkan oleh warga</small>
                                </div>
                            @endif
                        </td>
                        <td>
                            @php
                                $statusDb = strtolower($r->status);
                                $color = 'bg-light text-dark';
                                if($statusDb == 'diajukan') $color = 'bg-warning-subtle text-warning border-warning';
                                elseif($statusDb == 'diproses') $color = 'bg-info-subtle text-info border-info';
                                elseif($statusDb == 'selesai') $color = 'bg-success-subtle text-success border-success';
                                elseif($statusDb == 'ditolak') $color = 'bg-danger-subtle text-danger border-danger';
                                elseif($statusDb == 'dibatalkan') $color = 'bg-secondary-subtle text-secondary border-secondary';
                            @endphp
                            <span class="badge border {{ $color }} rounded-pill px-3 shadow-sm">{{ strtoupper($r->status) }}</span>
                        </td>
                        <td class="text-end">
                            <a href="{{ route('warga.surat.detail', $r->id) }}" class="btn btn-sm btn-outline-primary rounded-pill px-3 shadow-sm">
                                <i class="bi bi-info-circle me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-5 text-muted">
                            <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                            Tidak ada riwayat ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($riwayat->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <div class="text-muted small d-none d-md-block">
                Menampilkan <b>{{ $riwayat->firstItem() }}</b> sampai <b>{{ $riwayat->lastItem() }}</b> dari <b>{{ $riwayat->total() }}</b> data
            </div>
            <nav class="custom-pagination">
                {{ $riwayat->appends(request()->query())->links('pagination::bootstrap-4') }}
            </nav>
        </div>
        @endif
    </div>
</div>

<style>
    .overflow-auto::-webkit-scrollbar { display: none; }
    .btn-white:hover { background-color: #f8f9fa; border-color: #dee2e6; }
    .bg-warning-subtle { background-color: #fff3cd !important; }
    .bg-info-subtle { background-color: #cff4fc !important; }
    .bg-success-subtle { background-color: #d1e7dd !important; }
    .bg-danger-subtle { background-color: #f8d7da !important; }
    .bg-secondary-subtle { background-color: #e2e3e5 !important; }
    .custom-pagination .pagination { margin-bottom: 0; gap: 5px; }
    .custom-pagination .page-item .page-link { border: none; border-radius: 10px !important; padding: 8px 16px; color: #444; font-weight: 600; font-size: 0.85rem; background-color: #f8f9fa; transition: all 0.2s ease; box-shadow: 0 2px 4px rgba(0,0,0,0.03); }
    .custom-pagination .page-item.active .page-link { background-color: #198754; color: white; box-shadow: 0 4px 10px rgba(25, 135, 84, 0.2); }
</style>
@endsection