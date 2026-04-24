@extends('layouts.app')

@section('content')
<style>
    /* Hero Section dengan Gradient Emerald */
    .hero-wrapper {
        background: linear-gradient(135deg, #198754 0%, #0d4d2d 100%);
        padding: 80px 0 100px;
        color: white;
        position: relative;
        overflow: hidden;
    }

    /* Dekorasi Lingkaran di Background */
    .hero-wrapper::before {
        content: "";
        position: absolute;
        width: 400px;
        height: 400px;
        background: rgba(255, 255, 255, 0.05);
        border-radius: 50%;
        bottom: -100px;
        left: -100px;
    }

    /* Card Tombol yang Modern */
    .action-card {
        background: white;
        border-radius: 20px;
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 15px 35px rgba(0,0,0,0.1);
    }
    .action-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.15);
    }

    .btn-login-gold {
        background: #ffc107;
        color: #000;
        font-weight: 700;
        border-radius: 12px;
        padding: 15px 25px;
        transition: 0.3s;
    }
    .btn-login-gold:hover {
        background: #e0a800;
        color: #000;
    }

    /* Alur Pengajuan (Timeline) */
    .timeline-container {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin-top: 40px;
    }
    .timeline-item {
        flex: 1;
        text-align: center;
        position: relative;
        z-index: 2;
    }
    .timeline-dot {
        width: 16px;
        height: 16px;
        background: #ffc107;
        border-radius: 50%;
        margin: 0 auto 15px;
        box-shadow: 0 0 0 5px rgba(255, 193, 7, 0.2);
    }
    .timeline-line {
        position: absolute;
        top: 8px;
        left: 50px;
        right: 50px;
        height: 2px;
        background: rgba(255, 255, 255, 0.2);
        z-index: 1;
    }

    .footer-sambong {
        background: #f8f9fa;
        padding: 40px 0;
        border-top: 1px solid #dee2e6;
    }
</style>

<div class="hero-wrapper">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="d-flex align-items-center mb-4">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/3/3d/Logo_Kabupaten_Batang.png" alt="Logo Batang" height="65">
                    <div class="ms-3">
                        <h5 class="mb-0 fw-bold">KELURAHAN SAMBONG</h5>
                        <p class="small mb-0 opacity-75">Kabupaten Batang, Jawa Tengah</p>
                    </div>
                </div>
                
                <h1 class="display-4 fw-bold mb-3">Pelayanan Surat Online <br> Warga Sambong.</h1>
                <p class="lead opacity-75 mb-5">
                    Nikmati kemudahan mengurus surat keterangan administrasi secara mandiri. Cepat, aman, dan tanpa perlu antre lama di kantor Kelurahan.
                </p>

                <div class="timeline-container d-none d-md-flex">
                    <div class="timeline-line"></div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="small fw-bold">Daftar Akun</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="small fw-bold">Ajukan Surat</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="small fw-bold">Admin Validasi</div>
                    </div>
                    <div class="timeline-item">
                        <div class="timeline-dot"></div>
                        <div class="small fw-bold">Ambil Surat</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4 offset-lg-1 mt-5 mt-lg-0">
                <div class="card action-card p-4">
                    <div class="card-body text-center">
                        <i class="bi bi-person-badge text-success mb-3" style="font-size: 3rem;"></i>
                        <h4 class="fw-bold text-dark mb-4">Akses Layanan</h4>
                        
                        <div class="d-grid gap-3">
                            <a href="{{ route('login.warga') }}" class="btn btn-login-gold shadow-sm">
                                <i class="bi bi-box-arrow-in-right me-2"></i> LOGIN WARGA
                            </a>
                            
                            <a href="https://wa.me/6287843836341" target="_blank" class="btn btn-outline-dark fw-bold py-3 rounded-3">
                                <i class="bi bi-headset me-2"></i> PENGADUAN & CS
                            </a>
                        </div>
                        
                        <p class="text-muted small mt-4">
                            Belum punya akun? <a href="{{ route('register.warga') }}" class="text-success fw-bold text-decoration-none">Daftar Sekarang</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="py-5 bg-white">
    <div class="container text-center">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <h3 class="fw-bold text-dark mb-4">Tentang Sistem</h3>
                <p class="text-muted">
                    Sambong Online adalah inovasi pelayanan publik untuk mempermudah warga Kelurahan Sambong dalam permohonan surat keterangan seperti SKCK, Domisili Usaha, hingga Surat Keterangan Umum tanpa harus berulang kali datang ke kantor sebelum dokumen siap.
                </p>
            </div>
        </div>
    </div>
</div>

<footer class="footer-sambong">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h6 class="fw-bold text-success mb-3">KONTAK KAMI</h6>
                <p class="mb-1 text-dark fw-bold"><i class="bi bi-telephone-outbound-fill me-2"></i> (0285) 392211 / 0878-4383-6341</p>
                <p class="mb-1 text-muted small"><i class="bi bi-envelope-at-fill me-2"></i> kelurahan.sambong@batangkab.go.id</p>
                <p class="mb-0 text-muted small"><i class="bi bi-geo-alt-fill me-2"></i> Jl. Raya Sambong, Batang, Jawa Tengah</p>
            </div>
            <div class="col-md-6 text-md-end mt-4 mt-md-0">
                <div class="fs-4">
                    <a href="#" class="text-dark me-3"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-dark me-3"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-dark me-3"><i class="bi bi-youtube"></i></a>
                    <a href="#" class="text-dark"><i class="bi bi-globe"></i></a>
                </div>
                <p class="small text-muted mt-2 mb-0">&copy; {{ date('Y') }} Kelurahan Sambong. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>
@endsection