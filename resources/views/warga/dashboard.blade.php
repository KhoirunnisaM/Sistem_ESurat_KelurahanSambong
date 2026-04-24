@extends('layouts.app')

@section('content')
<style>
    :root { --primary-green: #198754; --secondary-green: #20c997; }
    body { background-color: #f4f7f6; }
    .navbar-custom { background: white; box-shadow: 0 2px 15px rgba(0,0,0,0.05); }
    .card-main { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
    .btn-create {
        background: linear-gradient(45deg, var(--primary-green), var(--secondary-green));
        border: none; color: white; padding: 10px 25px; border-radius: 10px; font-weight: 600;
    }
    .status-badge { padding: 6px 12px; border-radius: 30px; font-size: 0.75rem; font-weight: 600; display: inline-block; min-width: 80px; text-align: center; }
    .bg-diajukan { background-color: #ffc107; color: #000; }
    .bg-proses { background-color: #0dcaf0; color: #fff; }
    .bg-selesai { background-color: #198754; color: #fff; }
    .bg-batal { background-color: #6c757d; color: #fff; }
</style>

<div class="container py-5">
    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm mb-4 alert-dismissible fade show">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card card-main">
        <div class="card-body p-4">
            <div class="d-md-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Daftar Pengajuan Surat</h4>
                    <p class="text-muted small mb-0">Klik detail untuk melihat rincian atau mengubah data.</p>
                </div>
                <div class="dropdown mt-3 mt-md-0">
                    <button class="btn btn-create dropdown-toggle" type="button" data-bs-toggle="dropdown">
                        <i class="bi bi-plus-circle me-2"></i> BUAT SURAT BARU
                    </button>
                    <ul class="dropdown-menu border-0 shadow">
                        <li><a class="dropdown-item" href="{{ route('surat.buat', 'skck') }}">Pengantar SKCK</a></li>
                        <li><a class="dropdown-item" href="{{ route('surat.buat', 'keterangan-usaha') }}">Keterangan Usaha</a></li>
                        <li><a class="dropdown-item" href="{{ route('surat.buat', 'pengantar-umum') }}">Pengantar Umum</a></li>
                    </ul>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-light">
                        <tr>
                            <th class="px-4">No. Pengajuan</th>
                            <th>Jenis Surat</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($riwayat_surat as $surat)
                        @php
                            $no_surat = \Carbon\Carbon::parse($surat->created_at)->format('my') . '-' . str_pad($surat->id, 3, '0', STR_PAD_LEFT);
                        @endphp
                        <tr>
                            <td class="px-4 text-muted small fw-bold">{{ $no_surat }}</td>
                            <td class="fw-bold text-uppercase">{{ str_replace('-', ' ', $surat->jenis_surat) }}</td>
                            <td>{{ $surat->created_at->format('d-m-Y') }}</td>
                            <td>
                                <span class="status-badge bg-{{ strtolower(str_replace(' ', '', $surat->status)) == 'diproses' ? 'proses' : (strtolower($surat->status) == 'diajukan' ? 'diajukan' : (strtolower($surat->status) == 'selesai' ? 'selesai' : 'batal')) }}">
                                    {{ ucfirst($surat->status) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('warga.surat.detail', $surat->id) }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill">
                                    <i class="bi bi-search me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada data.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection