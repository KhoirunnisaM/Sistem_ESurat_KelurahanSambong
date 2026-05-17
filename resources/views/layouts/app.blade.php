<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Mandiri - Kelurahan Sambong</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">

    <style>
    :root {
        --active-green: #1e4d3a;
        --soft-green: #e8f0ed;
        /* Lebar sidebar sedikit dinamis namun terkunci di batas aman */
        --sidebar-w: clamp(240px, 18vw, 280px); 
        --sidebar-bg: #ffffff;
    }

    body { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        background: #f8fafc; 
        overflow-x: hidden;
        /* Mengatur base font agar mengecil di mobile dan membesar di desktop */
        font-size: clamp(0.875rem, 1vw, 1rem);
    }

    /* ─── SIDEBAR ─── */
    .sidebar {
        width: var(--sidebar-w);
        background: var(--sidebar-bg);
        position: fixed;
        top: 0; 
        left: 0; 
        bottom: 0;
        z-index: 1050;
        display: flex;
        flex-direction: column;
        padding: clamp(1rem, 2vw, 1.5rem);
        border-right: 1px solid #e2e8f0;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        transform: translateX(-100%);
    }

    /* ─── CONTENT WRAPPER ─── */
    #page-content-wrapper {
        width: 100%;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        padding-left: 0;
    }

    /* LOGIC SIDEBAR */
    body.sidebar-open .sidebar { 
        transform: translateX(0); 
    }

    @media (min-width: 992px) {
        body.sidebar-open #page-content-wrapper {
            padding-left: var(--sidebar-w);
        }
    }

    /* ─── NAVBAR & MAIN ─── */
    .navbar-admin {
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        padding: 0.5rem clamp(1rem, 3vw, 2rem);
        /* Tinggi navbar menyesuaikan layar */
        height: clamp(60px, 8vh, 75px);
        position: sticky;
        top: 0;
        z-index: 1000;
    }

    .app-main { 
        padding: clamp(1rem, 3vw, 2rem); 
        flex: 1;
    }

    /* ─── SIDEBAR BRAND (Logo & Nama) ─── */
    .sidebar-brand {
        display: flex; align-items: center; gap: 12px; margin-bottom: clamp(1.5rem, 4vh, 2.5rem);
    }
    .sidebar-brand img { width: clamp(32px, 4vw, 40px); }
    .sidebar-brand-text .name { 
        font-size: clamp(1rem, 1.5vw, 1.15rem); 
        font-weight: 700; color: #1e4d3a; line-height: 1; 
    }
    .sidebar-brand-text .sub { 
        font-size: clamp(0.6rem, 0.8vw, 0.7rem); 
        font-weight: 600; letter-spacing: 1px; color: #64748b; 
    }

    /* ─── NAV ITEM (Menu) ─── */
    .sidebar-label {
        font-size: clamp(0.6rem, 0.7vw, 0.7rem); 
        font-weight: 700; text-transform: uppercase;
        color: #94a3b8; margin: 1.25rem 0 0.5rem 0.5rem; letter-spacing: 0.5px;
    }

    .nav-item-link {
        display: flex; align-items: center; gap: 12px;
        padding: clamp(0.6rem, 1.2vh, 0.75rem) 1rem; 
        border-radius: 10px;
        font-size: clamp(0.85rem, 1vw, 0.9rem); 
        font-weight: 500; color: #475569;
        text-decoration: none; transition: all 0.2s; margin-bottom: 4px;
    }

    .nav-item-link.active {
        background: var(--active-green);
        color: #ffffff !important;
        box-shadow: 0 4px 12px rgba(30, 77, 58, 0.15);
    }

    .nav-item-link:hover:not(.active) { background: #f1f5f9; color: var(--active-green); }

    /* ─── OVERLAY & UTILS ─── */
    .sidebar-overlay {
        position: fixed; inset: 0; background: rgba(0,0,0,0.3);
        z-index: 1040; display: none; backdrop-filter: blur(2px);
    }
    
    @media (max-width: 991px) {
        body.sidebar-open .sidebar-overlay { display: block; }
        
        /* Dropdown nama user di mobile agar tidak terlalu lebar */
        #navbarDropdown {
            font-size: 0.85rem;
            max-width: 160px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
    }

    @media print { .no-print { display: none !important; } }
    </style>
</head>
<body> 
@if(session()->has('warga_logged_in') || true)
    <div class="sidebar-overlay" id="overlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <img src="{{ asset('storage/img/logo_batang.png') }}" alt="Logo">
            <div class="sidebar-brand-text">
                <div class="name">LAMAN SURAT</div>
                <div class="sub">SAMBONG</div>
            </div>
        </div>

        <div class="sidebar-label">Menu Utama</div>
        <a href="{{ route('warga.dashboard') }}" class="nav-item-link {{ request()->routeIs('warga.dashboard') ? 'active' : '' }}">
            <i class="bi bi-house-door"></i> Dashboard
        </a>
        <a href="{{ route('warga.ajukan') }}" class="nav-item-link {{ request()->routeIs('warga.ajukan') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-plus"></i> Ajukan Surat
        </a>
        <a href="{{ route('warga.riwayat') }}" class="nav-item-link {{ request()->routeIs('warga.riwayat') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i> Riwayat Anda
        </a>

        <div class="sidebar-label">Informasi</div>
        <a href="{{ route('warga.pengumuman.index') }}" class="nav-item-link {{ request()->routeIs('warga.pengumuman.*') ? 'active' : '' }}">
            <i class="bi bi-megaphone"></i> Pengumuman
        </a>

        <div class="sidebar-label">Pengaturan</div>
        <a href="{{ route('warga.profil') }}" class="nav-item-link {{ request()->routeIs('warga.profil') ? 'active' : '' }}">
            <i class="bi bi-person-gear"></i> Profil Saya
        </a>
    </aside>

    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-admin navbar-light no-print">
            <div class="container-fluid p-0">
                <button class="btn btn-sm btn-light border px-2 px-md-3" id="menu-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-justify"></i>
                </button>
                
                <div class="ms-auto d-flex align-items-center">
                    <div class="text-muted small me-3 d-none d-md-block" id="current-date"></div>
                    
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center fw-medium text-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <span class="d-inline-block me-1">{{ session('nama_lengkap') ?? 'Nama Warga' }}</span>
                            <i class="bi bi-person-circle fs-5 text-success me-2"></i>

                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-2">
                            <li><a class="dropdown-item py-2" href="{{ route('warga.profil') }}"><i class="bi bi-person me-2"></i> Profil Saya</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout.warga') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item py-2 text-danger">
                                        <i class="bi bi-box-arrow-right me-2"></i>Logout
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>

        <main class="app-main">
            @yield('content')
        </main>
    </div>

@else
    <div class="container py-5">
        @yield('content')
    </div>
@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Fungsi Toggle Sidebar
    function toggleSidebar() {
        document.body.classList.toggle('sidebar-open');
    }

    // Mengisi Tanggal di Navbar
    function updateDate() {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const today = new Date();
        const dateString = today.toLocaleDateString('id-ID', options);
        const dateElem = document.getElementById('current-date');
        if(dateElem) dateElem.innerText = dateString;
    }

    updateDate();
</script>
@stack('scripts')
</body>
</html>