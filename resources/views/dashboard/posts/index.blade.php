@extends('dashboard.layouts.main')

@section('container')
    {{-- Header --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">My Posts</h1>
    </div>

    {{-- alert --}}
    @if(session()->has('success'))
        <div class="alert alert-success col-lg-8" role="alert">
            {{ session('success') }}
        </div>
    @endif

    {{-- Table --}}
    <div class="table-responsive small col-lg-8">
        <a href="/dashboard/posts/create" class="btn btn-primary mb-3">Create new post</a>
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Category</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        {{-- Bawaan dari laravel untuk increment angka. Baca dokumentasi di internet --}}
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->category->name }}</td>
                        <td>
                            {{-- Posts --}}
                            <a href="/dashboard/posts/{{ $post->slug }}" class="badge bg-info"><i class="bi bi-eye-fill fs-6"></i></a>

                            {{-- Edit --}}
                            {{-- Aturan default kalau mau akses edit --}}
                            {{-- Kalau mau lihat semua list, maka bisa ketik di terminal "php artisan route:list" --}}
                            <a href="/dashboard/posts/{{ $post->slug }}/edit" class="badge bg-warning"><i class="bi bi-pen-fill fs-6"></i></a>

                            {{-- Delete --}}
                            {{-- form hanya bisa post saja --}}
                            <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
                                {{-- kita bajak ubah method menjadi delete --}}
                                @method('delete')
                                @csrf
                                {{-- javascript simpel seperti log confirm --}}
                                <button class="badge bg-danger border-0" onclick="return confirm('Are you sure?')"><i class="bi bi-x-circle fs-6"></i></button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection