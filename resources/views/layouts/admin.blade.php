<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - E-Surat Sambong</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --sidebar-bg: #1a1d21;
            --sidebar-color: #ced4da;
            --primary-green: #198754;
            --body-bg: #f4f7f6;
            --sidebar-w: clamp(240px, 18vw, 280px);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--body-bg);
            overflow-x: hidden;
            /* Font fleksibel: mengecil di mobile, membesar di desktop */
            font-size: clamp(0.875rem, 0.95vw, 1rem);
        }

        #wrapper { 
            display: flex; 
            width: 100%; 
            min-height: 100vh;
        }

        /* ─── SIDEBAR ─── */
        #sidebar-wrapper {
            width: var(--sidebar-w);
            background-color: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 1050;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(-100%); /* Default Tutup */
            display: flex;
            flex-direction: column;
        }

        body.toggled #sidebar-wrapper {
            transform: translateX(0);
        }

        #sidebar-wrapper .sidebar-heading {
            padding: clamp(1rem, 2vh, 1.5rem) 1.25rem;
            font-size: clamp(1rem, 1.2vw, 1.15rem);
            border-bottom: 1px solid #2d3238;
            color: #fff;
        }

        .menu-label {
            color: #6c757d;
            font-size: clamp(0.65rem, 0.7vw, 0.75rem);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding: 1.5rem 1.25rem 0.5rem;
        }

        #sidebar-wrapper .list-group-item {
            background-color: transparent;
            color: var(--sidebar-color);
            border: none;
            padding: clamp(0.6rem, 1vh, 0.75rem) 1.25rem;
            transition: 0.2s;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-size: clamp(0.85rem, 1vw, 0.9rem);
        }

        #sidebar-wrapper .list-group-item:hover,
        #sidebar-wrapper .list-group-item.active {
            background-color: rgba(255,255,255,0.05);
            color: #fff;
            border-left: 4px solid var(--primary-green);
        }

        #sidebar-wrapper .list-group-item i {
            margin-right: 12px;
            font-size: 1.1rem;
            width: 20px;
            text-align: center;
        }

        /* ─── CONTENT WRAPPER ─── */
        #page-content-wrapper {
            width: 100%;
            transition: padding-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            padding-left: 0;
            display: flex;
            flex-direction: column;
        }

        @media (min-width: 992px) {
            body.toggled #page-content-wrapper {
                padding-left: var(--sidebar-w);
            }
        }

        .navbar-admin {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 0.5rem clamp(1rem, 2vw, 1.5rem);
            height: clamp(60px, 8vh, 70px);
            position: sticky;
            top: 0;
            z-index: 1000;
            display: flex;
            align-items: center;
        }

        .admin-main {
            padding: clamp(1rem, 3vw, 2.5rem);
            flex: 1;
        }

        /* ─── OVERLAY ─── */
        .sidebar-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.4);
            z-index: 1040; display: none; backdrop-filter: blur(2px);
        }
        
        @media (max-width: 991px) {
            body.toggled .sidebar-overlay { display: block; }
        }

        #sidebar-wrapper::-webkit-scrollbar { width: 4px; }
        #sidebar-wrapper::-webkit-scrollbar-thumb { background: #333; }
        
        @media print { .no-print { display: none !important; } }
    </style>
    @yield('styles')
</head>
<body>

<div class="sidebar-overlay" id="overlay" onclick="toggleSidebar()"></div>

<div id="wrapper">
    <aside id="sidebar-wrapper">
        <div class="sidebar-heading fw-bold text-success text-center">
            <i class="bi bi-shield-check-fill me-2"></i>E-Surat Admin
        </div>
        
        <div class="list-group list-group-flush overflow-auto">
            <div class="menu-label">Menu Utama</div>
            <a href="{{ route('admin.dashboard') }}" class="nav-item-link list-group-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>
            <a href="{{ route('admin.surat.masuk', ['filter' => 'masuk']) }}" class="nav-item-link list-group-item {{ request('filter') == 'masuk' ? 'active' : '' }}">
                <i class="bi bi-envelope-exclamation"></i> Surat Masuk
            </a>
            <a href="{{ route('admin.surat.riwayat', ['filter' => 'riwayat']) }}" class="nav-item-link list-group-item {{ request('filter') == 'riwayat' ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat Surat
            </a>

            <div class="menu-label">Manajemen Data</div>
            <a href="{{ route('admin.pegawai.index') }}" class="nav-item-link list-group-item {{ request()->routeIs('admin.pegawai.index') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Pegawai & Staff
            </a>
            <a href="{{ route('admin.warga.index') }}" class="nav-item-link list-group-item {{ request()->routeIs('admin.warga.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i> Data Warga
            </a>

            <div class="menu-label">Informasi & Setelan</div>
            <a href="{{ route('admin.pengumuman.index') }}" class="nav-item-link list-group-item {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone"></i> Pengumuman
            </a>
            <a href="{{ route('admin.setting.index') }}" class="nav-item-link list-group-item {{ request()->routeIs('admin.setting.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-medical"></i> Template Surat
            </a>
        </div>
    </aside>

    <div id="page-content-wrapper">
        <nav class="navbar navbar-admin no-print">
            <div class="container-fluid p-0 d-flex align-items-center">
                <button class="btn btn-sm btn-light border px-2 px-md-3" id="menu-toggle" onclick="toggleSidebar()">
                    <i class="bi bi-justify fs-5"></i>
                </button>
                
                <div class="ms-auto d-flex align-items-center">
                    <div class="text-muted small me-3 d-none d-lg-block" id="current-date"></div>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center fw-medium text-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5 text-success me-2"></i>
                            <span class="d-none d-sm-inline">{{ auth()->guard('admin')->user()->username ?? 'Admin' }}</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end border-0 shadow mt-2">
                            <li>
                                <form action="{{ route('admin.logout') }}" method="POST">
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

        <main class="admin-main">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4 alert-dismissible fade show">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('admin_content')
        </main>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Fungsi Toggle Sidebar
    function toggleSidebar() {
        document.body.classList.toggle('toggled');
    }

    // Mengisi Tanggal Hari Ini
    function updateDate() {
        const options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        const today = new Date();
        const dateElem = document.getElementById('current-date');
        if(dateElem) dateElem.innerText = today.toLocaleDateString('id-ID', options);
    }

    updateDate();
</script>
@yield('scripts')
</body>
</html>