@extends('layouts.app')

@section('content')
<style>
    :root { --primary-green: #198754; --secondary-green: #20c997; }
    .card-main { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); }
    .btn-create {
        background: linear-gradient(45deg, var(--primary-green), var(--secondary-green));
        border: none; color: white; padding: 10px 25px; border-radius: 10px; font-weight: 600;
    }
    .status-badge { padding: 6px 12px; border-radius: 30px; font-size: 0.75rem; font-weight: 600; display: inline-block; min-width: 80px; text-align: center; }
    .bg-proses { background-color: #0dcaf0; color: #fff; }
    .bg-diajukan { background-color: #ffc107; color: #000; }
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

    <div class="card card-main bg-white">
        <div class="card-body p-4">
            <div class="d-md-flex justify-content-between align-items-center mb-4">
                <div>
                    <h4 class="fw-bold mb-1">Daftar Pengajuan Surat</h4>
                    <p class="text-muted small mb-0">Klik detail untuk melihat rincian atau mengubah data.</p>
                </div>
                <button class="btn btn-create shadow-sm mt-3 mt-md-0" data-bs-toggle="modal" data-bs-target="#pilihSuratModal">
                    <i class="bi bi-plus-circle me-2"></i> BUAT SURAT BARU
                </button>
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
                        <tr>
                            <td class="px-4 text-muted small fw-bold">#{{ str_pad($surat->id, 5, '0', STR_PAD_LEFT) }}</td>
                            <td class="fw-bold">{{ $surat->jenis_surat }}</td>
                            <td>{{ $surat->created_at->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    $statusClass = [
                                        'Diajukan' => 'diajukan',
                                        'Proses' => 'proses',
                                        'Selesai' => 'selesai',
                                        'Batal' => 'batal'
                                    ][$surat->status] ?? 'diajukan';
                                @endphp
                                <span class="status-badge bg-{{ $statusClass }}">{{ $surat->status }}</span>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('warga.surat.detail', $surat->id) }}" class="btn btn-sm btn-outline-primary px-3 rounded-pill">
                                    <i class="bi bi-search me-1"></i> Detail
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="5" class="text-center py-5 text-muted">Belum ada pengajuan surat.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection