@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h4 class="fw-bold text-dark mb-0">Profil Saya</h4>
                <button type="button" class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="bi bi-pencil-square me-2"></i>Edit Profil
                </button>
            </div>

            <div class="card border-0 shadow-sm overflow-hidden" style="border-radius: 20px;">
                <div class="bg-success p-5 text-white text-center position-relative">
                    <div class="position-relative d-inline-block mb-3">
                        <div class="bg-white rounded-circle d-flex align-items-center justify-content-center shadow" style="width: 100px; height: 100px;">
                            <i class="bi bi-person-fill text-success" style="font-size: 3.5rem;"></i>
                        </div>
                    </div>
                    <h4 class="fw-bold mb-1">{{ session('nama_lengkap') }}</h4>
                    <div class="d-flex justify-content-center gap-2">
                        <span class="badge bg-white text-success rounded-pill px-3">NIK: {{ session('nik') }}</span>
                        <span class="badge bg-success-subtle text-white border border-white rounded-pill px-3">KK: {{ session('no_kk') }}</span>
                    </div>
                </div>

                <div class="card-body p-4 p-md-5">
                    <div class="row g-4">
                        <div class="col-md-5 border-end">
                            <h6 class="fw-bold text-primary text-uppercase small mb-4">Informasi Pribadi</h6>
                            <div class="vstack gap-3">
                                <div>
                                    <label class="text-muted small d-block">Tempat, Tanggal Lahir</label>
                                    <span class="fw-semibold">
                                        {{ session('tempat_lahir') }}, 
                                        {{ session('tanggal_lahir') ? \Carbon\Carbon::parse(session('tanggal_lahir'))->translatedFormat('d F Y') : '-' }}
                                    </span>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <label class="text-muted small d-block">Jenis Kelamin</label>
                                        <span class="fw-semibold">{{ session('jenis_kelamin') ?? '-' }}</span>
                                    </div>
                                    <div class="col-6">
                                        <label class="text-muted small d-block">Agama</label>
                                        <span class="fw-semibold">{{ session('agama') }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-muted small d-block">Status Perkawinan</label>
                                    <span class="fw-semibold">{{ session('status_perkawinan') ?? '-' }}</span>
                                </div>
                                <div>
                                    <label class="text-muted small d-block">Pekerjaan</label>
                                    <span class="fw-semibold">{{ session('pekerjaan') }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7 ps-md-4">
                            <h6 class="fw-bold text-primary text-uppercase small mb-4">Alamat Domisili</h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="text-muted small d-block">Jalan / No. Rumah / Dukuh</label>
                                    <span class="fw-semibold">{{ session('alamat_lengkap') }}</span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small d-block">RT / RW</label>
                                    <span class="fw-semibold text-primary fw-bold">{{ session('rt') }} / {{ session('rw') }}</span>
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

<div class="modal fade" id="editProfileModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 px-4 pt-4">
                <h5 class="fw-bold mb-0">Update Profil Lengkap</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="formUpdateProfile" action="{{ route('warga.profile.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control bg-light border-0" value="{{ session('nama_lengkap') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">NIK</label>
                            <input type="text" name="nik" class="form-control bg-light border-0" value="{{ session('nik') }}" maxlength="16" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">No. KK</label>
                            <input type="text" name="no_kk" class="form-control bg-light border-0" value="{{ session('no_kk') }}" maxlength="16" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control bg-light border-0" value="{{ session('tempat_lahir') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Tanggal Lahir</label>
                            {{-- Format Y-m-d sangat penting agar input date HTML5 mengenali nilainya --}}
                            <input type="date" name="tanggal_lahir" class="form-control bg-light border-0" 
                                   value="{{ session('tanggal_lahir') ? \Carbon\Carbon::parse(session('tanggal_lahir'))->format('Y-m-d') : '' }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select bg-light border-0" required>
                                <option value="Laki-laki" {{ session('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ session('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Agama</label>
                            <input type="text" name="agama" class="form-control bg-light border-0" value="{{ session('agama') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Status Perkawinan</label>
                            <select name="status_perkawinan" class="form-select bg-light border-0" required>
                                @php $sp = session('status_perkawinan'); @endphp
                                <option value="Belum Kawin" {{ $sp == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                <option value="Kawin" {{ $sp == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                <option value="Cerai Hidup" {{ $sp == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="Cerai Mati" {{ $sp == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control bg-light border-0" value="{{ session('pekerjaan') }}" required>
                        </div>

                        <div class="col-12 mt-3">
                            <h6 class="fw-bold small text-muted text-uppercase">Alamat</h6>
                            <hr class="my-2 opacity-25">
                        </div>

                        <div class="col-12">
                            <label class="form-label">Alamat Lengkap</label>
                            <input type="text" name="alamat_lengkap" class="form-control bg-light border-0" value="{{ session('alamat_lengkap') }}" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">RT</label>
                            <input type="text" name="rt" class="form-control bg-light border-0" value="{{ session('rt') }}" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label">RW</label>
                            <input type="text" name="rw" class="form-control bg-light border-0" value="{{ session('rw') }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Kelurahan</label>
                            <input type="text" name="kelurahan" class="form-control bg-light border-0" value="{{ session('kelurahan') ?? 'Sambong' }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control bg-light border-0" value="{{ session('kecamatan') ?? 'Batang' }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Kabupaten</label>
                            <input type="text" name="kabupaten" class="form-control bg-light border-0" value="{{ session('kabupaten') ?? 'Batang' }}" required>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Provinsi</label>
                            <input type="text" name="provinsi" class="form-control bg-light border-0" value="{{ session('provinsi') ?? 'Jawa Tengah' }}" required>
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

<script>
// Logic SweetAlert & Validation
document.getElementById('formUpdateProfile').addEventListener('submit', function(e) {
    e.preventDefault();
    const form = this;

    if (!form.checkValidity()) {
        form.classList.add('was-validated');
        return;
    }

    Swal.fire({
        title: 'Simpan Perubahan?',
        text: "Data profil akan diperbarui sesuai inputan Anda.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            form.submit();
        }
    });
});

// Toast Sukses/Error
@if(session('success'))
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
@endif

@if(session('error'))
    Swal.fire({ icon: 'error', title: 'Gagal!', text: "{{ session('error') }}" });
@endif
</script>

<style>
    body { background-color: #f8f9fa; }
    label.form-label { font-size: 0.7rem; font-weight: 800; color: #6c757d; text-transform: uppercase; margin-bottom: 0.3rem; }
    .form-control:focus { background-color: #fff !important; border: 1px solid #0d6efd !important; box-shadow: none; }
</style>
@endsection