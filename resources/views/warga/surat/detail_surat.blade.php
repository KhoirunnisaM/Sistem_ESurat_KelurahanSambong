@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold text-dark mb-1">Rincian Pengajuan</h4>
                    <p class="text-muted small mb-0">ID Pengajuan: <span class="fw-bold text-primary">{{ $no_surat_format }}</span></p>
                </div>
                <div class="d-flex gap-2">
                   <a href="{{ session('url_asal_surat', route('warga.riwayat')) }}" class="btn btn-white bg-white border shadow-sm rounded-pill px-4">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>

            <div class="row g-4">
                <div class="col-md-7">
                    <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                        <div class="card-header bg-white border-0 pt-4 px-4">
                            <h6 class="fw-bold mb-0"><i class="bi bi-person-lines-fill me-2 text-success"></i>Data Pemohon</h6>
                        </div>
                        <div class="card-body p-4">
                            <div class="mb-4 text-center p-3 bg-light rounded-4">
                                <h5 class="fw-bold text-dark mb-1">{{ strtoupper($warga['nama_lengkap']) }}</h5>
                                <p class="text-muted small mb-0">NIK: {{ $warga['nik'] }}</p>
                            </div>

                            <div class="row g-3">
                                <div class="col-6">
                                    <label class="text-muted small d-block">Tempat, Tgl Lahir</label>
                                    <span class="fw-semibold">{{ $warga['tempat_lahir'] }}, {{ \Carbon\Carbon::parse($warga['tanggal_lahir'])->format('d/m/Y') }}</span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small d-block">Agama</label>
                                    <span class="fw-semibold">{{ $warga['agama'] }}</span>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted small d-block">Pekerjaan</label>
                                    <span class="fw-semibold">{{ $warga['pekerjaan'] }}</span>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted small d-block">Alamat Lengkap</label>
                                    <span class="fw-semibold small">
                                        {{ $warga['alamat_lengkap'] }}, RT.{{ $warga['rt'] }} RW.{{ $warga['rw'] }}, 
                                        Kel. {{ $warga['kelurahan'] ?? 'Sambong' }}, Kec. {{ $warga['kecamatan'] ?? 'Batang' }}, 
                                        {{ $warga['kabupaten'] ?? 'Batang' }}, {{ $warga['provinsi'] ?? 'Jawa Tengah' }}
                                    </span>
                                </div>
                            </div>

                            @if($surat->jenis_surat_id == 6)
                                <hr class="my-4 opacity-50">
                                <h6 class="fw-bold mb-3"><i class="bi bi-shop me-2 text-primary"></i>Detail Usaha / Lembaga</h6>
                                <div class="row g-3 p-3 border rounded-4 bg-light-subtle">
                                    <div class="col-12">
                                        <label class="text-muted small d-block">Nama Usaha/Lembaga</label>
                                        <span class="fw-bold text-dark">{{ $surat->nama_lembaga ?? $surat->lembaga ?? '-' }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-muted small d-block">Penanggung Jawab</label>
                                        <span class="fw-semibold">{{ $surat->penanggung_jawab ?? $surat->pimpinan ?? '-' }}</span>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="text-muted small d-block">Jabatan</label>
                                        <span class="fw-semibold">{{ $surat->jabatan_penanggung_jawab ?? '-' }}</span>
                                    </div>
                                    <div class="col-12">
                                        <label class="text-muted small d-block">Alamat Usaha</label>
                                        <span class="fw-semibold small">{{ $surat->alamat_lembaga ?? $surat->lokasi ?? '-' }}</span>
                                    </div>
                                </div>
                            @endif

                            <hr class="my-4 opacity-50">

                            <div class="mb-3">
                                <label class="text-muted small d-block mb-1">Tujuan / Keperluan</label>
                                <div class="p-3 bg-primary-subtle border-start border-primary border-4 rounded text-primary fw-bold">
                                    {{ $surat->keperluan }}
                                </div>
                            </div>

                            <div>
                                <label class="text-muted small d-block mb-1">Keterangan Tambahan</label>
                                <p class="text-dark small lh-base">
                                    {{ $surat->keterangan ?? 'Bahwa orang tersebut adalah warga Kelurahan Sambong dan berkelakuan baik.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5">
                   <div class="card border-0 shadow-sm mb-4" style="border-radius: 20px;">
    <div class="card-body p-4">
        <h6 class="fw-bold mb-3">Status Pengajuan</h6>
        
        @php
            $status = strtolower($surat->status);
            
            // Konfigurasi warna berdasarkan status
            $config = [
                'diajukan'   => ['bg' => 'bg-warning',   'text' => 'text-dark',  'border' => 'border-warning'],
                'diproses'   => ['bg' => 'bg-info',      'text' => 'text-white', 'border' => 'border-info'],
                'selesai'    => ['bg' => 'bg-success',   'text' => 'text-white', 'border' => 'border-success'],
                'ditolak'    => ['bg' => 'bg-danger',    'text' => 'text-white', 'border' => 'border-danger'],
                'dibatalkan' => ['bg' => 'bg-secondary', 'text' => 'text-white', 'border' => 'border-secondary'],
            ];

            $c = $config[$status] ?? $config['diajukan'];
        @endphp
        
        <div class="p-3 {{ $c['bg'] }} bg-opacity-10 rounded-4 border {{ $c['border'] }}">
            <div class="d-flex align-items-start mb-3">
                <div class="rounded-circle {{ $c['bg'] }} {{ $c['text'] }} p-2 me-3 shadow-sm">
                    <i class="bi bi-clock-history fs-5"></i>
                </div>
                <div>
                    <h6 class="mb-0 fw-bold text-dark">{{ strtoupper($surat->status) }}</h6>
                    <small class="text-muted d-block">Diperbarui: {{ $surat->updated_at->format('d M Y, H:i') }}</small>
                </div>
            </div>

            @if($status == 'selesai' || $status == 'diproses' || $status == 'ditolak' || $status == 'dibatalkan')
            <div class="bg-white rounded-3 p-3 border {{ $c['border'] }} shadow-sm">
                
                @if(($status == 'selesai' || $status == 'diproses') && $surat->nomor_surat)
                    <div class="text-center py-1">
                        <span class="text-muted small d-block mb-1">NOMOR SURAT:</span>
                        <h6 class="fw-bold text-dark mb-0">{{ $surat->nomor_surat }}</h6>
                    </div>
                @endif

                @if($status == 'ditolak')
                    <div class="mb-2">
                        <label class="text-danger small fw-bold d-block mb-1">ALASAN PENOLAKAN:</label>
                        <p class="text-dark small mb-2 lh-sm">{{ $surat->alasan_ditolak ?? 'Keterangan data salah atau tidak lengkap.' }}</p>
                    </div>
                    <div class="p-2 {{ $c['bg'] }} bg-opacity-10 rounded-2">
                        <small class="text-danger fw-bold" style="font-size: 0.75rem;">
                            Warga harus mengajukan ulang dengan berkas yang benar.
                        </small>
                    </div>
                @endif

                @if($status == 'dibatalkan')
                    <div class="text-center py-2">
                        <h6 class="fw-bold text-secondary mb-0">Dibatalkan oleh Warga</h6>
                    </div>
                @endif

            </div>
            @endif
        </div>
    </div>
</div>


                    <div class="card border-0 shadow-sm" style="border-radius: 20px;">
                        <div class="card-body p-4">
                            <h6 class="fw-bold mb-3"><i class="bi bi-paperclip me-2 text-success"></i>Lampiran Dokumen</h6>
                            
                            <div class="vstack gap-3">
                                <div class="p-2 border rounded-4 bg-light">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-white p-2 rounded-3 shadow-sm me-3">
                                                <i class="bi bi-file-earmark-image fs-4 text-primary"></i>
                                            </div>
                                            <span class="small fw-bold text-muted">Pengantar RT</span>
                                        </div>
                                        @if($surat->scan_pengantar_rt)
                                            <button type="button" class="btn btn-sm btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalRT">Lihat</button>
                                        @else
                                            <span class="badge bg-danger-subtle text-danger">Kosong</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="p-2 border rounded-4 bg-light">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-white p-2 rounded-3 shadow-sm me-3">
                                                <i class="bi bi-person-badge fs-4 text-primary"></i>
                                            </div>
                                            <span class="small fw-bold text-muted">KK / KTP</span>
                                        </div>
                                        @if($surat->scan_ktp_kk)
                                            <button type="button" class="btn btn-sm btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#modalKK">Lihat</button>
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
                                <form action="{{ route('warga.surat.batal', $surat->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin?')">
                                    @csrf
                                    <button type="submit" class="btn btn-link text-danger w-100 btn-sm text-decoration-none fw-bold">Batalkan Pengajuan</button>
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
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pratinjau Pengantar RT</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('storage/' . $surat->scan_pengantar_rt) }}" class="img-fluid">
            </div>
        </div>
    </div>
</div>
@endif

@if($surat->scan_ktp_kk)
<div class="modal fade" id="modalKK" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Pratinjau KK / KTP</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center">
                <img src="{{ asset('storage/' . $surat->scan_ktp_kk) }}" class="img-fluid">
            </div>
        </div>
    </div>
</div>
@endif

<style>
    body { background-color: #f8f9fa; }
    .btn-white:hover { background-color: #f1f1f1 !important; }
    .bg-primary-subtle { background-color: #e7f1ff !important; }
    .bg-light-subtle { background-color: #fcfcfc; border: 1px dashed #dee2e6 !important; }
    .rounded-4 { border-radius: 1rem !important; }
    label { letter-spacing: 0.5px; text-transform: uppercase; font-size: 0.7rem !important; font-weight: 700; }
</style>


<style>
    /* Styling tambahan untuk menyesuaikan dengan gambar */
    .bg-opacity-10 { --bs-bg-opacity: 0.1; }
    .rounded-4 { border-radius: 1.25rem !important; }
    .border-success { border-color: #198754 !important; }
    .border-danger { border-color: #dc3545 !important; }
    .border-secondary { border-color: #6c757d !important; }
</style>
@endsection