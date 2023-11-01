<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    // protected $fillable = ['title', 'excerpt', 'body']; // artinya boleh isi itu
    protected $guarded = ['id']; //artinya tidak boleh isi ID

    //cara singkat untuk mengambil data with, tetapi di dalam model
    //jadi tidak perlu query tambahan lagi, sudah diquery dari awal
    protected $with = ['category', 'author'];

    //mempersingkat tugas check apakah ada request search/filter
    public function scopeFilter($query, array $filters)
    {
        //cek apakah ada pencarian
        //menerima parameter array, bisa menerima 'search', 'author', dst
        //isset berfungsi untuk mencari apakah ada atau tidak di dalam array sebuah variable 'search'

        //cara pertama (cara panjang)
        // if (isset($filters['search']) ? $filters['search'] : false) {
        //     //melakukan query ke database
        //     //kalau sql biasa : select * from posts where title like %{{ search }}%
        //     //tujuan % adalah untuk bebas, yang penting dalamnya ada search
        //     return $query->where('title', 'like', '%' . $filters['search'] . '%')->orwhere('body', 'like', '%' . $filters['search'] . '%');
        // }

        //cara kedua (cara singkat)
        $query->when($filters['search'] ?? false, function ($query, $search) {
            return $query->where('title', 'like', '%' . $search . '%')->orwhere('body', 'like', '%' . $search . '%');
        });

        // cek apakah nama category di request sama dengan nama category di database
        $query->when($filters['category'] ?? false, function ($query, $category)
        {
            // melakukan join, mengakses tabel category
            // menggunakan use () untuk beritau kalau $category yang dimaksud adalah category yang sebelumnya sudah dibuat
            // mirip sql : select * from posts join categories on categories.id = posts.category_id where categories.slug = $category
            return $query->whereHas('category', function($query) use ($category){
                // mengakses slug untuk cek apakah sama atau tidak
                $query->where('slug', $category);
            });
        });

        // cek untuk authors filter
        $query->when($filters['author'] ?? false, function ($query, $author)
        {
            return $query->whereHas('author', function($query) use ($author){
                $query->where('username', $author);
            });
        });
    }

    //menghubungkan models/relasi dari post ke category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function author()
    {
        //menambahkan user_id untuk memberitau kalau ini sebenarnya yang dicari itu user_id, karena biasanya akan dicari berdasarkan nama functionnya
        return $this->belongsTo(User::class, 'user_id');
    }

    // ini memaksa, setiap route yang mengarah ke post, maka yang diambil adalah slug, bukan id
    // fitur ini dipakai waktu view index posts klik detail, awalnya mengarah ke id, sekarang mengarah ke slug
    // karena defaultnya, controller resource mencari berdasarkan id, tidak bisa slug
    public function getRouteKeyName()
    {
        return 'slug';
    }
}