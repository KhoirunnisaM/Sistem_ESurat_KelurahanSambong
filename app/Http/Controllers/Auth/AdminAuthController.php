<?php

namespace App\Http\Controllers\Auth; // Sesuaikan namespace

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAuthController extends Controller
{
    public function showLoginForm()
    {
        // Mengarah ke resources/views/auth/login_admin.blade.php
        return view('auth.login_admin'); 
    }

    public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required',
        'password' => 'required',
    ]);

    if (Auth::guard('admin')->attempt($credentials)) {
        $request->session()->regenerate();
        // Redirect ke dashboard admin setelah login sukses
        return redirect()->route('admin.dashboard'); 
    }

    return back()->withErrors(['username' => 'Username atau password salah.']);
}

    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('admin.login');
    }
}