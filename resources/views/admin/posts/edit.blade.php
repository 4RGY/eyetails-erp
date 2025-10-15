@extends('admin.layouts.app')

@section('title', 'Edit Artikel: ' . $post->title)

@section('content')
<header class="admin-content-header">
    <h1>Edit Artikel</h1>
    <p>Perbarui detail untuk artikel "{{ $post->title }}".</p>
</header>

<div class="admin-card">
    <div class="admin-card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data"
            class="admin-form">
            @csrf
            @method('PUT') {{-- Method 'PUT' untuk update --}}

            <div class="form-group">
                <label for="title">Judul Artikel</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $post->title) }}"
                    required>
            </div>

            <div class="form-group">
                <label for="image">Ganti Gambar Utama (Opsional)</label>
                <input type="file" name="image" id="image" class="form-control">
                @if($post->image)
                <div style="margin-top: 10px;">
                    <small>Gambar saat ini:</small><br>
                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" width="200"
                        style="border-radius: 4px; max-width: 100%;">
                </div>
                @endif
            </div>

            <div class="form-group">
                <label for="excerpt">Ringkasan (Excerpt)</label>
                <textarea name="excerpt" id="excerpt" rows="3" class="form-control"
                    required>{{ old('excerpt', $post->excerpt) }}</textarea>
            </div>

            <div class="form-group">
                <label for="body">Isi Konten</label>
                <textarea name="body" id="body" rows="10" class="form-control"
                    required>{{ old('body', $post->body) }}</textarea>
            </div>

            <div class="form-group">
                <label for="published_at">Tanggal Publikasi (Opsional)</label>
                {{-- Format tanggal untuk input datetime-local --}}
                <input type="datetime-local" name="published_at" id="published_at" class="form-control"
                    value="{{ old('published_at', $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('Y-m-d\TH:i') : '') }}">
                <small class="form-text text-muted">Kosongkan untuk menyimpan sebagai Draf.</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Artikel</button>
                <a href="{{ route('admin.posts.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

{{-- === EMBEDDED CSS === --}}
<style>
    .admin-form .form-group {
        margin-bottom: 25px;
    }

    .admin-form label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .admin-form .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
        box-sizing: border-box;
    }

    .form-text {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 5px;
    }

    .form-actions {
        margin-top: 30px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 5px;
        text-transform: uppercase;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-primary {
        background-color: var(--primary-accent);
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        padding: 1rem;
        border: 1px solid #f5c6cb;
        border-radius: .25rem;
        margin-bottom: 1rem;
    }
</style>
@endsection