@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Edit Pengajuan Surat</h4>
                    <p class="text-muted small">Update informasi atau dokumen lampiran Anda</p>
                </div>
                <a href="{{ route('warga.surat.detail', $surat->id) }}" class="btn btn-white bg-white border shadow-sm rounded-pill px-4">Batal</a>
            </div>

            <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                <div class="card-body p-4 p-md-5">
                    <form action="{{ route('warga.surat.update', $surat->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Section: Informasi Utama -->
                        <h6 class="fw-bold text-primary mb-4"><i class="bi bi-info-circle me-2"></i>Informasi Pengajuan</h6>
                        
                        

                        {{-- KHUSUS EDIT DATA DOMISILI USAHA (Berdasarkan jenis_surat_id 4) --}}
                        @if($surat->jenis_surat_id == 6)
                            <div class="p-4 border rounded-4 bg-light-subtle mb-4" style="border: 1px dashed #dee2e6 !important;">
                                <h6 class="fw-bold text-dark mb-4"><i class="bi bi-shop me-2"></i>Data Usaha / Lembaga</h6>
                                
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted">NAMA USAHA/LEMBAGA</label>
                                        <input type="text" name="nama_lembaga" class="form-control bg-white border-0 shadow-sm" 
                                               value="{{ old('nama_lembaga', $surat->nama_lembaga) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">PENANGGUNG JAWAB</label>
                                        <input type="text" name="penanggung_jawab" class="form-control bg-white border-0 shadow-sm" 
                                               value="{{ old('penanggung_jawab', $surat->penanggung_jawab) }}">
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-muted">JABATAN</label>
                                        <input type="text" name="jabatan_penanggung_jawab" class="form-control bg-white border-0 shadow-sm" 
                                               value="{{ old('jabatan_penanggung_jawab', $surat->jabatan_penanggung_jawab) }}">
                                    </div>
                                    <div class="col-12">
                                        <label class="form-label small fw-bold text-muted">ALAMAT USAHA</label>
                                        <textarea name="alamat_lembaga" class="form-control bg-white border-0 shadow-sm" rows="2">{{ old('alamat_lembaga', $surat->alamat_lembaga) }}</textarea>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">KETERANGAN TAMBAHAN</label>
                            <textarea name="keterangan" class="form-control bg-light border-0" rows="3" 
                                      placeholder="Tambahkan catatan jika ada...">{{ old('keterangan', $surat->keterangan) }}</textarea>
                        </div>

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-muted">TUJUAN / KEPERLUAN</label>
                            <input type="text" name="keperluan" class="form-control form-control-lg bg-light border-0 @error('keperluan') is-invalid @enderror" 
                                   placeholder="Contoh: Membuat KTP / Melamar Kerja"
                                   value="{{ old('keperluan', $surat->keperluan) }}" required>
                            @error('keperluan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <hr class="my-5 opacity-25">

                        <!-- Section: Upload Dokumen -->
                        <h6 class="fw-bold text-primary mb-4"><i class="bi bi-cloud-arrow-up me-2"></i>Update Lampiran Dokumen</h6>
                        
                        <div class="row g-4">
                            <!-- Input Pengantar RT -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded-4 bg-light">
                                    <label class="form-label small fw-bold text-muted d-block mb-2 text-center">SCAN SURAT PENGANTAR RT</label>
                                    
                                    @if($surat->scan_pengantar_rt)
                                        <div class="mb-2 text-center">
                                            <span class="badge bg-success-subtle text-success mb-2">File sudah ada</span>
                                        </div>
                                    @endif

                                    <input type="file" name="scan_pengantar_rt" class="form-control @error('scan_pengantar_rt') is-invalid @enderror">
                                    <div class="form-text mt-2 small text-muted text-center">Format: JPG, PNG, PDF (Max 2MB)</div>
                                    @error('scan_pengantar_rt') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <!-- Input KK / KTP -->
                            <div class="col-md-6">
                                <div class="p-3 border rounded-4 bg-light">
                                    <label class="form-label small fw-bold text-muted d-block mb-2 text-center">SCAN KK / KTP</label>
                                    
                                    @if($surat->scan_ktp_kk)
                                        <div class="mb-2 text-center">
                                            <span class="badge bg-success-subtle text-success mb-2">File sudah ada</span>
                                        </div>
                                    @endif

                                    <input type="file" name="scan_ktp_kk" class="form-control @error('scan_ktp_kk') is-invalid @enderror">
                                    <div class="form-text mt-2 small text-muted text-center">Format: JPG, PNG, PDF (Max 2MB)</div>
                                    @error('scan_ktp_kk') <div class="text-danger small">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 text-end">
                            <button type="submit" class="btn btn-primary px-5 py-2 fw-bold rounded-pill shadow">
                                <i class="bi bi-check-circle me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body { background-color: #f8f9fa; }
    .form-control:focus {
        background-color: #fff !important;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        border: 1px solid #0d6efd !important;
    }
    .rounded-4 { border-radius: 1rem !important; }
    .bg-light-subtle { background-color: #fcfcfc; }
</style>
@endsection