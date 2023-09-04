@extends('layouts.main')

@section('container')
    <div class="row justify-content-center">
        <div class="col-lg-5">
            <main class="form-registration w-100 m-auto">
                <h1 class="h3 mb-3 fw-normal text-center">Registration Form</h1>
                <form action="/register" method="POST">
                    {{-- menambahkan token untuk menghindari CSRF (website lain bisa melakukan POST). Kita ingin website kita yang melakukan POST, maka ditambahkan CSRF --}}
                    @csrf
                    <div class="form-floating">
                        {{-- menambahkan error('name') dan enderror untuk beritau kalau ini section error akan muncul ketika ada error di name=name --}}
                        {{-- menambahkan value = {{ old('name') }} untuk mengambil value lama dari attribute yang memiliki name 'name' ketika kena refresh --}}
                        <input type="text" name="name" class="form-control rounded-top @error('name') is-invalid @enderror" id="name" placeholder="Name" required value={{ old('nama') }}>
                        <label for="name">Name</label>
                        {{-- jika ada error, maka akan muncul feedback ini. Kita tinggal menggunakan bawaan laravel validation error dengan {{ message }} --}}
                        {{-- menambahkan required agar validasi error dilakukan oleh web browser (seperti muncul sebelum regist) --}}
                        @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-floating">
                        <input type="text" name="username" class="form-control @error('username') is-invalid @enderror" id="username" placeholder="Username" required value={{ old('username') }}>
                        <label for="username">Username</label>
                        @error('username') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-floating">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" id="email" placeholder="name@example.com" required value={{ old('email') }}>
                        <label for="email">Email address</label>
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="form-floating">
                        <input type="password" name="password" class="form-control rounded-bottom @error('password') is-invalid @enderror" id="Password" placeholder="Password" required>
                        <label for="Password">Password</label>
                        @error('password') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button class="btn btn-primary w-100 py-2 mt-3" type="submit">Register</button>
                </form>

                <small class="d-block text-center mt-3">Already registered? <a href="/login" class="text-decoration-none">Login</a></small>
            </main>
        </div>
    </div>
@endSection
