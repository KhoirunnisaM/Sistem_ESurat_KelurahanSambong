@extends('layouts.admin')

@section('admin_content')
<div id="realtime-container" class="container-fluid px-2 px-md-3">
    {{-- 1. HEADER HALAMAN --}}
    <div class="d-flex flex-column d-md-flex flex-md-row justify-content-between align-items-md-center mb-4 gap-3">
        <div>
            <h4 class="fw-bold text-dark responsive-title mb-1">Data Pegawai & Staff</h4>
            <p class="text-muted small responsive-sub mb-0">Kelola informasi SDM Kelurahan Sambong.</p>
        </div>
        <button class="btn btn-success rounded-pill px-4 btn-sm-responsive" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="bi bi-plus-lg me-2"></i>Tambah Data
        </button>
    </div>

  

    {{-- 2. FILTER SEARCH --}}
    <div class="card card-custom bg-white border-0 shadow-sm mb-4">
        <div class="card-body p-3 p-md-4">
            <form action="{{ route('admin.pegawai.index') }}" method="GET" class="row g-2">
                <div class="col-12 col-md-5">
                    <input type="text" name="search" class="form-control form-control-sm border-0 bg-light px-3 rounded-pill" 
                           placeholder="Cari Nama, NIP..." value="{{ request('search') }}">
                </div>
                <div class="col-8 col-md-4">
                    <select name="kategori" class="form-select form-select-sm border-0 bg-light px-3 rounded-pill">
                        <option value="">Semua Kategori</option>
                        <option value="Pegawai" {{ request('kategori') == 'Pegawai' ? 'selected' : '' }}>Pegawai</option>
                        <option value="Staff" {{ request('kategori') == 'Staff' ? 'selected' : '' }}>Staff</option>
                    </select>
                </div>
                <div class="col-4 col-md-3">
                    <button type="submit" class="btn btn-sm btn-dark rounded-pill w-100 px-3">Filter</button>
                </div>
            </form>
        </div>
    </div>

    {{-- 3. TABEL DATA --}}
    <div class="card card-custom bg-white border-0 shadow-sm overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover table-custom align-middle mb-0">
                    <thead class="table-light">
                        <tr class="text-muted small text-uppercase" style="font-size: 0.65rem;">
                            <th class="ps-4">No</th>
                            <th>Nama Lengkap</th>
                            <th>Identitas</th>
                            <th>Jabatan</th>
                            <th>Kategori</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pegawais as $index => $p)
                        <tr style="font-size: 0.85rem;">
                            <td class="ps-4 text-muted fw-medium">{{ $pegawais->firstItem() + $index }}</td>
                            <td>
                                <div class="fw-bold text-dark text-truncate" style="max-width: 200px;">{{ $p->nama_lengkap }}</div>
                            </td>
                            <td>
                                @if($p->kategori == 'Pegawai')
                                    <span class="text-muted" style="font-size: 0.75rem;">NIP: {{ $p->nip ?? '-' }}</span>
                                @else
                                    <span class="text-muted" style="font-size: 0.75rem;">NIPPPK: {{ $p->nipppk ?? '-' }}</span>
                                @endif
                            </td>
                            <td class="text-dark fw-medium" style="font-size: 0.75rem;">{{ $p->jabatan }}</td>
                            <td>
                                @php
                                    $catColor = $p->kategori == 'Pegawai' ? 'text-primary' : 'text-info';
                                @endphp
                                <span class="{{ $catColor }} fw-bold" style="font-size: 0.65rem;">{{ strtoupper($p->kategori) }}</span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center gap-1">
                                    <button class="btn btn-sm btn-outline-secondary border-0 p-1" data-bs-toggle="modal" data-bs-target="#modalEdit{{ $p->id }}">
                                        <i class="bi bi-pencil-square"></i>
                                    </button>
                                    <form action="{{ route('admin.pegawai.destroy', $p->id) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger border-0 p-1" onclick="return confirm('Hapus data ini?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="6" class="text-center py-5 text-muted small">Data tidak ditemukan.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            {{-- PAGINATION --}}
            @if($pegawais->hasPages())
            <div class="p-4 pt-3 border-top d-flex flex-column d-md-flex flex-md-row justify-content-between align-items-center gap-3">
                <div class="text-muted small responsive-text text-center text-md-start">
                    Menampilkan <b>{{ $pegawais->firstItem() }}</b> - <b>{{ $pegawais->lastItem() }}</b> dari <b>{{ $pegawais->total() }}</b> data
                </div>
                <div class="custom-pagination">
                    {{ $pegawais->links('pagination::bootstrap-4') }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- MODALS TETAP SAMA (LOGIKA & STRUKTUR) --}}
@foreach($pegawais as $p)
<div class="modal fade" id="modalEdit{{ $p->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.pegawai.update', $p->id) }}" method="POST" class="modal-content shadow border-0" style="border-radius: 15px;">
            @csrf @method('PUT')
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold text-dark">Edit Data Personel</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="small fw-bold mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control bg-light border-0 px-3 rounded-pill" value="{{ $p->nama_lengkap }}" required>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold mb-1">Kategori</label>
                    <select name="kategori" class="form-select bg-light border-0 px-3 rounded-pill" required>
                        <option value="Pegawai" {{ $p->kategori == 'Pegawai' ? 'selected' : '' }}>Pegawai (PNS)</option>
                        <option value="Staff" {{ $p->kategori == 'Staff' ? 'selected' : '' }}>Staff (PPPK/Lainnya)</option>
                    </select>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="small fw-bold mb-1">NIP</label>
                        <input type="text" name="nip" class="form-control bg-light border-0 px-3 rounded-pill" value="{{ $p->nip }}">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small fw-bold mb-1">NIPPPK</label>
                        <input type="text" name="nipppk" class="form-control bg-light border-0 px-3 rounded-pill" value="{{ $p->nipppk }}">
                    </div>
                </div>
                <div class="mb-0">
                    <label class="small fw-bold mb-1">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control bg-light border-0 px-3 rounded-pill" value="{{ $p->jabatan }}" required>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-dark rounded-pill px-4">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('admin.pegawai.store') }}" method="POST" class="modal-content shadow border-0" style="border-radius: 15px;">
            @csrf
            <div class="modal-header border-0 pb-0">
                <h5 class="fw-bold text-dark">Tambah Personel Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="mb-3">
                    <label class="small fw-bold mb-1">Kategori</label>
                    <select name="kategori" class="form-select bg-light border-0 px-3 rounded-pill" required>
                        <option value="Pegawai">Pegawai (PNS)</option>
                        <option value="Staff">Staff (PPPK/Lainnya)</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="small fw-bold mb-1">Nama Lengkap</label>
                    <input type="text" name="nama_lengkap" class="form-control bg-light border-0 px-3 rounded-pill" placeholder="Nama tanpa gelar" required>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="small fw-bold mb-1">NIP</label>
                        <input type="text" name="nip" class="form-control bg-light border-0 px-3 rounded-pill">
                    </div>
                    <div class="col-md-6 mb-3">
                        <label class="small fw-bold mb-1">NIPPPK</label>
                        <input type="text" name="nipppk" class="form-control bg-light border-0 px-3 rounded-pill">
                    </div>
                </div>
                <div class="mb-0">
                    <label class="small fw-bold mb-1">Jabatan</label>
                    <input type="text" name="jabatan" class="form-control bg-light border-0 px-3 rounded-pill" placeholder="Contoh: Sekretaris" required>
                </div>
            </div>
            <div class="modal-footer border-0 pt-0">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success rounded-pill px-4 text-white">Simpan Data</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
    /* ─── RESPONSIVE TYPOGRAPHY ─── */
    .responsive-title { font-size: clamp(1.1rem, 2.5vw, 1.4rem); }
    .responsive-sub { font-size: clamp(0.7rem, 1.5vw, 0.85rem); }
    .responsive-text { font-size: clamp(0.7rem, 1.2vw, 0.8rem); }
    .card-custom { border-radius: 12px; }
    
    .table-custom thead th { 
        padding: 12px 8px; 
        background-color: #f8f9fa; 
        border-bottom: 2px solid #edf2f7;
    }

    /* ─── MOBILE ADAPTATION ─── */
    @media (max-width: 576px) {
        .btn-sm-responsive { font-size: 0.75rem; padding: 8px 16px !important; width: 100%; }
        .table-responsive { border: 0; }
    }
</style>
@endsection