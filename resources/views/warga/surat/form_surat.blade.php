@extends('layouts.app')

@section('content')
<style>
    /* Konsistensi Warna & Font */
    :root { --hijau-keraton: #1e4d3a; --bg-light: #f8fafc; }
    
    .form-card { border-radius: 1.25rem; border: none; background: #ffffff; }
    .section-divider { 
        font-size: 0.9rem; 
        font-weight: 700; 
        color: var(--hijau-keraton); 
        border-bottom: 2px solid #e8f0ed;
        padding-bottom: 8px;
        margin-bottom: 20px;
    }
    
    .form-label { font-weight: 600; font-size: 0.85rem; color: #475569; }
    .form-control { 
        border-radius: 0.75rem; 
        padding: 0.6rem 1rem; 
        border: 1px solid #e2e8f0; 
        font-size: 0.9rem;
    }
    .form-control:focus { border-color: var(--hijau-keraton); box-shadow: 0 0 0 3px rgba(30, 77, 58, 0.1); }
    .bg-readonly { background-color: #f1f5f9 !important; border-color: #e2e8f0; }

    .btn-kirim { 
        background: var(--hijau-keraton); 
        color: white; 
        border-radius: 50px; 
        padding: 10px 35px; 
        font-weight: 700;
        transition: all 0.3s;
    }
    .btn-kirim:hover { background: #153629; transform: translateY(-2px); color: white; }
    
    .upload-area {
        background: #fcfcfc;
        border: 2px dashed #dee2e6;
        border-radius: 1rem;
        padding: 1.5rem;
        transition: 0.3s;
    }
    .upload-area:hover { border-color: var(--hijau-keraton); background: #f0f5f3; }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card form-card shadow-sm p-4">
                <div class="d-flex align-items-center mb-4">
                    <h3 class="fw-bold mb-0" style="font-size: clamp(1.2rem, 2vw, 1.75rem);">Form Pengajuan: {{ $nama_surat }}</h3>
                </div>

                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-4">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Data tetap sama persis --}}
                    <input type="hidden" name="tipe_slug" value="{{ $tipe }}">
                    <input type="hidden" name="jenis_surat_nama" value="{{ $nama_surat }}">
                    <input type="hidden" name="jenis_surat_id" value="{{ $jenis_surat_id }}">

                    <h6 class="section-divider">1. Data Identitas (Otomatis)</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <label class="form-label">NIK</label>
                            <input type="text" class="form-control bg-readonly" value="{{ session('nik') }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">No. Kartu Keluarga</label>
                            <input type="text" class="form-control bg-readonly" value="{{ session('no_kk') }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control bg-readonly" value="{{ session('nama_lengkap') }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Tempat, Tanggal Lahir</label>
                            <input type="text" class="form-control bg-readonly" value="{{ session('tempat_lahir') }}, {{ session('tanggal_lahir') ? \Carbon\Carbon::parse(session('tanggal_lahir'))->format('d-m-Y') : '-' }}" readonly>
                        </div>
                        <div class="col-md-4 col-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <input type="text" class="form-control bg-readonly" value="{{ session('jenis_kelamin') }}" readonly>
                        </div>
                        <div class="col-md-4 col-6">
                            <label class="form-label">Agama</label>
                            <input type="text" class="form-control bg-readonly" value="{{ session('agama') }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" class="form-control bg-readonly" value="{{ session('pekerjaan') }}" readonly>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat</label>
                            <input type="text" class="form-control bg-readonly" value="{{ session('alamat_lengkap') }}" readonly>
                        </div>
                        <div class="col-6 col-md-2">
                            <label class="form-label">RT</label>
                            <input type="text" class="form-control bg-readonly" value="{{ session('rt') }}" readonly>
                        </div>
                        <div class="col-6 col-md-2">
                            <label class="form-label">RW</label>
                            <input type="text" class="form-control bg-readonly" value="{{ session('rw') }}" readonly>
                        </div>
                        <div class="col-md-4 col-6">
                            <label class="form-label">Kelurahan</label>
                            <input type="text" class="form-control bg-readonly" value="{{ session('kelurahan') ?? 'Sambong' }}" readonly>
                        </div>
                        <div class="col-md-4 col-6">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" class="form-control bg-readonly" value="{{ session('kecamatan') ?? 'Batang' }}" readonly>
                        </div>
                    </div>

                    @if($jenis_surat_id == 6)
                    <h6 class="section-divider text-primary" style="border-color: #e7f1ff;">Data Lembaga / Usaha</h6>
                    <div class="row g-3 mb-4 p-3 rounded-4 bg-light-subtle" style="border: 1px dashed #dee2e6;">
                        <div class="col-md-6">
                            <label class="form-label text-dark">Nama Lembaga / Usaha</label>
                            <input type="text" name="nama_lembaga" class="form-control" placeholder="Masukkan nama lembaga/usaha" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark">Penanggung Jawab</label>
                            <input type="text" name="penanggung_jawab" class="form-control" placeholder="Nama pimpinan" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark">Jabatan</label>
                            <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Pemilik" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-dark">Alamat Usaha</label>
                            <input type="text" name="alamat_lembaga" class="form-control" placeholder="Lokasi usaha di Sambong" required>
                        </div>
                    </div>
                    @endif

                    <h6 class="section-divider">2. Detail Pengajuan</h6>
                    <div class="mb-3">
                        <label class="form-label">Keperluan <span class="text-danger">*</span></label>
                        <textarea name="keperluan" class="form-control" rows="2" placeholder="Contoh: Persyaratan melamar pekerjaan" required>{{ old('keperluan') }}</textarea>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Keterangan Tambahan <span class="text-danger">*</span></label>
                        <textarea name="keterangan" class="form-control" rows="2" placeholder="Isi sesuai surat pengantar RT" required>{{ old('keterangan') }}</textarea>
                    </div>

                    <h6 class="section-divider">3. Upload Dokumen (Maks. 2MB)</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="upload-area">
                                <label class="form-label d-block small">Scan Pengantar RT (JPG/PNG)</label>
                                <input type="file" name="scan_pengantar_rt" class="form-control form-control-sm mb-2" required>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Pastikan foto terlihat jelas.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="upload-area">
                                <label class="form-label d-block small">Scan KTP & KK (JPG/PNG)</label>
                                <input type="file" name="scan_ktp_kk" class="form-control form-control-sm mb-2" required>
                                <small class="text-muted d-block" style="font-size: 0.75rem;">Gabungkan KTP & KK dalam satu gambar.</small>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-top d-flex flex-column flex-md-row gap-2">
                        <button type="submit" class="btn btn-kirim">
                            <i class="bi bi-send me-2"></i>KIRIM PENGAJUAN
                        </button>
                        <a href="{{ route('warga.ajukan') }}" class="btn btn-light border rounded-pill px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection