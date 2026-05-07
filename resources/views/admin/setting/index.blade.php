@extends('layouts.admin')

@section('admin_content')
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <h5 class="fw-bold mb-4">Pengaturan Template Surat</h5>
            
            <div class="card shadow-sm border-0" style="border-radius: 15px; overflow: hidden;">
                <div class="card-header bg-white p-0 border-bottom">
                    <ul class="nav nav-tabs border-0" id="settingTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active py-3 px-4 fw-bold border-0" id="kop-tab" data-bs-toggle="tab" data-bs-target="#kop" type="button" role="tab">
                                <i class="bi bi-file-earmark-text me-2"></i>Kepala Surat & Instansi
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link py-3 px-4 fw-bold border-0" id="penutup-tab" data-bs-toggle="tab" data-bs-target="#penutup" type="button" role="tab">
                                <i class="bi bi-card-text me-2"></i>Kalimat Penutup Surat
                            </button>
                        </li>
                    </ul>
                </div>

                <div class="card-body p-4 bg-light">
                    <div class="tab-content" id="settingTabContent">
                        
                        <div class="tab-pane fade show active" id="kop" role="tabpanel">
                            <form action="{{ route('admin.setting.updateProfil') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-4 text-center border-end">
                                        <label class="fw-bold d-block mb-3">Logo Instansi</label>
                                        <div class="mb-3 p-3 bg-white rounded border d-inline-block">
                                            @if($profil && $profil->logo)
                                                <img src="{{ asset('storage/'.$profil->logo) }}" width="120" class="img-fluid rounded">
                                            @else
                                                <div class="text-muted p-4">Belum ada logo</div>
                                            @endif
                                        </div>
                                        <input type="file" name="logo" class="form-control form-control-sm mt-2">
                                        <small class="text-muted d-block mt-2">Format: PNG, JPG (Maks. 2MB)</small>
                                    </div>
                                    <div class="col-md-8 px-4">
                                        <div class="row mt-2">
                                            <div class="col-12 mb-3">
                                                <label class="small fw-bold text-uppercase">Pemerintah Kabupaten (Atas)</label>
                                                <input type="text" name="instansi_level_1" value="{{ $profil->instansi_level_1 ?? '' }}" class="form-control border-0 shadow-sm" placeholder= "PEMERINTAH KABUPATEN BATANG">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="small fw-bold text-uppercase">Pemerintah Kecamatan (Tengah)</label>
                                                <input type="text" name="instansi_level_2" value="{{ $profil->instansi_level_2 ?? '' }}" class="form-control border-0 shadow-sm" placeholder= "KECAMATAN BATANG">
                                            </div>
                                            <div class="col-12 mb-3">
                                                <label class="small fw-bold text-uppercase text-primary">Nama Lembaga / Kelurahan</label>
                                                <input type="text" name="nama_lembaga" value="{{ $profil->nama_lembaga ?? '' }}" class="form-control border-0 shadow-sm fw-bold" placeholder= "KELURAHAN SAMBONG">
                                            </div>
                                            <div class="col-md-8 mb-3">
                                                <label class="small fw-bold text-uppercase">Alamat Jalan</label>
                                                <input type="text" name="alamat_jalan" value="{{ $profil->alamat_jalan ?? '' }}" class="form-control border-0 shadow-sm" placeholder= "Jl.  Kyai Sambong  Nomor 12">
                                            </div>
                                            <div class="col-md-4 mb-3">
                                                <label class="small fw-bold text-uppercase">Kode Pos</label>
                                                <input type="text" name="kode_pos" value="{{ $profil->kode_pos ?? '' }}" class="form-control border-0 shadow-sm" placeholder= "Batang 51212">
                                            </div>
                                            <div class="col-12 mb-4">
                                                <label class="small fw-bold text-uppercase">Nomor Telepon / Email</label>
                                                <input type="text" name="no_telp" value="{{ $profil->no_telp ?? '' }}" class="form-control border-0 shadow-sm" placeholder= "0285 – 392126">
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button type="submit" class="btn btn-primary px-5 shadow-sm">Simpan Perubahan Kop</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="tab-pane fade" id="penutup" role="tabpanel">
                            <div class="row">
                                <div class="col-md-4 border-end">
                                    <h6 class="fw-bold mb-3">Pilih Jenis Surat</h6>
                                    <div class="list-group list-group-flush rounded shadow-sm border" id="list-tab" role="tablist">
                                        @foreach($jenisSurat as $key => $j)
                                            <a class="list-group-item list-group-item-action @if($key == 0) active @endif p-3 border-bottom" id="list-{{ $j->id }}-list" data-bs-toggle="list" href="#list-{{ $j->id }}" role="tab">
                                                <span class="d-block small fw-bold text-uppercase">{{ $j->nama_jenis }}</span>                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="col-md-8 px-4">
                                    <div class="tab-content" id="nav-tabContent">
                                        @foreach($jenisSurat as $key => $j)
                                        <div class="tab-pane fade @if($key == 0) show active @endif" id="list-{{ $j->id }}" role="tabpanel">
                                            <form action="{{ route('admin.setting.updatePenutup', $j->id) }}" method="POST">
                                                @csrf
                                                <div class="d-flex justify-content-between align-items-center mb-3">
                                                    <h6 class="fw-bold text-primary m-0">{{ $j->nama_jenis }}</h6>
                                                    <span class="badge bg-soft-primary text-primary">Template Penutup</span>
                                                </div>
                                                
                                                <div class="mb-3">
                                                    <label class="small fw-bold text-muted mb-2">Kalimat Penutup / Footer Surat</label>
                                                    <textarea name="kalimat_penutup" class="form-control border-0 shadow-sm" rows="6" placeholder="Contoh: Demikian surat keterangan ini dibuat agar dapat dipergunakan sebagaimana mestinya...">{{ $j->kalimat_penutup }}</textarea>
                                                </div>
                                                
                                                <div class="alert alert-warning border-0 small shadow-sm">
                                                    <i class="bi bi-info-circle me-2"></i> Kalimat ini akan muncul secara otomatis di bagian akhir isi surat sebelum tanda tangan.
                                                </div>

                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-success px-5 shadow-sm">Update Penutup</button>
                                                </div>
                                            </form>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .nav-tabs .nav-link { color: #6c757d; transition: all 0.3s; }
    .nav-tabs .nav-link.active { color: #0d6efd; background-color: #f8f9fa !important; border-bottom: 3px solid #0d6efd !important; }
    .bg-soft-primary { background-color: #e7f1ff; }
    .list-group-item.active { background-color: #0d6efd; border-color: #0d6efd; }
    .list-group-item.active .text-muted { color: #e7f1ff !important; }
    .form-control:focus { box-shadow: 0 0 0 0.25 mil rem rgba(13, 110, 253, 0.1); border: 1px solid #0d6efd; }
</style>
@endsection