@extends('layouts.admin')

@section('admin_content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h4 class="fw-bold m-0">Pengumuman</h4>
        <p class="text-muted small m-0">Kelola informasi, agenda, dan berita untuk warga.</p>
    </div>
    <a href="{{ route('admin.pengumuman.create') }}" class="btn btn-primary shadow-sm px-4">
        <i class="bi bi-plus-lg me-2"></i>Tambah Pengumuman
    </a>
</div>

<div class="card shadow-sm border-0" style="border-radius: 15px;">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3" style="width: 80px;">Media</th>
                        <th class="py-3">Informasi</th>
                        <th class="py-3">Status</th>
                        <th class="py-3">Tanggal Post</th>
                        <th class="text-end pe-4 py-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pengumuman as $p)
                    <tr>
                        <td class="ps-4">
                            @if($p->lampiran)
                                @php $ekstensi = pathinfo($p->lampiran, PATHINFO_EXTENSION); @endphp
                                @if(in_array($ekstensi, ['jpg', 'jpeg', 'png', 'webp']))
                                    <img src="{{ asset('storage/'.$p->lampiran) }}" width="60" height="45" class="rounded object-fit-cover shadow-sm">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 45px;">
                                        <i class="bi bi-file-earmark-pdf fs-4 text-danger"></i>
                                    </div>
                                @endif
                            @else
                                <div class="bg-light rounded d-flex align-items-center justify-content-center" style="width: 60px; height: 45px;">
                                    <i class="bi bi-megaphone fs-5 text-muted"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <div class="fw-bold text-dark">{{ $p->judul }}</div>
                            <div class="text-muted small text-truncate" style="max-width: 300px;">
                                {{ strip_tags($p->konten) }}
                            </div>
                        </td>
                        <td>
                            @if($p->status)
                                <div class="d-flex align-items-center text-success small">
                                    <i class="bi bi-circle-fill me-2" style="font-size: 0.5rem;"></i> Publik
                                </div>
                            @else
                                <div class="d-flex align-items-center text-muted small">
                                    <i class="bi bi-circle-fill me-2" style="font-size: 0.5rem;"></i> Draft
                                </div>
                            @endif
                        </td>
                        <td>
                            <small class="text-muted">{{ $p->created_at->translatedFormat('d M Y') }}</small>
                        </td>
                        <td class="text-end pe-4">
                            <div class="btn-group shadow-sm">
                                <a href="{{ route('admin.pengumuman.show', $p->id) }}" class="btn btn-white btn-sm border" title="Lihat Detail">
            <i class="bi bi-eye text-info"></i>
        </a>
                            
                            <a href="{{ route('admin.pengumuman.edit', $p->id) }}" class="btn btn-white btn-sm border" title="Edit">
                                    <i class="bi bi-pencil-square text-primary"></i>
                                </a>
                                <form action="{{ route('admin.pengumuman.destroy', $p->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-white btn-sm border" onclick="return confirm('Hapus pengumuman ini?')" title="Hapus">
                                        <i class="bi bi-trash3 text-danger"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="opacity-25 mb-3">
                            <p class="text-muted">Belum ada pengumuman yang diterbitkan.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('styles')
<style>
    .table thead th {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 700;
        color: #6c757d;
    }
    .badge {
        font-weight: 500;
        font-size: 0.7rem;
    }
    .btn-white {
        background-color: #fff;
    }
    .btn-white:hover {
        background-color: #f8f9fa;
    }
    .object-fit-cover {
        object-fit: cover;
    }
</style>
@endsection
@endsection