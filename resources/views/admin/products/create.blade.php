@extends('admin.layouts.app')

@section('title', 'Tambah Produk Baru')

@section('content')
<header class="admin-content-header">
    <h1>Tambah Produk Baru</h1>
    <p>Isi detail di bawah ini untuk menambahkan produk ke dalam katalog.</p>
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

        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
            class="admin-form modern-form">
            @csrf
            {{-- Bagian detail produk utama (tetap sama) --}}
            <div class="form-row">
                <div class="form-group full-width">
                    <label for="name">Nama Produk</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ old('name') }}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="sku">SKU (Stock Keeping Unit)</label>
                    <input type="text" name="sku" id="sku" class="form-control" value="{{ old('sku') }}" required>
                </div>
                <div class="form-group">
                    <label for="category_id">Kategori</label>
                    <select name="category_id" id="category_id" class="form-control" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id')==$category->id ? 'selected' : '' }}>{{
                            $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group full-width">
                    <label for="description">Deskripsi</label>
                    <textarea name="description" id="description" rows="5" class="form-control"
                        required>{{ old('description') }}</textarea>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="price">Harga (Rp)</label>
                    <input type="number" name="price" id="price" class="form-control" value="{{ old('price') }}"
                        required>
                </div>
                <div class="form-group">
                    <label for="sale_price">Harga Diskon (Rp) <small>(Opsional)</small></label>
                    <input type="number" name="sale_price" id="sale_price" class="form-control"
                        value="{{ old('sale_price') }}">
                </div>
            </div>
            <div class="form-group">
                <label for="images">Gambar Produk (Maksimal 7 file, file pertama akan jadi utama)</label>
                <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                @error('images.*')
                <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <hr class="form-divider">

            {{-- =================================================== --}}
            {{-- BAGIAN BARU UNTUK VARIAN PRODUK (UKURAN & STOK) --}}
            {{-- =================================================== --}}
            <div x-data="{ variants: [{ size: '', quantity: '' }] }">
                <h3 class="variants-header">Varian Produk (Ukuran & Stok)</h3>
                <template x-for="(variant, index) in variants" :key="index">
                    <div class="variant-row">
                        <div class="form-group">
                            <label>Ukuran</label>
                            <input type="text" x-model="variant.size" :name="`variants[${index}][size]`"
                                class="form-control" placeholder="Contoh: M" required>
                        </div>
                        <div class="form-group">
                            <label>Jumlah Stok</label>
                            <input type="number" x-model="variant.quantity" :name="`variants[${index}][quantity]`"
                                class="form-control" placeholder="Contoh: 50" required>
                        </div>
                        <button type="button" @click="variants.splice(index, 1)" x-show="variants.length > 1"
                            class="btn-remove-variant">
                            <i class="fa-solid fa-trash-alt"></i>
                        </button>
                    </div>
                </template>
                <button type="button" @click="variants.push({ size: '', quantity: '' })" class="btn btn-secondary">
                    <i class="fa-solid fa-plus"></i> Tambah Ukuran
                </button>
            </div>
            {{-- =================================================== --}}

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Simpan Produk</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .modern-form .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .modern-form .form-group {
        margin-bottom: 0;
    }

    .modern-form .form-group.full-width {
        grid-column: 1 / -1;
    }

    .modern-form label:not(.form-check-label) {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: #374151;
    }

    .modern-form .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 1rem;
        box-sizing: border-box;
    }

    .form-actions {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 0.75rem;
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

    .btn-secondary {
        background-color: #e5e7eb;
        color: #374151;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        padding: 1rem;
        border: 1px solid #f5c6cb;
        border-radius: .25rem;
        margin-bottom: 1rem;
    }

    .form-divider {
        border: none;
        border-top: 1px solid #e5e7eb;
        margin: 2rem 0;
    }

    .variants-header {
        font-size: 1.2rem;
        font-weight: 600;
        margin-bottom: 1.5rem;
    }

    .variant-row {
        display: grid;
        grid-template-columns: 1fr 1fr 50px;
        gap: 1rem;
        align-items: flex-end;
        margin-bottom: 1rem;
    }

    .btn-remove-variant {
        background-color: #fee2e2;
        color: #b91c1c;
        border: 1px solid #fecaca;
        height: 45px;
        width: 45px;
        border-radius: 6px;
        cursor: pointer;
    }
</style>
@endpush