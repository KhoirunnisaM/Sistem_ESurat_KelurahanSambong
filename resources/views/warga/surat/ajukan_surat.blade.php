@extends('layouts.app')

@section('content')
<style>
    /* Container utama yang fleksibel */
    .surat-container {
        max-width: 1100px;
        margin: 0 auto;
        padding: 0 clamp(5px, 2vw, 15px);
    }

    /* Header Styling */
    .header-title {
        font-size: clamp(1.25rem, 2.5vw, 1.75rem);
        color: #1e293b;
    }
    .header-subtitle {
        font-size: clamp(0.75rem, 1vw, 0.85rem);
        color: #64748b;
    }

    /* Card Styling yang konsisten dengan Pengumuman */
    .card-surat {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: clamp(12px, 2vw, 18px);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
        display: flex;
        flex-direction: column;
    }
    .card-surat:hover {
        transform: translateY(-5px);
        border-color: #1e4d3a;
        box-shadow: 0 12px 25px rgba(30, 77, 58, 0.08);
    }

    /* Icon Box */
    .icon-box {
        width: clamp(45px, 5vw, 54px);
        height: clamp(45px, 5vw, 54px);
        background: #e8f0ed;
        color: #1e4d3a;
        border-radius: clamp(10px, 1.5vw, 14px);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: clamp(1.25rem, 2vw, 1.6rem);
        flex-shrink: 0;
    }

    /* Typography di dalam Card */
    .surat-title {
        font-size: clamp(0.95rem, 1.2vw, 1.1rem);
        color: #1e293b;
        margin-bottom: 4px;
    }
    .surat-desc {
        font-size: clamp(0.8rem, 1vw, 0.875rem);
        color: #64748b;
        line-height: 1.6;
        min-height: 3em; /* Menjaga konsistensi tinggi baris */
    }

    /* Tombol yang konsisten */
    .btn-pilih {
        background: transparent;
        color: #1e4d3a;
        border: 1.5px solid #1e4d3a;
        border-radius: 50px;
        font-size: clamp(0.8rem, 1vw, 0.9rem);
        font-weight: 700;
        padding: clamp(8px, 1.2vh, 10px) 20px;
        transition: all 0.2s;
        text-align: center;
        text-decoration: none;
        display: block;
        margin-top: auto; /* Mendorong tombol ke bawah card */
    }
    .btn-pilih:hover {
        background: #1e4d3a;
        color: #ffffff !important;
    }

    .btn-kembali {
        font-size: clamp(0.75rem, 1vw, 0.85rem);
        border-radius: 50px;
        padding: clamp(6px, 1vh, 10px) clamp(15px, 2vw, 25px);
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #64748b;
        font-weight: 600;
    }
    .btn-kembali:hover {
        background: #f8fafc;
        color: #1e4d3a;
    }

    @media (max-width: 576px) {
        .header-section { flex-direction: column; align-items: flex-start !important; gap: 15px; }
        .btn-kembali { width: 100%; text-align: center; }
    }
</style>

<div class="surat-container py-2 py-md-4">
    <div class="header-section d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold header-title mb-1">Pilih Jenis Surat</h4>
            <p class="header-subtitle mb-0">Silakan pilih jenis surat yang ingin Anda ajukan sesuai keperluan.</p>
        </div>
        <a href="{{ route('warga.dashboard') }}" class="btn btn-kembali shadow-sm d-inline-flex align-items-center">
            <i class="bi bi-arrow-left me-2"></i> Kembali
        </a>
    </div>

    <div class="row g-3 g-md-4">
        @php
            $daftar_surat = [
                ['icon' => 'bi-file-earmark-person', 'title' => 'Pengantar SKCK', 'slug' => 'skck', 'desc' => 'Untuk keperluan melamar pekerjaan atau pendaftaran institusi.'],
                ['icon' => 'bi-envelope', 'title' => 'Pengantar Umum', 'slug' => 'pengantar-umum', 'desc' => 'Surat pengantar standar untuk berbagai keperluan administrasi umum.'],
                ['icon' => 'bi-envelope-paper', 'title' => 'Keterangan Umum', 'slug' => 'keterangan-umum', 'desc' => 'Surat keterangan resmi dari Kelurahan untuk warga setempat.'],
                ['icon' => 'bi-shop', 'title' => 'Keterangan Usaha', 'slug' => 'keterangan-usaha', 'desc' => 'Diperlukan untuk pengajuan izin atau permohonan bantuan usaha.'],
                ['icon' => 'bi-wallet2', 'title' => 'Tidak Mampu (SKTM)', 'slug' => 'keterangan-tidak-mampu', 'desc' => 'Untuk persyaratan keringanan biaya pendidikan atau kesehatan.'],
                ['icon' => 'bi-building-up', 'title' => 'Domisili Usaha', 'slug' => 'domisili-usaha', 'desc' => 'Keterangan mengenai lokasi atau tempat kedudukan operasional usaha.'],
                ['icon' => 'bi-house-heart', 'title' => 'Domisili Tinggal', 'slug' => 'domisili-tempat-tinggal', 'desc' => 'Keterangan tempat tinggal atau mukim saat ini di wilayah Kelurahan.'],
            ];
        @endphp
        
        @foreach($daftar_surat as $item)
        <div class="col-sm-12 col-md-6 col-lg-4">
            <div class="card-surat">
                <div class="card-body p-4 d-flex flex-column h-100">
                    <div class="d-flex align-items-center mb-3">
                        <div class="icon-box me-3">
                            <i class="bi {{ $item['icon'] }}"></i>
                        </div>
                        <div class="overflow-hidden">
                            <h6 class="fw-bold surat-title mb-0 text-truncate">{{ $item['title'] }}</h6>
                            <span class="text-muted" style="font-size: clamp(0.65rem, 0.8vw, 0.75rem);">
                                <i class="bi bi-lightning-charge-fill text-warning me-1"></i>Estimasi 1-2 Hari
                            </span>
                        </div>
                    </div>
                    
                    <p class="surat-desc mb-4">
                        {{ $item['desc'] }}
                    </p>
                    
                    <a href="{{ route('surat.buat', $item['slug']) }}" class="btn-pilih">
                        Pilih Jenis Surat
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection