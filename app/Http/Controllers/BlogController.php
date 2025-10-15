<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index()
    {
        // Ambil semua post yang sudah dipublikasikan, urutkan terbaru
        $posts = Post::whereNotNull('published_at')->latest()->paginate(10);
        return view('blog.index', compact('posts'));
    }

    public function show(Post $post)
    {
        return view('blog.show', compact('post'));
    }
}
