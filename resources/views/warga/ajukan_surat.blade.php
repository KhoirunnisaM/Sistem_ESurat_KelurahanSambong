@extends('layouts.app')

@section('content')

<div class="container py-4">
    <!-- Header dengan Tombol Kembali -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1">Pilih Jenis Surat</h4>
            <p class="text-muted small mb-0">Silakan pilih jenis surat yang ingin Anda ajukan.</p>
        </div>
        <a href="{{ route('warga.dashboard') }}" class="btn btn-white bg-white border shadow-sm rounded-pill px-4">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row g-3">
        @php
            $daftar_surat = [
                ['icon' => 'bi-file-earmark-person', 'title' => 'Pengantar SKCK', 'slug' => 'skck', 'desc' => 'Untuk keperluan melamar pekerjaan/pendaftaran.'],
                ['icon' => 'bi-envelope', 'title' => 'Pengantar Umum', 'slug' => 'pengantar-umum', 'desc' => 'Surat pengantar untuk berbagai keperluan umum.'],
                ['icon' => 'bi-envelope-paper', 'title' => 'Keterangan Umum', 'slug' => 'keterangan-umum', 'desc' => 'Surat keterangan dari kelurahan.'],
                ['icon' => 'bi-shop', 'title' => 'Keterangan Usaha', 'slug' => 'keterangan-usaha', 'desc' => 'Untuk keperluan izin atau bantuan usaha.'],
                ['icon' => 'bi-wallet2', 'title' => 'Tidak Mampu (SKTM)', 'slug' => 'keterangan-tidak-mampu', 'desc' => 'Untuk keringanan biaya pendidikan/kesehatan.'],
                ['icon' => 'bi-building-up', 'title' => 'Domisili Usaha', 'slug' => 'domisili-usaha', 'desc' => 'Keterangan tempat kedudukan usaha.'],
                ['icon' => 'bi-house-heart', 'title' => 'Domisili Tinggal', 'slug' => 'domisili-tempat-tinggal', 'desc' => 'Keterangan tempat tinggal saat ini.'],
            ];
        @endphp
        
        @foreach($daftar_surat as $item)
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100 transition-all hover-shadow" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <div class="d-flex align-items-start mb-3">
                        <div class="bg-light-success text-success p-3 rounded-3 me-3" style="background-color: #e8f5e9;">
                            <i class="bi {{ $item['icon'] }} fs-3"></i>
                        </div>
                        <div class="flex-grow-1">
                            <h6 class="fw-bold mb-1">{{ $item['title'] }}</h6>
                            <p class="text-muted mb-0" style="font-size: 0.75rem;">Estimasi 1-2 hari kerja</p>
                        </div>
                    </div>
                    <p class="text-secondary mb-4" style="font-size: 0.85rem; min-height: 40px;">
                        {{ $item['desc'] }}
                    </p>
                    <a href="{{ route('surat.buat', $item['slug']) }}" class="btn btn-outline-success w-100 rounded-pill fw-bold">
                        Pilih Surat
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

<style>
    .hover-shadow:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.08) !important;
        border: 1px solid #198754 !important;
    }
    .transition-all { transition: all 0.3s ease; }
    
    .btn-white:hover {
        background-color: #f8f9fa;
        border-color: #dee2e6;
    }
</style>
@endsection