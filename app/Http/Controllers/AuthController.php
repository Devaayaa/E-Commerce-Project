<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function showRegister()
    {
        return view('auth.register');
    }

    // Logika POST login dan register bisa ditambahkan di sini nanti
    public function login(Request $request)
    {
        // Logika autentikasi
        return redirect()->route('home');
    }

    public function register(Request $request)
    {
        // Logika pendaftaran
        return redirect()->route('home');
    }

        // Tambahkan method ini di dalam class AuthController
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}