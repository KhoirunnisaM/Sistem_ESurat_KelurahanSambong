@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --primary-green: #1e5233; 
        --secondary-green: #2d7a4d;
        --soft-green: #eef5f1;
        --text-dark: #1f2937;
        --text-muted: #6b7280;
        --bg-light: #ffffff;
        --shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1);
    }

    body { 
        font-family: 'Inter', sans-serif; 
        background-color: var(--bg-light); 
        color: var(--text-dark); 
    }

    /* --- Navbar Floating (Sesuai Gambar) --- */
    .custom-nav {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(15px);
        margin: 20px auto;
        padding: 12px 24px;
        border-radius: 100px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        max-width: 1100px;
        width: 92%;
        box-shadow: var(--shadow);
        position: sticky;
        top: 20px;
        z-index: 1000;
        border: 1px solid rgba(0,0,0,0.05);
    }

    .nav-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
    .nav-brand img { width: 32px; height: auto; }
    .nav-brand span { font-weight: 800; font-size: 1rem; color: var(--primary-green); line-height: 1.2; }

    .nav-links { display: flex; gap: 25px; list-style: none; margin: 0; padding: 0; }
    .nav-links a { text-decoration: none; color: var(--text-dark); font-weight: 500; font-size: 0.9rem; transition: 0.3s; }
    .nav-links a:hover { color: var(--primary-green); }

    .nav-auth { display: flex; gap: 10px; align-items: center; }
    .btn-masuk { padding: 8px 20px; border-radius: 50px; background: var(--soft-green); color: var(--primary-green); font-weight: 600; text-decoration: none; font-size: 0.85rem; }
    .btn-daftar { padding: 8px 20px; border-radius: 50px; background: var(--primary-green); color: white; font-weight: 600; text-decoration: none; font-size: 0.85rem; }

    /* --- Hero Section --- */
    .hero { text-align: center; padding: 80px 20px 40px; background: radial-gradient(circle at top, #f0fdf4 0%, #ffffff 100%); }
    .hero-badge { background: var(--soft-green); color: var(--secondary-green); padding: 6px 16px; border-radius: 50px; font-size: 0.8rem; font-weight: 700; margin-bottom: 20px; display: inline-block; }
    .hero h1 { font-size: clamp(2rem, 5vw, 3.5rem); font-weight: 800; letter-spacing: -1px; margin-bottom: 20px; }
    .hero h1 span { color: var(--secondary-green); }
    .hero p { color: var(--text-muted); max-width: 600px; margin: 0 auto 30px; font-size: 1.1rem; }

    /* --- Alur Pengajuan (Sesuai Gambar) --- */
    .alur-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 20px; margin-top: 50px; position: relative; }
    .alur-item { text-align: center; position: relative; z-index: 1; }
    .alur-icon { width: 70px; height: 70px; background: white; border: 2px solid var(--primary-green); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 1.5rem; color: var(--primary-green); transition: 0.3s; }
    .alur-item:hover .alur-icon { background: var(--primary-green); color: white; transform: translateY(-5px); }
    .alur-item h6 { font-weight: 700; font-size: 0.95rem; margin-bottom: 5px; }
    .alur-item p { font-size: 0.75rem; color: var(--text-muted); line-height: 1.4; padding: 0 10px; }

    /* --- Layanan Section --- */
    .service-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 15px; margin-top: 30px; }
    .service-card { background: white; padding: 20px; border-radius: 12px; display: flex; align-items: center; justify-content: space-between; text-decoration: none; color: inherit; border: 1px solid rgba(0,0,0,0.06); transition: 0.3s; box-shadow: 0 2px 4px rgba(0,0,0,0.02); }
    .service-card:hover { border-color: var(--primary-green); box-shadow: var(--shadow); transform: translateX(5px); }
    .service-info { display: flex; align-items: center; gap: 15px; }
    .service-info i { font-size: 1.4rem; color: var(--primary-green); }
    .service-info span { font-weight: 600; font-size: 0.95rem; }

    /* --- WhatsApp Button --- */
    .btn-wa-hero { background: #25d366; color: white; padding: 12px 25px; border-radius: 50px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 10px; transition: 0.3s; }
    .btn-wa-hero:hover { background: #1eb954; color: white; transform: scale(1.05); }
    
    .floating-wa { position: fixed; bottom: 30px; right: 30px; background: #25d366; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; box-shadow: 0 10px 20px rgba(37, 211, 102, 0.3); z-index: 1000; transition: 0.3s; }
    .floating-wa:hover { transform: scale(1.1); color: white; }

    @media (max-width: 768px) {
        .nav-links { display: none; }
        .alur-container { grid-template-columns: repeat(2, 1fr); gap: 30px; }
    }

     /* --- Tombol Utama Ajukan Surat --- */
    .btn-ajukan-hero { 
        background: var(--primary-green); 
        color: white; 
        padding: 14px 35px; 
        border-radius: 50px; 
        font-weight: 700; 
        text-decoration: none; 
        display: inline-flex; 
        align-items: center; 
        gap: 12px; 
        transition: 0.3s; 
        box-shadow: 0 10px 20px rgba(30, 82, 51, 0.2);
    }
    .btn-ajukan-hero:hover { 
        background: var(--secondary-green); 
        color: white; 
        transform: translateY(-3px); 
        box-shadow: 0 15px 25px rgba(30, 82, 51, 0.3);
    }
</style>

<nav class="custom-nav">
    <a href="#" class="nav-brand">
        <img src="storage/img/logo_batang.png" alt="Logo">
        <span>Laman Surat<br>Sambong</span>
    </a>
    
    <ul class="nav-links">
        <li><a href="#alur">Alur</a></li>
        <li><a href="#layanan">Layanan</a></li>
        <li><a href="#footer">Tentang kami</a></li>
    </ul>

    <div class="nav-auth">
        <a href="{{ route('login.warga') }}" class="btn-masuk">Masuk</a>
        <a href="{{ route('register.warga') }}" class="btn-daftar">Daftar</a>
    </div>
</nav>

<div class="container">
    <header class="hero">
        <div class="hero-badge">Sistem Layanan Mandiri</div>
        <h1>Layanan Mandiri Surat <span><br>Kelurahan Sambong</span></h1>
        <p>Ajukan berbagai surat keterangan kini lebih mudah dan cepat tanpa antrian. Semua dalam satu genggaman.</p>
        
        <a href="{{ route('login.warga') }}" class="btn-ajukan-hero">
            Ajukan Surat Sekarang <i class="bi bi-arrow-right"></i>
        </a>
    </header>


    <section id="alur" class="py-5">
        <div class="text-center mb-5">
            <h3 class="fw-bold">Alur Pengajuan</h3>
            <p class="text-muted small">Langkah mudah untuk mendapatkan surat Anda</p>
        </div>
        <div class="alur-container">
            <div class="alur-item">
                <div class="alur-icon"><i class="bi bi-person-plus"></i></div>
                <h6>1. Registrasi</h6>
                <p>Buat akun warga dengan data NIK valid.</p>
            </div>
            <div class="alur-item">
                <div class="alur-icon"><i class="bi bi-box-arrow-in-right"></i></div>
                <h6>2. Login</h6>
                <p>Masuk ke dashboard layanan mandiri.</p>
            </div>
            <div class="alur-item">
                <div class="alur-icon"><i class="bi bi-list-ul"></i></div>
                <h6>3. Pilih Jenis Surat</h6>
                <p>Pilih kategori surat yang dibutuhkan.</p>
            </div>
            <div class="alur-item">
                <div class="alur-icon"><i class="bi bi-file-earmark-arrow-up"></i></div>
                <h6>4. Lengkapi Data</h6>
                <p>Isi formulir dan unggah dokumen pendukung.</p>
            </div>
            <div class="alur-item">
                <div class="alur-icon"><i class="bi bi-gear"></i></div>
                <h6>5. Proses Admin</h6>
                <p>Validasi data oleh petugas kelurahan.</p>
            </div>
            <div class="alur-item">
                <div class="alur-icon"><i class="bi bi-check-lg"></i></div>
                <h6>6. Selesai</h6>
                <p>Surat siap diambil di Kantor Pelayanan Kelurahan Sambong.</p>
            </div>
        </div>
    </section>

    <section id="layanan" class="py-5">
        <div class="text-center mb-4">
            <h3 class="fw-bold">Layanan Surat Tersedia</h3>
        </div>
        <div class="service-grid">
            @php
                $services = [
                    ['icon' => 'bi-envelope', 'title' => 'Surat Pengantar Umum'],
                    ['icon' => 'bi-shield-check', 'title' => 'Surat Pengantar SKCK'],
                    ['icon' => 'bi-file-text', 'title' => 'Surat Keterangan Umum'],
                    ['icon' => 'bi-heart-pulse', 'title' => 'Surat Keterangan Tidak Mampu'],
                    ['icon' => 'bi-briefcase', 'title' => 'Surat Keterangan Usaha'],
                    ['icon' => 'bi-shop', 'title' => 'Surat Domisili Usaha'],
                    ['icon' => 'bi-geo-alt', 'title' => 'Surat Domisili Tempat Tinggal'],
                ];
            @endphp

            @foreach($services as $s)
            <a href="{{ route('login.warga') }}" class="service-card">
                <div class="service-info">
                    <i class="{{ $s['icon'] }}"></i>
                    <span>{{ $s['title'] }}</span>
                </div>
                <i class="bi bi-arrow-right text-muted"></i>
            </a>
            @endforeach
        </div>
    </section>
</div>

<a href="https://wa.me/6281122234567" target="_blank" class="floating-wa">
    <i class="bi bi-whatsapp"></i>
</a>

<section id="footer">
<footer class="mt-5" style="background: var(--primary-green); color: white; padding: 60px 0 20px;">
    <div class="container">
        <div class="row gy-4">
            <div class="col-md-4">
                <h5 class="fw-bold mb-3">Layanan Mandiri Sambong</h5>
                <p class="small opacity-75">Sistem Informasi Pelayanan Mandiri Pengajuan Surat Kelurahan Sambong, Kec. Batang, Kabupaten Batang.</p>
            </div>
            <div class="col-md-2 offset-md-1">
                <h6 class="fw-bold mb-3">Tautan Cepat</h6>
                <ul class="list-unstyled small opacity-75">
                    <li class="mb-2"><a href="#alur" class="text-white text-decoration-none">Alur Prosedur</a></li>
                    <li class="mb-2"><a href="#layanan" class="text-white text-decoration-none">Layanan</a></li>
                    <li class="mb-2"><a href="#footer" class="text-white text-decoration-none">Tentang Kami</a></li>
                </ul>
            </div>
            <div class="col-md-3">
                <h6 class="fw-bold mb-3">Kontak Resmi</h6>
                <ul class="list-unstyled small opacity-75">
                    <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> Jl. Kyai Sambong Nomor 12, kel.Sambong, Kec.Batang, Kab.Batang</li>
                    <li class="mb-2"><i class="bi bi-telephone me-2"></i> 0811-2223-4567</li>
                    <li class="mb-2"><i class="bi bi-envelope me-2"></i> info@sambong.mandiri</li>
                </ul>
            </div>
            <div class="col-md-2">
                <h6 class="fw-bold mb-3">Media Sosial</h6>
                <div class="d-flex gap-3 fs-5">
                    <i class="bi bi-facebook"></i>
                    <i class="bi bi-instagram"></i>
                    <i class="bi bi-youtube"></i>
                </div>
            </div>
        </div>
        <hr class="mt-5 opacity-25">
        <p class="text-center small opacity-50 mb-0">© 2026 Kelurahan Sambong - Kabupaten Batang. Developed for Digital Governance.</p>
    </div>
</footer>
</section>

@endsection