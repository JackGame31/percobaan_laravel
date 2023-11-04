@extends('dashboard.layouts.main')

@section('container')
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-8">

                <h1 class="mb-3">{{ $post->title }}</h1>

                {{-- Back to posts --}}
                <a href="/dashboard/posts" class="btn btn-success"><i class="bi bi-arrow-left fs-5 me-2"></i> Back to All My
                    Posts</a>

                {{-- Edit --}}
                <a href="/dashboard/posts/{{ $post->slug }}/edit" class="btn btn-warning"><i
                        class="bi bi-pen-fill fs-5 me-2"></i> Edit</a>

                {{-- Delete --}}
                <form action="/dashboard/posts/{{ $post->slug }}" method="post" class="d-inline">
                    {{-- kita bajak ubah method menjadi delete --}}
                    @method('delete')
                    @csrf
                    {{-- javascript simpel seperti log confirm --}}
                    <button class="btn btn-danger" onclick="return confirm('Are you sure?')"><i
                            class="bi bi-x-circle fs-6"></i> Delete</button>
                </form>

                {{-- image --}}
                @if ($post->image)
                    <div style="max-height: 350px; overflow:hidden;">
                        <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid mt-3"
                            alt="{{ $post->category->name }}">
                    </div>
                @else
                    <img src="https://source.unsplash.com/1200x400?{{ $post->category->name }}" class="img-fluid mt-3"
                        alt="{{ $post->category->name }}">
                @endif

                <article class="my-3 fs-5">
                    {!! $post->body !!} <!-- Ini untuk eksekus inner HTML -->
                </article>
            </div>
        </div>
    </div>
@endsection
