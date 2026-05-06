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
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Serif+Display:ital@0;1&display=swap" rel="stylesheet">

    <style>
        /* ─── RESET & BASE ─── */
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --sidebar-w:      240px;
            --sidebar-collapsed: 0px;

            --c-bg:           #f7f8fa;
            --c-surface:      #ffffff;
            --c-surface-2:    #f3f4f6;
            --c-border:       #e8eaed;
            --c-border-dark:  #d1d5db;

            --c-text-1:       #111827;
            --c-text-2:       #4b5563;
            --c-text-3:       #9ca3af;

            --c-green-900:    #0a2e1a;
            --c-green-700:    #166534;
            --c-green-600:    #16a34a;
            --c-green-500:    #22c55e;
            --c-green-50:     #f0fdf4;
            --c-green-100:    #dcfce7;

            --c-accent:       #16a34a;
            --c-accent-muted: #f0fdf4;
            --c-accent-text:  #166534;

            --c-danger:       #ef4444;
            --c-danger-muted: #fef2f2;

            --c-gold:         #d97706;
            --c-gold-muted:   #fffbeb;

            --shadow-xs: 0 1px 2px rgba(0,0,0,0.05);
            --shadow-sm: 0 1px 4px rgba(0,0,0,0.07);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.08);

            --r-sm: 8px;
            --r-md: 12px;
            --r-lg: 18px;
            --r-xl: 24px;

            --font-body:    'DM Sans', sans-serif;
            --font-display: 'DM Serif Display', serif;

            --bottom-nav-h: 66px;
        }

        html, body {
            font-family: var(--font-body);
            background: var(--c-bg);
            color: var(--c-text-1);
            font-size: 15px;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        a { text-decoration: none; color: inherit; }
        button { font-family: inherit; }

        /* ─── GUEST NAVBAR (shown when NOT logged in) ─── */
        .guest-nav {
            position: sticky;
            top: 0;
            z-index: 200;
            background: var(--c-surface);
            border-bottom: 1px solid var(--c-border);
            padding: 0 24px;
            height: 60px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .guest-nav-brand {
            display: flex;
            align-items: center;
            gap: 10px;
            font-family: var(--font-display);
            font-size: 17px;
            color: var(--c-text-1);
        }
        .guest-nav-brand .brand-dot {
            width: 8px; height: 8px;
            background: var(--c-accent);
            border-radius: 50%;
            display: inline-block;
        }
        .guest-nav-actions { display: flex; gap: 8px; align-items: center; }
        .btn-ghost {
            padding: 8px 18px;
            border-radius: var(--r-md);
            font-size: 13.5px;
            font-weight: 500;
            color: var(--c-text-2);
            border: 1px solid var(--c-border);
            background: transparent;
            transition: all 0.2s;
            display: inline-block;
        }
        .btn-ghost:hover {
            background: var(--c-surface-2);
            color: var(--c-text-1);
        }
        .btn-solid {
            padding: 8px 18px;
            border-radius: var(--r-md);
            font-size: 13.5px;
            font-weight: 600;
            color: white;
            background: var(--c-green-900);
            border: none;
            transition: all 0.2s;
            display: inline-block;
        }
        .btn-solid:hover {
            background: var(--c-green-700);
            color: white;
        }

        /* ─── APP SHELL (shown when logged in) ─── */
        .app-shell {
            display: flex;
            min-height: 100vh;
        }

        /* ─── SIDEBAR ─── */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--c-surface);
            border-right: 1px solid var(--c-border);
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 100;
            display: flex;
            flex-direction: column;
            transition: transform 0.3s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden;
        }

        /* sidebar brand area */
        .sidebar-brand {
            padding: 22px 20px 18px;
            border-bottom: 1px solid var(--c-border);
            display: flex;
            align-items: center;
            gap: 10px;
            flex-shrink: 0;
        }
        .sidebar-brand-icon {
            width: 34px; height: 34px;
            border-radius: var(--r-sm);
            background: var(--c-green-900);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .sidebar-brand-icon i { color: white; font-size: 16px; }
        .sidebar-brand-text { line-height: 1.2; }
        .sidebar-brand-text strong {
            display: block;
            font-family: var(--font-display);
            font-size: 15px;
            color: var(--c-text-1);
        }
        .sidebar-brand-text span {
            font-size: 11px;
            color: var(--c-text-3);
            font-weight: 400;
        }

        /* sidebar nav */
        .sidebar-nav {
            flex: 1;
            padding: 16px 12px;
            overflow-y: auto;
        }
        .sidebar-section-label {
            font-size: 10px;
            font-weight: 600;
            letter-spacing: 0.10em;
            text-transform: uppercase;
            color: var(--c-text-3);
            padding: 8px 10px 6px;
            margin-top: 8px;
        }
        .sidebar-section-label:first-child { margin-top: 0; }

        .nav-item-link {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 10px 12px;
            border-radius: var(--r-md);
            font-size: 14px;
            font-weight: 500;
            color: var(--c-text-2);
            transition: all 0.18s ease;
            margin-bottom: 2px;
            position: relative;
        }
        .nav-item-link i {
            font-size: 17px;
            flex-shrink: 0;
            width: 20px;
            text-align: center;
        }
        .nav-item-link:hover {
            background: var(--c-surface-2);
            color: var(--c-text-1);
        }
        .nav-item-link.active {
            background: var(--c-green-50);
            color: var(--c-accent-text);
            font-weight: 600;
        }
        .nav-item-link.active i { color: var(--c-accent); }
        .nav-item-link.active::before {
            content: '';
            position: absolute;
            left: 0; top: 6px; bottom: 6px;
            width: 3px;
            background: var(--c-accent);
            border-radius: 0 4px 4px 0;
        }

        /* sidebar user footer */
        .sidebar-user {
            border-top: 1px solid var(--c-border);
            padding: 14px 12px;
            flex-shrink: 0;
        }
        .sidebar-user-inner {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 10px;
            border-radius: var(--r-md);
            cursor: pointer;
            transition: background 0.18s;
            position: relative;
        }
        .sidebar-user-inner:hover { background: var(--c-surface-2); }
        .user-avatar {
            width: 34px; height: 34px;
            border-radius: 50%;
            background: var(--c-green-100);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            font-size: 14px;
            font-weight: 700;
            color: var(--c-accent-text);
        }
        .sidebar-user-info { flex: 1; min-width: 0; }
        .sidebar-user-name {
            font-size: 13px;
            font-weight: 600;
            color: var(--c-text-1);
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .sidebar-user-role {
            font-size: 11px;
            color: var(--c-text-3);
        }
        .sidebar-user-menu {
            position: absolute;
            bottom: calc(100% + 8px);
            left: 0; right: 0;
            background: var(--c-surface);
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            padding: 6px;
            box-shadow: var(--shadow-md);
            display: none;
            z-index: 50;
        }
        .sidebar-user-menu.open { display: block; }
        .user-menu-item {
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 9px 12px;
            border-radius: var(--r-sm);
            font-size: 13.5px;
            color: var(--c-text-2);
            transition: background 0.15s;
            cursor: pointer;
            width: 100%;
            text-align: left;
            background: none;
            border: none;
        }
        .user-menu-item:hover { background: var(--c-surface-2); color: var(--c-text-1); }
        .user-menu-item.danger { color: var(--c-danger); }
        .user-menu-item.danger:hover { background: var(--c-danger-muted); }
        .user-menu-item i { font-size: 15px; }
        .user-menu-divider { height: 1px; background: var(--c-border); margin: 4px 0; }

        /* ─── TOP HEADER BAR (inside app shell) ─── */
        .app-topbar {
            position: sticky;
            top: 0;
            z-index: 90;
            background: var(--c-surface);
            border-bottom: 1px solid var(--c-border);
            height: 58px;
            display: flex;
            align-items: center;
            padding: 0 24px;
            gap: 16px;
        }
        .app-topbar-title {
            font-family: var(--font-display);
            font-size: 17px;
            color: var(--c-text-1);
            flex: 1;
        }
        .topbar-status-pill {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 5px 12px;
            background: var(--c-green-50);
            border: 1px solid var(--c-green-100);
            border-radius: 100px;
            font-size: 12px;
            font-weight: 500;
            color: var(--c-accent-text);
        }
        .topbar-status-dot {
            width: 7px; height: 7px;
            background: var(--c-accent);
            border-radius: 50%;
            animation: pulse-dot 2.5s ease infinite;
        }
        @keyframes pulse-dot {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.4; }
        }
        .topbar-mobile-user {
            display: none;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 600;
            color: var(--c-text-1);
        }
        .topbar-mobile-user .user-avatar { width: 30px; height: 30px; font-size: 12px; }

        /* ─── MAIN CONTENT AREA ─── */
        .app-content-wrapper {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .app-main {
            flex: 1;
            padding: 28px 28px 40px;
            max-width: 1100px;
            width: 100%;
        }

        /* ─── FOOTER (inside app shell) ─── */
        .app-footer {
            border-top: 1px solid var(--c-border);
            background: var(--c-surface);
            padding: 14px 28px;
            font-size: 12px;
            color: var(--c-text-3);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .app-footer a { color: var(--c-text-3); }
        .app-footer a:hover { color: var(--c-accent); }

        /* ─── MOBILE SIDEBAR OVERLAY ─── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.3);
            z-index: 99;
            backdrop-filter: blur(2px);
        }
        .sidebar-overlay.open { display: block; }

        /* ─── BOTTOM NAV (mobile logged-in) ─── */
        .bottom-nav {
            display: none;
            position: fixed;
            bottom: 0; left: 0; right: 0;
            height: var(--bottom-nav-h);
            background: var(--c-surface);
            border-top: 1px solid var(--c-border);
            z-index: 150;
            align-items: center;
            justify-content: space-around;
            padding: 0 8px;
        }
        .bottom-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            padding: 8px 12px;
            border-radius: var(--r-md);
            color: var(--c-text-3);
            font-size: 10.5px;
            font-weight: 500;
            transition: all 0.18s;
            flex: 1;
            text-align: center;
        }
        .bottom-nav-item i { font-size: 20px; }
        .bottom-nav-item:hover { color: var(--c-text-2); }
        .bottom-nav-item.active {
            color: var(--c-accent-text);
        }
        .bottom-nav-item.active i {
            color: var(--c-accent);
        }
        .bottom-nav-fab {
            width: 48px; height: 48px;
            border-radius: 50%;
            background: var(--c-green-900);
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 14px rgba(10,46,26,0.3);
            transition: transform 0.2s;
        }
        .bottom-nav-fab:hover { transform: scale(1.05); }
        .bottom-nav-fab i { color: white; font-size: 20px; }
        .bottom-nav-fab-wrap {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 3px;
            flex: 0 0 auto;
        }
        .bottom-nav-fab-label {
            font-size: 10.5px;
            color: var(--c-text-3);
            font-weight: 500;
        }

        /* Guest layout has no sidebar, content fills width */
        .guest-content {
            min-height: calc(100vh - 60px);
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 991px) {
            .sidebar {
                transform: translateX(-100%);
            }
            .sidebar.mobile-open {
                transform: translateX(0);
                box-shadow: var(--shadow-md);
            }
            .app-content-wrapper {
                margin-left: 0;
            }
            .bottom-nav {
                display: flex;
            }
            .app-main {
                padding: 20px 16px calc(var(--bottom-nav-h) + 20px);
            }
            .app-topbar {
                padding: 0 16px;
            }
            .app-topbar-title { font-size: 15px; }
            .topbar-status-pill { display: none; }
            .topbar-mobile-user { display: flex; }
            .app-footer { display: none; }

            .sidebar-hamburger { display: flex !important; }
        }

        @media (max-width: 576px) {
            .guest-nav { padding: 0 16px; }
        }

        /* hamburger btn */
        .sidebar-hamburger {
            display: none;
            width: 36px; height: 36px;
            border: 1px solid var(--c-border);
            border-radius: var(--r-sm);
            background: transparent;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--c-text-2);
            font-size: 17px;
            transition: background 0.15s;
        }
        .sidebar-hamburger:hover { background: var(--c-surface-2); }

        /* Bootstrap overrides */
        .dropdown-menu {
            border: 1px solid var(--c-border);
            border-radius: var(--r-md);
            box-shadow: var(--shadow-md);
            padding: 6px;
            font-family: var(--font-body);
        }
        .dropdown-item {
            border-radius: var(--r-sm);
            font-size: 13.5px;
            padding: 9px 14px;
            color: var(--c-text-2);
        }
        .dropdown-item:hover { background: var(--c-surface-2); color: var(--c-text-1); }
        .dropdown-divider { border-color: var(--c-border); }
    </style>
</head>
<body>

@if(session()->has('warga_logged_in'))
{{-- ══════════════════════════════════════════════
     LOGGED IN — SIDEBAR APP SHELL
══════════════════════════════════════════════ --}}

{{-- SIDEBAR OVERLAY (mobile) --}}
<div class="sidebar-overlay" id="sidebarOverlay" onclick="closeSidebar()"></div>
{{-- SIDEBAR --}}
<aside class="sidebar" id="sidebar">

    {{-- Brand --}}
    <div class="sidebar-brand">
        <div class="sidebar-brand-icon">
            <i class="bi bi-shield-check-fill"></i>
        </div>
        <div class="sidebar-brand-text">
            <strong>Layanan Mandiri</strong>
            <span>Kelurahan Sambong</span>
        </div>
    </div>

    {{-- Nav --}}
    <nav class="sidebar-nav">
        <div class="sidebar-section-label">Menu Utama</div>

        <a href="{{ route('warga.dashboard') }}"
           class="nav-item-link {{ request()->routeIs('warga.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2"></i>
            Dashboard
        </a>

        <a href="{{ route('warga.ajukan') }}"
           class="nav-item-link {{ request()->routeIs('warga.ajukan') ? 'active' : '' }}">
            <i class="bi bi-file-earmark-plus"></i>
            Ajukan Surat
        </a>

        <a href="{{ route('warga.riwayat') }}"
           class="nav-item-link {{ request()->routeIs('warga.riwayat') ? 'active' : '' }}">
            <i class="bi bi-clock-history"></i>
            Riwayat Surat
        </a>

        <div class="sidebar-section-label">Akun</div>

        <a href="{{ route('warga.profil') }}"
           class="nav-item-link {{ request()->routeIs('warga.profil') ? 'active' : '' }}">
            <i class="bi bi-person"></i>
            Profil Saya
        </a>
    </nav>

    {{-- User footer --}}
    <div class="sidebar-user">
        <div class="sidebar-user-inner" id="userTrigger" onclick="toggleUserMenu()">

            {{-- User menu popup --}}
            <div class="sidebar-user-menu" id="userMenu">
                <a href="{{ route('warga.profil') }}" class="user-menu-item">
                    <i class="bi bi-person"></i> Lihat Profil
                </a>
                <div class="user-menu-divider"></div>
                <form action="{{ route('logout.warga') }}" method="POST" style="margin:0">
                    @csrf
                    <button type="submit" class="user-menu-item danger w-100">
                        <i class="bi bi-box-arrow-left"></i> Keluar
                    </button>
                </form>
            </div>

            <div class="user-avatar">
                {{ strtoupper(substr(session('nama_lengkap', 'W'), 0, 1)) }}
            </div>
            <div class="sidebar-user-info">
                <div class="sidebar-user-name">{{ session('nama_lengkap') }}</div>
                <div class="sidebar-user-role">Warga Kelurahan</div>
            </div>
            <i class="bi bi-chevron-up" style="font-size:12px; color:var(--c-text-3)"></i>
        </div>
    </div>
</aside>

{{-- APP CONTENT WRAPPER --}}
<div class="app-shell">
    <div class="app-content-wrapper">

        {{-- TOP BAR --}}
        <header class="app-topbar">
            <button class="sidebar-hamburger" onclick="openSidebar()" aria-label="Buka menu">
                <i class="bi bi-list"></i>
            </button>

            <span class="app-topbar-title">
                @if(request()->routeIs('warga.dashboard')) Dashboard
                @elseif(request()->routeIs('warga.ajukan')) Ajukan Surat
                @elseif(request()->routeIs('warga.riwayat')) Riwayat Surat
                @elseif(request()->routeIs('warga.profil')) Profil Saya
                @else Sambong Online
                @endif
            </span>
            

            <div class="topbar-status-pill">
                <div class="topbar-status-dot"></div>
                Sistem Aktif
            </div>

            <div class="topbar-mobile-user">
                <div class="user-avatar">
                    {{ strtoupper(substr(session('nama_lengkap', 'W'), 0, 1)) }}
                </div>
            </div>
        </header>

        {{-- PAGE CONTENT --}}
        <main class="app-main">
            @yield('content')
        </main>

        {{-- FOOTER (desktop only) --}}
        <footer class="app-footer">
            <span>&copy; {{ date('Y') }} Kelurahan Sambong &mdash; Sistem Pelayanan Surat Online</span>
            <span>v1.0</span>
        </footer>

    </div>
</div>

{{-- BOTTOM NAV (mobile only) --}}
<nav class="bottom-nav" aria-label="Navigasi bawah">
    <a href="{{ route('warga.dashboard') }}"
       class="bottom-nav-item {{ request()->routeIs('warga.dashboard') ? 'active' : '' }}">
        <i class="bi bi-grid-1x2{{ request()->routeIs('warga.dashboard') ? '-fill' : '' }}"></i>
        Dashboard
    </a>

    {{-- FAB: Ajukan Surat --}}
    <div class="bottom-nav-fab-wrap">
        <a href="{{ route('warga.ajukan') }}" class="bottom-nav-fab" aria-label="Ajukan Surat">
            <i class="bi bi-plus-lg"></i>
        </a>
        <span class="bottom-nav-fab-label">Ajukan</span>
    </div>

    <a href="{{ route('warga.riwayat') }}"
       class="bottom-nav-item {{ request()->routeIs('warga.riwayat') ? 'active' : '' }}">
        <i class="bi bi-clock{{ request()->routeIs('warga.riwayat') ? '-fill' : '' }}"></i>
        Riwayat
    </a>
</nav>

@else
{{-- ══════════════════════════════════════════════
     GUEST — TOP NAVBAR ONLY
══════════════════════════════════════════════ --}}

<header class="guest-nav">
    <a href="/" class="guest-nav-brand">
        <span class="brand-dot"></span>
        <span>Sambong Online</span>
    </a>
    <nav class="guest-nav-actions">
        <a href="{{ route('login.warga') }}" class="btn-ghost">Masuk</a>
        <a href="{{ route('register.warga') }}" class="btn-solid">Daftar</a>
    </nav>
</header>

<div class="guest-content">
    @yield('content')
</div>

<footer style="border-top:1px solid var(--c-border); background:var(--c-surface); padding:16px 24px; text-align:center; font-size:12px; color:var(--c-text-3);">
    &copy; {{ date('Y') }} Kelurahan Sambong &mdash; Sistem Pelayanan Surat Online
</footer>

@endif

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    /* ─── SIDEBAR MOBILE ─── */
    function openSidebar() {
        document.getElementById('sidebar').classList.add('mobile-open');
        document.getElementById('sidebarOverlay').classList.add('open');
        document.body.style.overflow = 'hidden';
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('mobile-open');
        document.getElementById('sidebarOverlay').classList.remove('open');
        document.body.style.overflow = '';
    }

    /* ─── USER MENU TOGGLE ─── */
    function toggleUserMenu() {
        const menu = document.getElementById('userMenu');
        if (menu) menu.classList.toggle('open');
    }
    document.addEventListener('click', function(e) {
        const trigger = document.getElementById('userTrigger');
        const menu = document.getElementById('userMenu');
        if (menu && trigger && !trigger.contains(e.target)) {
            menu.classList.remove('open');
        }
    });

    /* ─── ACTIVE NAV AUTO-TITLE ─── */
    /* already handled server-side via Blade */
</script>
</body>
</html>