@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="card border-0 shadow-sm p-4">
        <h3 class="fw-bold mb-4">Form Pengajuan: {{ $nama_surat }}</h3>

        <form action="{{ route('surat.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="jenis_surat_nama" value="{{ $nama_surat }}">

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
                    <input type="text" class="form-control bg-light" value="{{ session('tempat_lahir') }}, {{ \Carbon\Carbon::parse(session('tanggal_lahir'))->format('d-m-Y') }}" readonly>
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
                <div class="col-md-3">
                    <label class="form-label small fw-bold">RT</label>
                    <input type="text" class="form-control bg-light" value="{{ session('rt') }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">RW</label>
                    <input type="text" class="form-control bg-light" value="{{ session('rw') }}" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Kelurahan</label>
                    <input type="text" class="form-control bg-light" value="Sambong" readonly>
                </div>
                <div class="col-md-3">
                    <label class="form-label small fw-bold">Kecamatan</label>
                    <input type="text" class="form-control bg-light" value="Batang" readonly>
                </div>
            </div>

            <h5 class="text-success fw-bold border-bottom pb-2 mb-3">2. Detail Pengajuan</h5>
            <div class="mb-3">
                <label class="form-label fw-bold">Keperluan <span class="text-danger">*</span></label>
                <textarea name="keperluan" class="form-control" rows="2" placeholder="Contoh: Persyaratan melamar pekerjaan" required></textarea>
            </div>
            <div class="mb-4">
                <label class="form-label fw-bold">Keterangan</label>
                <textarea name="keterangan" class="form-control" rows="2" placeholder="Isi sesuai dengan keterangan dari surat pengantar RT" required></textarea>
            </div>

            <h5 class="text-success fw-bold border-bottom pb-2 mb-3">3. Upload Dokumen</h5>
            <div class="row g-3 mb-4">
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Scan Pengantar RT (JPG/PNG)</label>
                    <input type="file" name="scan_pengantar_rt" class="form-control" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-bold small">Scan KTP & KK (JPG/PNG)</label>
                    <input type="file" name="scan_ktp_kk" class="form-control" required>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit" class="btn btn-success px-5 py-2 fw-bold">KIRIM PENGAJUAN</button>
                <a href="{{ route('warga.dashboard') }}" class="btn btn-light px-4 py-2">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection