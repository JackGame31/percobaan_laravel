<?php

use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\DashboardPostController;

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

// halaman register
// tujuan menambahkan middleware guest adalah untuk memastikan yang bisa masuk ke route ini kalau belum login/guest
// kalau tidak lolos middleware, akan diarahkan ke route default
Route::get('register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('register', [RegisterController::class, 'store']);

// halaman login
// kalau user berusaha untuk paksa login dashboard, maka akan kita langsung otomatiskan route ke login (yang dibawah ini)
// ini diatur oleh Authenticate.php
Route::get('login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('login', [LoginController::class, 'authenticate']);
Route::post('logout', [LoginController::class, 'logout']);

//dashboard
// menandakan kalau ini hanya bisa diakses oleh orang-orang yang memiliki akses
Route::get('dashboard', function(){
    return view('dashboard.index');
})->middleware('auth');
// untuk mengakses function conversi title jadi slug
Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth');
// ini route khusus untuk CRUD, dari pada membuat semua CRUD satu-satu route, hanya buat satu route saja (dinamakan resource)
// cek class DashboardPostController sebagai salah satu controller resource
Route::resource('dashboard/posts', DashboardPostController::class)->middleware('auth');

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