@extends('admin.layouts.app')

@section('title', 'Tambah Kategori Baru')

@section('content')
<header class="admin-content-header">
    <h1>Tambah Kategori Baru</h1>
    <p>Isi detail kategori yang ingin ditambahkan di bawah ini.</p>
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
        <form action="{{ route('admin.categories.store') }}" method="POST" class="admin-form"
            enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nama Kategori</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required
                    autofocus>
                <small class="form-text text-muted">Nama kategori harus unik dan deskriptif, contoh: "T-Shirt".</small>
            </div>

            {{-- TAMBAHKAN INPUT FILE INI --}}
            <div class="form-group">
                <label for="image_path">Gambar Kategori (Opsional)</label>
                <input type="file" name="image_path" id="image_path" class="form-control-file">
                <small class="form-text text-muted">Direkomendasikan gambar dengan rasio 3:4 (portrait).</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Kategori</button>
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

    .form-text {
        font-size: .85rem
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
</style>
@endsection