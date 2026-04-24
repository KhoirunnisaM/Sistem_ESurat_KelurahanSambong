@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="fw-bold mb-0 text-success"><i class="bi bi-file-text me-2"></i>Rincian Pengajuan Surat</h5>
                    <a href="{{ route('warga.dashboard') }}" class="btn btn-sm btn-light border">Kembali</a>
                </div>
                <div class="card-body p-4">
                    <div class="p-3 bg-light rounded-3 d-flex justify-content-between align-items-center mb-4">
                        <span class="text-muted">No. Pengajuan: <strong class="text-dark">{{ $no_surat_format }}</strong></span>
                        <span class="badge bg-{{ $surat->status == 'Diajukan' ? 'warning text-dark' : ($surat->status == 'Selesai' ? 'success' : 'secondary') }} p-2 px-3">
                            {{ strtoupper($surat->status) }}
                        </span>
                    </div>

                    <div class="row g-3 mb-5">
                        <div class="col-sm-3 text-muted">a. Nama</div>
                        <div class="col-sm-9 fw-bold">: {{ strtoupper($warga['nama_lengkap']) }}</div>

                        <div class="col-sm-3 text-muted">b. Tempat lahir</div>
                        <div class="col-sm-9">: {{ $warga['tempat_lahir'] }}, {{ \Carbon\Carbon::parse($warga['tanggal_lahir'])->format('d-m-Y') }}</div>

                        <div class="col-sm-3 text-muted">c. Agama</div>
                        <div class="col-sm-9">: {{ $warga['agama'] }}</div>

                        <div class="col-sm-3 text-muted">d. Pekerjaan</div>
                        <div class="col-sm-9">: {{ $warga['pekerjaan'] }}</div>

                        <div class="col-sm-3 text-muted">e. Alamat di KTP</div>
                        <div class="col-sm-9">: {{ $warga['alamat_lengkap'] }}, RT.{{ $warga['rt'] }} RW.{{ $warga['rw'] }}<br>
                            &nbsp; Kelurahan {{ $warga['kelurahan'] }} Kec. {{ $warga['kecamatan'] }}<br>
                            &nbsp; Kab/Kota {{ $warga['kabupaten'] }} Provinsi Jawa Tengah
                        </div>

                        <div class="col-sm-3 text-muted">h. Surat Bukti diri</div>
                        <div class="col-sm-9">: NIK. {{ $warga['nik'] }}</div>

                        <div class="col-sm-3 text-muted">i. Keperluan</div>
                        <div class="col-sm-9 text-primary fw-bold">: {{ $surat->keperluan }}</div>

                        <div class="col-sm-3 text-muted">j. Keterangan</div>
                        <div class="col-sm-9">
                            <div class="p-3 border-start border-4 border-success bg-light rounded shadow-sm">
                                {{ $surat->keterangan ?? 'Bahwa orang tersebut adalah warga Kelurahan Sambong dan berkelakuan baik.' }}
                            </div>
                        </div>
                    </div>

                    <hr class="my-5">

                    <h6 class="fw-bold mb-4 text-dark"><i class="bi bi-images me-2"></i>Scan Dokumen Lampiran</h6>
                    <div class="row g-4">
                        
                        <div class="col-md-6">
                            <div class="card h-100 border-0 bg-light text-center p-3">
                                <p class="small fw-bold text-muted mb-2">Scan Surat Pengantar RT</p>
                                @if($surat->scan_pengantar_rt)
                                    @php 
                                        $urlRt = asset('storage/' . str_replace('\\', '/', $surat->scan_pengantar_rt)) . '?t=' . time(); 
                                    @endphp
                                    <div class="img-thumbnail-wrapper mb-2">
                                        <img src="{{ $urlRt }}" 
                                             class="img-fluid rounded border shadow-sm" 
                                             style="max-height: 250px; cursor: pointer;" 
                                             data-bs-toggle="modal" 
                                             data-bs-target="#modalRT"
                                             onerror="this.onerror=null;this.src='https://placehold.co/400x300?text=File+Fisik+Tidak+Ditemukan';">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-success px-3" data-bs-toggle="modal" data-bs-target="#modalRT">
                                        <i class="bi bi-zoom-in"></i> Perbesar Gambar
                                    </button>

                                    <div class="modal fade" id="modalRT" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-success text-white">
                                                    <h6 class="modal-title"><i class="bi bi-image me-2"></i>Pratinjau Surat Pengantar RT</h6>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center bg-dark-subtle">
                                                    <img src="{{ $urlRt }}" class="img-fluid rounded shadow">
                                                </div>
                                                <div class="modal-footer text-end">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="py-5 text-danger small">
                                        <i class="bi bi-file-earmark-x fs-1"></i><br>Data Gambar Kosong
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card h-100 border-0 bg-light text-center p-3">
                                <p class="small fw-bold text-muted mb-2">Scan KK / KTP</p>
                                @if($surat->scan_ktp_kk)
                                    @php 
                                        $urlKk = asset('storage/' . str_replace('\\', '/', $surat->scan_ktp_kk)) . '?t=' . time(); 
                                    @endphp
                                    <div class="img-thumbnail-wrapper mb-2">
                                        <img src="{{ $urlKk }}" 
                                             class="img-fluid rounded border shadow-sm" 
                                             style="max-height: 250px; cursor: pointer;" 
                                             data-bs-toggle="modal" 
                                             data-bs-target="#modalKK"
                                             onerror="this.onerror=null;this.src='https://placehold.co/400x300?text=File+Fisik+Tidak+Ditemukan';">
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-success px-3" data-bs-toggle="modal" data-bs-target="#modalKK">
                                        <i class="bi bi-zoom-in"></i> Perbesar Gambar
                                    </button>

                                    <div class="modal fade" id="modalKK" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered">
                                            <div class="modal-content border-0 shadow">
                                                <div class="modal-header bg-success text-white">
                                                    <h6 class="modal-title"><i class="bi bi-image me-2"></i>Pratinjau KK / KTP</h6>
                                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                                <div class="modal-body text-center bg-dark-subtle">
                                                    <img src="{{ $urlKk }}" class="img-fluid rounded shadow">
                                                </div>
                                                <div class="modal-footer text-end">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <div class="py-5 text-danger small">
                                        <i class="bi bi-file-earmark-x fs-1"></i><br>Data Gambar Kosong
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    @if($surat->status == 'Diajukan')
                    <div class="mt-5 d-flex gap-2">
                        <a href="{{ route('warga.surat.edit', $surat->id) }}" class="btn btn-warning px-4 fw-bold shadow-sm">
                            <i class="bi bi-pencil-square me-2"></i>Edit Pengajuan
                        </a>
                        <form action="{{ route('warga.surat.batal', $surat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin membatalkan pengajuan ini?')">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger px-4">Batalkan</button>
                        </form>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .img-thumbnail-wrapper {
        background: #fff;
        padding: 5px;
        border-radius: 8px;
        overflow: hidden;
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 200px;
        border: 1px dashed #dee2e6;
    }
    .img-thumbnail-wrapper img {
        transition: transform 0.3s ease;
    }
    .img-thumbnail-wrapper img:hover {
        transform: scale(1.05);
    }
    .modal-header .btn-close-white {
        filter: brightness(0) invert(1);
    }
</style>
@endsection