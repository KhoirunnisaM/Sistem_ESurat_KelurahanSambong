<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Mandiri - Kelurahan Sambong</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;700&family=DM+Serif+Display&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        :root {
            --sidebar-w: 260px;
            --c-bg: #f7f8fa;
            --c-surface: #ffffff;
            --c-border: #e8eaed;
            --c-text-1: #111827;
            --c-text-2: #4b5563;
            --c-text-3: #9ca3af;
            --c-green-900: #0a2e1a;
            --c-green-100: #dcfce7;
            --c-accent: #16a34a;
            --c-accent-text: #166534;
            --r-md: 12px;
            --r-sm: 8px;
            --shadow-md: 0 4px 20px rgba(0,0,0,0.1);
        }

        body { font-family: 'DM Sans', sans-serif; background: var(--c-bg); overflow-x: hidden; }

        /* ─── SIDEBAR (DEFAULT TUTUP) ─── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--c-surface);
            border-right: 1px solid var(--c-border);
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            /* Efek Slide ke Kiri */
            transform: translateX(-100%); 
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* State ketika Sidebar Terbuka */
        .sidebar.open {
            transform: translateX(0);
        }

        .sidebar-brand {
            padding: 22px 20px;
            border-bottom: 1px solid var(--c-border);
            display: flex; align-items: center; gap: 10px;
        }

        .sidebar-brand-icon {
            width: 34px; height: 34px; border-radius: var(--r-sm);
            background: var(--c-green-900); display: flex; align-items: center; justify-content: center;
        }

        .sidebar-nav { flex: 1; padding: 16px 12px; overflow-y: auto; }
        .sidebar-section-label { font-size: 10px; font-weight: 700; text-transform: uppercase; color: var(--c-text-3); padding: 10px; }

        .nav-item-link {
            display: flex; align-items: center; gap: 12px;
            padding: 12px; border-radius: var(--r-md);
            font-size: 14px; font-weight: 500; color: var(--c-text-2);
            transition: all 0.2s; margin-bottom: 4px;
        }

        .nav-item-link:hover { background: var(--c-surface-2); color: var(--c-text-1); }
        .nav-item-link.active { background: #f0fdf4; color: var(--c-accent-text); font-weight: 600; }
        .nav-item-link i { font-size: 18px; width: 24px; text-align: center; }

        /* ─── APP CONTENT ─── */
        .app-content-wrapper {
            width: 100%;
            min-height: 100vh;
            transition: padding-left 0.3s ease; /* Transisi saat sidebar muncul */
        }

        /* Opsional: Di desktop, konten geser jika sidebar buka */
        @media (min-width: 992px) {
            .sidebar.open + .app-content-wrapper {
                padding-left: var(--sidebar-w);
            }
        }

        .app-topbar {
            height: 60px; background: #fff; border-bottom: 1px solid var(--c-border);
            display: flex; align-items: center; padding: 0 20px; sticky: top; z-index: 900;
        }

        .toggle-btn {
            background: none; border: 1px solid var(--c-border);
            border-radius: var(--r-sm); width: 38px; height: 38px;
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: var(--c-text-2); margin-right: 15px;
        }

        .app-topbar-title { font-family: 'DM Serif Display', serif; font-size: 18px; }

        .app-main { padding: 25px; max-width: 1200px; margin: 0 auto; }

        /* OVERLAY */
        .sidebar-overlay {
            position: fixed; inset: 0; background: rgba(0,0,0,0.4);
            z-index: 950; display: none; backdrop-filter: blur(2px);
        }
        .sidebar-overlay.active { display: block; }

        /* User Footer */
        .sidebar-user { border-top: 1px solid var(--c-border); padding: 15px; }
        .sidebar-user-inner { display: flex; align-items: center; gap: 10px; cursor: pointer; }
        .user-avatar { width: 35px; height: 35px; border-radius: 50%; background: var(--c-green-100); display: flex; align-items: center; justify-content: center; font-weight: bold; color: var(--c-accent-text); }
    </style>
</head>
<body>

@if(session()->has('warga_logged_in'))
    <div class="sidebar-overlay" id="overlay" onclick="toggleSidebar()"></div>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-brand">
            <div class="sidebar-brand-icon"><i class="bi bi-shield-check-fill text-white"></i></div>
            <div class="sidebar-brand-text">
                <strong style="font-family:'DM Serif Display'">Sambong Mandiri</strong>
                <span style="font-size:11px; color:var(--c-text-3)">Kelurahan Sambong</span>
            </div>
            <button class="ms-auto border-0 bg-transparent d-lg-none" onclick="toggleSidebar()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>

        <nav class="sidebar-nav">
            <div class="sidebar-section-label">Menu Utama</div>
            
            <a href="{{ route('warga.dashboard') }}" class="nav-item-link {{ request()->routeIs('warga.dashboard') ? 'active' : '' }}">
                <i class="bi bi-grid-1x2"></i> Dashboard
            </a>

            <a href="{{ route('warga.pengumuman.index') }}" class="nav-item-link {{ request()->routeIs('warga.pengumuman.*') ? 'active' : '' }}">
                <i class="bi bi-megaphone"></i> Informasi
            </a>

            <a href="{{ route('warga.ajukan') }}" class="nav-item-link {{ request()->routeIs('warga.ajukan') ? 'active' : '' }}">
                <i class="bi bi-file-earmark-plus"></i> Ajukan Surat
            </a>

            <a href="{{ route('warga.riwayat') }}" class="nav-item-link {{ request()->routeIs('warga.riwayat') ? 'active' : '' }}">
                <i class="bi bi-clock-history"></i> Riwayat Surat
            </a>

            <div class="sidebar-section-label">Akun</div>
            <a href="{{ route('warga.profil') }}" class="nav-item-link {{ request()->routeIs('warga.profil') ? 'active' : '' }}">
                <i class="bi bi-person"></i> Profil Saya
            </a>
        </nav>

        <div class="sidebar-user">
            <form action="{{ route('logout.warga') }}" method="POST">
                @csrf
                <button type="submit" class="nav-item-link text-danger border-0 bg-transparent w-100">
                    <i class="bi bi-box-arrow-left"></i> Keluar
                </button>
            </form>
        </div>
    </aside>

    <div class="app-content-wrapper">
        <header class="app-topbar">
            <button class="toggle-btn" onclick="toggleSidebar()">
                <i class="bi bi-list fs-4"></i>
            </button>

            <span class="app-topbar-title">
                @if(request()->routeIs('warga.dashboard')) Dashboard
                @elseif(request()->routeIs('warga.pengumuman.*')) Informasi Desa
                @elseif(request()->routeIs('warga.ajukan')) Layanan Surat
                @elseif(request()->routeIs('warga.riwayat')) Riwayat Anda
                @else Kelurahan Sambong @endif
            </span>
        </header>

        <main class="app-main">
            @yield('content')
        </main>
    </div>

@else
    <div class="container py-5 text-center">
        @yield('content')
    </div>
@endif

<script>
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');
        
        sidebar.classList.toggle('open');
        overlay.classList.toggle('active');
        
        // Mencegah scroll saat sidebar buka di mobile
        if(sidebar.classList.contains('open') && window.innerWidth < 992) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = 'auto';
        }
    }

    // Menutup sidebar otomatis jika layar di-resize ke desktop (opsional)
    window.addEventListener('resize', function() {
        if (window.innerWidth > 992) {
            // Tetap tertutup atau terbuka sesuai keinginan Anda
        }
    });
</script>

</body>
</html>