<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Models\Category;

class PostController extends Controller
{
    public function index(){
        // coding untuk mengganti title sesuai request
        $title = '';
        if (request('category')) {
            //mencari category di database ada atau tidak
            $category = Category::firstWhere('slug', request('category'));
            $title = ' : ' . $category->name;
        }

        if (request('author')){
            $author = User::firstWhere('username', request('author'));
            $title = ' : ' . $author->name;
        }
        
        //melakukan query ke database
        return view('posts', [
            "title" => "All Posts" . $title,
            "active" => "posts",
            // "posts" => Post::all()
            // menampilkan post terbaru
            // menggunakan eager loading, agar tidak perlu banyak query, sekalian pas fetch query melakukan 2 kali saja user dan category
            // menggunakan filter() function scope di model Post
            // awalnya Post::latest()->get(), cuman diganti paginate untuk membatasi mau berapa post
            // dengan adanya withQueryString, maka apapun yang ada di request sebelumnya akan tetap ada
            "posts" => Post::latest()->filter(request(['search', 'category']))->paginate(7)->withQueryString()
        ]);
    }

    public function show(Post $post){ //syarat binding harus sama nama parameter dengan {post} di route. Tujuannya untuk menghindari penebakan
        return view('post', [
            "title" => "Single Post",
            "active" => "posts",
            "post" => $post //menyingkatkan Post::find($slug)
        ]);
    }
}