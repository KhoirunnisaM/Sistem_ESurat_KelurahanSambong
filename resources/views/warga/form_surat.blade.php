@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card border-0 shadow-sm p-4" style="border-radius: 15px;">
        <h3 class="fw-bold mb-4">Form Pengajuan: {{ $nama_surat }}</h3>

        @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <input type="hidden" name="tipe_slug" value="{{ $tipe }}">
            <input type="hidden" name="jenis_surat_nama" value="{{ $nama_surat }}">
            <input type="hidden" name="jenis_surat_id" value="{{ $jenis_surat_id }}">

            <h5 class="text-success fw-bold border-bottom pb-2 mb-3">1. Data Identitas (Otomatis)</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label small fw-bold">NIK</label>
                    <input type="text" class="form-control bg-light" value="{{ session('nik') }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">No. Kartu Keluarga</label>
                    <input type="text" class="form-control bg-light" value="{{ session('no_kk') }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Nama Lengkap</label>
                    <input type="text" class="form-control bg-light" value="{{ session('nama_lengkap') }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Tempat, Tanggal Lahir</label>
                    <input type="text" class="form-control bg-light" value="{{ session('tempat_lahir') }}, {{ session('tanggal_lahir') ? \Carbon\Carbon::parse(session('tanggal_lahir'))->format('d-m-Y') : '-' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Jenis Kelamin</label>
                    <input type="text" class="form-control bg-light" value="{{ session('jenis_kelamin') }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Agama</label>
                    <input type="text" class="form-control bg-light" value="{{ session('agama') }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Pekerjaan</label>
                    <input type="text" class="form-control bg-light" value="{{ session('pekerjaan') }}" readonly>
                </div>
                <div class="col-md-12">
                    <label class="form-label small fw-bold">Alamat</label>
                    <input type="text" class="form-control bg-light" value="{{ session('alamat_lengkap') }}" readonly>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">RT</label>
                    <input type="text" class="form-control bg-light" value="{{ session('rt') }}" readonly>
                </div>
                <div class="col-md-2">
                    <label class="form-label small fw-bold">RW</label>
                    <input type="text" class="form-control bg-light" value="{{ session('rw') }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Kelurahan</label>
                    <input type="text" class="form-control bg-light" value="{{ session('kelurahan') ?? 'Sambong' }}" readonly>
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold">Kecamatan</label>
                    <input type="text" class="form-control bg-light" value="{{ session('kecamatan') ?? 'Batang' }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Kabupaten / Kota</label>
                    <input type="text" class="form-control bg-light" value="{{ session('kabupaten') ?? 'Batang' }}" readonly>
                </div>
                <div class="col-md-6">
                    <label class="form-label small fw-bold">Provinsi</label>
                    <input type="text" class="form-control bg-light" value="{{ session('provinsi') ?? 'Jawa Tengah' }}" readonly>
                </div>
            </div>

            {{-- FORM KHUSUS DOMISILI USAHA --}}
            @if($jenis_surat_id == 6 || $jenis_surat_id == 6)
            <h5 class="text-primary fw-bold border-bottom pb-2 mb-3">Data Lembaga / Usaha</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Nama Lembaga / Usaha</label>
                    <input type="text" name="nama_lembaga" class="form-control" placeholder="Masukkan nama lembaga/usaha" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Penanggung Jawab / Pimpinan</label>
                    <input type="text" name="penanggung_jawab" class="form-control" placeholder="Nama penanggung jawab" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control" placeholder="Contoh: Direktur/Ketua/Pemilik" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Alamat Lengkap Tempat Usaha</label>
                    <input type="text" name="alamat_lembaga" class="form-control" placeholder="Alamat lokasi usaha di wilayah Sambong" required>
                </div>
            </div>
            @endif

            <h5 class="text-success fw-bold border-bottom pb-2 mb-3">2. Detail Pengajuan</h5>
            <div class="mb-3">
                <label class="form-label fw-bold">Keperluan <span class="text-danger">*</span></label>
                <textarea name="keperluan" class="form-control" rows="2" placeholder="Contoh: Persyaratan melamar pekerjaan atau pengurusan NPWP" required>{{ old('keperluan') }}</textarea>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Keterangan Tambahan <span class="text-danger">*</span></label>
                <textarea name="keterangan" class="form-control" rows="2" placeholder="Isi sesuai dengan keterangan yang tertera di surat pengantar RT" required>{{ old('keterangan') }}</textarea>
            </div>

            <h5 class="text-success fw-bold border-bottom pb-2 mb-3">3. Upload Dokumen (Maks. 2MB)</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <div class="p-3 border rounded bg-light">
                        <label class="form-label fw-bold small d-block">Scan Pengantar RT (JPG/PNG)</label>
                        <input type="file" name="scan_pengantar_rt" class="form-control" required>
                        <small class="text-muted mt-1 d-block">Pastikan foto terlihat jelas dan tidak terpotong.</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 border rounded bg-light">
                        <label class="form-label fw-bold small d-block">Scan KTP & KK (JPG/PNG)</label>
                        <input type="file" name="scan_ktp_kk" class="form-control" required>
                        <small class="text-muted mt-1 d-block">Gabungkan foto KTP dan KK dalam satu gambar atau gunakan salah satu yang valid.</small>
                    </div>
                </div>
            </div>

            <div class="mt-4 border-top pt-4">
                <button type="submit" class="btn btn-success px-5 py-2 fw-bold shadow-sm rounded-pill">
                    <i class="bi bi-send me-2"></i>KIRIM PENGAJUAN
                </button>
                <a href="{{ route('warga.ajukan') }}" class="btn btn-light px-4 py-2 border ms-2 rounded-pill">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection