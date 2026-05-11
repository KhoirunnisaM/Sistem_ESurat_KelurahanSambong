@extends('layouts.app')

@section('content')
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

<style>
    :root {
        --primary: #1e5233;
        --secondary: #2d7a4d;
        --bg-gradient: linear-gradient(135deg, #f0fdf4 0%, #ffffff 100%);
    }

    body { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        background: var(--bg-gradient);
        min-height: 100vh;
    }

    .auth-wrapper {
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .auth-card {
        background: rgba(255, 255, 255, 0.9);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.5);
        border-radius: 30px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 450px;
        padding: 40px;
    }

    .auth-logo {
        width: 50px;
        margin-bottom: 20px;
    }

    .auth-header h2 {
        font-weight: 800;
        color: var(--primary);
        letter-spacing: -1px;
    }

    .form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #4b5563;
        margin-left: 5px;
    }

    .form-control {
        border-radius: 15px;
        padding: 12px 20px;
        border: 2px solid #f3f4f6;
        background: #f9fafb;
        transition: 0.3s;
    }

    .form-control:focus {
        border-color: var(--secondary);
        background: #fff;
        box-shadow: 0 0 0 4px rgba(45, 122, 77, 0.1);
    }

    .btn-auth {
        background: var(--primary);
        color: white;
        border: none;
        padding: 14px;
        border-radius: 15px;
        font-weight: 700;
        width: 100%;
        margin-top: 20px;
        transition: 0.3s;
    }

    .btn-auth:hover {
        background: var(--secondary);
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(30, 82, 51, 0.2);
    }

    .auth-footer a {
        color: var(--secondary);
        font-weight: 700;
        text-decoration: none;
    }

   .btn-home-back {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #9ca3af;
        text-decoration: none;
        font-size: 0.85rem;
        margin-top: 2px;
        padding: 8px 16px;
        border-radius: 10px;
        transition: 0.2s;
    }

    .btn-home-back:hover {
        background: #f3f4f6;
        color: var(--text-main);
    }
</style>

<div class="auth-wrapper">
    <div class="auth-card">
        <div class="text-center auth-header">
            <img src="{{ asset('storage/img/logo_batang.png') }}" class="auth-logo" alt="Logo">
            <h2>Selamat Datang</h2>
            <p class="text-muted mb-4">Silakan masuk untuk akses layanan mandiri</p>
        </div>

        @if(session('error'))
            <div class="alert alert-danger border-0 small rounded-3">{{ session('error') }}</div>
        @endif

        <form action="{{ route('login.warga.submit') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">Nomor Induk Kependudukan (NIK)</label>
                <input type="text" name="nik" class="form-control" maxlength="16" placeholder="16 digit NIK" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Tanggal Lahir</label>
                <input type="date" name="tanggal_lahir" class="form-control" required>
            </div>
            <button type="submit" class="btn-auth">Masuk Sekarang</button>
        </form>

        <div class="text-center mt-4 auth-footer">
    <p class="small text-muted">
        Belum punya akun? <a href="{{ route('register.warga') }}" class="fw-bold" style="color: #1e4d3a;">Daftar Disini</a>
    </p>

    <a href="/" class="btn-home-back">
        <i class="bi bi-house-door"></i> Kembali ke Beranda 
    </a>  
</div>
    </div>
    </div>
</div>
@endsection