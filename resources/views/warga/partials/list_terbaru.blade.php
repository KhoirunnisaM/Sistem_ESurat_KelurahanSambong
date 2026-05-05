@forelse($terbaru as $s)
<a href="{{ route('warga.surat.detail', $s->id) }}" class="list-group-item list-group-item-action px-0 border-0 d-flex justify-content-between align-items-center">
    <div>
        <div class="fw-bold text-primary">{{ $s->jenis_surat }}</div>
        <small class="text-muted">{{ $s->created_at->format('d M Y h.m') }}</small>
    </div>
    
    @php
        // Logika Mapping Warna & Label agar konsisten
        $statusDb = strtolower($s->status);
        $label = $s->status;
        $color = 'bg-light text-dark';
        
        if($statusDb == 'diajukan') { 
            $color = 'bg-warning-subtle text-warning border-warning'; 
        }
        elseif($statusDb == 'diproses') { 
            $color = 'bg-info-subtle text-info border-info'; 
        }
        elseif($statusDb == 'selesai') { 
            $color = 'bg-success-subtle text-success border-success'; 
        }
        elseif($statusDb == 'ditolak') { 
            $color = 'bg-danger-subtle text-danger border-danger'; 
            $label = 'Dibatalkan'; 
        }
    @endphp

    <span class="badge border {{ $color }} rounded-pill px-3 shadow-sm">
        {{ $label }}
    </span>
</a>
@empty
<div class="text-center py-3">
    <p class="text-muted small mb-0">Belum ada pengajuan.</p>
</div>
@endforelse