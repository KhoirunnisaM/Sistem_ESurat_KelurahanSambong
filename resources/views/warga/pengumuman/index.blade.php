@extends('layouts.app')

@section('content')
<style>
    .notif-container {
        max-width: 900px;
        margin: 0 auto;
    }
    .notif-item {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: clamp(12px, 2vw, 16px);
        transition: all 0.2s ease-in-out;
        text-decoration: none !important;
        display: block;
        margin-bottom: 12px;
        padding: clamp(15px, 3vw, 20px);
    }
    .notif-item:hover {
        background: #f8fafc;
        border-color: #1e4d3a;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(30, 77, 58, 0.08);
    }
    .notif-icon {
        width: clamp(40px, 5vw, 48px);
        height: clamp(40px, 5vw, 48px);
        background: #e8f0ed;
        color: #1e4d3a;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: clamp(16px, 2vw, 20px);
        flex-shrink: 0;
    }
    .notif-date {
        font-size: clamp(0.7rem, 1vw, 0.75rem);
        color: #94a3b8;
    }
    .notif-title {
        font-size: clamp(0.85rem, 1.2vw, 1rem);
        line-height: 1.4;
    }
    .notif-preview {
        font-size: clamp(0.75rem, 1vw, 0.85rem);
        color: #64748b;
    }

    @media (max-width: 576px) {
        .notif-item { padding: 15px; }
        .chevron-hide { display: none; }
    }
</style>

<div class="container py-2 py-md-4">
    <div class="notif-container">
        <div class="mb-4 px-1">
            <h3 class="fw-bold text-dark mb-1" style="font-size: clamp(1.25rem, 2.5vw, 1.75rem);">Pusat Informasi</h3>
            <p class="text-muted small mb-0">Daftar pengumuman dan berita terbaru untuk warga Kelurahan Sambong.</p>
        </div>

        <div class="notif-list">
            @forelse($pengumuman as $p)
            <a href="{{ route('warga.pengumuman.show', $p->id) }}" class="notif-item">
                <div class="d-flex align-items-center">
                    <div class="notif-icon me-3">
                        @if($p->lampiran && in_array(pathinfo($p->lampiran, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png']))
                            <img src="{{ asset('storage/'.$p->lampiran) }}" style="width: 100%; height: 100%; border-radius: 10px; object-fit: cover;">
                        @else
                            <i class="bi bi-megaphone-fill"></i>
                        @endif
                    </div>

                    <div class="flex-grow-1 overflow-hidden">
                        <div class="d-flex justify-content-between align-items-start mb-1">
                            <h6 class="fw-bold text-dark mb-0 text-truncate pe-2 notif-title">{{ $p->judul }}</h6>
                            <span class="notif-date text-nowrap ms-2">{{ $p->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="notif-preview mb-0 text-truncate">
                            {{ Str::limit(strip_tags($p->konten), 100) }}
                        </p>
                    </div>

                    <div class="ms-3 text-muted opacity-50 chevron-hide">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>
            </a>
            @empty
            <div class="text-center py-5">
                <i class="bi bi-inbox text-muted opacity-25 d-block mb-3" style="font-size: 4rem;"></i>
                <p class="text-muted small">Tidak ada pengumuman baru saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection