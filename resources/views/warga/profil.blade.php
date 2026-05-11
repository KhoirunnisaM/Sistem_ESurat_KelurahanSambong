@extends('layouts.app')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
    :root {
        --hijau-keraton: #1e4d3a;
    }

    /* Tipografi Responsif */
    .res-title { font-size: clamp(1.1rem, 2vw, 1.5rem); }
    .res-subtitle { font-size: clamp(0.85rem, 1.5vw, 1rem); }
    .res-label { font-size: clamp(0.65rem, 1vw, 0.75rem); letter-spacing: 0.5px; }
    .res-value { font-size: clamp(0.8rem, 1.2vw, 0.95rem); }

    /* Card & Header */
    .card-profile { border-radius: 20px; overflow: hidden; background: #fff; }
    .profile-header-bg { 
        background: var(--hijau-keraton); 
        padding: 3rem 1.5rem; 
    }

    /* Avatar */
    .avatar-wrapper {
        width: clamp(80px, 10vw, 110px);
        height: clamp(80px, 10vw, 110px);
        background: #fff;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .avatar-wrapper i { font-size: clamp(2.5rem, 4vw, 3.5rem); color: var(--hijau-keraton); }

    /* Badges */
    .badge-custom {
        font-size: clamp(0.6rem, 1vw, 0.7rem);
        padding: 0.5em 1.2em;
        font-weight: 500;
        border-radius: 50px;
    }

    /* Form & Input */
    .form-label-custom { 
        font-size: 0.7rem; 
        font-weight: 700; 
        color: #6c757d; 
        text-transform: uppercase; 
        margin-bottom: 0.2rem; 
    }
    .input-custom {
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        padding: 0.6rem 0.8rem;
        font-size: 0.9rem;
    }
    .input-custom:focus {
        border-color: var(--hijau-keraton);
        box-shadow: 0 0 0 0.25rem rgba(30, 77, 58, 0.1);
    }

    /* Button */
    .btn-keraton {
        background: var(--hijau-keraton);
        color: white;
        border: none;
        transition: all 0.3s ease;
    }
    .btn-keraton:hover {
        background: #153a2b;
        color: white;
        transform: translateY(-1px);
    }

    @media (max-width: 576px) {
        .profile-header-bg { padding: 2rem 1rem; }
        .card-body-custom { padding: 1.5rem !important; }
        .info-divider { border-right: none !important; border-bottom: 1px solid #eee; padding-bottom: 1.5rem; margin-bottom: 1.5rem; }
    }
</style>

<div class="container py-3 py-md-5">
    <div class="row justify-content-center">
        <div class="col-lg-9">
            <div class="d-flex justify-content-between align-items-center mb-3 mb-md-4">
                <h4 class="fw-bold text-dark mb-0 res-title">Profil Saya</h4>
                <button type="button" class="btn btn-keraton rounded-pill px-3 px-md-4 py-1 py-md-2 shadow-sm res-subtitle" data-bs-toggle="modal" data-bs-target="#editProfileModal">
                    <i class="bi bi-pencil-square me-2"></i>Edit Profil
                </button>
            </div>

            <div class="card card-profile border-0 shadow-sm">
                <div class="profile-header-bg text-white text-center">
                    <div class="avatar-wrapper">
                        <i class="bi bi-person-fill"></i>
                    </div>
                    <h4 class="fw-bold mb-2 res-title">{{ $warga->nama_lengkap }}</h4>
                    <div class="d-flex justify-content-center flex-wrap gap-2">
                        <span class="badge bg-white text-dark badge-custom">NIK: {{ $warga->nik }}</span>
                        <span class="badge border border-white text-white badge-custom">KK: {{ $warga->no_kk }}</span>
                    </div>
                </div>

                <div class="card-body card-body-custom p-4 p-md-5">
                    <div class="row g-4">
                        <div class="col-md-5 info-divider border-end">
                            <h6 class="fw-bold text-uppercase res-label mb-3" style="color: var(--hijau-keraton)">Informasi Pribadi</h6>
                            <div class="vstack gap-3">
                                <div>
                                    <label class="text-muted res-label d-block">Tempat, Tanggal Lahir</label>
                                    <span class="fw-semibold res-value text-dark">
                                        {{ $warga->tempat_lahir }}, 
                                        {{ $warga->tanggal_lahir ? \Carbon\Carbon::parse($warga->tanggal_lahir)->translatedFormat('d F Y') : '-' }}
                                    </span>
                                </div>
                                <div class="row g-2">
                                    <div class="col-6">
                                        <label class="text-muted res-label d-block">Jenis Kelamin</label>
                                        <span class="fw-semibold res-value text-dark">{{ $warga->jenis_kelamin ?? '-' }}</span>
                                    </div>
                                    <div class="col-12">
                                        <label class="text-muted res-label d-block">Agama</label>
                                        <span class="fw-semibold res-value text-dark">{{ $warga->agama }}</span>
                                    </div>
                                </div>
                                <div>
                                    <label class="text-muted res-label d-block">Status Perkawinan</label>
                                    <span class="fw-semibold res-value text-dark">{{ $warga->status_perkawinan ?? '-' }}</span>
                                </div>
                                <div>
                                    <label class="text-muted res-label d-block">Pekerjaan</label>
                                    <span class="fw-semibold res-value text-dark">{{ $warga->pekerjaan }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7 ps-md-4">
                            <h6 class="fw-bold text-uppercase res-label mb-3" style="color: var(--hijau-keraton)">Alamat Domisili</h6>
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="text-muted res-label d-block">Alamat Lengkap</label>
                                    <span class="fw-semibold res-value text-dark">{{ $warga->alamat_lengkap }}</span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted res-label d-block">RT / RW</label>
                                    <span class="fw-bold res-value" style="color: var(--hijau-keraton)">{{ $warga->rt }} / {{ $warga->rw }}</span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted res-label d-block">Kelurahan</label>
                                    <span class="fw-semibold res-value text-dark">{{ $warga->kelurahan }}</span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted res-label d-block">Kecamatan</label>
                                    <span class="fw-semibold res-value text-dark">{{ $warga->kecamatan }}</span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted res-label d-block">Kabupaten</label>
                                    <span class="fw-semibold res-value text-dark">{{ $warga->kabupaten }}</span>
                                </div>
                                <div class="col-12">
                                    <label class="text-muted res-label d-block">Provinsi</label>
                                    <span class="fw-semibold res-value text-dark">{{ $warga->provinsi }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Profil --}}
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
                            <label class="form-label-custom">Nama Lengkap</label>
                            <input type="text" name="nama_lengkap" class="form-control input-custom bg-light border-0" value="{{ $warga->nama_lengkap }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">NIK</label>
                            <input type="text" name="nik" class="form-control input-custom bg-light border-0" value="{{ $warga->nik }}" maxlength="16" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">No. KK</label>
                            <input type="text" name="no_kk" class="form-control input-custom bg-light border-0" value="{{ $warga->no_kk }}" maxlength="16" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" class="form-control input-custom bg-light border-0" value="{{ $warga->tempat_lahir }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control input-custom bg-light border-0" 
                                   value="{{ $warga->tanggal_lahir ? \Carbon\Carbon::parse($warga->tanggal_lahir)->format('Y-m-d') : '' }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select input-custom bg-light border-0" required>
                                <option value="Laki-laki" {{ $warga->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                <option value="Perempuan" {{ $warga->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Agama</label>
                            <input type="text" name="agama" class="form-control input-custom bg-light border-0" value="{{ $warga->agama }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Status Perkawinan</label>
                            <select name="status_perkawinan" class="form-select input-custom bg-light border-0" required>
                                <option value="Belum Kawin" {{ $warga->status_perkawinan == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                <option value="Kawin" {{ $warga->status_perkawinan == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                <option value="Cerai Hidup" {{ $warga->status_perkawinan == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                <option value="Cerai Mati" {{ $warga->status_perkawinan == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Pekerjaan</label>
                            <input type="text" name="pekerjaan" class="form-control input-custom bg-light border-0" value="{{ $warga->pekerjaan }}" required>
                        </div>
                        <div class="col-12">
                            <label class="form-label-custom">Alamat Lengkap</label>
                            <input type="text" name="alamat_lengkap" class="form-control input-custom bg-light border-0" value="{{ $warga->alamat_lengkap }}" required>
                        </div>
                        <div class="col-md-3 col-6">
                            <label class="form-label-custom">RT</label>
                            <input type="text" name="rt" class="form-control input-custom bg-light border-0" value="{{ $warga->rt }}" required>
                        </div>
                        <div class="col-md-3 col-6">
                            <label class="form-label-custom">RW</label>
                            <input type="text" name="rw" class="form-control input-custom bg-light border-0" value="{{ $warga->rw }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Kelurahan</label>
                            <input type="text" name="kelurahan" class="form-control input-custom bg-light border-0" value="{{ $warga->kelurahan }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label-custom">Kecamatan</label>
                            <input type="text" name="kecamatan" class="form-control input-custom bg-light border-0" value="{{ $warga->kecamatan }}" required>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label-custom">Kabupaten</label>
                            <input type="text" name="kabupaten" class="form-control input-custom bg-light border-0" value="{{ $warga->kabupaten }}" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label-custom">Provinsi</label>
                            <input type="text" name="provinsi" class="form-control input-custom bg-light border-0" value="{{ $warga->provinsi }}" required>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-keraton rounded-pill px-4 shadow-sm">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Logic SweetAlert tetap sama
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
        confirmButtonColor: '#1e4d3a',
        confirmButtonText: 'Ya, Simpan!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) { form.submit(); }
    });
});

@if(session('success'))
    Swal.fire({ icon: 'success', title: 'Berhasil!', text: "{{ session('success') }}", timer: 3000, showConfirmButton: false });
@endif
</script>
@endsection