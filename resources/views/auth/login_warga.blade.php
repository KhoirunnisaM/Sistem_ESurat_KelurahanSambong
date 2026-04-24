@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow border-0">
                <div class="card-body p-5">
                    <div class="text-center mb-4">
                        <i class="bi bi-person-circle text-success" style="font-size: 3rem;"></i>
                        <h4 class="mt-2 fw-bold">Login Warga</h4>
                        <p class="text-muted">Masukkan data sesuai KTP Anda</p>
                    </div>

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <form action="{{ route('login.warga.submit') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">NIK (16 Digit)</label>
                            <input type="text" name="nik" class="form-control" maxlength="16" required placeholder="Masukkan NIK">
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-success btn-lg w-100">Masuk Ke Dashboard</button>
                    </form>
                    
                    <div class="text-center mt-4">
                        <span class="text-muted small">Belum punya akun? <a href="{{ route('register.warga') }}" class="text-success text-decoration-none">Daftar di sini</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection