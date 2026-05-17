<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Mandiri Kelurahan Sambong</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

    <style>
        :root {
            --primary-green: #1e5233; 
            --secondary-green: #2d7a4d;
            --soft-green: #eef5f1;
            --text-dark: #1f2937;
            --text-muted: #6b7280;
            --bg-light: #ffffff;
            --shadow: 0 10px 30px -10px rgba(0, 0, 0, 0.1);
            --shadow-lg: 0 20px 40px -15px rgba(0, 0, 0, 0.15);
        }

        body { 
            font-family: 'Inter', sans-serif; 
            background-color: var(--bg-light); 
            color: var(--text-dark); 
            overflow-x: hidden;
            margin: 0;
            padding: 0;
        }

        /* Animasi fade dan slide */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.05); }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }

        /* --- Navbar Floating --- */
        .custom-nav {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(15px);
            margin: 20px auto;
            padding: 12px 28px;
            border-radius: 100px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            max-width: 1200px;
            width: 92%;
            box-shadow: var(--shadow);
            position: sticky;
            top: 20px;
            z-index: 1000;
            border: 1px solid rgba(30, 82, 51, 0.1);
            transition: all 0.3s ease;
        }

        .custom-nav:hover {
            box-shadow: var(--shadow-lg);
        }

        .nav-brand { display: flex; align-items: center; gap: 12px; text-decoration: none; }
        .nav-brand img { width: 36px; height: auto; transition: transform 0.3s; }
        .nav-brand:hover img { transform: scale(1.05); }
        .nav-brand span { font-weight: 800; font-size: 1rem; color: var(--primary-green); line-height: 1.2; }

        .nav-links { display: flex; gap: 32px; list-style: none; margin: 0; padding: 0; }
        .nav-links a { text-decoration: none; color: var(--text-dark); font-weight: 500; font-size: 0.9rem; transition: 0.3s; position: relative; }
        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-green);
            transition: width 0.3s;
        }
        .nav-links a:hover::after { width: 100%; }
        .nav-links a:hover { color: var(--primary-green); }

        .nav-auth { display: flex; gap: 12px; align-items: center; }
        .btn-masuk { padding: 8px 22px; border-radius: 50px; background: var(--soft-green); color: var(--primary-green); font-weight: 600; text-decoration: none; font-size: 0.85rem; transition: all 0.3s; }
        .btn-masuk:hover { background: var(--primary-green); color: white; transform: translateY(-2px); }
        .btn-daftar { padding: 8px 22px; border-radius: 50px; background: var(--primary-green); color: white; font-weight: 600; text-decoration: none; font-size: 0.85rem; transition: all 0.3s; }
        .btn-daftar:hover { background: var(--secondary-green); transform: translateY(-2px); box-shadow: 0 5px 15px rgba(30, 82, 51, 0.3); }

        /* --- Hero Section --- */
        .hero { text-align: center; padding: 80px 20px 60px; background: radial-gradient(circle at 10% 20%, #f0fdf4 0%, #ffffff 80%); position: relative; overflow: hidden; }
        .hero::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -30%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(30, 82, 51, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .hero::after {
            content: '';
            position: absolute;
            bottom: -30%;
            left: -20%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(45, 122, 77, 0.04) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .hero-badge { background: var(--soft-green); color: var(--secondary-green); padding: 8px 20px; border-radius: 50px; font-size: 0.8rem; font-weight: 700; margin-bottom: 24px; display: inline-block; animation: fadeInUp 0.6s ease; }
        .hero h1 { font-size: clamp(2rem, 5vw, 3.8rem); font-weight: 800; letter-spacing: -1px; margin-bottom: 20px; animation: fadeInUp 0.6s ease 0.1s both; }
        .hero h1 span { color: var(--secondary-green); position: relative; display: inline-block; }
        .hero h1 span::before {
            content: '';
            position: absolute;
            bottom: 8px;
            left: 0;
            width: 100%;
            height: 12px;
            background: var(--soft-green);
            z-index: -1;
            border-radius: 10px;
        }
        .hero p { color: var(--text-muted); max-width: 600px; margin: 0 auto 30px; font-size: 1.1rem; animation: fadeInUp 0.6s ease 0.2s both; }

        /* --- Tombol Utama Ajukan Surat --- */
        .btn-ajukan-hero { 
            background: var(--primary-green); 
            color: white; 
            padding: 14px 38px; 
            border-radius: 50px; 
            font-weight: 700; 
            text-decoration: none; 
            display: inline-flex; 
            align-items: center; 
            gap: 12px; 
            transition: 0.3s; 
            box-shadow: 0 10px 25px rgba(30, 82, 51, 0.25);
            animation: fadeInUp 0.6s ease 0.3s both;
        }
        .btn-ajukan-hero:hover { 
            background: var(--secondary-green); 
            transform: translateY(-3px); 
            box-shadow: 0 15px 30px rgba(30, 82, 51, 0.35);
            color: white;
        }
        .btn-ajukan-hero i { transition: transform 0.3s; }
        .btn-ajukan-hero:hover i { transform: translateX(5px); }

        /* --- Statistik Section --- */
        .stats-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            gap: 24px;
            margin: 60px auto 40px;
            max-width: 1000px;
        }
        .stat-item {
            text-align: center;
            padding: 24px 16px;
            background: white;
            border-radius: 24px;
            box-shadow: var(--shadow);
            transition: all 0.3s;
            border: 1px solid rgba(0,0,0,0.03);
        }
        .stat-item:hover {
            transform: translateY(-8px);
            box-shadow: var(--shadow-lg);
            border-color: var(--soft-green);
        }
        .stat-number {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--primary-green);
            margin-bottom: 8px;
        }
        .stat-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            font-weight: 500;
        }
        .stat-icon {
            font-size: 2rem;
            color: var(--secondary-green);
            margin-bottom: 12px;
            opacity: 0.7;
        }

        /* --- Alur Pengajuan --- */
        .alur-container { display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 24px; margin-top: 50px; position: relative; }
        .alur-item { text-align: center; position: relative; z-index: 1; transition: all 0.3s; }
        .alur-item:hover { transform: translateY(-5px); }
        .alur-icon { width: 75px; height: 75px; background: white; border: 2px solid var(--primary-green); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 1.6rem; color: var(--primary-green); transition: 0.3s; box-shadow: var(--shadow); }
        .alur-item:hover .alur-icon { background: var(--primary-green); color: white; transform: scale(1.05); border-color: var(--secondary-green); }
        .alur-item h6 { font-weight: 700; font-size: 0.95rem; margin-bottom: 5px; }
        .alur-item p { font-size: 0.75rem; color: var(--text-muted); line-height: 1.4; padding: 0 10px; }

        /* Garis penghubung antar step (desktop) */
        @media (min-width: 992px) {
            .alur-container { position: relative; }
            .alur-container::before {
                content: '';
                position: absolute;
                top: 37px;
                left: 8%;
                width: 84%;
                height: 2px;
                background: linear-gradient(90deg, var(--soft-green), var(--primary-green), var(--soft-green));
                z-index: 0;
            }
            .alur-item { background: transparent; }
        }

        /* --- Layanan Section --- */
        .service-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 18px; margin-top: 30px; }
        .service-card { background: white; padding: 20px 24px; border-radius: 20px; display: flex; align-items: center; justify-content: space-between; text-decoration: none; color: inherit; border: 1px solid rgba(0,0,0,0.06); transition: 0.3s; box-shadow: var(--shadow); }
        .service-card:hover { border-color: var(--primary-green); box-shadow: var(--shadow-lg); transform: translateX(8px) translateY(-2px); }
        .service-info { display: flex; align-items: center; gap: 18px; }
        .service-info i { font-size: 1.6rem; color: var(--primary-green); width: 40px; text-align: center; transition: 0.3s; }
        .service-card:hover .service-info i { transform: scale(1.1); }
        .service-info span { font-weight: 600; font-size: 0.95rem; }

        /* --- CTA Banner --- */
        .cta-banner {
            background: linear-gradient(135deg, var(--primary-green) 0%, var(--secondary-green) 100%);
            border-radius: 32px;
            padding: 48px 40px;
            margin: 60px 0;
            text-align: center;
            color: white;
            position: relative;
            overflow: hidden;
        }
        .cta-banner::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -20%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            border-radius: 50%;
        }
        .cta-banner h3 { font-size: 1.8rem; font-weight: 800; margin-bottom: 16px; }
        .cta-banner p { opacity: 0.9; margin-bottom: 28px; max-width: 500px; margin-left: auto; margin-right: auto; }
        .cta-button {
            background: white;
            color: var(--primary-green);
            padding: 12px 32px;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            transition: 0.3s;
        }
        .cta-button:hover { transform: scale(1.05); box-shadow: 0 10px 25px rgba(0,0,0,0.2); }

        /* --- WhatsApp Button --- */
        .floating-wa { position: fixed; bottom: 30px; right: 30px; background: #25d366; color: white; width: 60px; height: 60px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 2rem; box-shadow: 0 10px 25px rgba(37, 211, 102, 0.4); z-index: 1000; transition: 0.3s; animation: pulse 2s infinite; text-decoration: none;}
        .floating-wa:hover { transform: scale(1.1); background: #1eb954; color: white; }

        /* --- Tombol Kembali ke Atas --- */
        .back-to-top {
            position: fixed;
            bottom: 30px;
            left: 30px;
            background: var(--primary-green);
            color: white;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.3rem;
            cursor: pointer;
            opacity: 0;
            visibility: hidden;
            transition: all 0.3s;
            z-index: 1000;
            box-shadow: var(--shadow);
        }
        .back-to-top.show { opacity: 1; visibility: visible; }
        .back-to-top:hover { background: var(--secondary-green); transform: translateY(-3px); }

        /* --- RESPONSIVE OVERRIDES (Sistem Penyesuaian Ukuran Device) --- */
        @media (max-width: 991.98px) {
            .custom-nav { width: 95%; padding: 10px 20px; margin: 15px auto; }
            .nav-links { display: none; }
        }

        @media (max-width: 767.98px) {
            .hero { padding: 60px 15px 40px; }
            .hero h1 { font-size: 2.2rem !important; line-height: 1.3; }
            .hero p { font-size: 0.95rem; padding: 0 10px; }
            .alur-container { grid-template-columns: repeat(2, 1fr); gap: 24px; }
            .alur-container::before { display: none; }
            .stats-container { grid-template-columns: repeat(2, 1fr); gap: 16px; }
            .stat-item { padding: 16px 12px; }
            .stat-number { font-size: 1.9rem; }
            .cta-banner { padding: 35px 20px; border-radius: 24px; }
            .cta-banner h3 { font-size: 1.4rem; }
            .service-grid { grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); }
        }

        @media (max-width: 575.98px) {
            .custom-nav { padding: 8px 16px; border-radius: 30px; }
            .nav-brand span { font-size: 0.85rem; }
            .nav-brand img { width: 30px; }
            .btn-masuk, .btn-daftar { padding: 6px 14px; font-size: 0.75rem; }
            .nav-auth { gap: 6px; }
            .alur-container { grid-template-columns: 1fr; gap: 20px; }
            .hero h1 { font-size: 1.8rem !important; }
            .btn-ajukan-hero { padding: 12px 24px; font-size: 0.85rem; width: 100%; justify-content: center; }
            .floating-wa { width: 50px; height: 50px; font-size: 1.6rem; bottom: 20px; right: 20px; }
            .back-to-top { width: 40px; height: 40px; font-size: 1.1rem; bottom: 20px; left: 20px; }
            .service-card { padding: 16px; }
            .service-info span { font-size: 0.85rem; }
        }
    </style>
</head>
<body>

    <nav class="custom-nav" data-aos="fade-down" data-aos-duration="800">
        <a href="#" class="nav-brand">
            <img src="storage/img/logo_batang.png" alt="Logo">
            <span>Laman Surat<br>Sambong</span>
        </a>
        
        <ul class="nav-links">
            <li><a href="#alur">Alur</a></li>
            <li><a href="#layanan">Layanan</a></li>
            <li><a href="#footer">Tentang Kami</a></li>
        </ul>

        <div class="nav-auth">
            <a href="{{ route('login.warga') }}" class="btn-masuk">Masuk</a>
            <a href="{{ route('register.warga') }}" class="btn-daftar">Daftar</a>
        </div>
    </nav>

    <div class="container">
        <header class="hero">
            <div class="hero-badge" data-aos="fade-up" data-aos-duration="600">
                <i class="bi bi-shield-check me-1"></i> Sistem Layanan Mandiri
            </div>
            <h1 data-aos="fade-up" data-aos-duration="600" data-aos-delay="100">
                Layanan Mandiri Surat <br><span>Kelurahan Sambong</span>
            </h1>
            <p data-aos="fade-up" data-aos-duration="600" data-aos-delay="200">
                Ajukan berbagai surat keterangan kini lebih mudah dan cepat tanpa antrian. Semua dalam satu genggaman.
            </p>
            
            <a href="{{ route('login.warga') }}" class="btn-ajukan-hero" data-aos="fade-up" data-aos-duration="600" data-aos-delay="300">
                Ajukan Surat Sekarang <i class="bi bi-arrow-right"></i>
            </a>
        </header>

        <section id="alur" class="py-5">
            <div class="text-center mb-5" data-aos="fade-up">
                <h3 class="fw-bold" style="font-size: 1.8rem;">Alur Pengajuan</h3>
                <p class="text-muted">Langkah mudah untuk mendapatkan surat Anda</p>
            </div>
            <div class="alur-container">
                <div class="alur-item" data-aos="fade-up" data-aos-delay="50">
                    <div class="alur-icon"><i class="bi bi-person-plus"></i></div>
                    <h6>1. Registrasi</h6>
                    <p>Buat akun warga dengan data NIK valid.</p>
                </div>
                <div class="alur-item" data-aos="fade-up" data-aos-delay="100">
                    <div class="alur-icon"><i class="bi bi-box-arrow-in-right"></i></div>
                    <h6>2. Login</h6>
                    <p>Masuk ke dashboard layanan mandiri.</p>
                </div>
                <div class="alur-item" data-aos="fade-up" data-aos-delay="150">
                    <div class="alur-icon"><i class="bi bi-list-ul"></i></div>
                    <h6>3. Pilih Jenis Surat</h6>
                    <p>Pilih kategori surat yang dibutuhkan.</p>
                </div>
                <div class="alur-item" data-aos="fade-up" data-aos-delay="200">
                    <div class="alur-icon"><i class="bi bi-file-earmark-arrow-up"></i></div>
                    <h6>4. Lengkapi Data</h6>
                    <p>Isi formulir dan unggah dokumen pendukung.</p>
                </div>
                <div class="alur-item" data-aos="fade-up" data-aos-delay="250">
                    <div class="alur-icon"><i class="bi bi-gear"></i></div>
                    <h6>5. Proses Admin</h6>
                    <p>Validasi data oleh petugas kelurahan.</p>
                </div>
                <div class="alur-item" data-aos="fade-up" data-aos-delay="300">
                    <div class="alur-icon"><i class="bi bi-check-lg"></i></div>
                    <h6>6. Selesai</h6>
                    <p>Surat siap diambil di Kantor Pelayanan Kelurahan Sambong.</p>
                </div>
            </div>
        </section>

        <section id="layanan" class="py-5">
            <div class="text-center mb-4" data-aos="fade-up">
                <h3 class="fw-bold" style="font-size: 1.8rem;">Layanan Surat Tersedia</h3>
                <p class="text-muted">Pilih jenis surat yang sesuai dengan kebutuhan Anda</p>
            </div>
            <div class="service-grid">
                @php
                    $services = [
                        ['icon' => 'bi-envelope', 'title' => 'Surat Pengantar Umum', 'desc' => 'Untuk keperluan administrasi umum'],
                        ['icon' => 'bi-shield-check', 'title' => 'Surat Pengantar SKCK', 'desc' => 'Penerbitan Surat Keterangan Catatan Kepolisian'],
                        ['icon' => 'bi-file-text', 'title' => 'Surat Keterangan Umum', 'desc' => 'Keterangan domisili & data diri'],
                        ['icon' => 'bi-heart-pulse', 'title' => 'Surat Keterangan Tidak Mampu', 'desc' => 'Untuk bantuan sosial & program pemerintah'],
                        ['icon' => 'bi-briefcase', 'title' => 'Surat Keterangan Usaha', 'desc' => 'Legalitas usaha mikro & kecil'],
                        ['icon' => 'bi-shop', 'title' => 'Surat Domisili Usaha', 'desc' => 'Penerbitan NIB & izin usaha'],
                        ['icon' => 'bi-geo-alt', 'title' => 'Surat Domisili Tempat Tinggal', 'desc' => 'Bukti alamat tetap'],
                    ];
                @endphp

                @foreach($services as $s)
                <a href="{{ route('login.warga') }}" class="service-card" data-aos="fade-up" data-aos-delay="{{ $loop->index * 50 }}">
                    <div class="service-info">
                        <i class="{{ $s['icon'] }}"></i>
                        <div>
                            <span>{{ $s['title'] }}</span>
                            <p style="font-size: 0.7rem; color: var(--text-muted); margin-top: 4px;">{{ $s['desc'] }}</p>
                        </div>
                    </div>
                    <i class="bi bi-arrow-right text-muted"></i>
                </a>
                @endforeach
            </div>
        </section>
    </div>

    <a href="https://wa.me/6282329572631" target="_blank" class="floating-wa">
        <i class="bi bi-whatsapp"></i>
    </a>

    <div class="back-to-top" id="backToTop">
        <i class="bi bi-arrow-up"></i>
    </div>

   <section id="footer">
    <footer style="background: var(--primary-green); color: white; padding: 60px 0 20px; margin-top: 80px;">
        <div class="container">
            <div class="row gy-4">
                <div class="col-md-4">
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <img src="{{ asset('storage/img/logo_batang.png') }}" alt="Logo" style="width: 40px;">
                        <h5 class="fw-bold mb-0">Layanan Mandiri Sambong</h5>
                    </div>
                    <p class="small opacity-75">Sistem Informasi Administrasi dan Layanan Mandiri Pengajuan Surat Kelurahan Sambong, Kecamatan Batang, Kabupaten Batang, Jawa Tengah.</p>
                </div>
                <div class="col-md-2 offset-md-1">
                </div>
                <div class="col-md-3">
                    <h6 class="fw-bold mb-3">Kontak Resmi</h6>
                    <ul class="list-unstyled small opacity-75">
                        <li class="mb-2"><i class="bi bi-geo-alt me-2"></i> Jl. Kyai Sambong Nomor 12, Kel. Sambong, Kec. Batang, Kab. Batang</li>
                        <li class="mb-2"><i class="bi bi-telephone me-2"></i> (0285) 4312345</li>
                        <li class="mb-2"><i class="bi bi-envelope me-2"></i> info@sambong.mandiri</li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h6 class="fw-bold mb-3">Media Sosial</h6>
                    <div class="d-flex gap-3 fs-5">
                        <a href="#" style="color: white;"><i class="bi bi-facebook"></i></a>
                        <a href="https://www.instagram.com/kelurahansambong_nowandforever?igsh=MTNobjZnbHZ0cndpdw==" target="_blank" style="color: white;"><i class="bi bi-instagram"></i></a>
                        <a href="#" style="color: white;"><i class="bi bi-youtube"></i></a>
                        <a href="#" style="color: white;"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>
            </div>
            <hr class="mt-5 opacity-25">
            <p class="text-center small opacity-50 mb-0">© 2026 Kelurahan Sambong - Kabupaten Batang. Developed for Digital Governance.</p>
        </div>
    </footer>
</section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 50
        });

        // Back to top button logic
        const backToTop = document.getElementById('backToTop');
        window.addEventListener('scroll', () => {
            if (window.scrollY > 300) {
                backToTop.classList.add('show');
            } else {
                backToTop.classList.remove('show');
            }
        });
        backToTop.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
    </script>
</body>
</html>