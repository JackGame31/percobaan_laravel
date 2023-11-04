@extends('layouts.main')

@section('container')
    <h1 class="mb-3 text-center">{{ $title }}</h1>

    <div class="row justify-content-center mb-3">
        <div class="col-md-6">
            <form action="/blog">
                {{-- jika ada request, dan tidak ingin dihilangkan, maka bisa membuat input baru --}}
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif
                @if (request('author'))
                    <input type="hidden" name="author" value="{{ request('author') }}">
                @endif
                <div class="input-group mb-3">
                    {{-- menambahkan value request search agar setelah search, valuenya masih ada --}}
                    <input type="text" class="form-control" placeholder="Search..." name="search"
                        value="{{ request('search') }}">
                    <button class="btn btn-danger" type="submit">Search</button>
                </div>
            </form>
        </div>
    </div>

    {{-- menampilkan paling pertama lebih besar. Maka memakai posts[0] --}}
    @if ($posts->count() > 0)
        {{-- Menampilkan post paling pertama --}}
        <div class="card mb-3">
            @if ($posts[0]->image)
                <div style="max-height: 400px; overflow:hidden;">
                    <img src="{{ asset('storage/' . $posts[0]->image) }}" class="card-img-top"
                        alt="{{ $posts[0]->category->name }}">
                </div>
            @else
                {{-- memakai unsplash untuk mendapatkan gambar random --}}
                <img src="https://source.unsplash.com/1200x400?{{ $posts[0]->category->name }}" class="card-img-top"
                    alt="{{ $posts[0]->category->name }}">
            @endif
            <div class="card-body text-center">
                <h3 class="card-title"><a href="/blog/{{ $posts[0]->slug }}"
                        class="text-decoration-none text-dark">{{ $posts[0]->title }}</a></h3>
                <p>
                    <small class="text-body-secondary">
                        By <a href="/blog?author={{ $posts[0]->author->username }}"
                            class="text-decoration-none">{{ $posts[0]->author->name }}</a> in <a
                            href="/blog?category={{ $posts[0]->category->slug }}" class="text-decoration-none">
                            {{ $posts[0]->category->name }}</a> {{ $posts[0]->created_at->diffForHumans() }}
                    </small>
                </p>
                <p class="card-text">
                    {{ $posts[0]->excerpt }}
                </p>
                <a href="/blog/{{ $posts[0]->slug }}" class="text-decoration-none btn btn-primary">Read more</a>
            </div>
        </div>

        {{-- menampilkan post lainnya --}}
        <div class="container">
            <div class="row">
                {{-- skip 1 post karena sudah dipakai di awal, memakai methode skip(1) --}}
                @foreach ($posts->skip(1) as $post)
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="position-absolute bg-dark px-3 py-2" style="background-color: rgba(0,0,0,0.7)">
                                <a href="/blog?categories={{ $post->category->slug }}"
                                    class="text-white text-decoration-none">{{ $post->category->name }}</a>
                            </div>
                            @if ($post->image)
                                <div style="max-height: 400px; overflow:hidden;">
                                    <img src="{{ asset('storage/' . $post->image) }}" class="card-img-top"
                                        alt="{{ $post->category->name }}">
                                </div>
                            @else
                                {{-- memakai unsplash untuk mendapatkan gambar random --}}
                                <img src="https://source.unsplash.com/500x400?{{ $post->category->name }}" class="card-img-top"
                                alt="{{ $post->category->name }}">
                            @endif
                            <div class="card-body">
                                <h5 class="card-title">{{ $post->title }}</h5>
                                <p>
                                    <small class="text-body-secondary">
                                        By <a href="/blog?author={{ $posts[0]->author->username }}"
                                            class="text-decoration-none">{{ $posts[0]->author->name }}</a>
                                        {{ $posts[0]->created_at->diffForHumans() }}
                                    </small>
                                </p>
                                <p class="card-text">{{ $post->excerpt }}</p>
                                <a href="/blog/{{ $post->slug }}" class="btn btn-primary">Read More</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @else
        <p class="text-center fs-4">No post found</p>
    @endif

    {{-- menambahkan next dan prev (langsung bawaan dari laravel) --}}
    <div class="d-flex justify-content-center">
        {{ $posts->links() }}
    </div>
@endsection