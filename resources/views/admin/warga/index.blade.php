@extends('layouts.admin')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark">
            {{ request('filter_akun') ? 'Warga Terdaftar Akun' : 'Database Semua Warga' }}
        </h4>
        <p class="text-muted small mb-0">Menampilkan data penduduk Kelurahan Sambong yang terdaftar dalam sistem.</p>
    </div>
    <button class="btn btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg me-2"></i>Tambah Warga
    </button>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr class="text-muted small fw-bold">
                        <th class="ps-4" width="50">NO</th>
                        <th>NAMA LENGKAP</th>
                        <th>IDENTITAS (NIK)</th>
                        <th>ALAMAT</th>
                        <th>PEKERJAAN</th>
                        <th class="text-center">AKSI</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($wargas as $index => $w)
                    <tr>
                        <td class="ps-4 text-muted">{{ $wargas->firstItem() + $index }}</td>
                        <td>
                            <div class="fw-bold text-dark">{{ $w->nama_lengkap }}</div>
                            <small class="text-muted">{{ $w->jenis_kelamin }}</small>
                        </td>
                        <td>
                            <span class="badge bg-light text-primary border fw-medium">NIK: {{ $w->nik }}</span>
                        </td>
                        <td>
                            <div class="small text-dark">{{ $w->alamat_lengkap }}</div>
                            <small class="text-muted">RT {{ $w->rt }} / RW {{ $w->rw }}</small>
                        </td>
                        <td>
                            <span class="badge bg-light text-dark fw-normal border">{{ $w->pekerjaan }}</span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-info border-0" title="Lihat Detail" data-bs-toggle="modal" data-bs-target="#modalDetail{{ $w->id }}">
                                    <i class="bi bi-eye-fill"></i>
                                </button>
                                <button class="btn btn-sm btn-outline-secondary border-0" title="Edit Data" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $w->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('admin.warga.destroy', $w->id) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus data warga ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalDetail{{ $w->id }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content border-0 shadow">
                                <div class="modal-header border-0 pb-0">
                                    <h5 class="fw-bold text-success mb-0"><i class="bi bi-person-vcard me-2"></i>Detail Warga</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="p-3 bg-light rounded-3 mb-3 text-center">
                                        <h5 class="fw-bold mb-1">{{ $w->nama_lengkap }}</h5>
                                        <span class="badge bg-success rounded-pill px-3">{{ $w->nik }}</span>
                                    </div>
                                    <div class="row g-3">
                                        <div class="col-6">
                                            <label class="text-muted small d-block">Nomor KK</label>
                                            <span class="fw-medium">{{ $w->no_kk }}</span>
                                        </div>
                                        <div class="col-6">
                                            <label class="text-muted small d-block">Jenis Kelamin</label>
                                            <span class="fw-medium">{{ $w->jenis_kelamin }}</span>
                                        </div>
                                        <div class="col-6">
                                            <label class="text-muted small d-block">Tempat, Tgl Lahir</label>
                                            <span class="fw-medium">{{ $w->tempat_lahir }}, {{ \Carbon\Carbon::parse($w->tanggal_lahir)->format('d/m/Y') }}</span>
                                        </div>
                                        <div class="col-6">
                                            <label class="text-muted small d-block">Agama</label>
                                            <span class="fw-medium">{{ $w->agama }}</span>
                                        </div>
                                        <div class="col-6">
                                            <label class="text-muted small d-block">Pekerjaan</label>
                                            <span class="fw-medium">{{ $w->pekerjaan }}</span>
                                        </div>
                                        <div class="col-6">
                                            <label class="text-muted small d-block">Status Perkawinan</label>
                                            <span class="fw-medium">{{ $w->status_perkawinan }}</span>
                                        </div>
                                        <div class="col-12">
                                            <hr class="my-1">
                                            <label class="text-muted small d-block">Alamat Lengkap</label>
                                            <span class="fw-medium text-dark">{{ $w->alamat_lengkap }} (RT {{ $w->rt }} / RW {{ $w->rw }})</span>
                                        </div>
                                        <div class="col-12">
                                            <label class="text-muted small d-block">Status Akun Sistem</label>
                                            <span class="badge {{ $w->status_akun ? 'bg-light-success text-success' : 'bg-light-danger text-danger' }} px-3">
                                                {{ $w->status_akun ? 'Aktif Terdaftar' : 'Belum Terdaftar' }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Tutup</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5 text-muted">
                            <i class="bi bi-person-x fs-1 d-block mb-2"></i>
                            Data warga tidak ditemukan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $wargas->appends(request()->input())->links() }}
</div>
@endsection