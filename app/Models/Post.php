<?php

namespace App\Models;

class Post
{
    private static $blog_posts = [
        [
            "title" => "Jokes Buah",
            "slug" => "jokes-buah",
            "author" => "Fellix Allenfant",
            "body" => "Buah, buah apa yang disukai mahasiswa? Jawaban : A Ples. Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus blanditiis tempora at nihil error perferendis nemo quae ipsa praesentium, qui animi molestiae ipsam, rerum vel iure, esse quisquam aut ea."
        ],
    
        [
            "title" => "Jokes Orang Manis",
            "slug" => "jokes-orang-manis",
            "author" => "Charles Wijaya",
            "body" => "Kenapa orang yang suka makan manisan cepet marah? Jawaban : Dia-Bete. Lorem ipsum dolor sit amet consectetur adipisicing elit. Temporibus blanditiis tempora at nihil error perferendis nemo quae ipsa praesentium, qui animi molestiae ipsam, rerum vel iure, esse quisquam aut ea."
        ]
    ];

    public static function all()
    {
        return collect(self::$blog_posts);
    }

    public static function find($slug)
    {
        $posts = static::all();
        return $posts->firstWhere('slug', $slug);
    }
}
