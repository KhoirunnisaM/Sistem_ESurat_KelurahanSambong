@extends('layouts.app')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

:root {
    --green:     #2e7d4f;
    --green-lt:  #3d9962;
    --green-bg:  #f0f7f3;
    --green-bd:  #c8e6d5;
    --gray-900:  #1a1d23;
    --gray-700:  #374151;
    --gray-500:  #6b7280;
    --gray-400:  #9ca3af;
    --gray-300:  #d1d5db;
    --gray-200:  #e5e7eb;
    --gray-100:  #f3f4f6;
    --gray-50:   #f9fafb;
    --white:     #ffffff;
    --font:      'Plus Jakarta Sans', sans-serif;
    --r:         10px;
}

html { scroll-behavior: smooth; }
body {
    font-family: var(--font);
    color: var(--gray-700);
    background: var(--white);
    font-size: 14px;
    line-height: 1.6;
    -webkit-font-smoothing: antialiased;
}
a { text-decoration: none; color: inherit; }

/* ─── NAV ─── */
.nav {
    background: var(--white);
    border-bottom: 1px solid var(--gray-200);
    position: sticky;
    top: 0;
    z-index: 100;
}
.nav-wrap {
    max-width: 1080px;
    margin: auto;
    padding: 0 20px;
    height: 60px;
    display: flex;
    align-items: center;
    gap: 10px;
}
.nav-logo { width: 32px; height: 32px; object-fit: contain; flex-shrink: 0; }
.nav-title {
    font-size: 13.5px;
    font-weight: 700;
    color: var(--gray-900);
    line-height: 1.2;
}
.nav-title span { display: block; font-size: 11px; font-weight: 400; color: var(--gray-400); }
.nav-divider { width: 1px; height: 24px; background: var(--gray-200); margin: 0 4px; }
.nav-links { display: flex; align-items: center; gap: 2px; margin-left: 4px; }
.nav-link {
    font-size: 13px; font-weight: 500; color: var(--gray-500);
    padding: 6px 12px; border-radius: 6px;
    transition: color .15s, background .15s;
}
.nav-link:hover { color: var(--green); background: var(--green-bg); }
.nav-auth { margin-left: auto; display: flex; align-items: center; gap: 8px; }
.btn-login {
    font-size: 13px; font-weight: 600; color: var(--green);
    padding: 7px 16px; border-radius: 6px;
    border: 1.5px solid var(--green);
    transition: background .15s, color .15s;
}
.btn-login:hover { background: var(--green); color: var(--white); }
.btn-register {
    font-size: 13px; font-weight: 600; color: var(--white);
    background: var(--green); padding: 7px 16px; border-radius: 6px;
    border: 1.5px solid var(--green);
    transition: background .15s;
}
.btn-register:hover { background: var(--green-lt); border-color: var(--green-lt); color: var(--white); }
.nav-toggle {
    display: none; margin-left: auto; background: none; border: none;
    cursor: pointer; padding: 6px; color: var(--gray-700); font-size: 22px; line-height: 1;
}
.mobile-menu { display: none; background: var(--white); border-top: 1px solid var(--gray-200); padding: 12px 20px 16px; }
.mobile-menu.open { display: block; }
.mobile-menu a {
    display: block; font-size: 14px; font-weight: 500; color: var(--gray-700);
    padding: 10px 0; border-bottom: 1px solid var(--gray-100);
}
.mobile-menu a:last-child { border-bottom: none; }
.mobile-auth { display: flex; gap: 8px; margin-top: 14px; }
.mobile-auth a { flex: 1; text-align: center; padding: 10px !important; border-bottom: none !important; border-radius: 8px; font-weight: 600 !important; }
.mobile-auth .m-login { border: 1.5px solid var(--green); color: var(--green) !important; }
.mobile-auth .m-reg   { background: var(--green); color: var(--white) !important; }

/* ─── HERO ─── */
.hero {
    background: linear-gradient(160deg, #1b4332 0%, #2d6a4f 55%, #3a8a5c 100%);
    padding: 56px 20px 60px;
}
.hero-wrap {
    max-width: 1080px; margin: auto;
    display: grid; grid-template-columns: 1fr 320px; gap: 48px; align-items: center;
}
.hero-eyebrow {
    display: inline-flex; align-items: center; gap: 6px;
    background: rgba(255,255,255,0.12); border: 1px solid rgba(255,255,255,0.18);
    color: rgba(255,255,255,0.8); font-size: 11px; font-weight: 600;
    letter-spacing: 0.08em; text-transform: uppercase;
    padding: 4px 12px; border-radius: 100px; margin-bottom: 20px;
}
.hero-title {
    font-size: clamp(22px, 4vw, 34px); font-weight: 700; color: var(--white);
    line-height: 1.25; margin-bottom: 14px; letter-spacing: -0.01em;
}
.hero-title span {
    color: rgba(255,255,255,0.55); font-weight: 400; font-size: 0.7em;
    display: block; margin-top: 4px; letter-spacing: 0;
}
.hero-desc {
    font-size: 14px; color: rgba(255,255,255,0.58); line-height: 1.8;
    max-width: 440px; margin-bottom: 28px; font-weight: 300;
}
.hero-stats { display: flex; gap: 24px; }
.hero-stat-num { font-size: 22px; font-weight: 700; color: var(--white); line-height: 1; margin-bottom: 3px; }
.hero-stat-label { font-size: 11px; color: rgba(255,255,255,0.45); }
.hero-stat-div { width: 1px; background: rgba(255,255,255,0.15); }

/* login card */
.login-card {
    background: var(--white); border-radius: 14px;
    padding: 28px 24px; box-shadow: 0 8px 40px rgba(0,0,0,0.18);
}
.login-card-title { font-size: 15px; font-weight: 700; color: var(--gray-900); margin-bottom: 4px; }
.login-card-sub { font-size: 12.5px; color: var(--gray-400); margin-bottom: 20px; }
.lc-stack { display: flex; flex-direction: column; gap: 9px; }
.lc-primary {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 12px; background: var(--green); color: var(--white);
    font-size: 13.5px; font-weight: 600; border-radius: 8px; border: none; cursor: pointer;
    transition: background .15s; font-family: var(--font);
}
.lc-primary:hover { background: var(--green-lt); color: var(--white); }
.lc-secondary {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 11px; background: transparent; color: var(--gray-700);
    font-size: 13px; font-weight: 600; border-radius: 8px; font-family: var(--font);
    border: 1.5px solid var(--gray-200); cursor: pointer; transition: border-color .15s, color .15s;
}
.lc-secondary:hover { border-color: var(--gray-300); color: var(--gray-900); }
.lc-wa {
    display: flex; align-items: center; justify-content: center; gap: 8px;
    width: 100%; padding: 11px; background: transparent; color: #128C7E;
    font-size: 13px; font-weight: 600; border-radius: 8px; font-family: var(--font);
    border: 1.5px solid #b7ebd1; cursor: pointer;
    transition: border-color .15s, background .15s;
}
.lc-wa:hover { background: #f0fff8; border-color: #25D366; }
.lc-or {
    text-align: center; font-size: 11.5px; color: var(--gray-400); position: relative;
}
.lc-or::before, .lc-or::after {
    content: ''; position: absolute; top: 50%; width: 38%; height: 1px; background: var(--gray-200);
}
.lc-or::before { left: 0; } .lc-or::after { right: 0; }

/* ─── SECTION ─── */
.section { padding: 64px 20px; }
.section-alt { background: var(--gray-50); border-top: 1px solid var(--gray-200); border-bottom: 1px solid var(--gray-200); }
.wrap { max-width: 1080px; margin: auto; }
.sec-label {
    font-size: 11px; font-weight: 700; letter-spacing: 0.1em; text-transform: uppercase;
    color: var(--green); margin-bottom: 8px; display: flex; align-items: center; gap: 6px;
}
.sec-title {
    font-size: clamp(18px, 3vw, 26px); font-weight: 700; color: var(--gray-900);
    line-height: 1.3; margin-bottom: 8px; letter-spacing: -0.01em;
}
.sec-sub { font-size: 13.5px; color: var(--gray-500); line-height: 1.75; font-weight: 300; }

/* ─── VISI ─── */
.visi-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; align-items: start; }
.visi-list { margin-top: 0; display: flex; flex-direction: column; gap: 10px; }
.visi-item {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 14px 16px; background: var(--white);
    border: 1px solid var(--gray-200); border-radius: var(--r);
}
.visi-dot {
    width: 28px; height: 28px; border-radius: 50%;
    background: var(--green-bg); display: flex; align-items: center; justify-content: center;
    flex-shrink: 0; margin-top: 1px;
}
.visi-dot i { font-size: 14px; color: var(--green); }
.visi-text { font-size: 13px; color: var(--gray-700); line-height: 1.65; }
.visi-text strong { display: block; font-weight: 600; color: var(--gray-900); margin-bottom: 2px; }

/* ─── LAYANAN ─── */
.layanan-header { margin-bottom: 28px; }
.layanan-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 14px; }
.svc {
    background: var(--white); border: 1px solid var(--gray-200);
    border-radius: var(--r); padding: 22px 20px;
    transition: border-color .2s, box-shadow .2s, transform .2s;
}
.svc:hover { border-color: var(--green-bd); box-shadow: 0 4px 20px rgba(46,125,79,0.08); transform: translateY(-2px); }
.svc-icon {
    width: 38px; height: 38px; border-radius: 8px; background: var(--green-bg);
    display: flex; align-items: center; justify-content: center; margin-bottom: 13px;
}
.svc-icon i { font-size: 19px; color: var(--green); }
.svc-name { font-size: 13.5px; font-weight: 700; color: var(--gray-900); margin-bottom: 5px; }
.svc-desc { font-size: 12.5px; color: var(--gray-500); line-height: 1.65; }
.svc-tag {
    display: inline-block; margin-top: 12px; font-size: 10.5px; font-weight: 600;
    letter-spacing: 0.06em; text-transform: uppercase; color: var(--green);
    background: var(--green-bg); padding: 2px 8px; border-radius: 100px;
}

/* ─── ALUR ─── */
.alur-desktop {
    display: grid; grid-template-columns: repeat(5, 1fr);
    gap: 0; margin-top: 40px; position: relative;
}
.alur-step {
    display: flex; flex-direction: column; align-items: center;
    text-align: center; position: relative; padding: 0 8px;
}
.alur-step:not(:last-child)::after {
    content: ''; position: absolute; top: 22px; right: -50%;
    width: 100%; height: 1.5px; background: var(--gray-200); z-index: 0;
}
.alur-num {
    width: 44px; height: 44px; border-radius: 50%;
    background: var(--white); border: 2px solid var(--gray-200);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700; color: var(--gray-900);
    margin-bottom: 14px; position: relative; z-index: 1;
    transition: border-color .2s, background .2s, color .2s;
}
.alur-step:hover .alur-num { border-color: var(--green); background: var(--green); color: var(--white); }
.alur-icon {
    width: 40px; height: 40px; border-radius: 8px; background: var(--gray-100);
    display: flex; align-items: center; justify-content: center; margin-bottom: 12px;
    transition: background .2s;
}
.alur-step:hover .alur-icon { background: var(--green-bg); }
.alur-icon i { font-size: 19px; color: var(--gray-500); transition: color .2s; }
.alur-step:hover .alur-icon i { color: var(--green); }
.alur-title { font-size: 12.5px; font-weight: 700; color: var(--gray-900); margin-bottom: 5px; }
.alur-desc { font-size: 11.5px; color: var(--gray-500); line-height: 1.6; }

.alur-mobile { display: none; flex-direction: column; gap: 0; margin-top: 32px; }
.alur-m-step { display: flex; gap: 16px; padding: 0 0 28px 0; position: relative; }
.alur-m-step:not(:last-child)::before {
    content: ''; position: absolute; left: 19px; top: 44px; bottom: 0;
    width: 1.5px; background: var(--gray-200);
}
.alur-m-num {
    width: 40px; height: 40px; border-radius: 50%;
    background: var(--green-bg); border: 2px solid var(--green-bd);
    display: flex; align-items: center; justify-content: center;
    font-size: 13px; font-weight: 700; color: var(--green); flex-shrink: 0;
}
.alur-m-body { padding-top: 8px; }
.alur-m-title { font-size: 13.5px; font-weight: 700; color: var(--gray-900); margin-bottom: 3px; }
.alur-m-desc { font-size: 12.5px; color: var(--gray-500); line-height: 1.6; }

/* ─── KONTAK ─── */
.kontak-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 48px; margin-top: 36px; }
.kontak-items { display: flex; flex-direction: column; gap: 12px; }
.kontak-item {
    display: flex; align-items: flex-start; gap: 12px;
    padding: 14px 16px; background: var(--white);
    border: 1px solid var(--gray-200); border-radius: var(--r);
}
.kontak-icon {
    width: 34px; height: 34px; border-radius: 7px; background: var(--green-bg);
    display: flex; align-items: center; justify-content: center; flex-shrink: 0;
}
.kontak-icon i { font-size: 15px; color: var(--green); }
.kontak-label { font-size: 10.5px; font-weight: 600; letter-spacing: 0.07em; text-transform: uppercase; color: var(--gray-400); margin-bottom: 2px; }
.kontak-val { font-size: 13px; color: var(--gray-700); line-height: 1.5; }

.kontak-right { display: flex; flex-direction: column; gap: 14px; }
.wa-btn {
    display: flex; align-items: center; gap: 12px;
    padding: 16px 18px; background: #f0fff8;
    border: 1px solid #b7ebd1; border-radius: var(--r);
    transition: background .15s, transform .15s;
}
.wa-btn:hover { background: #e0faf0; transform: translateY(-1px); }
.wa-btn-icon {
    width: 40px; height: 40px; border-radius: 8px; background: #25D366;
    display: flex; align-items: center; justify-content: center;
    font-size: 20px; color: var(--white); flex-shrink: 0;
}
.wa-btn-text strong { display: block; font-size: 13.5px; font-weight: 700; color: var(--gray-900); }
.wa-btn-text span { font-size: 12px; color: var(--gray-500); }
.wa-arrow { margin-left: auto; color: var(--gray-400); }

.medsos-label { font-size: 11px; font-weight: 700; letter-spacing: 0.08em; text-transform: uppercase; color: var(--gray-400); margin-bottom: 10px; }
.medsos-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.medsos-item {
    display: flex; align-items: center; gap: 10px;
    padding: 12px 14px; background: var(--white);
    border: 1px solid var(--gray-200); border-radius: var(--r);
    transition: border-color .15s, transform .15s;
}
.medsos-item:hover { border-color: var(--gray-300); transform: translateY(-1px); }
.medsos-item i { font-size: 18px; flex-shrink: 0; }
.medsos-text strong { display: block; font-size: 12.5px; font-weight: 700; color: var(--gray-900); }
.medsos-text span { font-size: 11px; color: var(--gray-400); }

/* ─── FOOTER ─── */
.footer { background: var(--gray-900); padding: 20px; }
.footer-wrap {
    max-width: 1080px; margin: auto;
    display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;
}
.footer-brand { display: flex; align-items: center; gap: 10px; }
.footer-logo { width: 26px; height: 26px; object-fit: contain; filter: brightness(0) invert(1); opacity: 0.45; }
.footer-copy { font-size: 12px; color: rgba(255,255,255,0.3); }
.footer-links { display: flex; gap: 16px; }
.footer-links a { font-size: 12px; color: rgba(255,255,255,0.3); transition: color .15s; }
.footer-links a:hover { color: rgba(255,255,255,0.65); }

/* ─── RESPONSIVE ─── */
@media (max-width: 900px) {
    .nav-links { display: none; }
    .nav-auth  { display: none; }
    .nav-toggle { display: block; }
    .hero-wrap { grid-template-columns: 1fr; }
    .login-card { max-width: 420px; }
    .visi-grid { grid-template-columns: 1fr; gap: 28px; }
    .layanan-grid { grid-template-columns: 1fr 1fr; }
    .alur-desktop { display: none; }
    .alur-mobile { display: flex; }
    .kontak-grid { grid-template-columns: 1fr; gap: 28px; }
}
@media (max-width: 560px) {
    .section { padding: 48px 16px; }
    .hero { padding: 40px 16px 44px; }
    .layanan-grid { grid-template-columns: 1fr; }
    .medsos-grid { grid-template-columns: 1fr; }
    .footer-wrap { flex-direction: column; align-items: flex-start; }
    .hero-stats { gap: 16px; }
    .nav-wrap { padding: 0 16px; }
    .mobile-menu { padding: 10px 16px 14px; }
}

@keyframes up { from { opacity:0; transform:translateY(14px); } to { opacity:1; transform:translateY(0); } }
.hero-wrap > * { animation: up .5s ease both; }
.hero-wrap > *:first-child { animation-delay: .05s; }
.hero-wrap > *:last-child  { animation-delay: .18s; }
</style>

{{-- NAV --}}
<nav class="nav">
    <div class="nav-wrap">
        <img src="https://upload.wikimedia.org/wikipedia/commons/3/3d/Logo_Kabupaten_Batang.png" alt="Logo" class="nav-logo">
        <div class="nav-title">
            Kelurahan Sambong
            <span>Kabupaten Batang, Jawa Tengah</span>
        </div>
        <div class="nav-divider"></div>
        <div class="nav-links">
            <a href="#visi"    class="nav-link">Visi &amp; Misi</a>
            <a href="#layanan" class="nav-link">Layanan</a>
            <a href="#alur"    class="nav-link">Alur Pengajuan</a>
            <a href="#kontak"  class="nav-link">Kontak</a>
        </div>
        <div class="nav-auth">
            <a href="{{ route('login.warga') }}"    class="btn-login">Login</a>
            <a href="{{ route('register.warga') }}" class="btn-register">Daftar</a>
        </div>
        <button class="nav-toggle" id="navToggle" aria-label="Menu">
            <i class="bi bi-list"></i>
        </button>
    </div>
    <div class="mobile-menu" id="mobileMenu">
        <a href="#visi">Visi &amp; Misi</a>
        <a href="#layanan">Layanan</a>
        <a href="#alur">Alur Pengajuan</a>
        <a href="#kontak">Kontak</a>
        <div class="mobile-auth">
            <a href="{{ route('login.warga') }}"    class="m-login">Login</a>
            <a href="{{ route('register.warga') }}" class="m-reg">Daftar</a>
        </div>
    </div>
</nav>

{{-- HERO --}}
<section class="hero">
    <div class="hero-wrap">
        <div>
            <div class="hero-eyebrow">
                <i class="bi bi-shield-check" style="font-size:12px;"></i>
                Sistem Informasi Pelayanan Digital
            </div>
            <h1 class="hero-title">
                Sambong Online
                <span>Kelurahan Sambong &mdash; Kabupaten Batang</span>
            </h1>
            <p class="hero-desc">
                Platform pengajuan surat keterangan administrasi warga secara digital.
                Mudah, cepat, transparan, dan tanpa biaya — langsung dari perangkat Anda.
            </p>
            <div class="hero-stats">
                <div>
                    <div class="hero-stat-num">24/7</div>
                    <div class="hero-stat-label">Akses Kapan Saja</div>
                </div>
                <div class="hero-stat-div"></div>
                <div>
                    <div class="hero-stat-num">5+</div>
                    <div class="hero-stat-label">Jenis Layanan</div>
                </div>
                <div class="hero-stat-div"></div>
                <div>
                    <div class="hero-stat-num">Gratis</div>
                    <div class="hero-stat-label">Tanpa Biaya Admin</div>
                </div>
            </div>
        </div>
        <div>
            <div class="login-card">
                <div class="login-card-title">Masuk ke Portal</div>
                <div class="login-card-sub">Akses layanan surat administrasi warga</div>
                <div class="lc-stack">
                    <a href="{{ route('login.warga') }}" class="lc-primary">
                        <i class="bi bi-box-arrow-in-right" style="font-size:15px;"></i>
                        Login Warga
                    </a>
                    <div class="lc-or">atau</div>
                    <a href="{{ route('register.warga') }}" class="lc-secondary">
                        <i class="bi bi-person-plus" style="font-size:15px;color:var(--green);"></i>
                        Buat Akun Baru
                    </a>
                    <a href="https://wa.me/6287843836341" target="_blank" class="lc-wa">
                        <i class="bi bi-whatsapp" style="font-size:15px;"></i>
                        Bantuan via WhatsApp
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- VISI & MISI --}}
<section class="section section-alt" id="visi">
    <div class="wrap">
        <div class="visi-grid">
            <div>
                <div class="sec-label"><i class="bi bi-flag"></i> Visi &amp; Misi</div>
                <h2 class="sec-title">Mewujudkan Pemerintahan yang Transparan dan Efisien</h2>
                <p class="sec-sub">
                    Sambong Online hadir sebagai wujud komitmen Kelurahan Sambong dalam memberikan
                    pelayanan publik yang modern, terbuka, dan berorientasi pada kemudahan warga.
                </p>
            </div>
            <div class="visi-list">
                <div class="visi-item">
                    <div class="visi-dot"><i class="bi bi-check-lg"></i></div>
                    <div class="visi-text">
                        <strong>Pelayanan Mudah &amp; Cepat</strong>
                        Warga dapat mengajukan permohonan surat dari mana saja tanpa harus datang ke kantor terlebih dahulu.
                    </div>
                </div>
                <div class="visi-item">
                    <div class="visi-dot"><i class="bi bi-check-lg"></i></div>
                    <div class="visi-text">
                        <strong>Transparansi Proses</strong>
                        Status permohonan dapat dipantau secara real-time oleh warga melalui portal ini.
                    </div>
                </div>
                <div class="visi-item">
                    <div class="visi-dot"><i class="bi bi-check-lg"></i></div>
                    <div class="visi-text">
                        <strong>Data Aman &amp; Terlindungi</strong>
                        Seluruh data warga dikelola dengan standar keamanan yang terstandarisasi pemerintah daerah.
                    </div>
                </div>
                <div class="visi-item">
                    <div class="visi-dot"><i class="bi bi-check-lg"></i></div>
                    <div class="visi-text">
                        <strong>Tanpa Biaya Administrasi</strong>
                        Semua layanan pengajuan surat pada platform ini sepenuhnya gratis untuk warga.
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- LAYANAN --}}
<section class="section" id="layanan">
    <div class="wrap">
        <div class="layanan-header">
            <div class="sec-label"><i class="bi bi-folder2-open"></i> Jenis Layanan</div>
            <h2 class="sec-title">Layanan Surat yang Tersedia</h2>
            <p class="sec-sub">Berbagai surat keterangan administrasi dapat diajukan secara online melalui portal ini.</p>
        </div>
        <div class="layanan-grid">
            <div class="svc">
                <div class="svc-icon"><i class="bi bi-shield-fill-check"></i></div>
                <div class="svc-name">Pengantar SKCK</div>
                <div class="svc-desc">Surat pengantar untuk pembuatan SKCK — syarat melamar kerja dan keperluan administratif lainnya.</div>
                <span class="svc-tag">Kepolisian</span>
            </div>
            <div class="svc">
                <div class="svc-icon"><i class="bi bi-shop"></i></div>
                <div class="svc-name">Surat Keterangan Usaha</div>
                <div class="svc-desc">Keterangan domisili usaha untuk keperluan perizinan, pembukaan rekening bisnis, dan legalitas usaha kecil.</div>
                <span class="svc-tag">Usaha</span>
            </div>
            <div class="svc">
                <div class="svc-icon"><i class="bi bi-person-vcard"></i></div>
                <div class="svc-name">Pengurusan KTP / KK</div>
                <div class="svc-desc">Surat pengantar administrasi kependudukan untuk pembuatan, penggantian, atau perubahan data KTP dan KK.</div>
                <span class="svc-tag">Kependudukan</span>
            </div>
            <div class="svc">
                <div class="svc-icon"><i class="bi bi-heart-pulse"></i></div>
                <div class="svc-name">Registrasi Kematian</div>
                <div class="svc-desc">Surat pengantar administrasi untuk pencatatan kematian dan pengurusan dokumen ahli waris.</div>
                <span class="svc-tag">Kependudukan</span>
            </div>
            <div class="svc">
                <div class="svc-icon"><i class="bi bi-file-earmark-text"></i></div>
                <div class="svc-name">Surat Keterangan Umum</div>
                <div class="svc-desc">Surat keterangan untuk beasiswa, melamar kerja, keperluan institusi pendidikan, dan lain-lain.</div>
                <span class="svc-tag">Umum</span>
            </div>
            <div class="svc">
                <div class="svc-icon"><i class="bi bi-journals"></i></div>
                <div class="svc-name">Layanan Lainnya</div>
                <div class="svc-desc">Surat pengantar dan keterangan lain sesuai kebutuhan administrasi warga. Konsultasikan ke petugas.</div>
                <span class="svc-tag">Lainnya</span>
            </div>
        </div>
    </div>
</section>

{{-- ALUR --}}
<section class="section section-alt" id="alur">
    <div class="wrap">
        <div class="sec-label"><i class="bi bi-diagram-3"></i> Alur Pengajuan</div>
        <h2 class="sec-title">Alur Pengajuan Surat (Sederhana)</h2>
        <p class="sec-sub">Ikuti langkah-langkah berikut untuk mengajukan surat keterangan secara online.</p>

        {{-- Desktop --}}
        <div class="alur-desktop">
            <div class="alur-step">
                <div class="alur-num">1</div>
                <div class="alur-icon"><i class="bi bi-person-plus"></i></div>
                <div class="alur-title">Daftar / Login</div>
                <div class="alur-desc">Buat akun dengan NIK atau masuk jika sudah terdaftar.</div>
            </div>
            <div class="alur-step">
                <div class="alur-num">2</div>
                <div class="alur-icon"><i class="bi bi-card-checklist"></i></div>
                <div class="alur-title">Pilih Layanan</div>
                <div class="alur-desc">Pilih jenis surat yang diperlukan dari daftar layanan.</div>
            </div>
            <div class="alur-step">
                <div class="alur-num">3</div>
                <div class="alur-icon"><i class="bi bi-cloud-upload"></i></div>
                <div class="alur-title">Unggah Dokumen</div>
                <div class="alur-desc">Lengkapi formulir dan unggah dokumen persyaratan.</div>
            </div>
            <div class="alur-step">
                <div class="alur-num">4</div>
                <div class="alur-icon"><i class="bi bi-person-gear"></i></div>
                <div class="alur-title">Verifikasi Petugas</div>
                <div class="alur-desc">Admin kelurahan memverifikasi dan memproses permohonan.</div>
            </div>
            <div class="alur-step">
                <div class="alur-num">5</div>
                <div class="alur-icon"><i class="bi bi-file-earmark-check"></i></div>
                <div class="alur-title">Surat Terbit</div>
                <div class="alur-desc">Surat siap, Anda mendapat notifikasi untuk pengambilan.</div>
            </div>
        </div>

        {{-- Mobile --}}
        <div class="alur-mobile">
            <div class="alur-m-step">
                <div class="alur-m-num">1</div>
                <div class="alur-m-body">
                    <div class="alur-m-title">Daftar / Login</div>
                    <div class="alur-m-desc">Buat akun dengan NIK atau masuk jika sudah terdaftar.</div>
                </div>
            </div>
            <div class="alur-m-step">
                <div class="alur-m-num">2</div>
                <div class="alur-m-body">
                    <div class="alur-m-title">Pilih Layanan</div>
                    <div class="alur-m-desc">Pilih jenis surat yang diperlukan dari daftar layanan.</div>
                </div>
            </div>
            <div class="alur-m-step">
                <div class="alur-m-num">3</div>
                <div class="alur-m-body">
                    <div class="alur-m-title">Unggah Dokumen</div>
                    <div class="alur-m-desc">Lengkapi formulir dan unggah dokumen persyaratan.</div>
                </div>
            </div>
            <div class="alur-m-step">
                <div class="alur-m-num">4</div>
                <div class="alur-m-body">
                    <div class="alur-m-title">Verifikasi Petugas</div>
                    <div class="alur-m-desc">Admin kelurahan memverifikasi dan memproses permohonan.</div>
                </div>
            </div>
            <div class="alur-m-step">
                <div class="alur-m-num">5</div>
                <div class="alur-m-body">
                    <div class="alur-m-title">Surat Terbit</div>
                    <div class="alur-m-desc">Surat siap, Anda mendapat notifikasi untuk pengambilan.</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- KONTAK --}}
<section class="section" id="kontak">
    <div class="wrap">
        <div class="sec-label"><i class="bi bi-headset"></i> Kontak &amp; Media Sosial</div>
        <h2 class="sec-title">Hubungi Kami</h2>
        <p class="sec-sub">Kami siap membantu warga. Kunjungi kantor atau hubungi lewat saluran berikut.</p>
        <div class="kontak-grid">
            <div class="kontak-items">
                <div class="kontak-item">
                    <div class="kontak-icon"><i class="bi bi-telephone-fill"></i></div>
                    <div>
                        <div class="kontak-label">Telepon</div>
                        <div class="kontak-val">(0285) 392211 / 0878-4383-6341</div>
                    </div>
                </div>
                <div class="kontak-item">
                    <div class="kontak-icon"><i class="bi bi-envelope-fill"></i></div>
                    <div>
                        <div class="kontak-label">Email</div>
                        <div class="kontak-val">kelurahan.sambong@batangkab.go.id</div>
                    </div>
                </div>
                <div class="kontak-item">
                    <div class="kontak-icon"><i class="bi bi-geo-alt-fill"></i></div>
                    <div>
                        <div class="kontak-label">Alamat</div>
                        <div class="kontak-val">Jl. Raya Sambong, Batang, Jawa Tengah</div>
                    </div>
                </div>
                <div class="kontak-item">
                    <div class="kontak-icon"><i class="bi bi-clock-fill"></i></div>
                    <div>
                        <div class="kontak-label">Jam Operasional</div>
                        <div class="kontak-val">Senin – Jumat, 08.00 – 15.30 WIB</div>
                    </div>
                </div>
            </div>
            <div class="kontak-right">
                <a href="https://wa.me/6287843836341" target="_blank" class="wa-btn">
                    <div class="wa-btn-icon"><i class="bi bi-whatsapp"></i></div>
                    <div class="wa-btn-text">
                        <strong>Chat WhatsApp CS</strong>
                        <span>Respons cepat di jam kerja</span>
                    </div>
                    <i class="bi bi-chevron-right wa-arrow"></i>
                </a>
                <div>
                    <div class="medsos-label">Media Sosial Resmi</div>
                    <div class="medsos-grid">
                        <a href="#" class="medsos-item">
                            <i class="bi bi-facebook" style="color:#1877f2;"></i>
                            <div class="medsos-text"><strong>Facebook</strong><span>@KelSambong</span></div>
                        </a>
                        <a href="#" class="medsos-item">
                            <i class="bi bi-instagram" style="color:#e1306c;"></i>
                            <div class="medsos-text"><strong>Instagram</strong><span>@KelSambong</span></div>
                        </a>
                        <a href="#" class="medsos-item">
                            <i class="bi bi-youtube" style="color:#ff0000;"></i>
                            <div class="medsos-text"><strong>YouTube</strong><span>Kel. Sambong</span></div>
                        </a>
                        <a href="#" class="medsos-item">
                            <i class="bi bi-globe" style="color:var(--green);"></i>
                            <div class="medsos-text"><strong>Website</strong><span>batangkab.go.id</span></div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- FOOTER --}}
<footer class="footer">
    <div class="footer-wrap">
        <div class="footer-brand">
            <img src="https://upload.wikimedia.org/wikipedia/commons/3/3d/Logo_Kabupaten_Batang.png" alt="Logo" class="footer-logo">
            <span class="footer-copy">&copy; {{ date('Y') }} Kelurahan Sambong &mdash; Kabupaten Batang, Jawa Tengah</span>
        </div>
        <div class="footer-links">
            <a href="#visi">Visi &amp; Misi</a>
            <a href="#layanan">Layanan</a>
            <a href="#alur">Alur</a>
            <a href="#kontak">Kontak</a>
        </div>
    </div>
</footer>

<script>
    const toggle = document.getElementById('navToggle');
    const menu   = document.getElementById('mobileMenu');
    toggle.addEventListener('click', () => {
        menu.classList.toggle('open');
        toggle.querySelector('i').className =
            menu.classList.contains('open') ? 'bi bi-x-lg' : 'bi bi-list';
    });
    menu.querySelectorAll('a[href^="#"]').forEach(a => {
        a.addEventListener('click', () => {
            menu.classList.remove('open');
            toggle.querySelector('i').className = 'bi bi-list';
        });
    });
</script>

@endsection