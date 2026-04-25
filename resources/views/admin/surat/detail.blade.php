@extends('layouts.admin')

@section('admin_content')
<div class="mb-4">
    <a href="{{ route('admin.surat.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Daftar
    </a>
</div>

<div class="row g-4">
    <div class="col-lg-8">
        <div class="card card-custom bg-white mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Detail Pengajuan</h5>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted small">Jenis Surat</div>
                    <div class="col-sm-8 fw-bold text-success">{{ strtoupper($surat->jenis_surat) }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted small">Nama Warga</div>
                    <div class="col-sm-8">{{ $surat->warga->nama_lengkap }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted small">NIK / No. KK</div>
                    <div class="col-sm-8">{{ $surat->warga->nik }} / {{ $surat->warga->no_kk }}</div>
                </div>
                <div class="row mb-3">
                    <div class="col-sm-4 text-muted small">Keperluan</div>
                    <div class="col-sm-8">{{ $surat->keperluan }}</div>
                </div>
                <hr>
                <h6 class="fw-bold mb-3">Dokumen Lampiran</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="small text-muted mb-2">Scan Pengantar RT/RW</p>
                        <div class="position-relative group-hover">
                            <img src="{{ asset('storage/'.$surat->scan_pengantar_rt) }}" class="img-fluid rounded border w-100" style="height: 250px; object-fit: cover;">
                            <a href="{{ asset('storage/'.$surat->scan_pengantar_rt) }}" target="_blank" class="btn btn-sm btn-light position-absolute top-50 start-50 translate-middle shadow-sm">Lihat Full</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p class="small text-muted mb-2">Scan KTP & KK</p>
                        <div class="position-relative group-hover">
                            <img src="{{ asset('storage/'.$surat->scan_ktp_kk) }}" class="img-fluid rounded border w-100" style="height: 250px; object-fit: cover;">
                            <a href="{{ asset('storage/'.$surat->scan_ktp_kk) }}" target="_blank" class="btn btn-sm btn-light position-absolute top-50 start-50 translate-middle shadow-sm">Lihat Full</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card card-custom bg-white border-top border-success border-4 mb-4">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Tindakan Petugas</h5>
                
                @if($surat->status == 'Diajukan')
                <form action="{{ route('admin.surat.proses', $surat->id) }}" method="POST" id="formProses">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Nomor Surat</label>
                        <input type="text" name="nomor_surat" class="form-control form-control-sm" placeholder="Input manual..." required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Tanggal TTD</label>
                        <input type="date" name="tanggal_surat_ttd" class="form-control form-control-sm" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Pejabat TTD</label>
                        <select name="officer_id" class="form-select form-select-sm" required>
                            <option value="">-- Pilih Pejabat --</option>
                            @foreach($pegawai as $p)
                                <option value="{{ $p->id }}">{{ $p->nama_lengkap }} ({{ $p->jabatan }})</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success w-100 fw-bold mb-3 shadow-sm py-2">
                        <i class="bi bi-check-lg me-1"></i> VALIDASI & SETUJUI
                    </button>
                </form>

                <button onclick="tolakSurat()" class="btn btn-link text-danger text-decoration-none w-100 small fw-bold">
                    Tolak Pengajuan
                </button>
                @elseif($surat->status == 'Diproses' || $surat->status == 'Selesai')
                <div class="text-center py-3">
                    <i class="bi bi-patch-check-fill text-success fs-1 mb-2"></i>
                    <h6 class="fw-bold">Surat Sudah Divalidasi</h6>
                    <p class="small text-muted mb-4">Nomor: {{ $surat->nomor_surat }}</p>
                    <a href="#" class="btn btn-dark w-100 rounded-pill py-2">
                        <i class="bi bi-printer me-2"></i> CETAK SEKARANG
                    </a>
                </div>
                @else
                <div class="alert alert-danger border-0 small">
                    <strong>Surat Ditolak:</strong><br>{{ $surat->alasan_ditolak }}
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<form id="form_tolak" action="{{ route('admin.surat.tolak', $surat->id) }}" method="POST" style="display:none;">
    @csrf
    <input type="hidden" name="alasan_ditolak" id="alasan_input">
</form>

<script>
function tolakSurat() {
    let alasan = prompt("Alasan penolakan berkas:");
    if (alasan) {
        document.getElementById('alasan_input').value = alasan;
        document.getElementById('form_tolak').submit();
    }
}
</script>
@endsection