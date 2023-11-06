@extends('dashboard.layouts.main')

{{-- tambahan untuk menggunakan trix --}}
@section('head')
    @include('dashboard.layouts.trix')
@endsection

@section('container')
    {{-- Header --}}
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Create New Post</h1>
    </div>

    <div class="col-lg-8">
        {{-- method post digabung dengan dashboard/posts akan mengarah kepada resource controller tipe store --}}
        {{-- menambah atribute multipart/form-data. tujuannya adalah ketika menerima request file, bisa diproses (wajib ada) --}}
        <form method="post" action="/dashboard/posts" class="mb-5" enctype="multipart/form-data">
            @csrf

            {{-- Title --}}
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" @error('title') is-invalid @enderror id="title" name="title"
                    required autofocus value="{{ old('title') }}">
                @error('title')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Slug --}}
            <div class="mb-3">
                <label for="slug" class="form-label">Slug</label>
                {{-- ditambah disabled readonly untuk tidak bisa diedit user, opsional --}}
                <input type="text" class="form-control" @error('slug') is-invalid @enderror id="slug" name="slug"
                    required value="{{ old('slug') }}">
                @error('slug')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Category --}}
            <div class="mb-3">
                <label for="category" class="form-label">Category</label>
                <select class="form-select" name="category_id">
                    @foreach ($categories as $category)
                        @if (old('category_id') == $category->id)
                            <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                        @else
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            {{-- Upload File --}}
            <div class="mb-3">
                <label for="image" class="form-label" @error('image') is-invalid @enderror>Post Image</label>
                <img class="img-fluid img-preview mb-3 col-sm-5">
                <input class="form-control" type="file" id="image" name="image" onchange="previewImage();">
                @error('image')
                    <div class="invalid-feedback d-block">
                        {{ $message }}
                    </div>
                @enderror
            </div>

            {{-- Text menggunakan Trix --}}
            <div class="mb-3">
                <label for="body" class="form-label">Body</label>
                @error('body')
                    <p class="text-danger">{{ $message }}</p>
                @enderror
                {{-- ketika menggunakan trix, usahakan id dan input memiliki nama yang sama --}}
                <input id="body" type="hidden" name="body" value="{{ old('body') }}">
                <trix-editor input="body"></trix-editor>
            </div>

            <button type="submit" class="btn btn-primary">Create Post</button>
        </form>
    </div>

    <script>
        // mendapat 2 komponen
        const title = document.querySelector('#title');
        const slug = document.querySelector('#slug');

        // ketika ada perubahan dalam title
        title.addEventListener('change', function() {
            // fetch = mengambil data dari url
            // then = menangkap data yang diambil
            // response = data yang diambil
            // json = mengubah data yang diambil menjadi json
            fetch('/dashboard/posts/checkSlug?title=' + title.value)
                .then(response => response.json())
                // ini artinya, attribute slug, isinya/valuenya diubah sesuai dengan data hasil fetch slug
                .then(data => slug.value = data.slug)
        });

        // mematikan fitur trix upload file
        document.addEventListener('trix-file-accept', function(e) {
            e.preventDefault();
        });

        function previewImage()
        {
            // ambil input dan tag image
            const image = document.querySelector('#image');
            const imagePreview = document.querySelector('.img-preview');

            imagePreview.style.display = 'block';

            // function untuk read file
            const oFReader = new FileReader();
            oFReader.readAsDataURL(image.files[0]);
            oFReader.onload = function(oFREvent) {
                imagePreview.src = oFREvent.target.result;
            }
        }
    </script>
@endsection