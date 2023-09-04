<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('home', [
        "title" => "Home",
        "active" => "home"
    ]);
});

Route::get('about', function () {
    return view('about', [
        "title" => "About",
        "active" => "about",
        "name" => "Fellix Allenfant",
        "email" => "fellixallenfant31@gmail.com",
        "image" => "profile_png.png"
    ]);
});

Route::get('blog', [PostController::class, 'index']);

//halaman single post
Route::get('blog/{post:slug}', [PostController::class, 'show']);

//halaman categories
Route::get('categories', function(){
    return view('categories', [
        'title' => 'All Categories',
        'active' => 'categories',
        'categories' => Category::all()
    ]);
});

// halaman login
Route::get('login', [LoginController::class, 'index']);
Route::get('register', [RegisterController::class, 'index']);

// Sudah tidak dipakai lagi setelah mengakses category dan author dengan request
// Route::get('categories/{category:slug}', function(Category $category){
//     return view('posts', [
//         'title' => "Post by Category : $category->name",
//         'active' => 'categories',
//         'posts' => $category->posts->load('category', 'author')
//     ]);
// });

// //author
// Route::get('authors/{author:username}', function(User $author){
//     return view('posts', [
//         'title' => 'Post by Author : '.$author->name,
//         'active' => 'posts',
//         // lazy eager loading. menambahkan load, agar setelah mengambil post, sekalian mengambil category dan author
//         // karena kalau tidak, akan diquery lagi di view posts berkali-kali
//         'posts' => $author->posts->load('category', 'author')
//     ]);
// });