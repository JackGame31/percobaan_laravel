<?php

namespace App\Http\Controllers;

use App\Models\Post;

class PostController extends Controller
{
    public function index(){
        return view('posts', [
            "title" => "Posts",
            "posts" => Post::all()
        ]);
    }

    public function show(Post $post){ //syarat binding harus sama nama parameter dengan {post} di route. Tujuannya untuk menghindari penebakan
        return view('post', [
            "title" => "Single Post",
            "post" => $post //menyingkatkan Post::find($slug)
        ]);
    }
}