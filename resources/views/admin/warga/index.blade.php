@extends('layouts.admin')

@section('admin_content')
<div id="realtime-container" class="container-fluid px-2 px-md-3">
    {{-- 1. HEADER HALAMAN --}}
    <div class="mb-4">
        <h4 class="fw-bold text-dark responsive-title mb-1">Manajemen Data & Aktivasi Akun Warga</h4>
        <p class="text-muted small responsive-sub mb-0">Kelurahan Sambong, Kecamatan Batang, Kabupaten Batang.</p>
    </div>

    {{-- 2. CARD FILTER / PENCARIAN --}}
    <div class="card card-custom border-0 shadow-sm mb-4 bg-white">
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('admin.warga.index') }}" method="GET" class="d-flex flex-wrap flex-md-nowrap gap-2">
                <div class="input-group input-group-sm flex-nowrap">
                    <input type="text" name="search" class="form-control border-0 bg-light px-3 rounded-start-pill" 
                           placeholder="Cari NIK, Nama, Jenis..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-success rounded-end-pill px-3">
                        <i class="bi bi-search"></i>
                    </button>
                </div>

                @if(request('search'))
                    <a href="{{ route('admin.warga.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill d-flex align-items-center px-3">Reset</a>
                @endif
            </form>
        </div>
    </div>

    {{-- ALERT PESAN --}}
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 rounded-pill px-4 py-2" role="alert">
            <small class="fw-bold"><i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}</small>
            <button type="button" class="btn-close" data-bs-dismiss="alert" style="font-size: 0.6rem;"></button>
        </div>
    @endif

    {{-- 3. TABEL DATA --}}
    <div class="card card-custom border-0 shadow-sm overflow-hidden bg-white">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-muted small fw-bold text-uppercase" style="font-size: 0.65rem;">
                            <th class="ps-4" width="60">NO.</th>
                            <th>NAMA LENGKAP</th>
                            <th>IDENTITAS (NIK)</th>
                            <th>ALAMAT</th>
                            <th>STATUS</th>
                            <th class="text-center" width="120">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wargas as $index => $w)
                        <tr style="font-size: 0.85rem;">
                            <td class="ps-4 text-muted fw-medium">{{ $wargas->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold text-dark text-truncate" style="max-width: 200px;">{{ ucwords(strtolower($w->nama_lengkap)) }}</div>
                                <div class="small text-muted" style="font-size: 0.7rem;">{{ ucwords(strtolower($w->jenis_kelamin)) }}</div>
                            </td>
                            <td>
                                <div class="text-dark text-truncate" style="max-width: 200px;">NIK: {{ ucwords(strtolower($w->nik)) }}</div>
                            </td>
                            <td>
                                <div class="small text-dark fw-medium text-truncate" style="max-width: 200px;">{{ ucwords(strtolower($w->alamat_lengkap)) }}</div>
                                <div class="small text-muted text-uppercase" style="font-size: 0.65rem;">RT {{ $w->rt }} / RW {{ $w->rw }}</div>
                            </td>
                            <td>
                                @if($w->status_akun)
                                    <span class="badge bg-success-subtle text-success border px-3 py-1 rounded-pill small" style="font-size: 0.7rem;">Aktif</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border px-3 py-1 rounded-pill small" style="font-size: 0.7rem;">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-sm btn-outline-info rounded-pill px-3 py-1 fw-bold" 
                                        style="font-size: 0.75rem; border-width: 1px;"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalDetail{{ $w->id }}">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted small">Data warga tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if($wargas->hasPages())
            <div class="p-4 pt-3 border-top d-flex flex-column d-md-flex flex-md-row justify-content-between align-items-center gap-3">
                <div class="text-muted small responsive-text text-center text-md-start">
                    Menampilkan <b>{{ $wargas->firstItem() }}</b> - <b>{{ $wargas->lastItem() }}</b> dari <b>{{ $wargas->total() }}</b> data
                </div>
                <div class="custom-pagination">
                    {{ $wargas->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- MODAL DETAIL --}}
@foreach($wargas as $w)
<div class="modal fade" id="modalDetail{{ $w->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">Detail Informasi Kependudukan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-primary fw-bold small text-uppercase mb-3" style="letter-spacing: 0.5px;">IDENTITAS PERSONAL</h6>
                        <hr class="mt-0 mb-3 opacity-10">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted small" width="130">Nama Lengkap</td><td class="fw-bold small">: {{ ucwords(strtolower($w->nama_lengkap)) }}</td></tr>
                            <tr><td class="text-muted small">NIK</td><td class="fw-bold small">: {{ $w->nik }}</td></tr>
                            <tr><td class="text-muted small">Nomor KK</td><td class="small">: {{ $w->no_kk }}</td></tr>
                            <tr><td class="text-muted small">Jenis Kelamin</td><td class="small">: {{ ucwords(strtolower($w->jenis_kelamin)) }}</td></tr>
                            <tr><td class="text-muted small">Tempat, Tgl. Lahir</td><td class="small">: {{ ucwords(strtolower($w->tempat_lahir)) }}, {{ \Carbon\Carbon::parse($w->tanggal_lahir)->translatedFormat('d F Y') }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary fw-bold small text-uppercase mb-3" style="letter-spacing: 0.5px;">INFORMASI LAINNYA</h6>
                        <hr class="mt-0 mb-3 opacity-10">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted small" width="130">Agama</td><td class="small">: {{ ucwords(strtolower($w->agama)) }}</td></tr>
                            <tr><td class="text-muted small">Pekerjaan</td><td class="small">: {{ ucwords(strtolower($w->pekerjaan)) }}</td></tr>
                            <tr><td class="text-muted small">Status Kawin</td><td class="small">: {{ ucwords(strtolower($w->status_perkawinan)) }}</td></tr>
                        </table>
                    </div>
                    <div class="col-12">
                        <div class="p-3 bg-light rounded-4 border border-light">
                            <h6 class="text-primary fw-bold small text-uppercase mb-3" style="letter-spacing: 0.5px;">DOMISILI LENGKAP</h6>
                            <div class="row g-3">
                                <div class="col-6 col-md-4"><label class="small text-muted d-block">Jalan / Dusun</label><span class="fw-bold small">{{ ucwords(strtolower($w->alamat_lengkap)) }}</span></div>
                                <div class="col-6 col-md-4"><label class="small text-muted d-block">RT / RW</label><span class="fw-bold small">{{ $w->rt }} / {{ $w->rw }}</span></div>
                                <div class="col-6 col-md-4"><label class="small text-muted d-block">Kelurahan</label><span class="fw-bold small">{{ $w->kelurahan ?? 'Sambong' }}</span></div>
                                <div class="col-6 col-md-4"><label class="small text-muted d-block">Kecamatan</label><span class="fw-bold small">{{ $w->kecamatan ?? 'Batang' }}</span></div>
                                <div class="col-6 col-md-4"><label class="small text-muted d-block">Kabupaten</label><span class="fw-bold small">{{ $w->kabupaten ?? 'Batang' }}</span></div>
                                <div class="col-6 col-md-4"><label class="small text-muted d-block">Provinsi</label><span class="fw-bold small">{{ $w->provinsi ?? 'Jawa Tengah' }}</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0 d-flex flex-column flex-md-row justify-content-between align-items-stretch gap-2">
                <form action="{{ route('admin.warga.toggle-status', $w->id) }}" method="POST" class="form-konfirmasi m-0">
                    @csrf
                    <input type="hidden" name="status_sekarang" value="{{ $w->status_akun }}">
                    <input type="hidden" name="nama_warga" value="{{ ucwords(strtolower($w->nama_lengkap)) }}">
                    <button type="submit" class="btn btn-sm {{ $w->status_akun ? 'btn-danger' : 'btn-success' }} rounded-pill px-4 w-100 fw-bold py-2 py-md-1">
                        <i class="bi {{ $w->status_akun ? 'bi-person-x-fill' : 'bi-person-check-fill' }} me-1"></i>
                        {{ $w->status_akun ? 'Nonaktifkan' : 'Aktifkan' }}
                    </button>
                </form>
                <button type="button" class="btn btn-dark rounded-pill px-4 fw-bold" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<script>
    document.querySelectorAll('.form-konfirmasi').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const statusAktif = this.querySelector('input[name="status_sekarang"]').value == '1';
            const nama = this.querySelector('input[name="nama_warga"]').value;
            
            let pesan = '';
            if (statusAktif) {
                pesan = `PERINGATAN KONFIRMASI!\n\n` +
                        `Apakah Anda yakin ingin MENONAKTIFKAN akun warga: ${nama}?\n\n` +
                        `PENTING: Setelah dinonaktifkan, akun ini TIDAK DAPAT DIGUNAKAN oleh warga untuk login atau mengajukan surat sampai diaktifkan kembali oleh Admin.`;
            } else {
                pesan = `KONFIRMASI AKTIVASI!\n\n` +
                        `Aktifkan kembali akun warga: ${nama}?`;
            }

            if (confirm(pesan)) {
                this.submit();
            }
        });
    });
</script>

@section('styles')
<style>
    /* ─── RESPONSIVE TYPOGRAPHY ─── */
    .responsive-title { font-size: clamp(1.1rem, 2.5vw, 1.4rem); }
    .responsive-sub { font-size: clamp(0.7rem, 1.5vw, 0.85rem); }
    .responsive-text { font-size: clamp(0.7rem, 1.2vw, 0.8rem); }
    .card-custom { border-radius: 15px; }
    
    .table-custom thead th { 
        padding: 12px 8px; 
        background-color: #f8f9fa; 
        border-bottom: 2px solid #edf2f7;
    }

    /* ─── MOBILE ADAPTATION ─── */
    @media (max-width: 576px) {
        .table-responsive { border: 0; }
        .input-group { width: 100% !important; }
    }
</style>
@endsection
@endsection