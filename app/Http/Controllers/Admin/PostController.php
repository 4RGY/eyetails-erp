<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Menampilkan daftar semua artikel blog.
     */
    public function index()
    {
        $posts = Post::latest()->paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Menampilkan form untuk membuat artikel baru.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Menyimpan artikel baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:posts',
            'excerpt' => 'required|string|max:300',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('posts', 'public');
            $data['image'] = $path;
        }

        Post::create($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Artikel baru berhasil ditambahkan.');
    }

    /**
     * Menampilkan form untuk mengedit artikel.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Memperbarui data artikel di database.
     */
    public function update(Request $request, Post $post)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:posts,title,' . $post->id,
            'excerpt' => 'required|string|max:300',
            'body' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->except('image');
        $data['slug'] = Str::slug($request->title);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $path = $request->file('image')->store('posts', 'public');
            $data['image'] = $path;
        }

        $post->update($data);

        return redirect()->route('admin.posts.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    /**
     * Menghapus artikel dari database.
     */
    public function destroy(Post $post)
    {
        // Hapus gambar terkait jika ada
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')
            ->with('success', 'Artikel berhasil dihapus.');
    }
}
