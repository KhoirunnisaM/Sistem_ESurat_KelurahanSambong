@extends('layouts.admin')

@section('admin_content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold text-dark">Data Pegawai & Staff</h4>
        <p class="text-muted small">Kelola informasi SDM Kelurahan Sambong.</p>
    </div>
    <button class="btn btn-success rounded-pill px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="bi bi-plus-lg me-2"></i>Tambah Data
    </button>
</div>

<div class="card border-0 shadow-sm mb-4">
    <div class="card-body">
        <form action="{{ route('admin.pegawai.index') }}" method="GET" class="row g-3">
            <div class="col-md-4">
                <input type="text" name="search" class="form-control form-control-sm rounded-pill" placeholder="Cari Nama, NIP..." value="{{ request('search') }}">
            </div>
            <div class="col-md-3">
                <select name="kategori" class="form-select form-select-sm rounded-pill">
                    <option value="">Semua Kategori</option>
                    <option value="Pegawai" {{ request('kategori') == 'Pegawai' ? 'selected' : '' }}>Pegawai</option>
                    <option value="Staff" {{ request('kategori') == 'Staff' ? 'selected' : '' }}>Staff</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-sm btn-dark rounded-pill px-3">Filter</button>
            </div>
        </form>
    </div>
</div>

<div class="card border-0 shadow-sm">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr class="text-muted small uppercase">
                        <th class="ps-4">No</th>
                        <th>Nama Lengkap</th>
                        <th>Identitas (NIP/NIPPPK)</th>
                        <th>Jabatan</th>
                        <th>Kategori</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pegawais as $index => $p)
                    <tr>
                        <td class="ps-4 text-muted">{{ $pegawais->firstItem() + $index }}</td>
                        <td class="fw-bold text-dark">{{ $p->nama_lengkap }}</td>
                        <td>
                            @if($p->kategori == 'Pegawai')
                                <span class="small">NIP: {{ $p->nip ?? '-' }}</span>
                            @else
                                <span class="small">NIPPPK: {{ $p->nipppk ?? '-' }}</span>
                            @endif
                        </td>
                        <td>{{ $p->jabatan }}</td>
                        <td>
                            <span class="badge {{ $p->kategori == 'Pegawai' ? 'bg-primary' : 'bg-info' }} rounded-pill">
                                {{ $p->kategori }}
                            </span>
                        </td>
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-outline-secondary border-0" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $p->id }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>
                                <form action="{{ route('admin.pegawai.destroy', $p->id) }}" method="POST">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger border-0" onclick="return confirm('Hapus data ini?')">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>

                    {{-- MODAL EDIT --}}
                    <div class="modal fade" id="modalEdit{{ $p->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <form action="{{ route('admin.pegawai.update', $p->id) }}" method="POST" class="modal-content">
                                @csrf @method('PUT')
                                <div class="modal-header"><h5>Edit Data</h5></div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Lengkap</label>
                                        <input type="text" name="nama_lengkap" class="form-control" value="{{ $p->nama_lengkap }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Kategori</label>
                                        <select name="kategori" class="form-select" required>
                                            <option value="Pegawai" {{ $p->kategori == 'Pegawai' ? 'selected' : '' }}>Pegawai</option>
                                            <option value="Staff" {{ $p->kategori == 'Staff' ? 'selected' : '' }}>Staff</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">NIP (Kosongkan jika Staff)</label>
                                        <input type="text" name="nip" class="form-control" value="{{ $p->nip }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">NIPPPK (Kosongkan jika Pegawai)</label>
                                        <input type="text" name="nipppk" class="form-control" value="{{ $p->nipppk }}">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Jabatan</label>
                                        <input type="text" name="jabatan" class="form-control" value="{{ $p->jabatan }}" required>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-dark px-4 rounded-pill">Update</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @empty
                    <tr><td colspan="6" class="text-center py-5 text-muted small">Data tidak ditemukan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="p-4">
            {{ $pegawais->links() }}
        </div>
    </div>
</div>

{{-- MODAL TAMBAH --}}
<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <form action="{{ route('admin.pegawai.store') }}" method="POST" class="modal-content shadow">
            @csrf
            <div class="modal-header border-0">
                <h5 class="fw-bold">Tambah Personel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="small fw-bold">Kategori</label>
                    <select name="kategori" class="form-select bg-light border-0" required>
                        <option value="Pegawai">Pegawai (PNS)</option>
                        <option value="Staff">Staff (PPPK/Lainnya)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control bg-light border-0" placeholder="Masukkan nama tanpa gelar" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="small fw-bold">NIP</label>
                        <input type="text" name="nip" class="form-control bg-light border-0" placeholder="Khusus PNS">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small fw-bold">NIPPPK</label>
                        <input type="text" name="nipppk" class="form-control bg-light border-0" placeholder="Khusus Staff">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control bg-light border-0" placeholder="Contoh: Lurah, Kasi, Staff IT" required>
                </div>
            </div>
            <div class="modal-footer border-0">
                <button type="submit" class="btn btn-success px-4 rounded-pill">Simpan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection