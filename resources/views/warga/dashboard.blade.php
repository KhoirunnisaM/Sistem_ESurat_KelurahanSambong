@extends('layouts.app')

@section('content')
<div class="container-fluid px-3 px-md-4 py-4">
    {{-- Header Section --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1 text-dark responsive-title">Halo, {{ session('nama_lengkap') }}!</h4>
        <p class="text-muted small responsive-sub">
            NIK: {{ session('nik') }} | Kelurahan Sambong, RT {{ session('rt') }}/RW {{ session('rw') }}
        </p>
    </div>

    {{-- Statistik Cards --}}
    <div class="row g-2 g-md-3 mb-4">
        @foreach([
            ['label' => 'Diajukan', 'val' => $stats['diajukan'], 'color' => 'warning', 'icon' => 'bi-bell-fill', 'id' => 'stat-diajukan'],
            ['label' => 'Diproses', 'val' => $stats['diproses'], 'color' => 'primary', 'icon' => 'bi-gear-fill', 'id' => 'stat-diproses'],
            ['label' => 'Ditolak', 'val' => $stats['ditolak'], 'color' => 'danger', 'icon' => 'bi-x-circle-fill', 'id' => 'stat-ditolak'],
            ['label' => 'Selesai', 'val' => $stats['selesai'], 'color' => 'success', 'icon' => 'bi-check-circle-fill', 'id' => 'stat-selesai']
        ] as $stat)
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm p-2 p-md-3 h-100 card-stat">
                <div class="d-flex justify-content-between align-items-start">
                    <div class="text-truncate">
                        <small class="text-muted fw-medium d-block mb-1 stat-label">{{ $stat['label'] }}</small>
                        <h3 class="fw-bold mb-0 stat-value" id="{{ $stat['id'] }}">{{ $stat['val'] }}</h3>
                    </div>
                    <div class="icon-box bg-{{ $stat['color'] }} bg-opacity-10 text-{{ $stat['color'] }} rounded responsive-icon">
                        <i class="bi {{ $stat['icon'] }}"></i>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Main Section: Pengajuan & Pengumuman Sejajar --}}
    <div class="row g-4 d-flex align-items-stretch">
        {{-- List Pengajuan Terbaru --}}
        <div class="col-12 col-lg-8 d-flex flex-column">
            <div class="mb-3">
                <a href="{{ route('warga.ajukan') }}" class="btn btn-success fw-bold shadow-sm border-0 responsive-btn" style="background-color: #1e4d3a;">
                    <i class="bi bi-plus-lg me-1"></i> AJUKAN SURAT SEKARANG
                </a>
            </div>

            <div class="card border-0 shadow-sm overflow-hidden flex-grow-1">
                <div class="card-header bg-white py-3 px-4 border-bottom d-flex justify-content-between align-items-center">
                    <h6 class="fw-bold mb-0 responsive-h6">Pengajuan Terbaru</h6>
                    <a href="{{ route('warga.riwayat') }}" class="text-success text-decoration-none small fw-bold responsive-link">Lihat Semua</a>
                </div>
                <div id="container-terbaru" class="w-100 flex-grow-1">
                    @include('warga.partials.list_terbaru')
                </div>
            </div>
        </div>

        {{-- Sidebar: Pengumuman (Sejajar dengan Pengajuan) --}}
        <div class="col-12 col-lg-4 d-flex flex-column">
            {{-- Spacer agar header Pengumuman sejajar dengan header Pengajuan (karena Pengajuan ada tombol di atasnya) --}}
            <div class="d-none d-lg-block" style="margin-bottom: 3.4rem;"></div>
            
            <div class="card border-0 shadow-sm flex-grow-1">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <h6 class="fw-bold mb-0 responsive-h6">Pengumuman</h6>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
    @forelse($pengumuman as $info)
    {{-- Mengarahkan langsung ke route show dengan parameter ID --}}
    <a href="{{ route('warga.pengumuman.show', $info->id) }}" 
       class="list-group-item px-4 py-3 border-0 border-bottom list-group-item-action text-start d-block text-decoration-none">
        
        <small class="text-success fw-bold d-block mb-1 responsive-date">
            {{ $info->created_at->format('d M Y') }}
        </small>
        
        <h6 class="fw-bold small mb-1 text-dark responsive-h6">{{ $info->judul }}</h6>
        
        <p class="text-muted small mb-0 text-truncate responsive-text">
            {{ Str::limit($info->isi, 60) }}
        </p>
    </a>
    @empty
    <div class="p-4 text-center">
        <p class="text-muted small mb-0">Tidak ada pengumuman.</p>
    </div>
    @endforelse
</div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* ─── KESELURUHAN & TRANSISI ─── */
    .container-fluid, .card, .row { transition: all 0.3s ease; }

    /* ─── PENGATURAN TINGGI SEJAJAR ─── */
    @media (min-width: 992px) {
        .d-flex.align-items-stretch { display: flex !important; }
        .flex-grow-1 { flex-grow: 1; }
    }

    /* ─── RESPONSIVE TYPOGRAPHY (Ukuran Otomatis) ─── */
    .responsive-title { font-size: clamp(1.1rem, 2.5vw, 1.5rem); }
    .responsive-sub { font-size: clamp(0.75rem, 1.5vw, 0.875rem); }
    .stat-label { font-size: clamp(0.7rem, 1.2vw, 0.85rem); }
    .stat-value { font-size: clamp(1.1rem, 2vw, 1.75rem); }
    .responsive-h6 { font-size: clamp(0.85rem, 1.5vw, 1rem); }
    .responsive-text { font-size: clamp(0.75rem, 1.2vw, 0.85rem); }
    .responsive-date { font-size: 0.7rem; }

    /* ─── RESPONSIVE BUTTONS & ICONS ─── */
    .responsive-btn {
        padding: clamp(0.4rem, 1vw, 0.6rem) clamp(0.75rem, 2vw, 1.5rem);
        font-size: clamp(0.7rem, 1.2vw, 0.9rem);
    }

    .responsive-icon {
        padding: clamp(4px, 1vw, 8px) clamp(8px, 1.5vw, 12px);
        font-size: clamp(0.9rem, 1.5vw, 1.2rem);
    }

    /* ─── HOVER EFFECTS ─── */
    .card-stat:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.05) !important;
    }

    .btn-success:active { transform: scale(0.98); }

    /* ─── MOBILE OPTIMIZATION ─── */
    @media (max-width: 576px) {
        .container-fluid { padding-left: 0.75rem !important; padding-right: 0.75rem !important; }
        .px-4 { padding-left: 1rem !important; padding-right: 1rem !important; }
        .mb-3 { margin-bottom: 0.75rem !important; }
    }
</style>

<script>
    function updateStats() {
        fetch("{{ route('warga.stats.realtime') }}")
            .then(response => response.json())
            .then(data => {
                const fields = ['diajukan', 'diproses', 'selesai', 'ditolak'];
                fields.forEach(f => {
                    const el = document.getElementById(`stat-${f}`);
                    if(el) el.innerText = data.stats[f];
                });
                
                if(data.html) {
                    document.getElementById('container-terbaru').innerHTML = data.html;
                }
            })
            .catch(error => console.error('Error updating stats:', error));
    }
    setInterval(updateStats, 1000);
</script>
@endsection