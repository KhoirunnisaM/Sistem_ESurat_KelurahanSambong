@extends('layouts.app')

@section('content')
<div class="container py-3 py-md-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            {{-- Header --}}
            <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center gap-3 mb-4">
               
            <div class="d-flex gap-2 w-10 w-sm-auto">
                    <a href="{{ session('url_asal_surat', route('warga.riwayat')) }}" class="btn btn-white bg-white border shadow-sm rounded-pill px-3 py-1 w-sm-auto text-center">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div><div>
                    <h4 class="fw-bold text-dark mb-0">Rincian Pengajuan</h4>
                </div>
                
            </div>

            <div class="row g-4">
                {{-- BAGIAN KIRI (Data Pemohon) --}}
                {{-- Pada mobile tampil kedua (order-2), pada desktop tampil pertama (order-md-1) --}}
                <div class="col-12 col-md-7 order-2 order-md-1">
                    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                        <div class="card-header bg-white border-0 pt-4 px-3 px-md-4">
                            <h6 class="fw-bold mb-0 "><i class="bi bi-person-lines-fill me-2 text-success"></i>Data Pemohon</h6>
                        </div>
                        <div class="card-body p-3 p-md-4">
                            <div class="mb-4 text-center p-3 bg-light rounded-4">
                                <h5 class="fw-bold text-dark mb-1 fs-5 fs-md-4">{{ strtoupper($warga['nama_lengkap']) }}</h5>
                                <p class="text-muted small mb-0">NIK: {{ $warga['nik'] }}</p>
                            </div>

                            <div class="row g-3">
                                <div class="col-12 col-sm-12">
                                    <label class="text-muted small d-block mb-1">Tempat, Tgl Lahir</label>
                                    <span class="fw-semibold small">{{ $warga['tempat_lahir'] }}, {{ \Carbon\Carbon::parse($warga['tanggal_lahir'])->format('d/m/Y') }}</span>
                                </div>
                                <div class="col-12 col-sm-12">
                                    <label class="text-muted small d-block mb-1">Agama</label>
                                    <span class="fw-semibold small">{{ $warga['agama'] }}</span>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted small d-block mb-1">Pekerjaan</label>
                                    <span class="fw-semibold small">{{ $warga['pekerjaan'] }}</span>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted small d-block mb-1">Alamat Lengkap</label>
                                    <span class="fw-semibold small">
                                        {{ $warga['alamat_lengkap'] }}, RT.{{ $warga['rt'] }} RW.{{ $warga['rw'] }}, 
                                        Kel. {{ $warga['kelurahan'] ?? 'Sambong' }}, Kec. {{ $warga['kecamatan'] ?? 'Batang' }}, 
                                        Kab. {{ $warga['kabupaten'] ?? 'Batang' }}, {{ $warga['provinsi'] ?? 'Jawa Tengah' }}
                                    </span>
                                </div>
                            </div>

                            @if($surat->jenis_surat_id == 6)
                                <hr class="my-4 opacity-50">
                                <h6 class="fw-bold mb-3 text-success"><i class="bi bi-shop me-2"></i>Detail Usaha / Lembaga</h6>
                                <div class="row g-3 p-3 border rounded-4 bg-light-subtle">
                                    <div class="col-12">
                                        <label class="text-muted small d-block mb-1">Nama Usaha/Lembaga</label>
                                        <span class="fw-bold text-dark small">{{ $surat->nama_lembaga ?? $surat->lembaga ?? '-' }}</span>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <label class="text-muted small d-block mb-1">Penanggung Jawab</label>
                                        <span class="fw-semibold small">{{ $surat->penanggung_jawab ?? $surat->pimpinan ?? '-' }}</span>
                                    </div>
                                    <div class="col-12 col-sm-12">
                                        <label class="text-muted small d-block mb-1">Jabatan</label>
                                        <span class="fw-semibold small">{{ $surat->jabatan_penanggung_jawab ?? '-' }}</span>
                                    </div>
                                    <div class="col-12">
                                        <label class="text-muted small d-block mb-1">Alamat Usaha</label>
                                        <span class="fw-semibold small">{{ $surat->alamat_lembaga ?? $surat->lokasi ?? '-' }}</span>
                                    </div>
                                </div>
                            @endif

                            <hr class="my-4 opacity-50">

                            <div class="mb-3">
                                <label class="text-muted small d-block mb-1">Keperluan</label>
                                <div class="fw-semibold small lh-base mb-0">
                                    {{ $surat->keperluan }}
                                </div>
                            </div>

                            <div>
                                <label class="text-muted small d-block mb-1">Keterangan </label>
                                <p class="fw-semibold small lh-base mb-0">
                                    {{ $surat->keterangan ?? 'Bahwa orang tersebut adalah warga Kelurahan Sambong dan berkelakuan baik.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- BAGIAN KANAN (Status & Lampiran) --}}
                {{-- Pada mobile tampil pertama (order-1), pada desktop tampil kedua (order-md-2) --}}
                <div class="col-12 col-md-5 order-1 order-md-2">
                    <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
                        <div class="card-body p-3 p-md-4">
                            <h6 class="fw-bold mb-3">Status Pengajuan</h6>
                            
                            @php
                                $status = strtolower($surat->status);
                                $config = [
                                    'diajukan'   => ['bg' => 'bg-warning',   'text' => 'text-dark',  'border' => 'border-warning'],
                                    'diproses'   => ['bg' => 'bg-info',      'text' => 'text-white', 'border' => 'border-info'],
                                    'selesai'    => ['bg' => 'bg-success',   'text' => 'text-white', 'border' => 'border-success'],
                                    'ditolak'    => ['bg' => 'bg-danger',    'text' => 'text-white', 'border' => 'border-danger'],
                                    'dibatalkan' => ['bg' => 'bg-secondary', 'text' => 'text-white', 'border' => 'border-secondary'],
                                ];
                                $c = $config[$status] ?? $config['diajukan'];
                            @endphp
                            
                            {{-- Modifikasi Box Status Responsif --}}
                            <div class="p-3 {{ $c['bg'] }} bg-opacity-10 rounded-4 border {{ $c['border'] }}">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="rounded-circle {{ $c['bg'] }} {{ $c['text'] }} p-1 p-sm-2 me-2 me-sm-3 shadow-sm flex-shrink-0">
                                        <i class="bi bi-clock-history fs-6 fs-md-5 px-1"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-bold text-dark fs-6 fs-md-5">{{ strtoupper($surat->status) }}</h6>
                                        <small class="text-muted d-block text-time">
                                            Diperbarui: {{ $surat->updated_at->format('d M Y, H:i') }}
                                        </small>
                                    </div>
                                </div>

                                @if($status == 'selesai' || $status == 'diproses' || $status == 'ditolak' || $status == 'dibatalkan')
                                <div class="bg-white rounded-3 p-2 p-sm-3 border {{ $c['border'] }} shadow-sm">
                                    @if(($status == 'selesai' || $status == 'diproses') && $surat->nomor_surat)
                                        <div class="text-center py-1">
                                            <span class="text-muted small d-block mb-1" style="font-size: 0.7rem;">NOMOR SURAT:</span>
                                            <h6 class="fw-bold text-dark mb-0 text-break fs-6 fs-md-5">{{ $surat->nomor_surat }}</h6>
                                        </div>
                                    @endif

                                    @if($status == 'selesai')
                                        <div class="mt-2 mt-sm-3 p-2 bg-success-subtle text-success rounded-2 text-center border border-success-subtle">
                                            <i class="bi bi-info-circle-fill me-1 small"></i>
                                            <small class="fw-semibold d-block text-start text-sm-center text-info-finish">
                                                Surat dapat diambil di Kantor Pelayanan Kelurahan Sambong pada jam kerja 
                                                <span class="d-block mt-1">(Senin - Kamis, 07.30 - 16.00 WIB. <br class="d-none d-sm-inline"> Jumat, 07.30 - 11.00)</span>
                                            </small>
                                        </div>
                                    @endif

                                    @if($status == 'ditolak')
                                        <div class="mb-2">
                                            <label class="text-danger small fw-bold d-block mb-1" style="font-size: 0.65rem !important;">ALASAN PENOLAKAN:</label>
                                            <p class="text-dark mb-2 lh-sm text-break" style="font-size: 0.8rem;">{{ $surat->alasan_ditolak ?? 'Keterangan data salah atau tidak lengkap.' }}</p>
                                        </div>
                                        <div class="p-2 {{ $c['bg'] }} bg-opacity-10 rounded-2">
                                            <small class="text-danger fw-bold d-block" style="font-size: 0.7rem;">
                                                Warga harus mengajukan ulang dengan berkas yang benar.
                                            </small>
                                        </div>
                                    @endif

                                    @if($status == 'dibatalkan')
                                        <div class="text-center py-1">
                                            <h6 class="fw-bold text-secondary mb-0 fs-6">Dibatalkan oleh Warga</h6>
                                        </div>
                                    @endif
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                        <div class="card-body p-3 p-md-4">
                            <h6 class="fw-bold mb-3"><i class="bi bi-paperclip me-2 text-success"></i>Lampiran Dokumen</h6>
                            <div class="vstack gap-3">
                                <div class="p-2 border rounded-4 bg-light">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-white p-2 rounded-3 shadow-sm me-3 flex-shrink-0">
                                                <i class="bi bi-file-earmark-image fs-4 text-success"></i>
                                            </div>
                                            <span class="small fw-bold text-muted">Pengantar RT</span>
                                        </div>
                                        @if($surat->scan_pengantar_rt)
                                            <button type="button" class="btn btn-sm btn-success rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalRT">Lihat</button>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">Kosong</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-2 border rounded-4 bg-light">
                                    <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-white p-2 rounded-3 shadow-sm me-3 flex-shrink-0">
                                                <i class="bi bi-person-badge fs-4 text-success"></i>
                                            </div>
                                            <span class="small fw-bold text-muted">KK / KTP</span>
                                        </div>
                                        @if($surat->scan_ktp_kk)
                                            <button type="button" class="btn btn-sm btn-success rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalKK">Lihat</button>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">Kosong</span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if($surat->status == 'Diajukan')
                            <div class="mt-4 pt-3 border-top vstack gap-2">
                                <a href="{{ route('warga.surat.edit', $surat->id) }}" class="btn btn-warning w-100 fw-bold rounded-pill">
                                    <i class="bi bi-pencil-square me-2"></i>Edit Data
                                </a>
                                <form id="formBatal" action="{{ route('warga.surat.batal', $surat->id) }}" method="POST" class="w-100">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-danger w-100 btn-sm text-decoration-none fw-bold pt-2">
                                        Batalkan Pengajuan
                                    </button>
                                </form>          
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MODAL AREA --}}
@if($surat->scan_pengantar_rt)
<div class="modal fade" id="modalRT" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered px-3">
        <div class="modal-content border-0 shadow" style="border-radius: 15px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Pratinjau Pengantar RT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-3">
                <img src="{{ asset('storage/' . $surat->scan_pengantar_rt) }}" class="img-fluid rounded-3">
            </div>
        </div>
    </div>
</div>
@endif

@if($surat->scan_ktp_kk)
<div class="modal fade" id="modalKK" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered px-3">
        <div class="modal-content border-0 shadow" style="border-radius: 15px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Pratinjau KK / KTP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center p-3">
                <img src="{{ asset('storage/' . $surat->scan_ktp_kk) }}" class="img-fluid rounded-3">
            </div>
        </div>
    </div>
</div>
@endif

<style>
    body { background-color: #f8f9fa; }
    .btn-white:hover { background-color: #f1f1f1 !important; }
    .bg-success-subtle { background-color: #e8f5e9 !important; }
    .text-success { color: #198754 !important; }
    .border-success { border-color: #198754 !important; }
    .bg-light-subtle { background-color: #fcfcfc; border: 1px dashed #dee2e6 !important; }
    .rounded-4 { border-radius: 1rem !important; }
    label { letter-spacing: 0.5px; text-transform: uppercase; font-size: 0.7rem !important; font-weight: 700; }
    .bg-opacity-10 { --bs-bg-opacity: 0.1; }
    .border-danger { border-color: #dc3545 !important; }
    .border-secondary { border-color: #6c757d !important; }
    .w-sm-auto { @media (min-width: 576px) { width: auto !important; } }
    
    /* Tambahan font size responsif via media query agar lebih smooth */
    .text-time { font-size: 0.75rem; }
    .text-info-finish { font-size: 0.75rem; }
    
    @media (min-width: 576px) {
        .text-time { font-size: 0.875rem; }
        .text-info-finish { font-size: 0.8rem; }
    }
</style>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const formBatal = document.getElementById('formBatal');
        
        if (formBatal) {
            formBatal.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: 'Batalkan Pengajuan?',
                    text: "Tindakan ini tidak dapat dibatalkan kembali.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#dc3545',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Batalkan!',
                    cancelButtonText: 'Tidak, Tetap Ajukan',
                    reverseButtons: true,
                    customClass: {
                        popup: 'rounded-4 shadow-sm',
                        confirmButton: 'rounded-pill px-4',
                        cancelButton: 'rounded-pill px-4'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Membatalkan...',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });
                        this.submit();
                    }
                });
            });
        }
    });
</script>
@endpush