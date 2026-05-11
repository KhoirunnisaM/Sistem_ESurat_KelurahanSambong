@extends('layouts.app')

@section('content')
<style>
    /* Card & Wrapper */
    .notif-wrapper { 
        max-width: 850px; 
        margin: 0 auto; 
        padding: 0 clamp(5px, 2vw, 15px); /* Padding samping dinamis */
    }
    .notif-card { 
        background: #fff; 
        border: 1px solid #e2e8f0; 
        /* Radius card menyesuaikan layar */
        border-radius: clamp(12px, 2.5vw, 24px); 
        overflow: hidden; 
        box-shadow: 0 10px 30px rgba(30, 77, 58, 0.03); 
    }

    /* Header Section */
    .notif-header { 
        padding: clamp(15px, 4vw, 30px); 
        border-bottom: 1px solid #f1f5f9; 
        background: #fafbfc; 
    }
    .notif-avatar { 
        /* Ukuran ikon utama yang fleksibel */
        width: clamp(40px, 6vw, 54px); 
        height: clamp(40px, 6vw, 54px); 
        background: #1e4d3a; 
        color: #fff; 
        border-radius: clamp(8px, 1.5vw, 14px); 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: clamp(16px, 2.5vw, 24px); /* Ukuran ikon di dalam avatar */
        flex-shrink: 0;
    }
    .notif-tag { 
        font-size: clamp(9px, 0.8vw, 11px); 
        font-weight: 700; 
        text-transform: uppercase; 
        color: #1e4d3a; 
        background: #e8f0ed; 
        padding: 4px clamp(8px, 1vw, 12px); 
        border-radius: 50px; 
        display: inline-block; 
        margin-bottom: 6px; 
        letter-spacing: 0.5px;
    }

    /* Body/Text Content */
    .notif-body { 
        padding: clamp(15px, 4vw, 30px); 
        min-height: 150px; 
    }
    .notif-text { 
        color: #334155; 
        line-height: 1.8; 
        /* Font isi pengumuman yang fluid */
        font-size: clamp(0.9rem, 1.1vw, 1.05rem); 
    }

    /* Footer & Attachment */
    .notif-footer { 
        padding: clamp(15px, 4vw, 25px) clamp(15px, 4vw, 30px); 
        background: #f8fafc; 
        border-top: 1px solid #f1f5f9; 
    }
    
    .attachment-card {
        background: #fff; 
        border: 1px solid #e2e8f0; 
        border-radius: 12px;
        padding: clamp(10px, 1.5vw, 15px); 
        display: flex; 
        align-items: center; 
        gap: clamp(10px, 2vw, 15px); 
        transition: all 0.2s;
    }
    
    .file-icon {
        /* Ikon lampiran mengecil di mobile */
        width: clamp(36px, 5vw, 45px); 
        height: clamp(36px, 5vw, 45px); 
        background: #f1f5f9; 
        color: #64748b;
        border-radius: 10px; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        font-size: clamp(16px, 2vw, 22px); 
        flex-shrink: 0;
    }

    /* Buttons */
    .btn-action {
        padding: clamp(6px, 1vw, 8px) clamp(10px, 1.5vw, 16px); 
        border-radius: 8px; 
        font-size: clamp(11px, 1vw, 13px); 
        font-weight: 600;
        text-decoration: none; 
        transition: 0.2s; 
        display: flex; 
        align-items: center; 
        gap: 6px;
    }
    .btn-view { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
    .btn-down { background: #1e4d3a; color: #fff; border: 1px solid #1e4d3a; }

    /* Mobile Optimization */
    @media (max-width: 576px) {
        .btn-action-group { 
            width: 100%; 
            display: grid; 
            grid-template-columns: 1fr 1fr; 
            gap: 8px; 
            margin-top: clamp(10px, 3vw, 15px); 
        }
        .attachment-card { flex-wrap: wrap; }
        .btn-action { justify-content: center; width: 100%; }
        .notif-header { flex-direction: column; gap: 12px !important; }
    }
</style>

<div class="container py-2 py-md-4">
    <div class="notif-wrapper">
        <div class="mb-3 mb-md-4">
            <a href="{{ route('warga.pengumuman.index') }}" class="text-muted text-decoration-none small d-inline-flex align-items-center fw-medium">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke daftar
            </a>
        </div>

        <div class="notif-card">
            <div class="notif-header d-flex gap-3 align-items-start">
                <div class="notif-avatar shadow-sm">
                    <i class="bi bi-megaphone-fill"></i>
                </div>
                <div>
                    <span class="notif-tag">Informasi Warga</span>
                    <h4 class="fw-bold text-dark mb-1" style="font-size: clamp(1.1rem, 2.5vw, 1.5rem);">{{ $pengumuman->judul }}</h4>
                    <p class="text-muted small mb-0" style="font-size: clamp(0.7rem, 0.9vw, 0.8rem);">
                        <i class="bi bi-calendar3 me-1"></i> {{ $pengumuman->created_at->translatedFormat('d M Y, H:i') }} WIB
                    </p>
                </div>
            </div>

            <div class="notif-body">
                <div class="notif-text">
                    {!! nl2br(e($pengumuman->konten)) !!}
                </div>
            </div>

            @if($pengumuman->lampiran)
            <div class="notif-footer">
                <p class="fw-bold text-muted mb-3 text-uppercase" style="font-size: clamp(9px, 0.8vw, 10px); letter-spacing: 1px;">Lampiran Dokumen</p>
                
                @php
                    $ext = strtolower(pathinfo($pengumuman->lampiran, PATHINFO_EXTENSION));
                @endphp

                <div class="attachment-card">
                    <div class="file-icon">
                        @if(in_array($ext, ['jpg', 'jpeg', 'png', 'webp'])) <i class="bi bi-image"></i>
                        @elseif($ext == 'pdf') <i class="bi bi-file-earmark-pdf"></i>
                        @elseif(in_array($ext, ['doc', 'docx'])) <i class="bi bi-file-earmark-word"></i>
                        @else <i class="bi bi-file-earmark-text"></i>
                        @endif
                    </div>
                    
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="text-dark fw-bold text-truncate" style="font-size: clamp(12px, 1.1vw, 14px);">{{ basename($pengumuman->lampiran) }}</div>
                        <div class="text-muted mt-0" style="font-size: clamp(10px, 0.9vw, 11px);">Berkas {{ strtoupper($ext) }}</div>
                    </div>

                    <div class="btn-action-group">
                        <a href="{{ asset('storage/'.$pengumuman->lampiran) }}" target="_blank" class="btn-action btn-view">
                            <i class="bi bi-eye"></i> Buka
                        </a>
                        <a href="{{ asset('storage/'.$pengumuman->lampiran) }}" download class="btn-action btn-down">
                            <i class="bi bi-download"></i> Simpan
                        </a>
                    </div>
                </div>
            </div>
            @endif
        </div>
        
        <div class="mt-4 text-center">
            <small class="text-muted opacity-75" style="font-size: clamp(10px, 0.9vw, 12px);">Kelurahan Sambong - Layanan Mandiri Warga</small>
        </div>
    </div>
</div>
@endsection