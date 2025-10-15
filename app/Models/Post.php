<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'body',
        'image',
        'published_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * TAMBAHKAN BLOK INI
     * @var array<string, string>
     */
    protected $casts = [
        'published_at' => 'datetime',
    ];
}