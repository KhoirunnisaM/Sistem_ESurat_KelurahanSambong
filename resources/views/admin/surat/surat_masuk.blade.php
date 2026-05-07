@extends('layouts.admin')

@section('admin_content')
<div class="mb-4">
    <h4 class="fw-bold text-dark">Daftar Surat Masuk</h4>
    <p class="text-muted small">Menampilkan semua permohonan dengan status <b>DIAJUKAN</b> dan <b>DIPROSES</b>.</p>
</div>

<!-- Filter Status Kapsul -->
<div class="d-flex overflow-auto pb-3 mb-4 flex-nowrap gap-2" style="scrollbar-width: none; -ms-overflow-style: none;">
    @php $currentStatus = request('status', 'semua'); @endphp
    <a href="{{ route('admin.surat.masuk', ['status' => 'semua', 'search' => request('search'), 'tanggal' => request('tanggal')]) }}" 
       class="btn btn-sm {{ $currentStatus == 'semua' ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill px-4 fw-bold shadow-sm">
        Semua
    </a>
    <a href="{{ route('admin.surat.masuk', ['status' => 'Diajukan', 'search' => request('search'), 'tanggal' => request('tanggal')]) }}" 
       class="btn btn-sm {{ $currentStatus == 'Diajukan' ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill px-4 fw-bold shadow-sm">
        Diajukan
    </a>
    <a href="{{ route('admin.surat.masuk', ['status' => 'Diproses', 'search' => request('search'), 'tanggal' => request('tanggal')]) }}" 
       class="btn btn-sm {{ $currentStatus == 'Diproses' ? 'btn-success' : 'btn-outline-secondary' }} rounded-pill px-4 fw-bold shadow-sm">
        Diproses
    </a>
</div>

<div class="card card-custom bg-white border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-md-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">Permintaan Aktif</h5>
                <p class="text-muted small mb-0">Kelola surat yang perlu segera ditindaklanjuti.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <form action="{{ route('admin.surat.masuk') }}" method="GET" class="d-flex gap-2">
                    <input type="hidden" name="status" value="{{ request('status', 'semua') }}">
                    
                    <!-- Filter Kalender -->
                    <input type="date" name="tanggal" class="form-control form-control-sm border-0 bg-light px-3 rounded-pill" 
                           value="{{ request('tanggal') }}">

                    <input type="text" name="search" class="form-control form-control-sm border-0 bg-light px-3 rounded-pill" 
                           placeholder="Cari NIK, Nama, Jenis..." value="{{ request('search') }}" style="min-width: 200px;">
                    
                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                        <i class="bi bi-search"></i>
                    </button>

                    @if(request('search') || request('tanggal') || (request('status') && request('status') != 'semua'))
                        <a href="{{ route('admin.surat.masuk') }}" class="btn btn-sm btn-outline-secondary rounded-pill text-decoration-none">Reset</a>
                    @endif
                </form>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-custom align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-muted small text-uppercase" style="font-size: 0.7rem;">
                        <th class="ps-4">No</th>
                        <th>Pemohon</th>
                        <th>Layanan & Nomor Surat</th>
                        <th>Waktu Pengajuan</th>
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $s)
                    <tr>
                        <td class="ps-4 fw-medium text-muted">
                            {{ ($data->currentPage() - 1) * $data->perPage() + $loop->iteration }}
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $s->warga->nama_lengkap }}</div>
                            <small class="text-muted">NIK: {{ $s->warga->nik }}</small>
                        </td>
                        <td>
                            <div class="fw-medium text-dark text-uppercase small">{{ $s->jenisSurat->nama_jenis }}</div>
                            @if($s->status !== 'Diajukan' && $s->nomor_surat)
                                <div class="mt-0">
                                    <span class="text-dark border-0 p-0 small fw-normal" style="font-size: 0.7rem;">
                                        <i class="bi bi-hash text-primary"></i> {{ $s->nomor_surat }}
                                    </span>
                                </div>
                            @elseif($s->status !== 'Diajukan' && !$s->nomor_surat)
                                <small class="text-danger italic" style="font-size: 0.65rem;">* Nomor surat belum diisi</small>
                            @endif
                        </td>
                        <td>
                            <div class="fw-medium text-dark small">{{ $s->created_at->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $s->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td>
                            @php
                                $statusClass = [
                                    'Diajukan' => 'bg-light-warning text-warning border-warning',
                                    'Diproses' => 'bg-light-primary text-primary border-primary',
                                    'Selesai'  => 'bg-light-success text-success border-success',
                                    'Ditolak'  => 'bg-light-danger text-danger border-danger'
                                ];
                            @endphp
                            <span class="badge {{ $statusClass[$s->status] ?? 'bg-light text-secondary' }} px-2 py-1" style="font-size: 0.65rem;">
                                {{ strtoupper($s->status) }}
                            </span>
                        </td>
                       <td class="text-center">
                            <a href="{{ route('admin.surat.show', $s->id) }}?from=masuk" class="btn btn-sm btn-outline-dark px-3 rounded-pill">
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

        {{-- PAGINATION CUSTOM --}}
        @if($data->hasPages())
        <div class="d-flex justify-content-between align-items-center mt-4 pt-3 border-top">
            <div class="text-muted small">
                Menampilkan <b>{{ $data->firstItem() }}</b> - <b>{{ $data->lastItem() }}</b> dari <b>{{ $data->total() }}</b> data
            </div>
            <nav class="custom-pagination">
                {{ $data->appends(request()->query())->links('pagination::bootstrap-4') }}
            </nav>
        </div>
        @endif
    </div>
</div>
@endsection

@section('styles')
<style>
    /* Sembunyikan scrollbar untuk filter status */
    .overflow-auto::-webkit-scrollbar { display: none; }
    
    /* Status Badge Style */
    .bg-light-warning { background-color: #fff8e1 !important; border: 1px solid #ffc107; }
    .bg-light-primary { background-color: #e3f2fd !important; border: 1px solid #0d6efd; }
    .bg-light-success { background-color: #e8f5e9 !important; border: 1px solid #198754; }
    .bg-light-danger { background-color: #ffebee !important; border: 1px solid #dc3545; }
    
    .table-custom thead th { padding: 15px 10px; background-color: #f8f9fa; border-bottom: 2px solid #eee; }
    .table-custom tbody td { padding: 15px 10px; border-bottom: 1px solid #f2f2f2; }
    .badge { border-width: 1px; border-style: solid; font-weight: 600; letter-spacing: 0.3px; }
    .italic { font-style: italic; }

    /* PAGINATION BEAUTIFIER */
    .custom-pagination .pagination {
        margin-bottom: 0;
        gap: 5px;
    }
    .custom-pagination .page-item .page-link {
        border: none;
        border-radius: 8px !important;
        padding: 8px 16px;
        color: #444;
        font-weight: 500;
        font-size: 0.85rem;
        background-color: #f8f9fa;
        transition: all 0.2s ease;
    }
    .custom-pagination .page-item.active .page-link {
        background-color: #198754; 
        color: white;
        box-shadow: 0 4px 10px rgba(25, 135, 84, 0.2);
    }
</style>
@endsection