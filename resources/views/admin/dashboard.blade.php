@extends('layouts.admin')

@section('admin_content')

{{-- 1. TAMPILAN RINGKASAN AKTIVITAS (Sesuai kode awal Anda) --}}
@if(!request('filter'))
<div class="mb-4">
    <h4 class="fw-bold text-dark">Ringkasan Aktivitas</h4>
    <p class="text-muted small">Pemantauan real-time pengajuan surat Kelurahan Sambong.</p>
</div>

<div class="row g-4 mb-5">
    <div class="col-6 col-md-3">
        <div class="card card-custom stat-card bg-white h-100 p-3 shadow-sm border-0">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="h6 text-muted mb-0 small">Surat Diajukan</div>
                <div class="icon-shape bg-light-warning text-warning rounded-pill px-2 py-1 small">
                    <i class="bi bi-bell-fill"></i>
                </div>
            </div>
            <div class="h2 fw-bold text-dark mb-0">{{ $stats['diajukan'] ?? 0 }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom stat-card bg-white h-100 p-3 shadow-sm border-0">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="h6 text-muted mb-0 small">Sedang Diproses</div>
                <div class="icon-shape bg-light-primary text-primary rounded-pill px-2 py-1 small">
                    <i class="bi bi-gear-fill"></i>
                </div>
            </div>
            <div class="h2 fw-bold text-dark mb-0">{{ $stats['diproses'] ?? 0 }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom stat-card bg-white h-100 p-3 shadow-sm border-0">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="h6 text-muted mb-0 small">Ditolak</div>
                <div class="icon-shape bg-light-danger text-danger rounded-pill px-2 py-1 small">
                    <i class="bi bi-x-circle-fill"></i>
                </div>
            </div>
            <div class="h2 fw-bold text-dark mb-0">{{ $stats['ditolak'] ?? 0 }}</div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="card card-custom stat-card bg-white h-100 p-3 shadow-sm border-0">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <div class="h6 text-muted mb-0 small">Surat Selesai</div>
                <div class="icon-shape bg-light-success text-success rounded-pill px-2 py-1 small">
                    <i class="bi bi-check-circle-fill"></i>
                </div>
            </div>
            <div class="h2 fw-bold text-dark mb-0">{{ $stats['selesai'] ?? 0 }}</div>
        </div>
    </div>
</div>
@endif

{{-- 2. BAGIAN TABEL DATA (Sudah diselaraskan dengan halaman detail harian) --}}
<div class="card card-custom bg-white border-0 shadow-sm">
    <div class="card-body p-4">
        <div class="d-md-flex justify-content-between align-items-center mb-4">
            <div>
                <h5 class="fw-bold mb-1">
                    @if(request('filter') == 'masuk') Daftar Surat Masuk 
                    @elseif(request('filter') == 'riwayat') Daftar Riwayat Surat 
                    @else Surat Masuk Hari Ini
                    @endif
                </h5>
                <p class="text-muted small mb-0">
                    @if(!request('filter') && !request('search'))
                        Menampilkan permohonan yang diajukan khusus hari ini.
                    @else
                        Urutan berdasarkan waktu pengajuan terdahulu.
                    @endif
                </p>
            </div>
            
            <div class="mt-3 mt-md-0 d-flex gap-2">
                <form action="{{ url()->current() }}" method="GET" class="d-flex gap-2">
                    @if(request('filter'))
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                        <select name="status" class="form-select form-select-sm border-0 bg-light rounded-pill px-3" onchange="this.form.submit()">
                            <option value="">Semua Status</option>
                            <option value="Diajukan" {{ request('status') == 'Diajukan' ? 'selected' : '' }}>Diajukan</option>
                            <option value="Diproses" {{ request('status') == 'Diproses' ? 'selected' : '' }}>Diproses</option>
                            <option value="Selesai" {{ request('status') == 'Selesai' ? 'selected' : '' }}>Selesai</option>
                            <option value="Ditolak" {{ request('status') == 'Ditolak' ? 'selected' : '' }}>Ditolak</option>
                        </select>
                    @endif

                    <input type="text" name="search" class="form-control form-control-sm border-0 bg-light px-3 rounded-pill" 
                           placeholder="Cari NIK, Nama, Jenis..." value="{{ request('search') }}">
                    
                    <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                        <i class="bi bi-search"></i>
                    </button>

                    @if(request('search') || request('status'))
                        <a href="{{ url()->current() . (request('filter') ? '?filter='.request('filter') : '') }}" 
                           class="btn btn-sm btn-outline-secondary rounded-pill">Reset</a>
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
                    @forelse($surat_terbaru as $index => $s)
                    <tr>
                        <td class="ps-4 fw-medium text-muted">
                            @if(method_exists($surat_terbaru, 'firstItem'))
                                {{ $surat_terbaru->firstItem() + $index }}
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
                            
                            {{-- PENYELARASAN: Tampilkan Nomor Surat atau Alasan Penolakan --}}
                            @if(in_array($s->status, ['Diproses', 'Selesai']) && $s->nomor_surat)
                                <div class="mt-1">
                                    <span class="badge bg-light text-dark border-0 p-0 fw-normal" style="font-size: 0.7rem;">
                                        <i class="bi bi-hash text-primary"></i> {{ $s->nomor_surat }}
                                    </span>
                                </div>
                            @elseif($s->status == 'Ditolak' && $s->alasan_ditolak)
                                <div class="mt-1">
                                    <small class="text-danger d-block lh-sm" style="font-size: 0.7rem; max-width: 220px;">
                                        <i class="bi bi-exclamation-circle-fill"></i> <b>Alasan:</b> {{ $s->alasan_ditolak }}
                                    </small>
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
                        <td colspan="6" class="text-center py-5 text-muted small">Tidak ada data surat yang tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-4 text-center">
            @if(!request('filter') && !request('search'))
                <a href="{{ route('admin.surat.hari-ini') }}" class="btn btn-sm btn-outline-success rounded-pill px-4">
                    Lihat Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                </a>
            @else
                <div class="d-flex justify-content-center">
                    @if(method_exists($surat_terbaru, 'links'))
                        {{ $surat_terbaru->appends(request()->query())->links() }}
                    @endif
                </div>
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
    .stat-card { border-radius: 12px; }
    .table-custom thead th { padding: 15px 10px; background-color: #f8f9fa; }
    /* Menambahkan style badge agar konsisten */
    .badge { border-width: 1px; border-style: solid; font-weight: 600; letter-spacing: 0.3px; }
</style>
@endsection