@extends('layouts.admin')

@section('admin_content')

<div id="realtime-container" class="container-fluid px-2 px-md-3">
    {{-- 1. TAMPILAN RINGKASAN AKTIVITAS --}}
    @if(!request('filter'))
    <div class="mb-4">
        <h4 class="fw-bold text-dark responsive-title">Ringkasan Aktivitas</h4>
        <p class="text-muted small responsive-sub">Pemantauan real-time pengajuan surat Kelurahan Sambong.</p>
    </div>

    <div class="row g-2 g-md-3 mb-4">
        <div class="col-6 col-md-3">
            <div class="card card-custom stat-card bg-white h-100 p-2 p-md-3 shadow-sm border-0">
                <div class="d-flex align-items-center justify-content-between mb-1 mb-md-2">
                    <div class="text-muted mb-0 stat-label">Surat Diajukan</div>
                    <div class="icon-shape bg-light-warning text-warning rounded-pill px-2 py-1 responsive-icon-box">
                        <i class="bi bi-bell-fill"></i>
                    </div>
                </div>
                <div class="fw-bold text-dark mb-0 stat-value">{{ $stats['diajukan'] ?? 0 }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-custom stat-card bg-white h-100 p-2 p-md-3 shadow-sm border-0">
                <div class="d-flex align-items-center justify-content-between mb-1 mb-md-2">
                    <div class="text-muted mb-0 stat-label">Sedang Diproses</div>
                    <div class="icon-shape bg-light-primary text-primary rounded-pill px-2 py-1 responsive-icon-box">
                        <i class="bi bi-gear-fill"></i>
                    </div>
                </div>
                <div class="fw-bold text-dark mb-0 stat-value">{{ $stats['diproses'] ?? 0 }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-custom stat-card bg-white h-100 p-2 p-md-3 shadow-sm border-0">
                <div class="d-flex align-items-center justify-content-between mb-1 mb-md-2">
                    <div class="text-muted mb-0 stat-label">Ditolak/Batal</div>
                    <div class="icon-shape bg-light-danger text-danger rounded-pill px-2 py-1 responsive-icon-box">
                        <i class="bi bi-x-circle-fill"></i>
                    </div>
                </div>
                <div class="fw-bold text-dark mb-0 stat-value">{{ ($stats['ditolak'] ?? 0) + ($stats['dibatalkan'] ?? 0) }}</div>
            </div>
        </div>
        <div class="col-6 col-md-3">
            <div class="card card-custom stat-card bg-white h-100 p-2 p-md-3 shadow-sm border-0">
                <div class="d-flex align-items-center justify-content-between mb-1 mb-md-2">
                    <div class="text-muted mb-0 stat-label">Surat Selesai</div>
                    <div class="icon-shape bg-light-success text-success rounded-pill px-2 py-1 responsive-icon-box">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                </div>
                <div class="fw-bold text-dark mb-0 stat-value">{{ $stats['selesai'] ?? 0 }}</div>
            </div>
        </div>
    </div>
    @endif

    {{-- 2. BAGIAN TABEL DATA --}}
    <div class="card card-custom bg-white border-0 shadow-sm overflow-hidden">
        <div class="card-body p-3 p-md-4">
            <div class="d-flex flex-column d-md-flex flex-md-row justify-content-between align-items-md-center mb-4">
                <div>
                    <h5 class="fw-bold mb-1 responsive-h6">
                        @if(request('filter') == 'masuk') Daftar Surat Masuk 
                        @elseif(request('filter') == 'riwayat') Daftar Riwayat Surat 
                        @else Surat Masuk Hari Ini
                        @endif
                    </h5>
                    <p class="text-muted small mb-0 responsive-text">
                        @if(!request('filter') && !request('search'))
                            Menampilkan permohonan khusus hari ini.
                        @else
                            Urutan berdasarkan waktu terbaru.
                        @endif
                    </p>
                </div>
                
                <div class="mt-3 mt-md-0">
                    <form action="{{ url()->current() }}" method="GET" class="d-flex gap-2">
                        <input type="text" name="search" class="form-control form-control-sm border-0 bg-light px-3 rounded-pill flex-grow-1" 
                               placeholder="Cari..." value="{{ request('search') }}" style="min-width: 150px;">
                        
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
            <div class="d-flex flex-nowrap overflow-auto gap-2 mb-4 pb-2" style="scrollbar-width: none; -ms-overflow-style: none;">
                <a href="{{ request()->fullUrlWithQuery(['status' => null]) }}" 
                   class="btn btn-sm rounded-pill px-3 flex-shrink-0 {{ !request('status') ? 'btn-dark' : 'btn-outline-dark' }}">
                   Semua
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'Diajukan']) }}" 
                   class="btn btn-sm rounded-pill px-3 flex-shrink-0 {{ request('status') == 'Diajukan' ? 'btn-warning text-white' : 'btn-outline-warning' }}">
                   Diajukan
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'Diproses']) }}" 
                   class="btn btn-sm rounded-pill px-3 flex-shrink-0 {{ request('status') == 'Diproses' ? 'btn-primary' : 'btn-outline-primary' }}">
                   Diproses
                </a>
                 <a href="{{ request()->fullUrlWithQuery(['status' => 'Selesai']) }}" 
                   class="btn btn-sm rounded-pill px-3 flex-shrink-0 {{ request('status') == 'Selesai' ? 'btn-success' : 'btn-outline-success' }}">
                   Selesai
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'Ditolak']) }}" 
                   class="btn btn-sm rounded-pill px-3 flex-shrink-0 {{ request('status') == 'Ditolak' ? 'btn-danger' : 'btn-outline-danger' }}">
                   Ditolak
                </a>
                <a href="{{ request()->fullUrlWithQuery(['status' => 'Dibatalkan']) }}" 
       class="btn btn-sm rounded-pill px-3 flex-shrink-0 {{ request('status') == 'Dibatalkan' ? 'btn-secondary' : 'btn-outline-secondary' }}">
       Dibatalkan
    </a>
               
            </div>

            <div class="table-responsive">
                <table class="table table-hover table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-muted small text-uppercase" style="font-size: 0.65rem;">
                            <th class="ps-3">No</th>
                            <th>Pemohon</th>
                            <th >Layanan</th>
                            <th>Waktu</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($surat_terbaru as $index => $s)
                        <tr style="font-size: 0.85rem;">
                            <td class="ps-3 fw-medium text-muted">
                                {{ method_exists($surat_terbaru, 'firstItem') ? $surat_terbaru->firstItem() + $index : $index + 1 }}
                            </td>
                            <td>
                                <div class="fw-bold text-dark text-truncate" style="max-width: 200px;">{{ $s->warga->nama_lengkap ?? 'User' }}</div>
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
                                <div class="text-dark fw-medium" style="font-size: 0.75rem;">{{ $s->created_at->format('d/m/Y') }}</div>
                                <small class="text-muted" style="font-size: 0.65rem;">{{ $s->created_at->format('H:i')}} WIB</small>
                            </td>
                            <td>
                                @php
                                    $statusColor = ['Diajukan'=>'text-warning','Diproses'=>'text-primary','Ditolak'=>'text-danger','Selesai'=>'text-success','Dibatalkan'=>'text-secondary'];
                                    $currentColor = $statusColor[$s->status] ?? 'text-muted';
                                @endphp
                                <span class="{{ $currentColor }} fw-bold" style="font-size: 0.65rem;">{{ strtoupper($s->status) }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('admin.surat.show', $s->id) }}?from=dashboard" class="btn btn-sm btn-outline-dark rounded-pill px-2 py-0" style="font-size: 0.7rem;">
                                    Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted small">Tidak ada data.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-4 d-flex justify-content-center">
                @if(!request('filter') && !request('search') && !request('status'))
                    @if(method_exists($surat_terbaru, 'hasMorePages') && $surat_terbaru->hasMorePages())
                        <a href="{{ route('admin.surat.hari-ini', ['filter' => 'masuk']) }}" class="btn btn-sm btn-outline-success rounded-pill px-4 responsive-text">
                            Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    @endif
                @else
                    @if(method_exists($surat_terbaru, 'links'))
                        {{ $surat_terbaru->appends(request()->query())->links() }}
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>

<script>
    function refreshDashboard() {
        const currentUrl = window.location.href;
        fetch(currentUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newContent = doc.getElementById('realtime-container').innerHTML;
            document.getElementById('realtime-container').innerHTML = newContent;
        })
        .catch(error => console.warn('Update gagal:', error));
    }
    setInterval(refreshDashboard, 5000);
</script>

@endsection

@section('styles')
<style>
    /* ─── KESELURUHAN & TRANSISI ─── */
    .container-fluid, .card, .row { transition: all 0.3s ease; }

    /* ─── RESPONSIVE TYPOGRAPHY (Ukuran Otomatis) ─── */
    .responsive-title { font-size: clamp(1.1rem, 2.5vw, 1.4rem); }
    .responsive-sub { font-size: clamp(0.7rem, 1.5vw, 0.85rem); }
    .stat-label { font-size: clamp(0.65rem, 1.2vw, 0.8rem); font-weight: 500; }
    .stat-value { font-size: clamp(1.2rem, 2.2vw, 1.6rem); }
    .responsive-h6 { font-size: clamp(0.85rem, 1.8vw, 1rem); }
    .responsive-text { font-size: clamp(0.7rem, 1.2vw, 0.8rem); }

    .responsive-icon-box {
        font-size: clamp(0.8rem, 1.5vw, 1rem);
        padding: 2px 8px !important;
    }

    /* ─── STYLING KHAS ─── */
    .bg-light-warning { background-color: #fff8e1 !important; border: 1px solid #ffc107; }
    .bg-light-primary { background-color: #e3f2fd !important; border: 1px solid #0d6efd; }
    .bg-light-danger { background-color: #ffebee !important; border: 1px solid #dc3545; }
    .bg-light-success { background-color: #e8f5e9 !important; border: 1px solid #198754; }
    
    .stat-card { border-radius: 12px; transition: transform 0.2s; }
    .stat-card:hover { transform: translateY(-3px); }

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
    }
</style>
@endsection