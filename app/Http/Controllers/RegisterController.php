<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register.index', [
            'title' => 'Register',
            'active' => 'register'
        ]);
    }

    // tujuannya untuk memproses register
    public function store(Request $request)
    {
        // mengambil data
        // cara pertama
        // request()->all();

        // cara kedua
        // $request->all();

        // melakukan validasi data
        $validatedData = $request->validate([
            'name' => 'required|max:255',
            'username' => ['required', 'min:4', 'max:255', 'unique:users'], //unique:users artinya akan dicari di model user dan di cek apakah ada yang sama atau tidak
            'email' => 'required|email:dns|unique:users',
            'password' => 'required|min:5|max:255'
        ]);

        // enskripsi password
        // cara 1
        // $validatedData['password'] = bcrypt($validatedData['password']);
        // cara 2
        $validatedData['password'] = Hash::make($validatedData['password']);

        //jika yang ada di request lolos, maka yang ada di bawahnya akan dijalankan
        User::create($validatedData);

        //mengeluarkan pemberitahuan kalau berhasil
        // maksudnya, aku kasih session ini namanya succes. Nanti untuk menampilkan, tinggal ketik session('success')
        // $request->session()->flash('success', 'Registration success! Please login');

        // route ke login kalau sudah selesai ke register
        // bisa langsung flash dengan redirect
        return redirect('/login')->with('success', 'Registration success! Please login');
    }
}