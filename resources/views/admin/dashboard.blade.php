@extends('layouts.admin')

@section('admin_content')

<div id="realtime-container">
    {{-- 1. TAMPILAN RINGKASAN AKTIVITAS --}}
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
                    <div class="h6 text-muted mb-0 small">Ditolak/Dibatalkan</div>
                    <div class="icon-shape bg-light-danger text-danger rounded-pill px-2 py-1 small">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                </div>
                <div class="h2 fw-bold text-dark mb-0">{{ ($stats['ditolak'] ?? 0) + ($stats['dibatalkan'] ?? 0) }}</div>
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

    {{-- 2. BAGIAN TABEL DATA --}}
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
                            Urutan berdasarkan waktu pengajuan terbaru.
                        @endif
                    </p>
                </div>
                
                <div class="mt-3 mt-md-0 d-flex gap-2">
                    <form action="{{ url()->current() }}" method="GET" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control form-control-sm border-0 bg-light px-3 rounded-pill" 
                               placeholder="Cari NIK, Nama, Jenis..." value="{{ request('search') }}">
                        
                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3">
                            <i class="bi bi-search"></i>
                        </button>

                        @if(request('search') || request('status'))
                            <a href="{{ url()->current() }}" class="btn btn-sm btn-outline-secondary rounded-pill">Reset</a>
                        @endif
                    </form>
                </div>
            </div>

            {{-- FILTER KAPSUL STATUS --}}
            <div class="d-flex flex-wrap gap-2 mb-4">
                <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" 
                   class="btn btn-sm rounded-pill px-3 {{ !request('status') ? 'btn-dark' : 'btn-outline-dark' }}">
                   Semua
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'Diajukan']) }}" 
                   class="btn btn-sm rounded-pill px-3 {{ request('status') == 'Diajukan' ? 'btn-warning text-white' : 'btn-outline-warning' }}">
                   Diajukan
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'Diproses']) }}" 
                   class="btn btn-sm rounded-pill px-3 {{ request('status') == 'Diproses' ? 'btn-primary' : 'btn-outline-primary' }}">
                   Diproses
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'Ditolak']) }}" 
                   class="btn btn-sm rounded-pill px-3 {{ request('status') == 'Ditolak' ? 'btn-danger' : 'btn-outline-danger' }}">
                   Ditolak
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'Dibatalkan']) }}" 
                   class="btn btn-sm rounded-pill px-3 {{ request('status') == 'Dibatalkan' ? 'btn-secondary' : 'btn-outline-secondary' }}">
                   Dibatalkan
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'Selesai']) }}" 
                   class="btn btn-sm rounded-pill px-3 {{ request('status') == 'Selesai' ? 'btn-success' : 'btn-outline-success' }}">
                   Selesai
                </a>
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
                                <div class="fw-medium text-dark text-uppercase small">{{ $s->jenisSurat->nama_jenis }}</div>
                                
                                @if(($s->status == 'Selesai' || $s->status == 'Diproses') && $s->nomor_surat)
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
                                    $statusColor = [
                                        'Diajukan'   => 'text-warning',
                                        'Diproses'   => 'text-primary',
                                        'Ditolak'    => 'text-danger',
                                        'Selesai'    => 'text-success',
                                        'Dibatalkan' => 'text-secondary'
                                    ];
                                    $currentColor = $statusColor[$s->status] ?? 'text-muted';
                                @endphp
                                
                                <span class="{{ $currentColor }} fw-bold px-2 py-1" style="font-size: 0.65rem; ">
                                    {{ strtoupper($s->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.surat.show', $s->id) }}?from=dashboard" class="btn btn-sm btn-outline-dark px-3 rounded-pill">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted small">Tidak ada permohonan surat dengan kriteria tersebut.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 text-center">
                @if(!request('filter') && !request('search') && !request('status'))
                    @if(method_exists($surat_terbaru, 'hasMorePages') && $surat_terbaru->hasMorePages())
                        <a href="{{ route('admin.surat.hari-ini', ['filter' => 'masuk']) }}" class="btn btn-sm btn-outline-success rounded-pill px-4">
                            Lihat Selengkapnya <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    @endif
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
</div>

<script>
    // Fungsi untuk memuat data tanpa refresh
    function refreshDashboard() {
        // Ambil URL saat ini (termasuk query string search/status agar filter tidak hilang)
        const currentUrl = window.location.href;

        fetch(currentUrl, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest' // Tandai sebagai permintaan AJAX
            }
        })
        .then(response => response.text())
        .then(html => {
            // Buat elemen sementara untuk memparsing HTML yang baru
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContent = doc.getElementById('realtime-container').innerHTML;
            
            // Update isi kontainer dengan data yang baru
            document.getElementById('realtime-container').innerHTML = newContent;
        })
        .catch(error => console.warn('Realtime update gagal:', error));
    }

    // Jalankan setiap 5 detik
    setInterval(refreshDashboard, 1000);
</script>

@endsection

@section('styles')
<style>
    .bg-light-warning { background-color: #fff8e1 !important; border: 1px solid #ffc107; }
    .bg-light-primary { background-color: #e3f2fd !important; border: 1px solid #0d6efd; }
    .bg-light-danger { background-color: #ffebee !important; border: 1px solid #dc3545; }
    .bg-light-success { background-color: #e8f5e9 !important; border: 1px solid #198754; }
    .bg-light-secondary { background-color: #f8f9fa !important; border: 1px solid #6c757d; }
    
    .stat-card { border-radius: 12px; }
    .table-custom thead th { padding: 15px 10px; background-color: #f8f9fa; }
    .badge { border-width: 1px; border-style: solid; font-weight: 600; letter-spacing: 0.3px; }
    .fst-italic { font-style: italic; }
</style>
@endsection