@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">Pendaftaran Akun Warga Baru</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('register.warga.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-12 md-6 mb-3">
                                <label class="form-label">Nama Lengkap</label>
                                <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror" value="{{ old('nama_lengkap') }}" placeholder="Nama Lengkap Sesuai KK/KTP">
                                @error('nama_lengkap') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">NIK (16 Digit)</label>
                                <input type="text" name="nik" class="form-control @error('nik') is-invalid @enderror" value="{{ old('nik') }}" maxlength="16" placeholder="16 Digit (contoh: 3312000000000000)">
                                @error('nik') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nomor KK</label>
                                <input type="text" name="no_kk" class="form-control @error('no_kk') is-invalid @enderror" value="{{ old('no_kk') }}" maxlength="16" placeholder="16 Digit (contoh: 3312000000000000)">
                            </div>
                             </div>
                             <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tempat Lahir</label>
                                <input type="text" name="tempat_lahir" class="form-control" value="{{ old('tempat_lahir') }}" placeholder="contoh: Batang, Kota Pekalongan, etc.">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Tgl Lahir</label>
                                <input type="date" name="tanggal_lahir" class="form-control" value="{{ old('tanggal_lahir') }}">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat_lengkap" class="form-control" rows="2" placeholder="contoh: Sambong Pos, Perumahan Wirosari 3 No.12, etc.">{{ old('alamat_lengkap') }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">RT</label>
                                <input type="text" name="rt" class="form-control" placeholder="Contoh: 01" value="{{ old('rt') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">RW</label>
                                <input type="text" name="rw" class="form-control" placeholder="Contoh: 06" value="{{ old('rw') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kelurahan / Desa</label>
                                <input type="text" name="kelurahan" class="form-control" placeholder="Contoh: Sambong" value="{{ old('kelurahan', 'Sambong') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kecamatan</label>
                                <input type="text" name="kecamatan" class="form-control" placeholder="Contoh: Batang" value="{{ old('kecamatan', 'Batang') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kabupaten / Kota</label>
                                <input type="text" name="kabupaten" class="form-control" placeholder="Contoh: Batang, Kota Pekalongan, etc." value="{{ old('kabupaten', 'Batang') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Provinsi</label>
                                <input type="text" name="provinsi" class="form-control" placeholder="Contoh: Jawa Tengah" value="{{ old('provinsi', 'Jawa Tengah') }}">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Jenis Kelamin</label>
                                <select name="jenis_kelamin" class="form-select">
                                    <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                                    <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Agama</label>
                                <input type="text" name="agama" class="form-control" placeholder="Contoh: Islam" value="{{ old('agama') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Pekerjaan</label>
                                <input type="text" name="pekerjaan" class="form-control" placeholder="Contoh: Belum Bekerja, Wiraswasta, Mahasiswa, etc." value="{{ old('pekerjaan') }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status Kawin</label>
                                <select name="status_perkawinan" class="form-select">
                                    <option value="Belum Kawin" {{ old('status_perkawinan') == 'Belum Kawin' ? 'selected' : '' }}>Belum Kawin</option>
                                    <option value="Kawin" {{ old('status_perkawinan') == 'Kawin' ? 'selected' : '' }}>Kawin</option>
                                    <option value="Cerai Hidup" {{ old('status_perkawinan') == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                                    <option value="Cerai Mati" {{ old('status_perkawinan') == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                                </select>
                            </div>
                        </div>

                        <div class="d-grid mt-4">
                            <button type="submit" class="btn btn-success btn-lg">Daftar Sekarang</button>
                            <a href="/" class="btn btn-link text-secondary mt-2">Kembali ke Beranda</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection