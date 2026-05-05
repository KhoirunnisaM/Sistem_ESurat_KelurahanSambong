@extends('layouts.admin')

@section('admin_content')
<div class="mb-4">
    <h4 class="fw-bold text-dark">Riwayat Pengajuan Surat</h4>
    <p class="text-muted small">Arsip permohonan dengan status <b>SELESAI</b> dan <b>DITOLAK</b>.</p>
</div>

<div class="card card-custom bg-white border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-md-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">Arsip Surat</h5>
            </div>
            <div class="mt-3 mt-md-0">
                <form action="{{ route('admin.surat.riwayat') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm border-0 bg-light px-3 rounded-pill" 
                           placeholder="Cari NIK atau Nama..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                        <i class="bi bi-search"></i>
                    </button>
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
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $s)
                    <tr>
                        <td class="ps-4 fw-medium text-muted">
                            {{ $data->firstItem() + $index }}
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $s->warga->nama_lengkap }}</div>
                            <small class="text-muted">NIK: {{ $s->warga->nik }}</small>
                        </td>
                        <td>
                            <div class="fw-medium text-dark text-uppercase small">{{ $s->jenis_surat }}</div>
                            
                            {{-- Jika Selesai tampilkan Nomor Surat --}}
                            @if($s->status == 'Selesai' && $s->nomor_surat)
                                <div class="mt-1">
                                    <span class="badge bg-light text-dark border-0 p-0 fw-normal" style="font-size: 0.7rem;">
                                        <i class="bi bi-hash text-success"></i> {{ $s->nomor_surat }}
                                    </span>
                                </div>
                            {{-- Jika Ditolak tampilkan Alasan Penolakan dari kolom alasan_ditolak --}}
                            @elseif($s->status == 'Ditolak' && $s->alasan_ditolak)
                                <div class="mt-1">
                                    <div class="p-2 bg-light-danger rounded border-start border-3 border-danger" style="max-width: 250px;">
                                        <small class="text-danger d-block fw-bold" style="font-size: 0.65rem; letter-spacing: 0.5px;">ALASAN DITOLAK:</small>
                                        <small class="text-dark d-block lh-sm" style="font-size: 0.7rem;">
                                            {{ $s->alasan_ditolak }}
                                        </small>
                                    </div>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-medium text-dark small">{{ $s->created_at->format('d/m/Y') }}</div>
                            <small class="text-muted">{{ $s->created_at->format('H:i') }} WIB</small>
                        </td>
                        <td>
                            @php
                                $statusClass = [
                                    'Selesai' => 'bg-light-success text-success border-success',
                                    'Ditolak'  => 'bg-light-danger text-danger border-danger'
                                ];
                            @endphp
                            <span class="badge {{ $statusClass[$s->status] ?? 'bg-light text-secondary' }} px-2 py-1" style="font-size: 0.65rem;">
                                {{ strtoupper($s->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.surat.show', $s->id) }}" class="btn btn-sm btn-outline-dark px-3 rounded-pill" style="font-size: 0.75rem;">
                                Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted small">Belum ada riwayat data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="mt-4">
            {{ $data->links() }}
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-light-success { background-color: #e8f5e9 !important; border: 1px solid #198754; }
    .bg-light-danger { background-color: #ffebee !important; border: 1px solid #dc3545; }
    .table-custom thead th { padding: 15px 10px; background-color: #f8f9fa; }
    .table-custom tbody td { padding: 15px 10px; }
    .badge { border-width: 1px; border-style: solid; font-weight: 600; letter-spacing: 0.3px; }
</style>
@endsection