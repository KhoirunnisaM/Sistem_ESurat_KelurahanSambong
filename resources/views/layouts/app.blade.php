<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sambong Online - Kelurahan Sambong</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; color: #333; }
        .navbar { background-color: #ffffff; border-bottom: 1px solid #eef0f2; }
        .nav-link { font-weight: 500; color: #6c757d; transition: 0.3s; padding: 0.5rem 1rem !important; }
        .nav-link:hover, .nav-link.active { color: #198754 !important; }
        .nav-link.active { font-weight: 700; position: relative; }
        .nav-link.active::after { content: ''; position: absolute; bottom: 0; left: 1rem; right: 1rem; height: 3px; background: #198754; border-radius: 10px; }
        .dropdown-menu { border-radius: 12px; border: none; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        .btn-success { background-color: #198754; border: none; border-radius: 8px; }
        .btn-success:hover { background-color: #157347; }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="{{ route('warga.dashboard') }}">
                <i class="bi bi-shield-check-fill me-2"></i>SAMBONG ONLINE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @if(session()->has('warga_logged_in'))
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('warga.dashboard') ? 'active' : '' }}" href="{{ route('warga.dashboard') }}">Dashboard</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('warga.ajukan') ? 'active' : '' }}" href="{{ route('warga.ajukan') }}">Ajukan Surat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('warga.riwayat') ? 'active' : '' }}" href="{{ route('warga.riwayat') }}">Riwayat Surat</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('warga.profil') ? 'active' : '' }}" href="{{ route('warga.profil') }}">Profil Saya</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle border rounded-pill px-3 shadow-sm" href="#" id="userDrop" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ session('nama_lengkap') }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end p-2">
                                <li>
                                    <a class="dropdown-item rounded-3 py-2" href="{{ route('warga.profil') }}">
                                        <i class="bi bi-person me-2"></i> Lihat Profil
                                    </a>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form action="{{ route('logout.warga') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger rounded-3 py-2 w-100 text-start">
                                            <i class="bi bi-box-arrow-left me-2"></i> Keluar
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @else
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="btn btn-outline-success px-4 me-2" href="{{ route('login.warga') }}">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="btn btn-success px-4" href="{{ route('register.warga') }}">Daftar</a>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    <footer class="py-4 mt-5 text-center text-muted border-top bg-white">
        <small>&copy; 2026 Kelurahan Sambong - Sistem Pelayanan Surat Online</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>