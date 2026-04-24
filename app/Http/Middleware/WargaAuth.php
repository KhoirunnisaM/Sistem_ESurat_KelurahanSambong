<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WargaAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        // Cek apakah session warga_logged_in ada
        if (!session()->has('warga_logged_in')) {
            return redirect('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        return $next($request);
    }
}