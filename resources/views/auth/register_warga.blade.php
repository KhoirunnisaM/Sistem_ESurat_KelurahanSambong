<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Layanan Mandiri Kelurahan Sambong</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

<style>
    :root {
        --primary-green: #1e5233; 
        --secondary-green: #2d7a4d;
        --border-light: #e5e7eb;
        --text-main: #111827;
        --text-soft: #6b7280;
    }

    body { 
        font-family: 'Plus Jakarta Sans', sans-serif; 
        background-color: #f8fafc;
        color: var(--text-main);
    }

    .register-wrapper {
        padding: 50px 0;
        min-height: 100vh;
        display: flex;
        align-items: center;
    }

    .register-card {
        background: #ffffff;
        border: 1px solid var(--border-light);
        border-radius: 28px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
    }

    .form-header {
        text-align: center;
        padding-bottom: 25px;
        border-bottom: 1px solid #f1f5f9;
        margin-bottom: 30px;
    }

    .section-label {
        font-size: 0.75rem;
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1.2px;
        color: var(--secondary-green);
        margin: 25px 0 15px;
        display: flex;
        align-items: center;
    }

    .section-label::after {
        content: "";
        flex: 1;
        height: 1px;
        background: #f1f5f9;
        margin-left: 15px;
    }

    .form-label {
        font-weight: 600;
        font-size: 0.85rem;
        color: #374151;
        margin-bottom: 6px;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 11px 16px;
        border: 1px solid #d1d5db;
        font-size: 0.9rem;
        transition: all 0.2s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: var(--secondary-green);
        box-shadow: 0 0 0 4px rgba(45, 122, 77, 0.1);
    }

    .btn-register {
        background: var(--primary-green);
        color: white;
        border: none;
        padding: 16px;
        border-radius: 14px;
        font-weight: 700;
        width: 100%;
        transition: 0.3s;
        box-shadow: 0 4px 6px -1px rgba(30, 82, 51, 0.2);
    }

    .btn-register:hover {
        background: var(--secondary-green);
        transform: translateY(-2px);
        box-shadow: 0 10px 15px -3px rgba(30, 82, 51, 0.25);
    }

    /* Area Navigasi Bawah */
    .bottom-nav {
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #f1f5f9;
        text-align: center;
    }

    .login-prompt {
        color: var(--text-soft);
        font-size: 0.9rem;
        margin-bottom: 8px;
    }

    .link-login {
        color: var(--secondary-green);
        text-decoration: none;
        font-weight: 700;
        transition: 0.2s;
    }

    .link-login:hover { color: var(--primary-green); }

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

    @media (max-width: 576px) {
        .card-body { padding: 30px 20px !important; }
    }
</style>

<div class="register-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-7">
                <div class="card register-card border-0">
                    <div class="card-body p-4 p-md-5">
                        
                        <div class="form-header">
                            <img src="{{ asset('storage/img/logo_batang.png') }}" alt="Logo" style="height: 55px;" class="mb-3">
                            <h3 class="fw-bold">Pendaftaran Warga Baru</h3>
                            <p class="text-muted small">Kelurahan Sambong, Kabupaten Batang</p>
                        </div>

                        <form action="{{ route('register.warga.store') }}" method="POST">
                            @csrf

                            <div class="section-label">Informasi Identitas</div>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Nama Lengkap Sesuai KTP</label>
                                    <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" placeholder="Contoh: Budi Santoso">
                                    @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nomor Induk Kependudukan (NIK)</label>
                                    <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" maxlength="16" placeholder="16 Digit NIK">
                                    @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Nomor Kartu Keluarga (KK)</label>
                                    <input type="text" name="no_kk" class="form-control @error('no_kk') is-invalid @enderror" maxlength="16" placeholder="16 Digit No. KK">
                                </div>
                            </div>

                            <div class="section-label">Data Kelahiran & Jenis Kelamin</div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Tempat Lahir</label>
                                    <input type="text" name="tempat_lahir" class="form-control" placeholder="Contoh: Batang">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Tanggal Lahir</label>
                                    <input type="date" name="tanggal_lahir" class="form-control">
                                        </div>
                                <div class="col-md-4">
                                    <label class="form-label">Jenis Kelamin</label>
                                    <select name="jenis_kelamin" class="form-select">
                                        <option value="Laki-laki">Laki-laki</option>
                                        <option value="Perempuan">Perempuan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="section-label">Alamat Domisili</div>
                            <div class="mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="alamat_lengkap" class="form-control" rows="2" placeholder="Contoh: Sambong Pos No. 12">{{ old('alamat_lengkap') }}</textarea>
                            </div>
                            <div class="row g-3">
                                <div class="col-6 col-md-3">
                                    <label class="form-label">RT</label>
                                    <input type="text" name="rt" class="form-control" placeholder="00">
                                </div>
                                <div class="col-6 col-md-3">
                                    <label class="form-label">RW</label>
                                    <input type="text" name="rw" class="form-control" placeholder="00">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Kelurahan / Desa</label>
                                    <input type="text" name="kelurahan" class="form-control" value="Sambong" placeholder="Sambong">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Kecamatan</label>
                                    <input type="text" name="kecamatan" class="form-control" value="Batang" placeholder="Batang">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Kabupaten</label>
                                    <input type="text" name="kabupaten" class="form-control" value="Batang" placeholder="Batang">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Provinsi</label>
                                    <input type="text" name="provinsi" class="form-control" value="Jawa Tengah" placeholder="Jawa Tengah">
                                </div>
                            </div>

                            <div class="section-label">Informasi Tambahan</div>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label">Agama</label>
                                    <input type="text" name="agama" class="form-control" placeholder="Contoh: Islam">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Pekerjaan</label>
                                    <input type="text" name="pekerjaan" class="form-control" placeholder="Contoh: Wiraswasta">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Status Kawin</label>
                                    <select name="status_perkawinan" class="form-select">
                                        <option value="Belum Kawin">Belum Kawin</option>
                                        <option value="Kawin">Kawin</option>
                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                        <option value="Cerai Mati">Cerai Mati</option>
                                    </select>
                                </div>
                            </div>

                            <div class="mt-5">
                                <button type="submit" class="btn-register">Daftar Sekarang</button>
                            </div>
                        </form>

                        <div class="bottom-nav">
                            <p class="login-prompt">Sudah memiliki akun warga?
                            <a href="{{ route('login.warga') }}" class="link-login">
                                 Login Disini
                            </a></p>
                            <a href="/" class="btn-home-back">
                                <i class="bi bi-house-door"></i> Kembali ke Beranda
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>