<div class="table-responsive">
    <table class="table table-hover align-middle border-top">
        <thead>
            <tr class="text-muted small">
                <th class="py-3" style="width: 45%;">LAYANAN & DETAIL</th>
                <th class="py-3" style="width: 30%;">WAKTU PENGAJUAN</th>
                <th class="py-3 text-center" style="width: 25%;">STATUS</th>
            </tr>
        </thead>
        <tbody>
            @forelse($terbaru as $r)
            {{-- Tambahkan style pointer dan link via JavaScript agar satu baris bisa diklik --}}
            <tr onclick="window.location='{{ route('warga.surat.detail', $r->id) }}';" style="cursor: pointer;">
                <td class="py-3">
                    <div class="fw-bold text-dark text-uppercase mb-1" style="font-size: 0.95rem;">
                        {{ $r->jenisSurat->nama_jenis }}
                    </div>
                    
                    @if($r->status == 'Selesai' && $r->nomor_surat)
                                <div class="mt-0">
                                    <span class="badge bg-light text-dark border-0 p-0 fw-normal" style="font-size: 0.7rem;">
                                        <i class="bi bi-hash text-success"></i> {{ $r->nomor_surat }}
                                    </span>
                                </div>
                                @elseif($r->status == 'Diproses' && $r->nomor_surat)
                                <div class="mt-0">
                                    <span class="badge bg-light text-dark border-0 p-0 fw-normal" style="font-size: 0.7rem;">
                                        <i class="bi bi-hash text-success"></i> {{ $r->nomor_surat }}
                                    </span>
                                </div>
                            @elseif($r->status == 'Ditolak' && $r->alasan_ditolak)
                                <div class="mt-1">
                                        <small class="text-danger d-block lh-sm fst-italic" style="font-size: 0.7rem; max-width: 220px; opacity: 0.8;">
                                * {{ $r->alasan_ditolak }}
                            </small>    
                                </div>
                            @elseif($r->status == 'Dibatalkan')
                                <div class="mt-0">
                                    <small class="text-muted fst-italic" style="font-size: 0.7rem;">* Dibatalkan oleh warga</small>
                                </div>
                            @endif
                </td>
                
                <td class="py-3">
                    <div class="text-dark mb-0" style="font-size: 0.9rem;">{{ $r->created_at->format('d/m/Y') }}</div>
                    <small class="text-muted">{{ $r->created_at->format('H:i') }} WIB</small>
                </td>

                <td class="py-3 text-center">
                    @php
                        $statusDb = strtolower($r->status);
                        $label = $r->status;
                        $color = 'bg-light text-dark';
                        
                        if($statusDb == 'diajukan') { 
                            $color = 'bg-warning-subtle text-warning border-warning'; 
                        } elseif($statusDb == 'diproses') { 
                            $color = 'bg-info-subtle text-info border-info'; 
                        } elseif($statusDb == 'selesai') { 
                            $color = 'bg-success-subtle text-success border-success'; 
                        } elseif($statusDb == 'ditolak') { 
                            $color = 'bg-danger-subtle text-danger border-danger'; 
                        } elseif($statusDb == 'dibatalkan') { 
                            $color = 'bg-secondary-subtle text-secondary border-secondary'; 
                        }
                    @endphp
                    <span class="badge border {{ $color }} rounded-pill px-3 py-2 shadow-sm" style="font-size: 0.75rem; min-width: 100px;">
                        {{ strtoupper($label) }}
                    </span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="3" class="text-center py-5 text-muted">
                    <i class="bi bi-inbox fs-1 d-block mb-2"></i>
                    Belum ada pengajuan.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<style>
    /* Memberikan efek hover agar user tahu baris ini bisa diklik */
    .table-hover tbody tr:hover {
        background-color: rgba(0,0,0,.02);
    }
    
    .table thead th {
        letter-spacing: 0.5px;
        border-bottom: 2px solid #f8f9fa;
    }

    .italic { font-style: italic; }
    
    /* Warna Background Subtle */
    .bg-warning-subtle { background-color: #fffdf2 !important; }
    .bg-info-subtle { background-color: #f0faff !important; }
    .bg-success-subtle { background-color: #f2fff9 !important; }
    .bg-danger-subtle { background-color: #fff5f6 !important; }
    .bg-secondary-subtle { background-color: #f8f9fa !important; }
</style>