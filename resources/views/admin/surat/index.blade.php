@extends('layouts.admin')

@section('admin_content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <div>
        <h3 class="fw-bold mb-1">Daftar Permintaan Surat</h3>
        <p class="text-muted">Kelola dan verifikasi pengajuan surat warga.</p>
    </div>
</div>

<div class="card card-custom bg-white border-0">
    <div class="card-body p-4">
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <form action="" method="GET">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-0" placeholder="Cari NIK atau Nama...">
                    </div>
                </form>
            </div>
            <div class="col-md-8 d-flex justify-content-md-end gap-2">
                <a href="?status=Diajukan" class="btn btn-sm btn-outline-warning rounded-pill px-3">Menunggu</a>
                <a href="?status=Diproses" class="btn btn-sm btn-outline-primary rounded-pill px-3">Proses</a>
                <a href="?status=Selesai" class="btn btn-sm btn-outline-success rounded-pill px-3">Selesai</a>
                <a href="{{ route('admin.surat.index') }}" class="btn btn-sm btn-secondary rounded-pill px-3">Semua</a>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-custom align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="ps-4">Pemohon</th>
                        <th>Layanan Surat</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($semua_surat as $s)
                    <tr>
                        <td class="ps-4">
                            <div class="fw-bold text-dark">{{ $s->warga->nama_lengkap }}</div>
                            <div class="small text-muted">{{ $s->warga->nik }}</div>
                        </td>
                        <td>
                            <div class="badge bg-light text-dark border fw-medium">{{ $s->jenis_surat }}</div>
                            <div class="small text-muted mt-1">{{ $s->created_at->format('d/m/Y H:i') }}</div>
                        </td>
                        <td>
                            <span class="status-badge badge bg-light-{{ $s->status == 'Diajukan' ? 'warning' : ($s->status == 'Ditolak' ? 'danger' : 'success') }} text-{{ $s->status == 'Diajukan' ? 'warning' : ($s->status == 'Ditolak' ? 'danger' : 'success') }}">
                                {{ $s->status }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.surat.show', $s->id) }}" class="btn btn-sm btn-dark rounded-pill px-3">
                                <i class="bi bi-eye me-1"></i> Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center py-5 text-muted">Tidak ada data surat ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection