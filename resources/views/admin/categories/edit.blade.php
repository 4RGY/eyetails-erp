@extends('admin.layouts.app')

@section('title', 'Edit Kategori: ' . $category->name)

@section('content')
<header class="admin-content-header">
    <h1>Edit Kategori</h1>
    <p>Ubah detail untuk kategori "{{ $category->name }}".</p>
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

        {{-- PERUBAHAN: Tambahkan enctype untuk upload file --}}
        <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="admin-form"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nama Kategori</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}"
                    required autofocus>
            </div>

            {{-- TAMBAHKAN INPUT FILE DAN PREVIEW GAMBAR --}}
            <div class="form-group">
                <label for="image_path">Ganti Gambar (Opsional)</label>
                <input type="file" name="image_path" id="image_path" class="form-control-file">
                @if ($category->image_path)
                <div class="current-image-preview">
                    <small>Gambar Saat Ini:</small>
                    <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }}">
                </div>
                @endif
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Kategori</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<style>
    .admin-form .form-group {
        margin-bottom: 20px
    }

    .admin-form label {
        display: block;
        font-weight: 600;
        margin-bottom: 5px;
        font-size: .9rem
    }

    .admin-form .form-control,
    .admin-form .form-control-file {
        width: 100%;
        max-width: 500px;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
        box-sizing: border-box
    }

    .form-actions {
        margin-top: 30px
    }

    .btn {
        padding: 10px 20px;
        border-radius: 5px;
        text-transform: uppercase;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block
    }

    .btn-primary {
        background-color: var(--primary-accent);
        color: #fff
    }

    .btn-secondary {
        background-color: #6c757d;
        color: #fff
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        padding: 1rem;
        border: 1px solid #f5c6cb;
        border-radius: .25rem;
        margin-bottom: 1rem
    }

    /* Style untuk preview gambar */
    .current-image-preview {
        margin-top: 15px;
    }

    .current-image-preview small {
        display: block;
        margin-bottom: 5px;
        color: #6c757d;
    }

    .current-image-preview img {
        max-width: 200px;
        height: auto;
        border-radius: 4px;
        border: 1px solid #ddd;
    }
</style>
@endsection