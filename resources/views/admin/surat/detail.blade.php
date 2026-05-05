@extends('layouts.admin')

@section('admin_content')
<div class="mb-4">
    <a href="javascript:void(0)" onclick="history.back()" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1"></i> Kembali ke Halaman Sebelumnya
    </a>
</div>

<div class="row g-4">
    {{-- BAGIAN KIRI: DETAIL DATA --}}
    <div class="col-lg-8">
        <div class="card card-custom bg-white mb-4 shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 border-bottom pb-2">Detail Data Pengajuan Surat</h5>
                
                <div class="row">
                    {{-- DATA PERSONAL WARGA --}}
                    <div class="col-md-6 border-end">
                        <h6 class="text-success fw-bold small mb-3 text-uppercase">Data Personal Warga</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="text-muted small" width="40%">Nama Lengkap</td>
                                <td class="fw-bold">: {{ strtoupper($surat->warga->nama_lengkap) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">NIK</td>
                                <td>: {{ $surat->warga->nik }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">No. KK</td>
                                <td>: {{ $surat->warga->no_kk }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">TTL</td>
                                <td>: {{ ucwords(strtolower($surat->warga->tempat_lahir)) }}, {{ \Carbon\Carbon::parse($surat->warga->tanggal_lahir)->translatedFormat('d F Y') }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">Agama</td>
                                <td>: {{ ucwords(strtolower($surat->warga->agama)) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">Pekerjaan</td>
                                <td>: {{ ucwords(strtolower($surat->warga->pekerjaan)) }}</td>
                            </tr>
                        </table>
                    </div>

                    {{-- ALAMAT KORESPONDENSI --}}
                    <div class="col-md-6">
                        <h6 class="text-success fw-bold small mb-3 text-uppercase">Alamat Korespondensi</h6>
                        <table class="table table-sm table-borderless">
                            <tr>
                                <td class="text-muted small" width="40%">Alamat</td>
                                <td>: {{ ucwords(strtolower($surat->warga->alamat_lengkap)) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">RT / RW</td>
                                <td>: {{ $surat->warga->rt }} / {{ $surat->warga->rw }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">Kel / Kec</td>
                                <td>: {{ ucwords(strtolower($surat->warga->kelurahan)) }} / {{ ucwords(strtolower($surat->warga->kecamatan)) }}</td>
                            </tr>
                            <tr>
                                <td class="text-muted small">Kab / Prov</td>
                                <td>: {{ ucwords(strtolower($surat->warga->kabupaten)) }} / Jawa Tengah</td>
                            </tr>
                        </table>
                    </div>
                </div>

                <hr>

                {{-- ISI & KEPERLUAN SURAT --}}
                <div class="mt-3">
                    <h6 class="text-success fw-bold small mb-3 text-uppercase">Isi & Keperluan Surat</h6>
                    <div class="bg-light p-3 rounded">
                        <div class="row mb-2">
                            <div class="col-sm-3 text-muted small">Jenis Surat</div>
                            <div class="col-sm-9 fw-bold text-primary">{{ strtoupper($surat->jenis_surat) }}</div>
                        </div>

                        @if(str_contains(strtoupper($surat->jenis_surat), 'DOMISILI USAHA'))
                            <div class="row mb-2">
                                <div class="col-sm-3 text-muted small">Nama Lembaga/Usaha</div>
                                <div class="col-sm-9 fw-bold text-dark">{{ strtoupper($surat->nama_lembaga ?? '-') }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-3 text-muted small">Penanggung Jawab</div>
                                <div class="col-sm-9 text-dark">{{ $surat->penanggung_jawab ?? '-' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-3 text-muted small">Jabatan</div>
                                <div class="col-sm-9 text-dark">{{ $surat->jabatan_penanggung_jawab ?? '-' }}</div>
                            </div>
                            <div class="row mb-2">
                                <div class="col-sm-3 text-muted small">Alamat Lembaga</div>
                                <div class="col-sm-9 text-dark">
                                    {{ $surat->alamat_lembaga ?? 'Jl. Kyai Sambong, Kelurahan Sambong, Kecamatan Batang, Kabupaten Batang, Jawa Tengah' }}
                                </div>
                            </div>
                        @else
                            <div class="row mb-2">
                                <div class="col-sm-3 text-muted small">Keperluan</div>
                                <div class="col-sm-9 text-dark">{{ $surat->keperluan ?? '-' }}</div>
                            </div>
                            <div class="row mb-0">
                                <div class="col-sm-3 text-muted small">Keterangan Tambahan</div>
                                <div class="col-sm-9 text-dark italic">"{{ $surat->keterangan ?? 'Bahwa yang bersangkutan benar-benar warga Kelurahan Sambong.' }}"</div>
                            </div>
                        @endif
                    </div>
                </div>

                <hr>

                {{-- DOKUMEN LAMPIRAN --}}
                <h6 class="fw-bold mb-3 small text-uppercase">Dokumen Lampiran (Verifikasi)</h6>
                <div class="row g-3">
                    <div class="col-md-6">
                        <p class="small text-muted mb-2 text-center bg-light py-1 border">Scan Pengantar RT/RW</p>
                        <div class="position-relative border rounded overflow-hidden">
                            <img src="{{ asset('storage/'.$surat->scan_pengantar_rt) }}" class="img-fluid w-100" style="height: 200px; object-fit: cover;">
                            <a href="{{ asset('storage/'.$surat->scan_pengantar_rt) }}" target="_blank" class="btn btn-sm btn-light position-absolute top-50 start-50 translate-middle shadow">Lihat Full</a>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <p class="small text-muted mb-2 text-center bg-light py-1 border">Scan KTP & KK</p>
                        <div class="position-relative border rounded overflow-hidden">
                            <img src="{{ asset('storage/'.$surat->scan_ktp_kk) }}" class="img-fluid w-100" style="height: 200px; object-fit: cover;">
                            <a href="{{ asset('storage/'.$surat->scan_ktp_kk) }}" target="_blank" class="btn btn-sm btn-light position-absolute top-50 start-50 translate-middle shadow">Lihat Full</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- BAGIAN KANAN: SIDEBAR TINDAKAN --}}
    <div class="col-lg-4">
        <div class="card card-custom bg-white border-top border-success border-4 shadow-sm border-0">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4">Tindakan Petugas</h5>
                
                @if($surat->status == 'Diajukan')
                    <form action="{{ route('admin.surat.proses', $surat->id) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Nomor Surat</label>
                            <input type="text" name="nomor_surat" class="form-control" placeholder="Contoh: 145/{{ date('Y') }}/Kel.Sbg" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Tanggal Tanda Tangan</label>
                            <input type="date" name="tanggal_surat_ttd" class="form-control" value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label small fw-bold">Pejabat Penandatangan</label>
                            <select name="officer_id" class="form-select" required>
                                <option value="">-- Pilih Pejabat --</option>
                                @foreach($pegawai as $p)
                                    <option value="{{ $p->id }}">{{ $p->nama_lengkap }} ({{ $p->jabatan }})</option>
                                @endforeach
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">
                            <i class="bi bi-check-lg me-1"></i> VALIDASI & PROSES
                        </button>
                    </form>

                    <button onclick="tolakSurat()" class="btn btn-link text-danger text-decoration-none w-100 mt-3 small fw-bold">
                        Tolak Pengajuan
                    </button>

                    {{-- Form Tersembunyi untuk Tolak --}}
                    <form id="formTolak" action="{{ route('admin.surat.tolak', $surat->id) }}" method="POST" style="display: none;">
                        @csrf
                        <input type="hidden" name="alasan_ditolak" id="inputAlasanTolak">
                    </form>

                @elseif($surat->status == 'Diproses')
                    <div class="text-center py-3">
                        <div id="wrapperCetakSekarang">
                            <i class="bi bi-patch-check-fill text-success display-4 mb-3 d-block"></i>
                            <h6 class="fw-bold">Siap Cetak</h6>
                            <div class="badge bg-light text-dark border mb-4">Nomor: {{ $surat->nomor_surat }}</div>
                            
                            <button onclick="printSurat()" class="btn btn-dark w-100 rounded-pill py-2 shadow mb-3">
                                <i class="bi bi-printer me-2"></i> CETAK SEKARANG
                            </button>
                        </div>

                        <div id="wrapperCetakUlang" style="display: none;">
                            <i class="bi bi-printer-fill text-primary display-4 mb-3 d-block"></i>
                            <h6 class="fw-bold">Surat Telah Dicetak</h6>
                            <div class="badge bg-light text-dark border mb-4">Nomor: {{ $surat->nomor_surat }}</div>

                            <button onclick="printSurat()" class="btn btn-outline-dark w-100 rounded-pill py-2 mb-3">
                                <i class="bi bi-printer me-2"></i> CETAK ULANG
                            </button>

                            <hr>
                            <p class="small text-muted mb-2">Klik selesai untuk memindahkan ke riwayat</p>
                            <form action="{{ route('admin.surat.selesai', $surat->id) }}" method="POST" onsubmit="clearCetakStatus()">
                                @csrf
                                <input type="hidden" name="status" value="Selesai">
                                <button type="submit" class="btn btn-success w-100 rounded-pill py-2 fw-bold shadow-sm">
                                    <i class="bi bi-check-circle me-2"></i> SELESAI & ARSIPKAN
                                </button>
                            </form>
                        </div>
                    </div>

                @elseif($surat->status == 'Selesai')
                    <div class="text-center">
                        <div class="alert alert-success border-0 text-center mb-3">
                            <i class="bi bi-archive-fill mb-2 d-block fs-4"></i>
                            <h6 class="fw-bold mb-0">Surat Sudah Selesai</h6>
                        </div>
                        <div class="badge bg-light text-dark border mb-3">Nomor: {{ $surat->nomor_surat }}</div>
                        <button onclick="printSurat()" class="btn btn-outline-dark btn-sm w-100">
                            <i class="bi bi-printer me-1"></i> Cetak Ulang
                        </button>
                    </div>

                @elseif($surat->status == 'Ditolak')
                    <div class="text-center py-3">
                        <i class="bi bi-x-circle-fill text-danger display-4 mb-3 d-block"></i>
                        <h6 class="fw-bold text-danger">Pengajuan Ditolak</h6>
                        <div class="alert alert-light border small text-start mt-3">
                            <strong>Alasan Penolakan:</strong><br>
                            {{ $surat->alasan_ditolak }}
                        </div>
                        <p class="text-muted small">Warga harus mengajukan ulang dengan berkas yang benar.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<iframe id="printFrame" style="display:none;"></iframe>

{{-- Load SweetAlert2 dari CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const suratId = "{{ $surat->id }}";
    const isPrinted = localStorage.getItem("printed_surat_" + suratId);
    
    if (isPrinted === "true") {
        const sekarang = document.getElementById('wrapperCetakSekarang');
        const ulang = document.getElementById('wrapperCetakUlang');
        
        if (sekarang && ulang) {
            sekarang.style.display = 'none';
            ulang.style.display = 'block';
        }
    }
});

function tolakSurat() {
    Swal.fire({
        title: 'Tolak Pengajuan?',
        text: "Masukkan alasan penolakan agar warga dapat memperbaikinya:",
        input: 'textarea',
        inputPlaceholder: 'Contoh: Berkas Scan KTP tidak jelas...',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Tolak',
        cancelButtonText: 'Batal',
        inputValidator: (value) => {
            if (!value || value.length < 5) {
                return 'Alasan harus diisi minimal 5 karakter!'
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById('inputAlasanTolak').value = result.value;
            document.getElementById('formTolak').submit();
        }
    });
}

function printSurat() {
    const suratId = "{{ $surat->id }}";
    const frame = document.getElementById('printFrame');
    frame.src = "{{ route('admin.surat.cetak', $surat->id) }}";
    
    frame.onload = function() {
        if(frame.getAttribute('src') !== "" && frame.getAttribute('src') !== "about:blank") {
            frame.contentWindow.print();
            localStorage.setItem("printed_surat_" + suratId, "true");
            
            const sekarang = document.getElementById('wrapperCetakSekarang');
            const ulang = document.getElementById('wrapperCetakUlang');
            
            if(sekarang && ulang) {
                sekarang.style.display = 'none';
                ulang.style.display = 'block';
            }
        }
    };
}

function clearCetakStatus() {
    const suratId = "{{ $surat->id }}";
    localStorage.removeItem("printed_surat_" + suratId);
}
</script>
@endsection