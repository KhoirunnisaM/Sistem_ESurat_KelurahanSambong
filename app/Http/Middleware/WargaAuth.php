<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Warga;
use Symfony\Component\HttpFoundation\Response;

class WargaAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Cek apakah session warga_logged_in ada
        if (!session()->has('warga_logged_in')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Cek status_akun langsung ke database untuk memastikan akun tetap aktif
        $warga = Warga::find(session('warga_id'));

        if (!$warga || $warga->status_akun != 1) {
            session()->flush(); 
            return redirect('/login')->with('error', 'Sesi berakhir atau akun Anda tidak aktif.');
        }

        return $next($request);
    }
}