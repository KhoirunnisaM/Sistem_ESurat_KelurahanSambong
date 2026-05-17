@extends('layouts.admin')

@section('admin_content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="mb-4 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                <div>
                    <h4 class="fw-bold text-dark mb-1">
                        <i class="bi bi-file-earmark-bar-graph me-2 text-success"></i>Laporan Rekapitulasi
                    </h4>
                    <p class="text-muted small mb-0">Kelola dan cetak data surat yang telah selesai ke format Excel.</p>
                </div>
            </div>

            <div class="card border-0 shadow-sm mb-4" style="border-radius: 15px;">
                <div class="card-body p-3 p-md-4">
                    <form id="filterForm" action="{{ route('admin.laporan.export') }}" method="GET">
                        <div class="row g-3">
                            <div class="col-12 col-sm-6 col-md-3">
                                <label class="form-label small fw-bold text-muted">DARI TANGGAL</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-calendar-event text-success"></i></span>
                                    <input type="date" name="tgl_awal" id="tgl_awal" class="form-control bg-light border-0 shadow-none" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-6 col-md-3">
                                <label class="form-label small fw-bold text-muted">SAMPAI TANGGAL</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-calendar-check text-success"></i></span>
                                    <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control bg-light border-0 shadow-none" required>
                                </div>
                            </div>
                            <div class="col-12 col-md-3">
                                <label class="form-label small fw-bold text-muted">JENIS SURAT</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-0"><i class="bi bi-funnel text-success"></i></span>
                                    <select name="jenis_surat" id="jenis_surat" class="form-select bg-light border-0 shadow-none" required>
                                        <option value="semua">Semua Jenis Surat</option>
                                        @foreach($jenisSurat as $jenis)
                                            <option value="{{ $jenis->id }}">{{ $jenis->nama_surat ?? $jenis->nama_jenis }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-md-3 d-flex align-items-end gap-2">
                                <button type="button" id="btnPreview" class="btn btn-outline-success border-2 px-3 fw-semibold flex-grow-1">
                                    <i class="bi bi-eye me-1"></i> Preview
                                </button>
                                <button type="submit" class="btn btn-success px-3 fw-semibold flex-grow-1">
                                    <i class="bi bi-file-earmark-excel me-1"></i> Excel
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Area Preview --}}
            <div id="previewSection" style="display: none;">
                <div class="card border-0 shadow-sm" style="border-radius: 15px;">
                    <div class="card-header bg-white border-0 py-3 px-3 px-md-4">
                        <div class="d-flex flex-column flex-sm-row justify-content-between align-items-sm-center gap-2">
                            <h6 class="fw-bold mb-0 text-dark">Pratinjau Data Laporan</h6>
                            <span class="badge bg-success-subtle text-success px-3 py-2 rounded-pill w-fit-content">
                                <i class="bi bi-collection me-1"></i> <span id="dataCount">0</span> Data Ditemukan
                            </span>
                        </div>
                    </div>
                    <div id="previewContent" class="card-body p-0">
                        {{-- Isi Preview dimuat via AJAX --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('btnPreview').addEventListener('click', function() {
    const tglAwal = document.getElementById('tgl_awal').value;
    const tglAkhir = document.getElementById('tgl_akhir').value;
    const jenisSurat = document.getElementById('jenis_surat').value;

    if(!tglAwal || !tglAkhir) {
        alert('Mohon pilih rentang tanggal laporan!');
        return;
    }

    const originalBtn = this.innerHTML;
    this.innerHTML = '<span class="spinner-border spinner-border-sm me-1"></span> Loading...';
    this.disabled = true;
    
    fetch(`{{ route('admin.laporan.preview') }}?tgl_awal=${tglAwal}&tgl_akhir=${tglAkhir}&jenis_surat=${jenisSurat}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('previewSection').style.display = 'block';
            document.getElementById('previewContent').innerHTML = data.html;
            document.getElementById('dataCount').innerText = data.count;
            this.innerHTML = originalBtn;
            this.disabled = false;
        })
        .catch(error => {
            alert('Terjadi kesalahan sistem.');
            this.innerHTML = originalBtn;
            this.disabled = false;
        });
});
</script>

<style>
    /* CSS Tambahan agar badge tidak full width di mobile */
    .w-fit-content { width: fit-content; }
</style>
@endsection