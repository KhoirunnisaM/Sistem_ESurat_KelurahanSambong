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

    /* Responsive Typography */
    .responsive-title { font-size: clamp(1.2rem, 2vw, 1.75rem); }
    .responsive-sub { font-size: clamp(0.75rem, 1.5vw, 0.875rem); }

    @media (max-width: 576px) {
        .header-section { flex-direction: column; align-items: flex-start !important; gap: 1rem; }
        .btn-batal { width: 100%; text-align: center; order: 2; }
        .title-box { order: 1; }
    }
</style>

<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Header Section --}}
            <div class="d-flex justify-content-between align-items-center mb-4 header-section">
                <div class="title-box">
                    <h3 class="fw-bold mb-1 responsive-title">Edit Pengajuan Surat</h3>
                    <p class="text-muted mb-0 responsive-sub">Update informasi atau dokumen lampiran Anda</p>
                </div>
            </div>

            <div class="card form-card shadow-sm p-3 p-md-4">
                @if ($errors->any())
                    <div class="alert alert-danger border-0 shadow-sm rounded-4">
                        <ul class="mb-0 small">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('warga.surat.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    {{-- Data Lembaga/Usaha --}}
                    @if($surat->jenis_surat_id == 6)
                    <h6 class="section-divider">1. Data Lembaga / Usaha</h6>
                    <div class="row g-3 mb-4 p-3 rounded-4 bg-light-subtle" style="border: 1px dashed #dee2e6;">
                        <div class="col-md-6">
                            <label class="form-label">Nama Lembaga / Usaha</label>
                            <input type="text" name="nama_lembaga" class="form-control" 
                                   value="{{ old('nama_lembaga', $surat->nama_lembaga) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Penanggung Jawab</label>
                            <input type="text" name="penanggung_jawab" class="form-control" 
                                   value="{{ old('penanggung_jawab', $surat->penanggung_jawab) }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Jabatan</label>
                            <input type="text" name="jabatan_penanggung_jawab" class="form-control" 
                                   value="{{ old('jabatan_penanggung_jawab', $surat->jabatan_penanggung_jawab) }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label">Alamat Usaha</label>
                            <textarea name="alamat_lembaga" class="form-control" rows="2" required>{{ old('alamat_lembaga', $surat->alamat_lembaga) }}</textarea>
                        </div>
                    </div>
                    @endif

                    <h6 class="section-divider">{{ $surat->jenis_surat_id == 6 ? '2' : '1' }}. Detail Pengajuan</h6>
                    <div class="mb-3">
                        <label class="form-label">Keperluan <span class="text-danger">*</span></label>
                        <input type="text" name="keperluan" class="form-control @error('keperluan') is-invalid @enderror" 
                               value="{{ old('keperluan', $surat->keperluan) }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Keterangan Tambahan <span class="text-danger">*</span></label>
                        <textarea name="keterangan" class="form-control" rows="3" required>{{ old('keterangan', $surat->keterangan) }}</textarea>
                    </div>

                    <h6 class="section-divider">{{ $surat->jenis_surat_id == 6 ? '3' : '2' }}. Update Lampiran (Maks. 2MB)</h6>
                    <div class="row g-3 mb-4">
                        <div class="col-md-6">
                            <div class="upload-area">
                                <label class="form-label d-block small mb-2">Scan Pengantar RT (JPG/PNG)</label>
                                @if($surat->scan_pengantar_rt)
                                    <div class="mb-2"><span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3">File Terlampir</span></div>
                                @endif
                                <input type="file" name="scan_pengantar_rt" class="form-control form-control-sm mb-1">
                                <small class="text-muted d-block" style="font-size: 0.7rem;">Biarkan kosong jika tidak ingin mengubah file.</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="upload-area">
                                <label class="form-label d-block small mb-2">Scan KTP & KK (JPG/PNG)</label>
                                @if($surat->scan_ktp_kk)
                                    <div class="mb-2"><span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 rounded-pill px-3">File Terlampir</span></div>
                                @endif
                                <input type="file" name="scan_ktp_kk" class="form-control form-control-sm mb-1">
                                <small class="text-muted d-block" style="font-size: 0.7rem;">Biarkan kosong jika tidak ingin mengubah file.</small>
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 border-top d-flex flex-column flex-md-row gap-2">
                        <button type="submit" class="btn btn-kirim shadow-sm">
                            <i class="bi bi-check-circle me-2"></i>SIMPAN PERUBAHAN
                        </button>
                        <a href="{{ route('warga.surat.detail', $surat->id) }}" class="btn btn-light border rounded-pill px-4">Batal</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection