<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index(){
        return view('login.index', [
            'title' => 'Login',
            'active' => 'login'
        ]);
    }

    public function authenticate(Request $request){
        $credentials = $request->validate([
            // kalau mau format gmail, bisa pakai :dns
            'email' => 'required|email',
            'password' => 'required'
        ]);

        // mengecek apakah input sudah sesuai di dalam database
        if (Auth::attempt($credentials)){
            // melakukan regenerasi session
            // tujuannya untuk menghindari trik jahat menggunakan session untuk menipu kalau dia lagi login
            $request->session()->regenerate();

            // menggunakan intended untuk melakukan middleware terlebih dahulu sebelum masuk
            return redirect()->intended('/dashboard');
        }

        // memberikan flash message
        return back()->with('loginError', 'Login failed!');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        // menghapus session agar tidak digunakan orang lain
        // bisa memakai cara ini
        $request->session()->invalidate();

        // dibuat baru agar tidak bisa dibajak
        // cara ini juga bisa
        request()->session()->regenerateToken();

        return redirect('/');
    }
}
