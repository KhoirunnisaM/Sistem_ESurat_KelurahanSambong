@extends('layouts.app')

@section('content')
<style>
    .notif-wrapper { max-width: 800px; margin: 0 auto; }
    .notif-card { 
        background: #fff; border: 1px solid #eef0f2; border-radius: 16px; 
        overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.04); 
    }
    .notif-header { padding: 25px; border-bottom: 1px solid #f8f9fa; background: #fafbfc; }
    .notif-avatar { 
        width: 48px; height: 48px; background: #0a2e1a; color: #fff; 
        border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 20px;
    }
    .notif-tag { 
        font-size: 11px; font-weight: 700; text-transform: uppercase; 
        color: #166534; background: #dcfce7; padding: 4px 12px; border-radius: 50px; 
        display: inline-block; margin-bottom: 10px;
    }
    .notif-body { padding: 25px; min-height: 150px; }
    .notif-text { color: #374151; line-height: 1.8; font-size: 16px; }
    .notif-footer { padding: 20px 25px; background: #f8f9fa; border-top: 1px solid #f1f3f5; }
    
    /* Box Lampiran Modern */
    .attachment-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 15px;
        display: flex;
        align-items: center;
        gap: 15px;
        transition: all 0.2s;
    }
    .attachment-card:hover {
        border-color: #16a34a;
        box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    .file-icon {
        width: 45px; height: 45px; background: #f8fafc; color: #64748b;
        border-radius: 10px; display: flex; align-items: center; justify-content: center; font-size: 22px;
    }
    .btn-action-group { display: flex; gap: 8px; }
    .btn-action {
        padding: 8px 16px; border-radius: 8px; font-size: 13px; font-weight: 600;
        text-decoration: none; transition: 0.2s; display: flex; align-items: center; gap: 6px;
    }
    .btn-view { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
    .btn-view:hover { background: #e2e8f0; color: #1e293b; }
    .btn-down { background: #16a34a; color: #fff; border: 1px solid #16a34a; }
    .btn-down:hover { background: #15803d; color: #fff; }
</style>

<div class="container py-4">
    <div class="notif-wrapper">
        <div class="mb-4">
            <a href="{{ route('warga.pengumuman.index') }}" class="text-muted text-decoration-none small d-inline-flex align-items-center">
                <i class="bi bi-arrow-left me-2"></i> Kembali ke daftar pengumuman
            </a>
        </div>

        <div class="notif-card">
            <div class="notif-header d-flex gap-3">
                <div class="notif-avatar shadow-sm">
                    <i class="bi bi-megaphone-fill"></i>
                </div>
                <div>
                    <span class="notif-tag">Informasi Warga</span>
                    <h4 class="fw-bold text-dark mb-1">{{ $pengumuman->judul }}</h4>
                    <p class="text-muted small mb-0">
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
                <p class="small fw-bold text-muted mb-3 text-uppercase" style="letter-spacing: 0.5px;">Lampiran Dokumen</p>
                
                @php
                    $extension = pathinfo($pengumuman->lampiran, PATHINFO_EXTENSION);
                    $ext = strtolower($extension);
                @endphp

                <div class="attachment-card">
                    <div class="file-icon">
                        @if(in_array($ext, ['jpg', 'jpeg', 'png', 'webp']))
                            <i class="bi bi-image"></i>
                        @elseif($ext == 'pdf')
                            <i class="bi bi-file-earmark-pdf"></i>
                        @elseif(in_array($ext, ['doc', 'docx']))
                            <i class="bi bi-file-earmark-word"></i>
                        @else
                            <i class="bi bi-file-earmark-text"></i>
                        @endif
                    </div>
                    
                    <div class="flex-grow-1 overflow-hidden">
                        <div class="text-dark fw-bold small text-truncate">{{ basename($pengumuman->lampiran) }}</div>
                        <div class="text-muted mt-1" style="font-size: 11px;">Berkas {{ strtoupper($ext) }}</div>
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
            <small class="text-muted">Gunakan tombol <strong>Buka</strong> untuk melihat pratinjau dokumen atau gambar.</small>
        </div>
    </div>
</div>
@endsection