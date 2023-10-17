@extends('layouts.main')

@section('container')
    <div class="row justify-content-center">
        <div class="col-lg-5">
            {{-- menambahkan alert ketika sudah berhasil login --}}
            {{-- cek dulu apakah session success ada isinya --}}
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            {{-- lebih baik menggunakan ini, agar menghindari user lain bisa tau salahnya di email, mengakibatkan pontensi melakukan kejahatan --}}
            @if (session()->has('loginError'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('loginError') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            <main class="form-signin w-100 m-auto">
                <h1 class="h3 mb-3 fw-normal text-center">Please Login</h1>
                <form action="/login" method="POST">
                    @csrf
                    <div class="form-floating">
                        {{-- menambah autofocus untuk otomatis type ketika login --}}
                        <input type="email" name="email" class="form-control"
                            id="email" placeholder="name@example.com" autofocus required value="{{ old('email') }}">
                        <label for="email">Email address</label>
                    </div>
                    <div class="form-floating">
                        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
                            id="password" placeholder="Password" required>
                        <label for="password">Password</label>
                    </div>

                    <button class="btn
                            btn-primary w-100 py-2" type="submit">Login</button>
                </form>

                <small class="d-block text-center mt-3">Not registered? <a href="/register"
                        class="text-decoration-none">Register Now!</a></small>
            </main>
        </div>
    </div>
@endSection
