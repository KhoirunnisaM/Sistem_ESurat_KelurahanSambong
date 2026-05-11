<div class="table-responsive">
    <table class="table table-hover align-middle mb-0">
        <thead>
            <tr>
                <th class="px-3 px-md-4 py-3 border-bottom text-muted fw-bold" style="width: 45%; font-size: clamp(0.6rem, 1vw, 0.75rem); letter-spacing: 0.5px;">LAYANAN & DETAIL</th>
                <th class="py-3 border-bottom text-muted fw-bold" style="width: 30%; font-size: clamp(0.6rem, 1vw, 0.75rem); letter-spacing: 0.5px;">WAKTU PENGAJUAN</th>
                <th class="py-3 text-center border-bottom text-muted fw-bold" style="width: 25%; font-size: clamp(0.6rem, 1vw, 0.75rem); letter-spacing: 0.5px;">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($terbaru as $r)
            <tr onclick="window.location='{{ route('warga.surat.detail', $r->id) }}';" style="cursor: pointer;">
                <td class="px-3 px-md-4 py-3">
                    <div class="fw-bold text-dark mb-1 responsive-td-title">
                        {{ strtoupper($r->jenisSurat->nama_jenis) }}
                    </div>
                    
                    @if(($r->status == 'Selesai' || $r->status == 'Diproses') && $r->nomor_surat)
                        <div class="d-flex align-items-center">
                            <span class="text-success fw-medium responsive-td-sub">
                                <i class="bi bi-hash"></i> {{ $r->nomor_surat }}
                            </span>
                        </div>
                    @elseif($r->status == 'Ditolak' && $r->alasan_ditolak)
                        <div class="mt-1">
                            <small class="text-danger d-block lh-sm fst-italic responsive-td-extra" style="max-width: 250px;">
                                * {{ $r->alasan_ditolak }}
                            </small>    
                        </div>
                    @elseif($r->status == 'Dibatalkan')
                        <small class="text-muted fst-italic responsive-td-extra">* Dibatalkan oleh Warga</small>
                    @endif
                </td>
                
                <td class="py-3">
                    <div class="text-dark fw-medium responsive-td-date">{{ $r->created_at->format('d/m/Y') }}</div>
                    <div class="text-muted responsive-td-sub">{{ $r->created_at->format('H:i') }} WIB</div>
                </td>

                <td class="py-3 text-center">
                    @php
                        $statusColor = [
                            'Diajukan'   => 'text-warning',
                            'Diproses'   => 'text-primary',
                            'Ditolak'    => 'text-danger',
                            'Selesai'    => 'text-success',
                            'Dibatalkan' => 'text-secondary'
                        ];
                        $statusKey = ucfirst(strtolower($r->status));
                        $currentColor = $statusColor[$statusKey] ?? 'text-muted';
                    @endphp
                    
                    <span class="{{ $currentColor }} fw-bold px-2 py-1 responsive-badge" style="letter-spacing: 0.5px;">
                        {{ strtoupper($r->status) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-2 d-block mb-2 opacity-50"></i>
                    <span class="small">Belum ada pengajuan terbaru.</span>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
    /* Menggunakan clamp(ukuran_minimal, ukuran_ideal, ukuran_maksimal) */
    .responsive-td-title {
        font-size: clamp(0.75rem, 1.2vw, 0.85rem);
    }
    .responsive-td-date {
        font-size: clamp(0.75rem, 1.2vw, 0.9rem);
    }
    .responsive-td-sub {
        font-size: clamp(0.65rem, 1vw, 0.75rem);
    }
    .responsive-td-extra {
        font-size: clamp(0.6rem, 0.9vw, 0.7rem);
    }
    .responsive-badge {
        font-size: clamp(0.55rem, 0.8vw, 0.65rem);
    }

    /* Penyesuaian padding tabel untuk layar kecil */
    @media (max-width: 576px) {
        .table > :not(caption) > * > * {
            padding-left: 0.5rem !important;
            padding-right: 0.5rem !important;
        }
    }
</style>