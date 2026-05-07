<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel - E-Surat Sambong</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <style>
        :root {
            --sidebar-bg: #1a1d21;
            --sidebar-color: #ced4da;
            --primary-green: #198754;
            --body-bg: #f4f7f6;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--body-bg);
            overflow-x: hidden;
        }

        #wrapper { display: flex; width: 100%; align-items: stretch; }

        /* Sidebar Styling */
        #sidebar-wrapper {
            min-height: 100vh;
            width: 250px;
            background-color: var(--sidebar-bg);
            transition: all .25s ease-out;
            position: fixed;
            z-index: 1000;
        }

        #sidebar-wrapper .sidebar-heading {
            padding: 1.5rem 1.25rem;
            font-size: 1.2rem;
            border-bottom: 1px solid #2d3238;
        }

        #sidebar-wrapper .list-group-item {
            background-color: transparent;
            color: var(--sidebar-color);
            border: none;
            padding: 0.75rem 1.25rem;
            transition: all 0.3s;
            cursor: pointer;
            display: flex;
            align-items: center;
            text-decoration: none;
        }

        #sidebar-wrapper .list-group-item:hover,
        #sidebar-wrapper .list-group-item.active {
            background-color: rgba(255,255,255,0.05);
            color: #fff;
            border-left: 4px solid var(--primary-green);
        }

        #sidebar-wrapper .list-group-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
        }

        /* Main Content Styling */
        #page-content-wrapper {
            margin-left: 250px;
            width: calc(100% - 250px);
            transition: all .25s ease-out;
            min-height: 100vh;
        }

        .navbar-admin {
            background-color: #fff;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            padding: 0.75rem 1.5rem;
            position: sticky;
            top: 0;
            z-index: 999;
        }

        #wrapper.toggled #sidebar-wrapper { margin-left: -250px; }
        #wrapper.toggled #page-content-wrapper { margin-left: 0; width: 100%; }

        @media (max-width: 768px) {
            #sidebar-wrapper { margin-left: -250px; }
            #page-content-wrapper { margin-left: 0; width: 100%; }
            #wrapper.toggled #sidebar-wrapper { margin-left: 0; }
        }

        /* Custom scrollbar for sidebar */
        #sidebar-wrapper::-webkit-scrollbar { width: 5px; }
        #sidebar-wrapper::-webkit-scrollbar-thumb { background: #333; }
    </style>
    @yield('styles')
</head>
<body>

<div class="d-flex" id="wrapper">
    <div id="sidebar-wrapper">
        <div class="sidebar-heading fw-bold text-success text-center">
            <i class="bi bi-shield-check-fill me-2"></i>E-Surat Admin
        </div>
        <div class="list-group list-group-flush mt-3">
            <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Dashboard
            </a>

            <a href="{{ route('admin.surat.masuk', ['filter' => 'masuk']) }}" class="list-group-item list-group-item-action {{ request('filter') == 'masuk' ? 'active' : '' }}">
                <i class="bi bi-envelope-exclamation"></i> Surat Masuk
            </a>

            <a href="{{ route('admin.surat.riwayat', ['filter' => 'riwayat']) }}" class="list-group-item list-group-item-action {{ request('filter') == 'riwayat' ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat Surat
            </a>
            
            <div class="text-muted small px-3 mt-4 mb-2 text-uppercase" style="font-size: 0.7rem; letter-spacing: 1px;">Manajemen Data</div>
            
            <a href="{{ route('admin.pegawai.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.pegawai.index') ? 'active' : '' }}">
                <i class="bi bi-people"></i> Data Pegawai & Staff
            </a>

            <a href="{{ route('admin.warga.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.warga.*') ? 'active' : '' }}">
                <i class="bi bi-person-badge"></i> Data Warga
            </a>

            <a href="{{ route('admin.setting.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.setting.*') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-medical"></i> Template Surat
            </a>

            <a href="{{ route('admin.pengumuman.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.pengumuman.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone"></i> Pengumuman
            </a>
        </div>
    </div>

    <div id="page-content-wrapper">
        <nav class="navbar navbar-expand-lg navbar-admin navbar-light">
            <div class="container-fluid p-0">
                <button class="btn btn-sm btn-light border no-print" id="menu-toggle">
                    <i class="bi bi-justify"></i>
                </button>
                
                <div class="ms-auto d-flex align-items-center">
                    <div class="text-muted small me-3 d-none d-md-block" id="current-date"></div>
                    <div class="dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center fw-medium text-dark" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle fs-5 text-success me-2"></i>
                            {{ auth()->guard('admin')->user()->username ?? 'Admin' }}
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

        <div class="container-fluid p-4 p-md-5">
            @if(session('success'))
                <div class="alert alert-success border-0 shadow-sm mb-4 alert-dismissible fade show">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
            
            @yield('admin_content')
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Toggle Sidebar
    document.getElementById("menu-toggle").onclick = function(e) {
        e.preventDefault();
        document.getElementById("wrapper").classList.toggle("toggled");
    };

    // Tanggal Hari Ini
    const dateOptions = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
    document.getElementById('current-date').innerText = new Date().toLocaleDateString('id-ID', dateOptions);
</script>
@yield('scripts')
</html>
</body>