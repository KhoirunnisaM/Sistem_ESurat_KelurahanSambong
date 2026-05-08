@extends('layouts.app')

@section('content')

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

:root{
    --bg:#f5f6f8;
    --card:#ffffff;
    --line:#e5e7eb;

    --primary:#64796b;
    --primary-dark:#4f6357;
    --primary-light:#eef3f0;

    --text:#111827;
    --text-soft:#6b7280;

    --shadow-sm:0 6px 18px rgba(0,0,0,.04);
    --shadow-md:0 14px 38px rgba(0,0,0,.06);

    --radius-xl:30px;
    --radius-lg:22px;
    --radius-md:18px;
}

html{
    scroll-behavior:smooth;
}

body{
    font-family:'Inter',sans-serif;
    background:
        radial-gradient(circle at top left, rgba(100,121,107,.06), transparent 24%),
        radial-gradient(circle at bottom right, rgba(100,121,107,.05), transparent 28%),
        var(--bg);
    color:var(--text);
}

/* MAIN */
.page{
    width:100%;
    min-height:100vh;
    padding:24px;
}

.container-main{
    width:100%;
    max-width:1400px;
    margin:auto;
    display:grid;
    grid-template-columns:1.1fr .9fr;
    gap:24px;
    align-items:start;
}

/* HERO */
.hero-card{
    position:relative;
    overflow:hidden;
    background:rgba(255,255,255,.82);
    backdrop-filter:blur(14px);
    border:1px solid rgba(255,255,255,.7);
    border-radius:36px;
    box-shadow:var(--shadow-md);
    min-height:760px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
}

.hero-card::before{
    content:'';
    position:absolute;
    top:-140px;
    right:-140px;
    width:320px;
    height:320px;
    border-radius:50%;
    background:rgba(100,121,107,.08);
}

.hero-content{
    position:relative;
    z-index:2;
    padding:42px;
}

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:70px;
    gap:18px;
}

.logo{
    display:flex;
    align-items:center;
    gap:14px;
}

.logo-icon{
    width:72px;
    height:72px;
    border-radius:22px;
    background:white;
    border:1px solid var(--line);
    display:flex;
    align-items:center;
    justify-content:center;
    box-shadow:var(--shadow-sm);
    flex-shrink:0;
}

.logo-icon img{
    width:46px;
}

.logo-text h4{
    font-size:17px;
    font-weight:800;
    margin-bottom:3px;
}

.logo-text p{
    font-size:13px;
    color:var(--text-soft);
}

.hero-badge{
    padding:10px 18px;
    border-radius:999px;
    background:var(--primary-light);
    color:var(--primary-dark);
    font-size:12px;
    font-weight:700;
    letter-spacing:.08em;
    text-transform:uppercase;
    white-space:nowrap;
}

.hero-title{
    font-size:clamp(42px,6vw,76px);
    line-height:1;
    font-weight:800;
    margin-bottom:24px;
    max-width:650px;
}

.hero-title span{
    color:var(--primary);
}

.hero-desc{
    max-width:620px;
    font-size:16px;
    line-height:2;
    color:var(--text-soft);
    margin-bottom:38px;
}

/* BUTTONS */
.hero-buttons{
    display:flex;
    gap:16px;
    flex-wrap:wrap;
}

.btn-main{
    height:58px;
    padding:0 28px;
    border-radius:18px;
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:10px;
    font-size:14px;
    font-weight:700;
    text-decoration:none;
    transition:.25s ease;
}

.btn-primary{
    background:var(--primary);
    color:white;
    border:1px solid var(--primary);
}

.btn-primary:hover{
    background:var(--primary-dark);
    transform:translateY(-2px);
}

.btn-secondary{
    background:white;
    border:1px solid var(--line);
    color:var(--text);
}

.btn-secondary:hover{
    border-color:rgba(100,121,107,.4);
    color:var(--primary-dark);
    transform:translateY(-2px);
}

/* BOTTOM INFO */
.hero-bottom{
    position:relative;
    z-index:2;
    padding:0 42px 42px;
}

.info-grid{
    display:grid;
    grid-template-columns:repeat(3,1fr);
    gap:16px;
}

.info-card{
    background:white;
    border:1px solid var(--line);
    border-radius:22px;
    padding:20px;
    box-shadow:var(--shadow-sm);
}

.info-icon{
    width:50px;
    height:50px;
    border-radius:16px;
    background:var(--primary-light);
    color:var(--primary-dark);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    margin-bottom:16px;
}

.info-card h5{
    font-size:15px;
    margin-bottom:8px;
}

.info-card p{
    font-size:13px;
    line-height:1.8;
    color:var(--text-soft);
}

/* RIGHT */
.right-side{
    display:flex;
    flex-direction:column;
    gap:22px;
}

/* SECTION */
.section{
    background:rgba(255,255,255,.85);
    backdrop-filter:blur(14px);
    border:1px solid rgba(255,255,255,.7);
    border-radius:32px;
    overflow:hidden;
    box-shadow:var(--shadow-md);
}

.section-header{
    padding:28px 30px 20px;
    border-bottom:1px solid var(--line);
}

.section-header h3{
    font-size:22px;
    font-weight:800;
    margin-bottom:8px;
}

.section-header p{
    font-size:14px;
    line-height:1.8;
    color:var(--text-soft);
}

/* FLOW */
.flow-list{
    padding:26px;
    display:flex;
    flex-direction:column;
    gap:16px;
}

.flow-item{
    display:flex;
    gap:16px;
    align-items:flex-start;
    background:white;
    border:1px solid var(--line);
    border-radius:22px;
    padding:18px;
}

.flow-number{
    width:44px;
    height:44px;
    border-radius:14px;
    background:var(--primary-light);
    color:var(--primary-dark);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:15px;
    font-weight:800;
    flex-shrink:0;
}

.flow-text h5{
    font-size:15px;
    margin-bottom:5px;
}

.flow-text p{
    font-size:13px;
    line-height:1.8;
    color:var(--text-soft);
}

/* CONTACT */
.contact-wrap{
    padding:26px;
    display:flex;
    flex-direction:column;
    gap:16px;
}

.contact-item{
    display:flex;
    align-items:center;
    gap:16px;
    padding:18px;
    border-radius:22px;
    background:white;
    border:1px solid var(--line);
    text-decoration:none;
    transition:.2s ease;
}

.contact-item:hover{
    transform:translateY(-2px);
    border-color:rgba(100,121,107,.35);
}

.contact-icon{
    width:54px;
    height:54px;
    border-radius:18px;
    background:var(--primary-light);
    color:var(--primary-dark);
    display:flex;
    align-items:center;
    justify-content:center;
    font-size:22px;
    flex-shrink:0;
}

.contact-info h5{
    font-size:15px;
    margin-bottom:5px;
}

.contact-info p{
    font-size:13px;
    color:var(--text-soft);
}

.socials{
    display:flex;
    gap:12px;
    margin-top:8px;
    flex-wrap:wrap;
}

.social-btn{
    width:54px;
    height:54px;
    border-radius:18px;
    border:1px solid var(--line);
    background:white;
    display:flex;
    align-items:center;
    justify-content:center;
    color:var(--primary-dark);
    font-size:20px;
    transition:.2s ease;
}

.social-btn:hover{
    background:var(--primary-light);
    border-color:rgba(100,121,107,.35);
    transform:translateY(-2px);
}

/* FOOTER */
.footer{
    padding:0 30px 28px;
    text-align:center;
    font-size:12px;
    color:var(--text-soft);
    line-height:1.8;
}

/* TABLET */
@media(max-width:1200px){

    .container-main{
        grid-template-columns:1fr;
    }

    .hero-card{
        min-height:auto;
    }

}

/* MOBILE */
@media(max-width:768px){

    .page{
        padding:14px;
    }

    .hero-content{
        padding:24px;
    }

    .hero-bottom{
        padding:0 24px 24px;
    }

    .topbar{
        flex-direction:column;
        align-items:flex-start;
        margin-bottom:40px;
    }

    .hero-title{
        font-size:44px;
    }

    .hero-desc{
        font-size:14px;
    }

    .info-grid{
        grid-template-columns:1fr;
    }

    .hero-buttons{
        flex-direction:column;
    }

    .btn-main{
        width:100%;
    }

    .section-header{
        padding:22px 22px 18px;
    }

    .flow-list,
    .contact-wrap{
        padding:18px;
    }

}

/* SMALL MOBILE */
@media(max-width:480px){

    .hero-title{
        font-size:36px;
    }

    .logo{
        align-items:flex-start;
    }

    .logo-icon{
        width:64px;
        height:64px;
    }

    .logo-icon img{
        width:40px;
    }

    .section,
    .hero-card{
        border-radius:28px;
    }

}
</style>

<div class="page">

    <div class="container-main">

        {{-- HERO --}}
        <div class="hero-card">

            <div class="hero-content">

                <div class="topbar">

                    <div class="logo">

                        <div class="logo-icon">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/3/3d/Logo_Kabupaten_Batang.png" alt="Logo">
                        </div>

                        <div class="logo-text">
                            <h4>Sambong Online</h4>
                            <p>Sistem Pelayanan Administrasi Digital</p>
                        </div>

                    </div>

                    <div class="hero-badge">
                        Kelurahan Sambong
                    </div>

                </div>

                <h1 class="hero-title">
                    Pelayanan Surat <span>Lebih Modern</span> & Praktis
                </h1>

                <p class="hero-desc">
                    Sistem administrasi digital yang memudahkan warga dalam
                    melakukan pengajuan surat secara online melalui perangkat
                    mobile maupun desktop dengan proses yang cepat dan efisien.
                </p>

                <div class="hero-buttons">

                    <a href="{{ route('login.warga') }}" class="btn-main btn-primary">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Login Warga
                    </a>

                    <a href="{{ route('register.warga') }}" class="btn-main btn-secondary">
                        <i class="bi bi-person-plus"></i>
                        Registrasi
                    </a>

                </div>

            </div>

            <div class="hero-bottom">

                <div class="info-grid">

                    <div class="info-card">

                        <div class="info-icon">
                            <i class="bi bi-lightning-charge"></i>
                        </div>

                        <h5>Proses Cepat</h5>

                        <p>
                            Pengajuan surat dilakukan secara online tanpa harus datang langsung.
                        </p>

                    </div>

                    <div class="info-card">

                        <div class="info-icon">
                            <i class="bi bi-phone"></i>
                        </div>

                        <h5>Mobile Friendly</h5>

                        <p>
                            Tampilan responsif dan nyaman digunakan di semua perangkat.
                        </p>

                    </div>

                    <div class="info-card">

                        <div class="info-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>

                        <h5>Transparan</h5>

                        <p>
                            Status pengajuan dapat dipantau langsung oleh warga secara realtime.
                        </p>

                    </div>

                </div>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="right-side">

            {{-- ALUR --}}
            <div class="section">

                <div class="section-header">
                    <h3>Alur Pengajuan Surat</h3>

                    <p>
                        Langkah pengajuan dibuat sederhana agar mudah dipahami oleh semua warga.
                    </p>
                </div>

                <div class="flow-list">

                    <div class="flow-item">

                        <div class="flow-number">1</div>

                        <div class="flow-text">
                            <h5>Login / Register</h5>
                            <p>Masuk menggunakan akun warga terlebih dahulu.</p>
                        </div>

                    </div>

                    <div class="flow-item">

                        <div class="flow-number">2</div>

                        <div class="flow-text">
                            <h5>Pilih Jenis Surat</h5>
                            <p>Pilih layanan surat sesuai kebutuhan administrasi.</p>
                        </div>

                    </div>

                    <div class="flow-item">

                        <div class="flow-number">3</div>

                        <div class="flow-text">
                            <h5>Upload Dokumen</h5>
                            <p>Lengkapi data dan unggah persyaratan yang dibutuhkan.</p>
                        </div>

                    </div>

                    <div class="flow-item">

                        <div class="flow-number">4</div>

                        <div class="flow-text">
                            <h5>Verifikasi Admin</h5>
                            <p>Petugas akan melakukan pengecekan data pengajuan.</p>
                        </div>

                    </div>

                    <div class="flow-item">

                        <div class="flow-number">5</div>

                        <div class="flow-text">
                            <h5>Surat Selesai</h5>
                            <p>Surat dapat diunduh atau diambil sesuai ketentuan.</p>
                        </div>

                    </div>

                </div>

            </div>

            {{-- KONTAK --}}
            <div class="section">

                <div class="section-header">
                    <h3>Kontak & Informasi</h3>

                    <p>
                        Hubungi admin apabila mengalami kendala saat menggunakan layanan.
                    </p>
                </div>

                <div class="contact-wrap">

                    <a href="https://wa.me/6287843836341" target="_blank" class="contact-item">

                        <div class="contact-icon">
                            <i class="bi bi-whatsapp"></i>
                        </div>

                        <div class="contact-info">
                            <h5>WhatsApp</h5>
                            <p>+62 878-4383-6341</p>
                        </div>

                    </a>

                    <div class="contact-item">

                        <div class="contact-icon">
                            <i class="bi bi-geo-alt"></i>
                        </div>

                        <div class="contact-info">
                            <h5>Alamat Kelurahan</h5>
                            <p>Kelurahan Sambong, Kabupaten Batang</p>
                        </div>

                    </div>

                    <div class="socials">

                        <a href="#" class="social-btn">
                            <i class="bi bi-instagram"></i>
                        </a>

                        <a href="#" class="social-btn">
                            <i class="bi bi-facebook"></i>
                        </a>

                        <a href="#" class="social-btn">
                            <i class="bi bi-tiktok"></i>
                        </a>

                    </div>

                </div>

                <div class="footer">
                    © {{ date('Y') }} Sambong Online — Sistem Pelayanan Administrasi Digital Kelurahan Sambong
                </div>

            </div>

        </div>

    </div>

</div>

@endsection