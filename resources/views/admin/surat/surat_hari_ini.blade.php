@extends('layouts.admin')

@section('admin_content')
<div class="mb-4">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-sm btn-outline-secondary rounded-pill mb-3">
        <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
    </a>
    <h4 class="fw-bold text-dark">Daftar Semua Surat Hari Ini</h4>
    <p class="text-muted small">Menampilkan seluruh permohonan yang diajukan khusus hari ini, tanggal {{ \Carbon\Carbon::today()->format('d F Y') }}.</p>
</div>

<div class="card card-custom bg-white border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-md-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">Surat Masuk Hari Ini</h5>
                <p class="text-muted small mb-0">Urutan berdasarkan waktu pengajuan terbaru.</p>
            </div>
            
            <div class="mt-3 mt-md-0">
                <form action="{{ route('admin.surat.hari-ini') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-sm border-0 bg-light px-3 rounded-pill" 
                           placeholder="Cari NIK, Nama, Jenis..." value="{{ request('search') }}">
                    
                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                        <i class="bi bi-search"></i>
                    </button>

                    @if(request('search'))
                        <a href="{{ route('admin.surat.hari-ini') }}" class="btn btn-sm btn-outline-secondary rounded-pill">Reset</a>
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
                        <th>Status</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $s)
                    <tr>
                        <td class="ps-4 fw-medium text-muted">
                            @if(method_exists($data, 'firstItem'))
                                {{ $data->firstItem() + $index }}
                            @else
                                {{ $index + 1 }}
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $s->warga->nama_lengkap ?? 'User' }}</div>
                            <small class="text-muted">NIK: {{ $s->warga->nik ?? '-' }}</small>
                        </td>
                        <td>
                            <div class="fw-medium text-dark text-uppercase small">{{ $s->jenis_surat }}</div>
                            
                           @if($s->status == 'Selesai' && $s->nomor_surat)
                                <div class="mt-0">
                                    <span class="text-dark border-0 p-0 fw-normal" style="font-size: 0.7rem;">
                                        <i class="bi bi-hash text-success"></i> {{ $s->nomor_surat }}
                                    </span>
                                </div>
                                 @elseif($s->status == 'Diproses' && $s->nomor_surat)
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
                                    <small class="text-muted fst-italic" style="font-size: 0.7rem;">* Dibatalkan oleh warga</small>
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
                                    'Diajukan' => 'bg-light-warning text-warning border-warning',
                                    'Diproses' => 'bg-light-primary text-primary border-primary',
                                    'Ditolak'  => 'bg-light-danger text-danger border-danger',
                                    'Selesai'  => 'bg-light-success text-success border-success'
                                ];
                                $currentClass = $statusClass[$s->status] ?? 'bg-light text-secondary';
                            @endphp
                            <span class="badge {{ $currentClass }} px-2 py-1" style="font-size: 0.65rem;">
                                {{ strtoupper($s->status) }}
                            </span>
                        </td>
                        <td class="text-center">
                            <a href="{{ route('admin.surat.show', $s->id) }}" class="btn btn-sm btn-dark px-3 rounded-pill" style="font-size: 0.75rem;">
                                Periksa
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted small">Tidak ada permohonan surat hari ini.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4 d-flex justify-content-center">
            @if(method_exists($data, 'links'))
                {{ $data->appends(request()->query())->links() }}
            @endif
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .bg-light-warning { background-color: #fff8e1 !important; border: 1px solid #ffc107; }
    .bg-light-primary { background-color: #e3f2fd !important; border: 1px solid #0d6efd; }
    .bg-light-danger { background-color: #ffebee !important; border: 1px solid #dc3545; }
    .bg-light-success { background-color: #e8f5e9 !important; border: 1px solid #198754; }
    .table-custom thead th { padding: 15px 10px; background-color: #f8f9fa; }
    .table-custom tbody td { padding: 15px 10px; }
    .badge { border-width: 1px; border-style: solid; font-weight: 600; letter-spacing: 0.3px; }
</style>
@endsection