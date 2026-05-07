@extends('layouts.admin')

@section('admin_content')
<div class="mb-4">
    <h4 class="fw-bold text-dark">Riwayat Pengajuan Surat</h4>
    <p class="text-muted small">Arsip permohonan dengan status <b>SELESAI</b>, <b>DITOLAK</b>, dan <b>DIBATALKAN</b>.</p>
</div>

<!-- Filter Status Kapsul (Riwayat) -->
<div class="d-flex overflow-auto pb-3 mb-4 flex-nowrap gap-2" style="scrollbar-width: none; -ms-overflow-style: none;">
    @php $currentStatus = request('status', 'semua'); @endphp
    <a href="{{ route('admin.surat.riwayat', ['status' => 'semua', 'search' => request('search'), 'tanggal' => request('tanggal')]) }}" 
               class="btn btn-sm rounded-pill px-3 {{ !request('status') ? 'btn-dark' : 'btn-outline-dark' }}">
        Semua
    </a>
    <a href="{{ route('admin.surat.riwayat', ['status' => 'Selesai', 'search' => request('search'), 'tanggal' => request('tanggal')]) }}" 
               class="btn btn-sm rounded-pill px-3 {{ request('status') == 'Selesai' ? 'btn-success' : 'btn-outline-success' }}">
        Selesai
    </a>
    <a href="{{ route('admin.surat.riwayat', ['status' => 'Ditolak', 'search' => request('search'), 'tanggal' => request('tanggal')]) }}" 
               class="btn btn-sm rounded-pill px-3 {{ request('status') == 'Ditolak' ? 'btn-danger' : 'btn-outline-danger' }}">
        Ditolak
    </a>
    <a href="{{ route('admin.surat.riwayat', ['status' => 'Dibatalkan', 'search' => request('search'), 'tanggal' => request('tanggal')]) }}" 
               class="btn btn-sm rounded-pill px-3 {{ request('status') == 'Dibatalkan' ? 'btn-secondary' : 'btn-outline-secondary' }}">
        Dibatalkan
    </a>
</div>

<div class="card card-custom bg-white border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-md-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">Arsip Surat</h5>
                <p class="text-muted small mb-0">Menampilkan data yang telah diproses final.</p>
            </div>
            <div class="mt-3 mt-md-0">
                <form action="{{ route('admin.surat.riwayat') }}" method="GET" class="d-flex gap-2">
                    <input type="hidden" name="status" value="{{ request('status', 'semua') }}">
                    
                    <!-- Filter Kalender -->
                    <input type="date" name="tanggal" class="form-control form-control-sm border-0 bg-light px-3 rounded-pill" 
                           value="{{ request('tanggal') }}">

                    <input type="text" name="search" class="form-control form-control-sm border-0 bg-light px-3 rounded-pill" 
                           placeholder="Cari NIK, Nama..." value="{{ request('search') }}" style="min-width: 200px;">
                    
                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                        <i class="bi bi-search"></i>
                    </button>

                    @if(request('search') || request('tanggal') || (request('status') && request('status') != 'semua'))
                        <a href="{{ route('admin.surat.riwayat') }}" class="btn btn-sm btn-outline-secondary rounded-pill text-decoration-none">Reset</a>
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
                        <th>Layanan & Detail</th>
                        <th>Waktu Pengajuan</th>
                        <th>Waktu Selesai/Batal</th>
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
                            @if($s->status == 'Selesai' && $s->nomor_surat)
                                <div class="mt-0">
                                    <span class="text-dark border-0 p-0 fw-normal" style="font-size: 0.7rem;">
                                        <i class="bi bi-hash text-success"></i> {{ $s->nomor_surat }}
                                    </span>
                                </div>
                            @elseif($s->status == 'Ditolak' && $s->alasan_ditolak)
                                <div class="mt-1">
                                    <small class="text-danger d-block fst-italic" style="font-size: 0.7rem; max-width: 220px; opacity: 0.8;">
                                        * {{ $s->alasan_ditolak }}
                                    </small>    
                                </div>
                            @elseif($s->status == 'Dibatalkan')
                                <div class="mt-0">
                                    <small class="text-muted italic" style="font-size: 0.7rem;">* Dibatalkan oleh warga</small>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-medium text-dark small">{{ $s->created_at->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $s->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td>
                            <div class="fw-bold text-primary small">{{ $s->updated_at->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $s->updated_at->format('H:i') }} WIB</small>
                        </td>
                        <td>
                            @php
                                $statusClass = [
                                    'Selesai'    => 'bg-light-success text-success border-success',
                                    'Ditolak'    => 'bg-light-danger text-danger border-danger',
                                    'Dibatalkan' => 'bg-light-secondary text-secondary border-secondary'
                                ];
                            @endphp
                            <span class="badge {{ $statusClass[$s->status] ?? 'bg-light text-secondary' }} px-2 py-1" style="font-size: 0.65rem;">
                                {{ strtoupper($s->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.surat.show', $s->id) }}?from=riwayat" class="btn btn-sm btn-outline-dark px-3 rounded-pill">
    Detail
</a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5 text-muted small">Belum ada riwayat data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
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