<div class="table-responsive">
    <table class="table table-hover align-middle mb-0" style="font-size: 0.875rem; min-width: 800px;">
        <thead class="bg-light text-muted">
            <tr>
                <th class="ps-4 border-0 py-3" style="width: 15%;">NO SURAT</th>
                <th class="border-0 py-3" style="width: 20%;">NAMA WARGA / NIK</th>
                <th class="border-0 py-3" style="width: 20%;">JENIS SURAT</th>
                <th class="border-0 py-3" style="width: 25%;">KEPERLUAN</th>
                <th class="border-0 py-3 pe-4" style="width: 15%;">TGL SELESAI</th>
            </tr>
        </thead>
        <tbody class="border-top-0">
            @forelse($surat as $s)
            <tr>
                <td class="ps-4">
                    <span class="fw-semibold text-dark">{{ $s->nomor_surat }}</span>
                </td>
                <td>
                    <div class="fw-bold text-dark text-nowrap">{{ $s->warga->nama_lengkap }}</div>
                    <div class="text-muted small"><i class="bi bi-card-text me-1"></i>{{ $s->warga->nik }}</div>
                </td>
                <td>
                    <span class="badge rounded-pill bg-success-subtle text-success border border-success-subtle px-3">
                        {{ $s->jenisSurat->nama_surat ?? $s->jenisSurat->nama_jenis }}
                    </span>
                </td>
                <td>
                    <div class="text-wrap" style="max-width: 250px;">
                        {{ $s->keperluan }}
                    </div>
                </td>
                <td class="pe-4 text-muted text-nowrap">
                    <i class="bi bi-calendar-check me-1"></i> {{ $s->updated_at->format('d/m/Y') }}
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/7486/7486744.png" width="80" class="opacity-25 mb-3" alt="Empty">
                    <p class="text-muted fw-medium">Tidak ada surat berstatus 'Selesai' pada periode ini.</p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>