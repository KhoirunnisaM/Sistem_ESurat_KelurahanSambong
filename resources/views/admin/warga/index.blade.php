@extends('layouts.admin')

@section('admin_content')
<div class="container-fluid px-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold text-dark mb-1">Manajemen Data & Aktivasi Akun Warga</h4>
            <p class="text-muted small">Kelurahan Sambong, Kecamatan Batang, Kabupaten Batang.</p>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr class="text-muted small fw-bold text-uppercase">
                            <th class="ps-4" width="50">NO.</th>
                            <th>NAMA LENGKAP</th>
                            <th width="200">IDENTITAS (NIK)</th>
                            <th>ALAMAT</th>
                            <th width="150">STATUS</th>
                            <th class="text-center" width="120">AKSI</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($wargas as $index => $w)
                        <tr>
                            <td class="ps-4 text-muted">{{ $wargas->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ ucwords(strtolower($w->nama_lengkap)) }}</div>
                                <div class="small text-muted">{{ ucwords(strtolower($w->jenis_kelamin)) }}</div>
                            </td>
                            <td>
                                <span class="badge bg-light text-primary border fw-medium px-2 py-2">
                                    NIK: {{ $w->nik }}
                                </span>
                            </td>
                            <td>
                                <div class="small text-dark">{{ ucwords(strtolower($w->alamat_lengkap)) }}</div>
                                <div class="small text-muted text-uppercase">RT {{ $w->rt }} / RW {{ $w->rw }}</div>
                            </td>
                            <td>
                                @if($w->status_akun)
                                    <span class="badge bg-success-subtle text-success border px-3 py-2 rounded-pill small">Aktif</span>
                                @else
                                    <span class="badge bg-danger-subtle text-danger border px-3 py-2 rounded-pill small">Nonaktif</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <button class="btn btn-outline-info rounded-pill px-3 py-1 small" 
                                        style="border-width: 1px; font-size: 0.85rem;"
                                        data-bs-toggle="modal" 
                                        data-bs-target="#modalDetail{{ $w->id }}">
                                    <i class="bi bi-eye me-1"></i> Detail
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">Data warga tidak ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- MODAL DETAIL --}}
@foreach($wargas as $w)
<div class="modal fade" id="modalDetail{{ $w->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow">
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold mb-0">Detail Informasi Kependudukan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h6 class="text-primary fw-bold small text-uppercase mb-3">IDENTITAS PERSONAL</h6>
                        <hr class="mt-0 mb-3 opacity-10">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted small" width="130">Nama Lengkap</td><td class="fw-bold">: {{ ucwords(strtolower($w->nama_lengkap)) }}</td></tr>
                            <tr><td class="text-muted small">NIK</td><td class="fw-bold">: {{ $w->nik }}</td></tr>
                            <tr><td class="text-muted small">Nomor KK</td><td>: {{ $w->no_kk }}</td></tr>
                            <tr><td class="text-muted small">Jenis Kelamin</td><td>: {{ ucwords(strtolower($w->jenis_kelamin)) }}</td></tr>
                            <tr><td class="text-muted small">Tempat, Tgl. Lahir</td><td>: {{ ucwords(strtolower($w->tempat_lahir)) }}, {{ \Carbon\Carbon::parse($w->tanggal_lahir)->translatedFormat('d F Y') }}</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-primary fw-bold small text-uppercase mb-3">INFORMASI LAINNYA</h6>
                        <hr class="mt-0 mb-3 opacity-10">
                        <table class="table table-sm table-borderless mb-0">
                            <tr><td class="text-muted small" width="130">Agama</td><td>: {{ ucwords(strtolower($w->agama)) }}</td></tr>
                            <tr><td class="text-muted small">Pekerjaan</td><td>: {{ ucwords(strtolower($w->pekerjaan)) }}</td></tr>
                            <tr><td class="text-muted small">Status Kawin</td><td>: {{ ucwords(strtolower($w->status_perkawinan)) }}</td></tr>
                        </table>
                    </div>
                    <div class="col-12 mt-4">
                        <div class="p-3 bg-light rounded-3 border border-light">
                            <h6 class="text-primary fw-bold small text-uppercase mb-3">DOMISILI LENGKAP</h6>
                            <div class="row g-3">
                                <div class="col-md-4"><label class="small text-muted d-block">Jalan / Dusun</label><span class="fw-bold">{{ ucwords(strtolower($w->alamat_lengkap)) }}</span></div>
                                <div class="col-md-4"><label class="small text-muted d-block">RT / RW</label><span class="fw-bold">{{ $w->rt }} / {{ $w->rw }}</span></div>
                                <div class="col-md-4"><label class="small text-muted d-block">Kelurahan</label><span class="fw-bold">Sambong</span></div>
                                <div class="col-md-4"><label class="small text-muted d-block">Kecamatan</label><span class="fw-bold">Batang</span></div>
                                <div class="col-md-4"><label class="small text-muted d-block">Kabupaten</label><span class="fw-bold">Batang</span></div>
                                <div class="col-md-4"><label class="small text-muted d-block">Provinsi</label><span class="fw-bold">Jawa Tengah</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0 d-flex justify-content-between align-items-center">
                <div>
                    <form action="{{ route('admin.warga.toggle-status', $w->id) }}" method="POST" class="form-konfirmasi">
                        @csrf
                        <input type="hidden" name="status_sekarang" value="{{ $w->status_akun }}">
                        <input type="hidden" name="nama_warga" value="{{ ucwords(strtolower($w->nama_lengkap)) }}">
                        <button type="submit" class="btn btn-sm {{ $w->status_akun ? 'btn-danger' : 'btn-success' }} rounded-pill px-4">
                            <i class="bi {{ $w->status_akun ? 'bi-person-x-fill' : 'bi-person-check-fill' }} me-1"></i>
                            {{ $w->status_akun ? 'Nonaktifkan' : 'Aktifkan' }}
                        </button>
                    </form>
                </div>
                <button type="button" class="btn btn-dark rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endforeach

<div class="mt-4 d-flex justify-content-center">
    {{ $wargas->links() }}
</div>

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
@endsection