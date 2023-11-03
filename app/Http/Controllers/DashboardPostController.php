<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use \Cviebrock\EloquentSluggable\Services\SlugService;

// Membuat controller tipe resource, untuk langsung CRUD otomatis dibuat
// Jika mengarah kepada model, bisa ditambahkan juga (saat ini, yang diarahkan adalah Post)
class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // ini dipanggil ketika mengakses dashboard/posts (ini adalah route menuju controller ini)
        // jika tidak dispesifikasi mau apa, maka default mengarah ke ini
        return view('dashboard.posts.index', [
            'posts' => Post::where('user_id', auth()->user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.posts.create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            // unique:posts artinya di tabel posts, kolom slug harus unique
            'slug' => 'required|unique:posts',
            'category_id' => 'required',
            'body' => 'required'
        ]);

        $validatedData['user_id'] = auth()->user()->id;
        // untuk membatasi karakter. Kalaumelebihi 200, diganti dengan ...
        // menggunakan strip tags untuk menghilangkan tag html
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200, '...');

        Post::create($validatedData);
        return redirect('/dashboard/posts')->with('success', 'New post has been added!');
    }

    /**
     * Display the specified resource.
     * Secara default, jika /id, maka akan otomatis ke sini
     * Jika ingin mengubahnya, bisa menggunakan getRouteKeyName() di model
     * Cek di model Post.php
     */
    public function show(Post $post)
    {
        // return detail post, dipanggil dari route dashboard/posts/{post} di index posts view
        return view('dashboard.posts.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        return view('dashboard.posts.edit', [
            'post' => $post,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        // membuat rules dulu, memastikan apakah perlu rules slug atau tidak
        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',
            'body' => 'required'
        ];

        // slug cukup kompleks, jadi perlu perlakuan khusus
        // secara otomatis, variable $post sudah tau post yang dimaksud itu yang mana
        if ($request->slug != $post->slug){
            $rules['slug'] = 'required|unique:posts';
        }

        // validasi setelah rules dibuat
        $validatedData = $request->validate($rules);

        // update
        Post::where('id', $post->id)->update($validatedData);

        // redirect
        return redirect('/dashboard/posts')->with('success', 'Post has been updated!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        Post::destroy($post->id);
        return redirect('/dashboard/posts')->with('success', 'Post has been deleted!');
    }

    // function untuk konversi title menjadi slug
    public function checkSlug(Request $request)
    {
        // artinya, mau membuat slug dari model Post
        // kolom yang mau disimpan slugnya namanya 'slug'
        // dan yang mau dikonversi menjadi slug adalah request title
        // request didapat dari create.blade.php dengan javascript api request key title
        // kenapa harus connect model/database? karena ingin dicek apakah ada slug yang sama di dalam database
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }
}
