@extends('layouts.app')

@section('content')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Lora:ital@0;1&display=swap" rel="stylesheet">

<style>
    *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

    :root {
        --green-900: #0a2e1a;
        --green-800: #113d23;
        --green-700: #1a5c35;
        --green-600: #1f7a45;
        --green-500: #259554;
        --green-400: #3db870;
        --green-100: #d4f0e1;
        --green-50:  #edf9f2;
        --gold-500:  #d4960a;
        --gold-400:  #f0ac12;
        --gold-300:  #f7c948;
        --gold-100:  #fef3d0;
        --slate-900: #0f172a;
        --slate-700: #334155;
        --slate-500: #64748b;
        --slate-300: #cbd5e1;
        --slate-100: #f1f5f9;
        --slate-50:  #f8fafc;
        --white:     #ffffff;
        --shadow-sm: 0 1px 3px rgba(0,0,0,0.08);
        --shadow-md: 0 4px 16px rgba(0,0,0,0.10);
        --shadow-lg: 0 12px 40px rgba(0,0,0,0.13);
        --radius-sm: 8px;
        --radius-md: 14px;
        --radius-lg: 22px;
        --font-main: 'Plus Jakarta Sans', sans-serif;
        --font-serif: 'Lora', serif;
    }

    body { font-family: var(--font-main); color: var(--slate-900); background: var(--white); }
    a { text-decoration: none; color: inherit; }

    /* ── TOPBAR ── */
    .sb-topbar {
        background: var(--green-900);
        padding: 10px 0;
        border-bottom: 1px solid var(--green-800);
    }
    .sb-topbar-inner {
        max-width: 1100px;
        margin: auto;
        padding: 0 20px;
        display: flex;
        align-items: center;
        gap: 12px;
    }
    .sb-topbar-logo {
        height: 36px;
        width: 36px;
        object-fit: contain;
        filter: brightness(0) invert(1);
        opacity: 0.85;
    }
    .sb-topbar-text { line-height: 1.2; }
    .sb-topbar-text strong {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: var(--white);
        letter-spacing: 0.05em;
        text-transform: uppercase;
    }
    .sb-topbar-text span {
        font-size: 11px;
        color: rgba(255,255,255,0.5);
    }
    .sb-topbar-badge {
        margin-left: auto;
        background: var(--gold-400);
        color: var(--green-900);
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.07em;
        text-transform: uppercase;
        padding: 4px 10px;
        border-radius: 100px;
    }

    /* ── HERO ── */
    .sb-hero {
        background: linear-gradient(155deg, var(--green-900) 0%, var(--green-700) 60%, var(--green-600) 100%);
        position: relative;
        overflow: hidden;
        padding: 64px 20px 80px;
    }
    .sb-hero::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image:
            radial-gradient(circle at 80% 15%, rgba(255,255,255,0.04) 0%, transparent 50%),
            radial-gradient(circle at 5% 85%, rgba(255,255,255,0.03) 0%, transparent 45%);
        pointer-events: none;
    }
    .sb-hero-grid-overlay {
        position: absolute;
        inset: 0;
        background-image:
            linear-gradient(rgba(255,255,255,0.025) 1px, transparent 1px),
            linear-gradient(90deg, rgba(255,255,255,0.025) 1px, transparent 1px);
        background-size: 44px 44px;
        pointer-events: none;
    }
    .sb-hero-inner {
        max-width: 1100px;
        margin: auto;
        display: grid;
        grid-template-columns: 1fr 340px;
        gap: 48px;
        align-items: center;
        position: relative;
        z-index: 2;
    }
    .sb-hero-eyebrow {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: rgba(255,255,255,0.09);
        border: 1px solid rgba(255,255,255,0.14);
        color: var(--gold-300);
        font-size: 11.5px;
        font-weight: 600;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 6px 14px;
        border-radius: 100px;
        margin-bottom: 22px;
    }
    .sb-hero-eyebrow i { font-size: 13px; }
    .sb-hero-title {
        font-family: var(--font-serif);
        font-size: clamp(28px, 5vw, 48px);
        font-weight: 700;
        color: var(--white);
        line-height: 1.22;
        margin-bottom: 16px;
    }
    .sb-hero-title em {
        font-style: italic;
        color: var(--gold-300);
    }
    .sb-hero-desc {
        font-size: 15px;
        color: rgba(255,255,255,0.62);
        line-height: 1.78;
        max-width: 520px;
        margin-bottom: 38px;
    }

    /* ── FLOW STEPS ── */
    .sb-steps {
        display: flex;
        align-items: flex-start;
        gap: 0;
    }
    .sb-step {
        display: flex;
        align-items: center;
        flex: 1;
    }
    .sb-step-content { text-align: center; flex: 1; }
    .sb-step-num {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        background: rgba(255,255,255,0.10);
        border: 1.5px solid rgba(255,255,255,0.22);
        color: var(--gold-300);
        font-size: 13px;
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 8px;
    }
    .sb-step-label {
        font-size: 11px;
        color: rgba(255,255,255,0.55);
        font-weight: 600;
        letter-spacing: 0.02em;
    }
    .sb-step-connector {
        height: 1.5px;
        flex: 0 0 28px;
        background: rgba(255,255,255,0.18);
        margin-top: -22px;
    }

    /* ── LOGIN CARD ── */
    .sb-card {
        background: var(--white);
        border-radius: var(--radius-lg);
        box-shadow: var(--shadow-lg);
        padding: 36px 30px 32px;
        position: relative;
        overflow: hidden;
    }
    .sb-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--green-500), var(--gold-400));
    }
    .sb-card-icon {
        width: 52px;
        height: 52px;
        border-radius: var(--radius-sm);
        background: var(--green-50);
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 18px;
    }
    .sb-card-icon i { font-size: 26px; color: var(--green-600); }
    .sb-card-title {
        font-size: 18px;
        font-weight: 700;
        color: var(--slate-900);
        text-align: center;
        margin-bottom: 6px;
    }
    .sb-card-sub {
        font-size: 12.5px;
        color: var(--slate-500);
        text-align: center;
        margin-bottom: 26px;
        line-height: 1.6;
    }
    .sb-divider {
        height: 1px;
        background: var(--slate-100);
        margin-bottom: 24px;
    }

    /* ── BUTTONS ── */
    .btn-primary {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        width: 100%;
        padding: 15px 20px;
        border-radius: var(--radius-md);
        background: linear-gradient(135deg, var(--green-600) 0%, var(--green-800) 100%);
        color: var(--white);
        font-size: 14px;
        font-weight: 700;
        letter-spacing: 0.04em;
        transition: all 0.25s ease;
        border: none;
        cursor: pointer;
        box-shadow: 0 4px 14px rgba(31,122,69,0.32);
    }
    .btn-primary:hover {
        box-shadow: 0 7px 22px rgba(31,122,69,0.45);
        transform: translateY(-2px);
        color: var(--white);
    }
    .btn-primary i { font-size: 18px; }

    .btn-outline {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        width: 100%;
        padding: 13px 20px;
        border-radius: var(--radius-md);
        background: transparent;
        color: var(--slate-700);
        font-size: 13.5px;
        font-weight: 600;
        transition: all 0.22s ease;
        border: 1.5px solid var(--slate-300);
        cursor: pointer;
    }
    .btn-outline:hover {
        border-color: #25D366;
        color: #128C7E;
        background: #f0fdf4;
    }
    .btn-outline i { font-size: 17px; color: #25D366; }

    .btn-stack { display: flex; flex-direction: column; gap: 11px; }

    .card-register-link {
        text-align: center;
        margin-top: 20px;
        font-size: 13px;
        color: var(--slate-500);
    }
    .card-register-link a {
        color: var(--green-600);
        font-weight: 700;
    }
    .card-register-link a:hover { text-decoration: underline; }

    /* ── STATS BAR ── */
    .sb-stats {
        background: var(--green-900);
        padding: 38px 20px;
    }
    .sb-stats-inner {
        max-width: 900px;
        margin: auto;
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
        text-align: center;
    }
    .sb-stat-num {
        font-size: 30px;
        font-weight: 800;
        color: var(--gold-300);
        line-height: 1;
        margin-bottom: 7px;
        font-family: var(--font-serif);
    }
    .sb-stat-label {
        font-size: 11.5px;
        color: rgba(255,255,255,0.5);
        font-weight: 500;
        letter-spacing: 0.04em;
    }

    /* ── ABOUT ── */
    .sb-about {
        background: var(--white);
        padding: 72px 20px;
    }
    .sb-about-inner { max-width: 1100px; margin: auto; }

    .sb-section-tag {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: var(--green-50);
        color: var(--green-700);
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        padding: 5px 13px;
        border-radius: 100px;
        margin-bottom: 14px;
        border: 1px solid var(--green-100);
    }
    .sb-section-tag i { font-size: 13px; }
    .sb-section-title {
        font-family: var(--font-serif);
        font-size: clamp(22px, 3.5vw, 34px);
        font-weight: 700;
        color: var(--slate-900);
        line-height: 1.3;
        margin-bottom: 14px;
    }
    .sb-section-desc {
        font-size: 15px;
        color: var(--slate-500);
        line-height: 1.78;
        max-width: 560px;
    }
    .sb-features-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
        gap: 18px;
        margin-top: 48px;
    }
    .sb-feature-card {
        background: var(--slate-50);
        border: 1px solid var(--slate-100);
        border-radius: var(--radius-md);
        padding: 26px 22px;
        transition: all 0.25s ease;
    }
    .sb-feature-card:hover {
        border-color: var(--green-100);
        background: var(--green-50);
        transform: translateY(-3px);
        box-shadow: var(--shadow-md);
    }
    .sb-feature-icon {
        width: 44px;
        height: 44px;
        border-radius: var(--radius-sm);
        background: var(--green-100);
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 14px;
    }
    .sb-feature-icon i { font-size: 22px; color: var(--green-700); }
    .sb-feature-title {
        font-size: 14.5px;
        font-weight: 700;
        color: var(--slate-900);
        margin-bottom: 7px;
    }
    .sb-feature-desc {
        font-size: 13px;
        color: var(--slate-500);
        line-height: 1.65;
    }

    /* ── FOOTER ── */
    .sb-footer {
        background: var(--slate-50);
        border-top: 1px solid var(--slate-100);
        padding: 52px 20px 32px;
    }
    .sb-footer-inner {
        max-width: 1100px;
        margin: auto;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 48px;
        align-items: start;
    }
    .sb-footer-brand { display: flex; align-items: center; gap: 12px; margin-bottom: 14px; }
    .sb-footer-logo { height: 38px; width: 38px; object-fit: contain; }
    .sb-footer-brand-text strong { display: block; font-size: 13px; font-weight: 700; color: var(--slate-900); }
    .sb-footer-brand-text span { font-size: 11.5px; color: var(--slate-500); }
    .sb-footer-tagline { font-size: 13px; color: var(--slate-500); line-height: 1.7; max-width: 280px; }

    .sb-footer-contact h6 {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.09em;
        text-transform: uppercase;
        color: var(--green-700);
        margin-bottom: 16px;
    }
    .sb-contact-item {
        display: flex;
        align-items: flex-start;
        gap: 10px;
        margin-bottom: 12px;
    }
    .sb-contact-item i { font-size: 15px; color: var(--green-500); margin-top: 2px; flex-shrink: 0; }
    .sb-contact-item span { font-size: 13px; color: #475569; line-height: 1.55; }

    .sb-footer-bottom {
        max-width: 1100px;
        margin: 32px auto 0;
        padding-top: 20px;
        border-top: 1px solid var(--slate-100);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
    }
    .sb-footer-copy { font-size: 12px; color: var(--slate-500); }
    .sb-social-links { display: flex; gap: 8px; }
    .sb-social-link {
        width: 34px;
        height: 34px;
        border-radius: var(--radius-sm);
        background: var(--white);
        border: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--slate-500);
        font-size: 15px;
        transition: all 0.2s;
    }
    .sb-social-link:hover {
        border-color: var(--green-400);
        color: var(--green-600);
        background: var(--green-50);
    }

    /* ── RESPONSIVE MOBILE ── */
    @media (max-width: 768px) {
        .sb-hero { padding: 44px 18px 56px; }
        .sb-hero-inner {
            grid-template-columns: 1fr;
            gap: 30px;
        }
        .sb-steps { display: none; }
        .sb-hero-desc { max-width: 100%; }
        .sb-card { padding: 28px 20px 26px; }

        .sb-about { padding: 52px 18px; }
        .sb-features-grid { grid-template-columns: 1fr; gap: 14px; }

        .sb-stats-inner { gap: 8px; }
        .sb-stat-num { font-size: 22px; }
        .sb-stat-label { font-size: 10.5px; }

        .sb-footer-inner { grid-template-columns: 1fr; gap: 28px; }
        .sb-footer-bottom { flex-direction: column; align-items: flex-start; }
        .sb-topbar-badge { display: none; }
    }

    /* ── ANIMATIONS ── */
    @keyframes fadeInUp {
        from { opacity: 0; transform: translateY(18px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .sb-hero-left > * { animation: fadeInUp 0.55s ease both; }
    .sb-hero-left > *:nth-child(1) { animation-delay: 0.05s; }
    .sb-hero-left > *:nth-child(2) { animation-delay: 0.15s; }
    .sb-hero-left > *:nth-child(3) { animation-delay: 0.25s; }
    .sb-hero-left > *:nth-child(4) { animation-delay: 0.35s; }
    .sb-hero-right { animation: fadeInUp 0.55s ease 0.28s both; }
</style>

{{-- ── TOPBAR ── --}}
<div class="sb-topbar">
    <div class="sb-topbar-inner">
        <img src="https://upload.wikimedia.org/wikipedia/commons/3/3d/Logo_Kabupaten_Batang.png"
             alt="Logo Kabupaten Batang" class="sb-topbar-logo">
        <div class="sb-topbar-text">
            <strong>Kelurahan Sambong</strong>
            <span>Kabupaten Batang, Jawa Tengah</span>
        </div>
        <span class="sb-topbar-badge">Resmi</span>
    </div>
</div>

{{-- ── HERO ── --}}
<section class="sb-hero">
    <div class="sb-hero-grid-overlay"></div>
    <div class="sb-hero-inner">

        {{-- KIRI --}}
        <div class="sb-hero-left">
            <div class="sb-hero-eyebrow">
                <i class="bi bi-shield-check"></i>
                Layanan Administrasi Digital
            </div>

            <h1 class="sb-hero-title">
                Pelayanan Surat Online<br>
                Warga <em>Sambong.</em>
            </h1>

            <p class="sb-hero-desc">
                Urus surat keterangan administrasi secara mandiri — kapan saja, di mana saja.
                Cepat, aman, dan tanpa harus antre di kantor Kelurahan.
            </p>

            <div class="sb-steps">
                <div class="sb-step">
                    <div class="sb-step-content">
                        <div class="sb-step-num">1</div>
                        <div class="sb-step-label">Daftar Akun</div>
                    </div>
                </div>
                <div class="sb-step-connector"></div>
                <div class="sb-step">
                    <div class="sb-step-content">
                        <div class="sb-step-num">2</div>
                        <div class="sb-step-label">Ajukan Surat</div>
                    </div>
                </div>
                <div class="sb-step-connector"></div>
                <div class="sb-step">
                    <div class="sb-step-content">
                        <div class="sb-step-num">3</div>
                        <div class="sb-step-label">Admin Validasi</div>
                    </div>
                </div>
                <div class="sb-step-connector"></div>
                <div class="sb-step">
                    <div class="sb-step-content">
                        <div class="sb-step-num">4</div>
                        <div class="sb-step-label">Ambil Surat</div>
                    </div>
                </div>
            </div>
        </div>

        {{-- KANAN: CARD LOGIN --}}
        <div class="sb-hero-right">
            <div class="sb-card">
                <div class="sb-card-icon">
                    <i class="bi bi-person-vcard-fill"></i>
                </div>
                <div class="sb-card-title">Akses Layanan</div>
                <div class="sb-card-sub">
                    Masuk ke portal warga atau hubungi<br>kami untuk bantuan administrasi
                </div>
                <div class="sb-divider"></div>

                <div class="btn-stack">
                    <a href="{{ route('login.warga') }}" class="btn-primary">
                        <i class="bi bi-box-arrow-in-right"></i>
                        Login Warga
                    </a>
                    <a href="https://wa.me/6287843836341" target="_blank" class="btn-outline">
                        <i class="bi bi-whatsapp"></i>
                        Pengaduan &amp; Bantuan CS
                    </a>
                </div>

                <p class="card-register-link">
                    Belum punya akun?
                    <a href="{{ route('register.warga') }}">Daftar Sekarang</a>
                </p>
            </div>
        </div>

    </div>
</section>

{{-- ── STATS BAR ── --}}
<div class="sb-stats">
    <div class="sb-stats-inner">
        <div>
            <div class="sb-stat-num">24<span style="font-size:17px;opacity:.65">/7</span></div>
            <div class="sb-stat-label">Akses Kapan Saja</div>
        </div>
        <div>
            <div class="sb-stat-num">5+</div>
            <div class="sb-stat-label">Jenis Layanan Surat</div>
        </div>
        <div>
            <div class="sb-stat-num">100%</div>
            <div class="sb-stat-label">Tanpa Biaya Admin</div>
        </div>
    </div>
</div>

{{-- ── ABOUT ── --}}
<section class="sb-about">
    <div class="sb-about-inner">
        <div class="sb-section-tag">
            <i class="bi bi-info-circle"></i>
            Tentang Sistem
        </div>
        <h2 class="sb-section-title">
            Inovasi Pelayanan Publik<br>Kelurahan Sambong
        </h2>
        <p class="sb-section-desc">
            Sambong Online hadir untuk mempermudah warga dalam permohonan surat keterangan
            seperti SKCK, Domisili Usaha, hingga Surat Keterangan Umum — tanpa harus berulang
            kali datang ke kantor sebelum dokumen siap.
        </p>

        <div class="sb-features-grid">
            <div class="sb-feature-card">
                <div class="sb-feature-icon">
                    <i class="bi bi-phone"></i>
                </div>
                <div class="sb-feature-title">Mudah &amp; Praktis</div>
                <div class="sb-feature-desc">Ajukan permohonan surat langsung dari smartphone Anda kapan pun dan di mana pun.</div>
            </div>
            <div class="sb-feature-card">
                <div class="sb-feature-icon">
                    <i class="bi bi-shield-lock"></i>
                </div>
                <div class="sb-feature-title">Aman &amp; Terpercaya</div>
                <div class="sb-feature-desc">Data warga dilindungi dengan sistem keamanan yang terstandarisasi pemerintah daerah.</div>
            </div>
            <div class="sb-feature-card">
                <div class="sb-feature-icon">
                    <i class="bi bi-lightning-charge"></i>
                </div>
                <div class="sb-feature-title">Proses Cepat</div>
                <div class="sb-feature-desc">Pengajuan diproses admin kelurahan dengan notifikasi status secara real-time.</div>
            </div>
            <div class="sb-feature-card">
                <div class="sb-feature-icon">
                    <i class="bi bi-file-earmark-check"></i>
                </div>
                <div class="sb-feature-title">Berbagai Jenis Surat</div>
                <div class="sb-feature-desc">Tersedia layanan SKCK, Domisili Usaha, Surat Keterangan Umum, dan lainnya.</div>
            </div>
        </div>
    </div>
</section>

{{-- ── FOOTER ── --}}
<footer class="sb-footer">
    <div class="sb-footer-inner">
        <div>
            <div class="sb-footer-brand">
                <img src="https://upload.wikimedia.org/wikipedia/commons/3/3d/Logo_Kabupaten_Batang.png"
                     alt="Logo Batang" class="sb-footer-logo">
                <div class="sb-footer-brand-text">
                    <strong>Kelurahan Sambong</strong>
                    <span>Kabupaten Batang, Jawa Tengah</span>
                </div>
            </div>
            <p class="sb-footer-tagline">
                Melayani warga dengan sepenuh hati melalui inovasi digital yang terpercaya dan profesional.
            </p>
        </div>

        <div class="sb-footer-contact">
            <h6>Kontak Kami</h6>
            <div class="sb-contact-item">
                <i class="bi bi-telephone-fill"></i>
                <span>(0285) 392211 / 0878-4383-6341</span>
            </div>
            <div class="sb-contact-item">
                <i class="bi bi-envelope-fill"></i>
                <span>kelurahan.sambong@batangkab.go.id</span>
            </div>
            <div class="sb-contact-item">
                <i class="bi bi-geo-alt-fill"></i>
                <span>Jl. Raya Sambong, Batang,<br>Jawa Tengah</span>
            </div>
        </div>
    </div>

    <div class="sb-footer-bottom">
        <p class="sb-footer-copy">&copy; {{ date('Y') }} Kelurahan Sambong. All Rights Reserved.</p>
        <div class="sb-social-links">
            <a href="#" class="sb-social-link" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
            <a href="#" class="sb-social-link" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
            <a href="#" class="sb-social-link" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
            <a href="#" class="sb-social-link" aria-label="Website"><i class="bi bi-globe"></i></a>
        </div>
    </div>
</footer>

@endsection