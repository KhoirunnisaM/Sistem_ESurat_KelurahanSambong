@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="mb-4">
        <h2 class="fw-bold">Halo, {{ session('nama_lengkap') }}!</h2>
        <p class="text-muted">
            NIK: {{ session('nik') }} | Alamat: {{ session('alamat_lengkap') }}, RT {{ session('rt') }}/RW {{ session('rw') }}, Kel. {{ session('kelurahan') }}
        </p>
    </div>

    <!-- Statistik KPI -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3">
                <small class="text-muted d-block mb-2"><i class="bi bi-clock"></i> Diajukan</small>
                <!-- Tambah ID stat-diajukan -->
                <h2 class="fw-bold mb-0" id="stat-diajukan">{{ $stats['diajukan'] }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3" style="border-left: 4px solid #0dcaf0 !important;">
                <small class="text-muted d-block mb-2"><i class="bi bi-arrow-repeat"></i> Diproses</small>
                <!-- Tambah ID stat-diproses -->
                <h2 class="fw-bold mb-0" id="stat-diproses">{{ $stats['diproses'] }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3" style="border-left: 4px solid #198754 !important;">
                <small class="text-muted d-block mb-2"><i class="bi bi-check-circle"></i> Selesai</small>
                <!-- Tambah ID stat-selesai -->
                <h2 class="fw-bold mb-0" id="stat-selesai">{{ $stats['selesai'] }}</h2>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm p-3" style="border-left: 4px solid #dc3545 !important;">
                <small class="text-muted d-block mb-2"><i class="bi bi-x-circle"></i> Ditolak/Dibatalkan</small>
                <!-- Tambah ID stat-ditolak -->
                <h2 class="fw-bold mb-0" id="stat-ditolak">{{ $stats['ditolak'] }}</h2>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm p-4">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <h5 class="fw-bold mb-0">Pengajuan Terbaru</h5>
                    <a href="{{ route('warga.riwayat') }}" class="btn btn-sm btn-link text-decoration-none">Lihat Semua</a>
                </div>
                <!-- Tambah ID list-terbaru di sini -->
                <div class="list-group list-group-flush" id="list-terbaru">
                    @include('warga.partials.list_terbaru', ['terbaru' => $terbaru])
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm p-4 bg-success text-white">
                <h5 class="fw-bold">Butuh Surat?</h5>
                <p class="small">Ajukan surat keterangan atau pengantar secara online tanpa antri.</p>
                <a href="{{ route('warga.ajukan') }}" class="btn btn-light btn-sm fw-bold">BUAT SURAT</a>
            </div>
        </div>
    </div>
</div>

<script>
    function updateStats() {
        fetch("{{ route('warga.stats.realtime') }}")
            .then(response => response.json())
            .then(data => {
                // Update Angka KPI (Pastikan key JSON sama dengan ID HTML)
                document.getElementById('stat-diajukan').innerText = data.stats.diajukan;
                document.getElementById('stat-diproses').innerText = data.stats.diproses;
                document.getElementById('stat-selesai').innerText = data.stats.selesai;
                document.getElementById('stat-ditolak').innerText = data.stats.ditolak;

                // Update List Terbaru
                document.getElementById('list-terbaru').innerHTML = data.html;
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Refresh setiap 3 detik
    setInterval(updateStats, 3000);
</script>
@endsection