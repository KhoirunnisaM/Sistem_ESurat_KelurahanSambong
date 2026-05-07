@extends('layouts.admin')

@section('admin_content')
<div class="mb-4">
    <a href="{{ route('admin.pengumuman.index') }}" class="btn btn-light border btn-sm px-3 mb-3">
        <i class="bi bi-arrow-left me-1"></i> Kembali
    </a>
    <div class="d-flex justify-content-between align-items-start">
        <div>
            <h3 class="fw-bold text-dark mb-1">{{ $pengumuman->judul }}</h3>
            <p class="text-muted">
                Diterbitkan pada {{ $pengumuman->created_at->translatedFormat('d F Y') }} 
                <span class="mx-2">•</span> 
                Status: {!! $pengumuman->status ? '<span class="text-success">Publik</span>' : '<span class="text-muted">Draft</span>' !!}
            </p>
        </div>
        <div class="btn-group">
            <a href="{{ route('admin.pengumuman.edit', $pengumuman->id) }}" class="btn btn-outline-primary btn-sm px-3">
                <i class="bi bi-pencil me-1"></i> Edit
            </a>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm border-0 p-4 mb-4" style="border-radius: 15px;">
            <div class="pengumuman-body text-dark" style="line-height: 1.8; white-space: pre-line;">
                {{ $pengumuman->konten }}
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
            <div class="card-header bg-white fw-bold border-0 pt-4 px-4">
                Lampiran & Media
            </div>
            <div class="card-body px-4 pb-4">
                @if($pengumuman->lampiran)
                    @php 
                        $ekstensi = pathinfo($pengumuman->lampiran, PATHINFO_EXTENSION); 
                        $nama_file = basename($pengumuman->lampiran);
                    @endphp

                    @if(in_array($ekstensi, ['jpg', 'jpeg', 'png', 'webp']))
                        <div class="mb-3">
                            <img src="{{ asset('storage/'.$pengumuman->lampiran) }}" class="img-fluid rounded shadow-sm border">
                        </div>
                    @else
                        <div class="bg-light rounded p-3 d-flex align-items-center mb-3">
                            <i class="bi bi-file-earmark-pdf-fill fs-2 text-danger me-3"></i>
                            <div class="text-truncate">
                                <span class="d-block small fw-bold text-dark text-truncate">{{ $nama_file }}</span>
                                <span class="text-muted small text-uppercase">{{ $ekstensi }}</span>
                            </div>
                        </div>
                    @endif

                    <div class="d-grid gap-2">
                        <a href="{{ asset('storage/'.$pengumuman->lampiran) }}" target="_blank" class="btn btn-primary btn-sm">
                            <i class="bi bi-eye me-1"></i> Lihat / Buka
                        </a>
                        <a href="{{ asset('storage/'.$pengumuman->lampiran) }}" download class="btn btn-light border btn-sm">
                            <i class="bi bi-download me-1"></i> Unduh File
                        </a>
                    </div>
                @else
                    <div class="text-center py-4">
                        <i class="bi bi-file-earmark-x text-muted fs-1 d-block mb-2"></i>
                        <span class="text-muted small">Tidak ada lampiran</span>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection