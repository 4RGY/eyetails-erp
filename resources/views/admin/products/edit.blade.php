@extends('admin.layouts.app')

@section('title', 'Edit Produk: ' . $product->name)

@push('styles')
{{-- Style ini udah digabung dan disesuaikan sama kode lu --}}
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

    /* KODE BARU: Style untuk Galeri Gambar Saat Ini */
    .current-images-section {
        padding: 1.5rem;
        border-bottom: 1px solid #e5e7eb;
        margin-bottom: 1.5rem;
    }

    .current-images-section h3 {
        margin-top: 0;
        margin-bottom: 1rem;
        font-size: 1.2rem;
        font-weight: 600;
    }

    .image-gallery {
        display: flex;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .image-item {
        position: relative;
        width: 120px;
        height: 120px;
        border-radius: 8px;
        overflow: hidden;
        border: 1px solid #e5e7eb;
    }

    .image-item img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-item .delete-btn {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(220, 53, 69, 0.8);
        color: white;
        border: none;
        border-radius: 50%;
        width: 24px;
        height: 24px;
        font-size: 16px;
        font-weight: bold;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        transition: background 0.2s;
    }

    .image-item .delete-btn:hover {
        background: #dc3545;
    }
</style>
@endpush

@section('content')
<header class="admin-content-header">
    <h1>Edit Produk</h1>
    <p>Perbarui detail untuk produk "{{ $product->name }}".</p>
</header>

<div class="admin-card">
    <div class="admin-card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
            <ul>@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
        @endif

        {{-- ======================================================= --}}
        {{-- BAGIAN BARU UNTUK MENAMPILKAN & MENGHAPUS GAMBAR --}}
        {{-- ======================================================= --}}
        <div class="current-images-section">
            <h3>Gambar Saat Ini</h3>
            <div class="image-gallery">
                @forelse($product->images as $image)
                <div class="image-item">
                    <img src="{{ asset('storage/' . $image->path) }}" alt="Product Image {{ $loop->iteration }}">
                    <form action="{{ route('admin.products.images.destroy', $image->id) }}" method="POST"
                        onsubmit="return confirm('Yakin ingin menghapus gambar ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn" title="Hapus Gambar">&times;</button>
                    </form>
                </div>
                @empty
                <p>Belum ada gambar untuk produk ini.</p>
                @endforelse
            </div>
        </div>
        {{-- ======================================================= --}}

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
            class="admin-form modern-form">
            @csrf
            @method('PUT')

            {{-- Bagian detail produk utama (kode lu, ga diubah) --}}
            <div class="form-row">
                <div class="form-group full-width"><label for="name">Nama Produk</label><input type="text" name="name"
                        id="name" class="form-control" value="{{ old('name', $product->name) }}" required></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label for="sku">SKU</label><input type="text" name="sku" id="sku"
                        class="form-control" value="{{ old('sku', $product->sku) }}" required></div>
                <div class="form-group"><label for="category_id">Kategori</label><select name="category_id"
                        id="category_id" class="form-control" required>@foreach($categories as $category)<option
                            value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ?
                            'selected' : '' }}>{{ $category->name }}</option>@endforeach</select></div>
            </div>
            <div class="form-row">
                <div class="form-group full-width"><label for="description">Deskripsi</label><textarea
                        name="description" id="description" rows="5" class="form-control"
                        required>{{ old('description', $product->description) }}</textarea></div>
            </div>
            <div class="form-row">
                <div class="form-group"><label for="price">Harga (Rp)</label><input type="number" name="price"
                        id="price" class="form-control" value="{{ old('price', $product->price) }}" required></div>
                <div class="form-group"><label for="sale_price">Harga Diskon (Rp)</label><input type="number"
                        name="sale_price" id="sale_price" class="form-control"
                        value="{{ old('sale_price', $product->sale_price) }}"></div>
            </div>

            {{-- ======================================================= --}}
            {{-- PERUBAHAN INPUT FILE MENJADI MULTIPLE --}}
            {{-- ======================================================= --}}
            <div class="form-row">
                <div class="form-group full-width">
                    <label for="images">Tambah Gambar Baru (Maksimal 7)</label>
                    <input type="file" name="images[]" id="images" class="form-control" multiple accept="image/*">
                    @error('images.*') <div class="text-danger" style="font-size: 0.8rem; margin-top: 5px;">{{ $message
                        }}</div> @enderror
                </div>
            </div>
            {{-- ======================================================= --}}

            <hr class="form-divider">

            {{-- Bagian Varian dengan Alpine.js (kode lu, ga diubah) --}}
            <div
                x-data="{ variants: {{ json_encode(old('variants', $product->variants->map(fn($v) => ['size' => $v->size, 'quantity' => $v->quantity]))) }} }">
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

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Produk</button>
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection