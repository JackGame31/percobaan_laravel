<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        //
    }
}
