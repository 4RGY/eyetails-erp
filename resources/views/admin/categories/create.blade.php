@extends('admin.layouts.app')

@section('title', 'Tambah Kategori Baru')

@section('content')
<header class="admin-content-header">
    <h1>Tambah Kategori Baru</h1>
    <p>Isi nama kategori yang ingin ditambahkan di bawah ini.</p>
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

        <form action="{{ route('admin.categories.store') }}" method="POST" class="admin-form">
            @csrf
            <div class="form-group">
                <label for="name">Nama Kategori</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required
                    autofocus>
                <small class="form-text text-muted">Nama kategori harus unik dan deskriptif, contoh: "T-Shirt", "Hoodie
                    & Sweater".</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Kategori</button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

{{-- CSS Tambahan --}}
<style>
    .admin-form .form-group {
        margin-bottom: 20px;
    }

    .admin-form label {
        display: block;
        font-weight: 600;
        margin-bottom: 5px;
        font-size: 0.9rem;
    }

    .admin-form .form-control {
        width: 100%;
        max-width: 500px;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
        box-sizing: border-box;
    }

    .form-text {
        font-size: 0.85rem;
    }

    .form-actions {
        margin-top: 30px;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 5px;
        text-transform: uppercase;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
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