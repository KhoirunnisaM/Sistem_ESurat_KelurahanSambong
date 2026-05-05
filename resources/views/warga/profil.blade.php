@extends('layouts.app')

@section('content')
<!-- Tambahkan SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <!-- Header Profil -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-dark mb-0">Profil Saya</h4>
                <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="bi bi-pencil-square me-2"></i>Edit Profil
                </button>
            </div>
            

            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <!-- Profile Header Banner -->
                <div class="bg-success p-5 text-white text-center position-relative">
                    <div class="position-relative d-inline-block mb-3">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 100px; height: 100px;">
                            <i class="bi bi-person-fill text-success" style="font-size: 3.5rem;"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-1">{{ session('nama_lengkap') }}</h4>
                    <span class="badge bg-white text-success rounded-pill px-3">NIK: {{ session('nik') }}</span>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="row g-4">
                        <!-- Informasi Pribadi -->
                        <div class="col-md-5 border-end">
                            <h6 class="fw-bold text-primary text-uppercase small mb-4">Informasi Pribadi</h6>
                            <div class="vstack gap-3">
                                <div>
                                    <label class="text-muted small d-block">Tempat, Tanggal Lahir</label>
                                    <span class="fw-semibold">{{ session('tempat_lahir') }}, {{ date('d-m-Y', strtotime(session('tanggal_lahir'))) }}</span>
                                </div>
                                <div>
                                    <label class="text-muted small d-block">Agama</label>
                                    <span class="fw-semibold">{{ session('agama') }}</span>
                                </div>
                                <div>
                                    <label class="text-muted small d-block">Pekerjaan</label>
                                    <span class="fw-semibold">{{ session('pekerjaan') }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Alamat Domisili Lengkap -->
                        <div class="col-md-7 ps-md-4">
                            <h6 class="fw-bold text-primary text-uppercase small mb-4">Alamat Domisili</h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="text-muted small d-block"> Dukuh</label>
                                    <span class="fw-semibold">{{ session('alamat_lengkap') }}</span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small d-block">RT / RW</label>
                                    <span class="fw-semibold">{{ session('rt') }} / {{ session('rw') }}</span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small d-block">Kelurahan</label>
                                    <span class="fw-semibold">{{ session('kelurahan') ?? 'Sambong' }}</span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small d-block">Kecamatan</label>
                                    <span class="fw-semibold">{{ session('kecamatan') ?? 'Batang' }}</span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small d-block">Kabupaten</label>
                                    <span class="fw-semibold">{{ session('kabupaten') ?? 'Batang' }}</span>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted small d-block">Provinsi</label>
                                    <span class="fw-semibold">{{ session('provinsi') ?? 'Jawa Tengah' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit Profil -->
<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow" style="border-radius: 20px;">
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="fw-bold mb-0">Update Profil Lengkap</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="formUpdateProfile" action="{{ route('warga.profile.update') }}" method="POST" class="needs-validation" novalidate>
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control bg-light border-0" value="{{ session('nama_lengkap') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control bg-light border-0" value="{{ session('pekerjaan') }}" required>
                        </div>
                        
                        <div class="col-12 mt-4">
                            <h6 class="fw-bold small text-muted text-uppercase">Detail Alamat</h6>
                            <hr class="mt-1 mb-3 opacity-25">
                        </div>

                        <div class="col-12">
                            <label class="form-label small fw-bold text-dark">Jalan / No. Rumah / Dukuh</label>
                            <input type="text" name="alamat_lengkap" class="form-control bg-light border-0" value="{{ session('alamat_lengkap') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-dark">RT</label>
                            <input type="number" name="rt" class="form-control bg-light border-0" value="{{ session('rt') }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label small fw-bold text-dark">RW</label>
                            <input type="number" name="rw" class="form-control bg-light border-0" value="{{ session('rw') }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label small fw-bold text-dark">Kelurahan</label>
                            <input type="text" name="kelurahan" class="form-control bg-light border-0" value="{{ session('kelurahan', 'Sambong') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-dark">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control bg-light border-0" value="{{ session('kecamatan', 'Batang') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-dark">Kabupaten</label>
                            <input type="text" name="kabupaten" class="form-control bg-light border-0" value="{{ session('kabupaten', 'Batang') }}" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label small fw-bold text-dark">Provinsi</label>
                            <input type="text" name="provinsi" class="form-control bg-light border-0" value="{{ session('provinsi', 'Jawa Tengah') }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Script Alert & Validasi -->
<script>
document.getElementById('formUpdateProfile').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;

    if (!form.checkValidity()) {
        e.stopPropagation();
        form.classList.add('was-validated');
        return;
    }

    Swal.fire({
        title: 'Konfirmasi Simpan',
        text: "Apakah data profil yang Anda masukkan sudah benar?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Cek Kembali',
        borderRadius: '15px'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

// Auto-show success alert jika session success ada (opsional)
@if(session('success'))
    Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        timer: 2000,
        showConfirmButton: false
    });
@endif
</script>

<style>
    body { background-color: #f8f9fa; }
    label { letter-spacing: 0.5px; text-transform: uppercase; font-weight: 700; color: #adb5bd !important; font-size: 0.7rem; }
    .form-control:focus { background-color: #fff !important; box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1); border: 1px solid #0d6efd !important; }
    .fw-semibold { color: #333; }
</style>
@endsection