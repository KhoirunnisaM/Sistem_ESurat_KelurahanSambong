@extends('layouts.app')

@section('content')
<style>
    /* Styling khusus untuk daftar notifikasi */
    .notif-container {
        max-width: 900px;
        margin: 0 auto;
    }
    .notif-item {
        background: #ffffff;
        border: 1px solid #eef0f2;
        border-radius: 16px;
        transition: all 0.2s ease-in-out;
        text-decoration: none !important;
        display: block;
        margin-bottom: 12px;
        padding: 20px;
    }
    .notif-item:hover {
        background: #f8fafc;
        border-color: #16a34a; /* Warna hijau aksen */
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .notif-icon {
        width: 48px;
        height: 48px;
        background: #f0fdf4;
        color: #166534;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        flex-shrink: 0;
    }
    .notif-dot {
        width: 8px;
        height: 8px;
        background: #16a34a;
        border-radius: 50%;
        display: inline-block;
        margin-right: 8px;
    }
    .notif-date {
        font-size: 12px;
        color: #9ca3af;
    }
</style>

<div class="container py-4">
    <div class="notif-container">
        <div class="mb-4">
            <h3 class="fw-bold text-dark mb-1">Pusat Informasi</h3>
            <p class="text-muted small">Daftar pengumuman dan berita terbaru untuk warga Kelurahan Sambong.</p>
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
                            <h6 class="fw-bold text-dark mb-0 text-truncate pe-3">{{ $p->judul }}</h6>
                            <span class="notif-date text-nowrap">{{ $p->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-muted small mb-0 text-truncate">
                            {{ Str::limit(strip_tags($p->konten), 120) }}
                        </p>
                    </div>

                    <div class="ms-3 text-muted opacity-50">
                        <i class="bi bi-chevron-right"></i>
                    </div>
                </div>
            </a>
            @empty
            <div class="text-center py-5">
                <div class="mb-3">
                    <i class="bi bi-inbox text-muted opacity-25" style="font-size: 4rem;"></i>
                </div>
                <p class="text-muted">Tidak ada pengumuman baru saat ini.</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection