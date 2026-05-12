@extends('layouts.admin')

@section('admin_content')
{{-- Gunakan wrapper 'main' untuk memastikan konten berada di bawah navbar --}}
<main class="py-4">
    <div id="realtime-container" class="container-fluid px-3 px-md-4">
        
        {{-- HEADER HALAMAN --}}
        <div class="row mb-4">
            <div class="col-12">
                <h4 class="fw-bold text-dark responsive-title mb-1">Pengaturan Template Surat</h4>
                <p class="text-muted small responsive-sub mb-0">Sesuaikan identitas lembaga dan format otomatis penutup surat.</p>
            </div>
        </div>

        {{-- KONTEN UTAMA --}}
        <div class="card card-custom bg-white border-0 shadow-sm">
            {{-- Navigasi Tab --}}
            <div class="card-header bg-white p-0 border-bottom">
                <ul class="nav nav-tabs border-0 flex-nowrap overflow-auto scrollbar-hide" id="settingTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active py-3 px-4 fw-bold border-0 text-nowrap" id="kop-tab" data-bs-toggle="tab" data-bs-target="#kop" type="button" role="tab">
                            <i class="bi bi-file-earmark-text me-2"></i>Kop & Instansi
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link py-3 px-4 fw-bold border-0 text-nowrap" id="penutup-tab" data-bs-toggle="tab" data-bs-target="#penutup" type="button" role="tab">
                            <i class="bi bi-card-text me-2"></i>Kalimat Penutup
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body p-3 p-md-4">
                <div class="tab-content" id="settingTabContent">
                    
                    {{-- TAB 1: KOP SURAT --}}
                    <div class="tab-pane fade show active" id="kop" role="tabpanel">
                        <form action="{{ route('admin.setting.updateProfil') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row g-4">
                                <div class="col-lg-4 text-center border-end-lg">
                                    <label class="fw-bold d-block mb-3 small text-uppercase" style="letter-spacing: 1px;">Logo Instansi</label>
                                    <div class="mb-3 p-3 bg-white rounded-4 shadow-sm d-inline-block border">
                                        @if($profil && $profil->logo)
                                            <img src="{{ asset('storage/'.$profil->logo) }}" style="max-height: 120px; width: auto;" class="img-fluid rounded">
                                        @else
                                            <div class="text-muted p-4 small">Belum ada logo</div>
                                        @endif
                                    </div>
                                    <div class="px-3">
                                        <input type="file" name="logo" class="form-control form-control-sm mt-2 rounded-pill shadow-sm">
                                        <small class="text-muted d-block mt-2" style="font-size: 0.7rem;">Format: PNG, JPG (Maks. 2MB)</small>
                                    </div>
                                </div>

                                <div class="col-lg-8 px-md-4">
                                    <div class="row g-3">
                                        <div class="col-12">
                                            <label class="small fw-bold text-muted text-uppercase" style="font-size: 0.65rem;">Pemerintah Kabupaten (Atas)</label>
                                            <input type="text" name="instansi_level_1" value="{{ $profil->instansi_level_1 ?? '' }}" class="form-control form-control-custom border-0 bg-light shadow-sm" placeholder="Contoh: PEMERINTAH KABUPATEN BATANG">
                                        </div>
                                        <div class="col-12">
                                            <label class="small fw-bold text-muted text-uppercase" style="font-size: 0.65rem;">Pemerintah Kecamatan (Tengah)</label>
                                            <input type="text" name="instansi_level_2" value="{{ $profil->instansi_level_2 ?? '' }}" class="form-control form-control-custom border-0 bg-light shadow-sm" placeholder="Contoh: KECAMATAN BATANG">
                                        </div>
                                        <div class="col-12">
                                            <label class="small fw-bold text-primary text-uppercase" style="font-size: 0.65rem;">Nama Lembaga / Kelurahan</label>
                                            <input type="text" name="nama_lembaga" value="{{ $profil->nama_lembaga ?? '' }}" class="form-control form-control-custom border-0 bg-light shadow-sm fw-bold" placeholder="Contoh: KELURAHAN SAMBONG">
                                        </div>
                                        <div class="col-md-8">
                                            <label class="small fw-bold text-muted text-uppercase" style="font-size: 0.65rem;">Alamat Jalan</label>
                                            <input type="text" name="alamat_jalan" value="{{ $profil->alamat_jalan ?? '' }}" class="form-control form-control-custom border-0 bg-light shadow-sm" placeholder="Jl. Kyai Sambong Nomor 12">
                                        </div>
                                        <div class="col-md-4">
                                            <label class="small fw-bold text-muted text-uppercase" style="font-size: 0.65rem;">Kode Pos</label>
                                            <input type="text" name="kode_pos" value="{{ $profil->kode_pos ?? '' }}" class="form-control form-control-custom border-0 bg-light shadow-sm" placeholder="51212">
                                        </div>
                                        <div class="col-12 mb-3">
                                            <label class="small fw-bold text-muted text-uppercase" style="font-size: 0.65rem;">Nomor Telepon / Email</label>
                                            <input type="text" name="no_telp" value="{{ $profil->no_telp ?? '' }}" class="form-control form-control-custom border-0 bg-light shadow-sm" placeholder="0285 – 392126 / kelurahan@email.com">
                                        </div>
                                    </div>
                                    <div class="text-end">
                                        <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm fw-bold" style="font-size: 0.85rem;">
                                            <i class="bi bi-check2-circle me-1"></i> Simpan Perubahan Kop
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>

                    {{-- TAB 2: PENUTUP SURAT --}}
                    <div class="tab-pane fade" id="penutup" role="tabpanel">
                        <div class="row g-4">
                            <div class="col-lg-4 border-end-lg">
                                <h6 class="fw-bold mb-3 small text-uppercase" style="letter-spacing: 1px;">Pilih Jenis Surat</h6>
                                <div class="list-group list-group-custom rounded-4 shadow-sm overflow-hidden border-0" id="list-tab" role="tablist">
                                    @foreach($jenisSurat as $key => $j)
                                        <a class="list-group-item list-group-item-action @if($key == 0) active @endif p-3 border-0" id="list-{{ $j->id }}-list" data-bs-toggle="list" href="#list-{{ $j->id }}" role="tab">
                                            <span class="d-block small fw-bold text-uppercase">{{ $j->nama_jenis }}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-lg-8 px-md-4">
                                <div class="tab-content" id="nav-tabContent">
                                    @foreach($jenisSurat as $key => $j)
                                    <div class="tab-pane fade @if($key == 0) show active @endif" id="list-{{ $j->id }}" role="tabpanel">
                                        <form action="{{ route('admin.setting.updatePenutup', $j->id) }}" method="POST">
                                            @csrf
                                            <div class="d-flex justify-content-between align-items-center mb-3">
                                                <h6 class="fw-bold text-primary m-0 text-truncate pe-2">{{ $j->nama_jenis }}</h6>
                                                <span class="badge bg-primary-subtle text-primary rounded-pill px-3 py-2" style="font-size: 0.6rem;">Template Penutup</span>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label class="small fw-bold text-muted mb-2 text-uppercase" style="font-size: 0.65rem;">Kalimat Penutup / Footer Surat</label>
                                                <textarea name="kalimat_penutup" class="form-control border-0 bg-light shadow-sm rounded-4 p-3" rows="6" style="font-size: 0.9rem;" placeholder="Contoh: Demikian surat keterangan ini dibuat agar dapat dipergunakan sebagaimana mestinya...">{{ $j->kalimat_penutup }}</textarea>
                                            </div>
                                            
                                            <div class="alert alert-info border-0 small shadow-sm rounded-4 d-flex align-items-start">
                                                <i class="bi bi-info-circle-fill me-2 mt-1"></i>
                                                <span>Kalimat ini akan muncul secara otomatis di bagian akhir isi surat sebelum kolom tanda tangan.</span>
                                            </div>

                                            <div class="text-end">
                                                <button type="submit" class="btn btn-success px-4 py-2 rounded-pill shadow-sm fw-bold" style="font-size: 0.85rem;">
                                                    <i class="bi bi-arrow-repeat me-1"></i> Update Penutup
                                                </button>
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
</main>
@endsection

@section('styles')
<style>
    main { position: relative; z-index: 1; }
    .responsive-title { font-size: clamp(1.1rem, 2.5vw, 1.4rem); }
    .responsive-sub { font-size: clamp(0.7rem, 1.5vw, 0.85rem); }
    
    .nav-tabs .nav-link { 
        color: #6c757d; 
        border-bottom: 3px solid transparent !important; 
    }
    .nav-tabs .nav-link.active { 
        color: #198754; 
        background: transparent !important; 
        border-bottom: 3px solid #198754 !important; 
    }

    .form-control-custom:focus {
        background-color: #fff !important;
        box-shadow: 0 4px 10px rgba(0,0,0,0.05) !important;
    }

    .list-group-custom .list-group-item.active {
        background-color: #f8f9fa;
        color: #0d6efd;
        border-left: 4px solid #0d6efd !important;
    }

    .scrollbar-hide::-webkit-scrollbar { display: none; }
    .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }

    @media (min-width: 992px) {
        .border-end-lg { border-right: 1px solid #edf2f7 !important; }
    }
</style>
@endsection