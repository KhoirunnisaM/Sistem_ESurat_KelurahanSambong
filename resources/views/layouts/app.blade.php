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
        body { font-family: 'Inter', sans-serif; background-color: #f4f7f6; }
        .nav-link { font-weight: 500; transition: 0.3s; }
        .nav-link:hover { color: #198754 !important; }
        .dropdown-menu { border-radius: 12px; margin-top: 10px !important; }
        .icon-shape { width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; }
        .hover-shadow:hover { background-color: #f8fffb; border-color: #198754 !important; transform: translateY(-3px); box-shadow: 0 5px 15px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top py-3">
        <div class="container">
            <a class="navbar-brand fw-bold text-success" href="{{ url('/') }}">
                <i class="bi bi-shield-check-fill me-2"></i>SAMBONG ONLINE
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                @if(session()->has('warga_logged_in'))
                    <ul class="navbar-nav mx-auto">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->is('dashboard') ? 'text-success fw-bold' : '' }}" href="{{ route('warga.dashboard') }}">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#pilihSuratModal">Buat Surat</a>
                        </li>
                    </ul>
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle border rounded-pill px-3 shadow-sm" href="#" id="userDrop" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i> {{ session('nama') }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end shadow border-0 p-2">
                                <li>
                                    <form action="{{ route('logout.warga') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger rounded-3 py-2">
                                            <i class="bi bi-box-arrow-left me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    </ul>
                @endif
            </div>
        </div>
    </nav>

    @yield('content')

    @if(session()->has('warga_logged_in'))
    <div class="modal fade" id="pilihSuratModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                <div class="modal-header border-0 p-4 pb-0">
                    <h5 class="modal-title fw-bold"><i class="bi bi-grid-fill me-2 text-success"></i> Pilih Jenis Surat</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <div class="row g-3">
                        @php
                            $surats = [
                                ['icon' => 'bi-file-earmark-person', 'title' => 'Pengantar SKCK', 'slug' => 'skck'],
                                ['icon' => 'bi-envelope', 'title' => 'Pengantar Umum', 'slug' => 'pengantar-umum'],
                                ['icon' => 'bi-envelope-paper', 'title' => 'Keterangan Umum', 'slug' => 'keterangan-umum'],
                                ['icon' => 'bi-shop', 'title' => 'Keterangan Usaha', 'slug' => 'keterangan-usaha'],
                                ['icon' => 'bi-wallet2', 'title' => 'Tidak Mampu (SKTM)', 'slug' => 'keterangan-tidak-mampu'],
                                ['icon' => 'bi-building-up', 'title' => 'Domisili Usaha', 'slug' => 'domisili-usaha'],
                                ['icon' => 'bi-house-heart', 'title' => 'Domisili Tinggal', 'slug' => 'domisili-tempat-tinggal'],
                            ];
                        @endphp
                        @foreach($surats as $s)
                        <div class="col-md-6 col-lg-4">
                            <a href="{{ route('surat.buat', $s['slug']) }}" class="text-decoration-none">
                                <div class="card h-100 border p-3 text-center hover-shadow transition-all" style="border-radius: 15px;">
                                    <div class="icon-shape bg-light-success text-success mx-auto mb-2 rounded-3">
                                        <i class="bi {{ $s['icon'] }} fs-4"></i>
                                    </div>
                                    <h6 class="fw-bold text-dark mb-0" style="font-size: 0.85rem;">{{ $s['title'] }}</h6>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>