@extends('akun.master')

@section('title', 'Wishlist Saya | eyetails.co')

@section('account-content')
<div class="wishlist-header">
    <h2 class="dashboard-title"><i class="far fa-heart"></i> Wishlist Saya</h2>
    <p class="mb-4 text-gray-600">Produk yang Anda sukai dan simpan untuk dibeli nanti.</p>
</div>


@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

@if ($wishlistItems->count())
<div class="wishlist-grid">
    @foreach ($wishlistItems as $item)
    @if($item->product)
    <div class="wishlist-item-container">
        {{-- Menggunakan component product-card yang sudah ada --}}
        <x-product-card :product="$item->product" />

        {{-- Tombol Hapus dengan style baru --}}
        <form method="POST" action="{{ route('wishlist.toggle') }}" class="remove-wishlist-form">
            @csrf
            <input type="hidden" name="product_id" value="{{ $item->product->id }}">
            <button type="submit" class="btn btn-remove-wishlist">
                <i class="fas fa-times"></i> Hapus dari Wishlist
            </button>
        </form>
    </div>
    @endif
    @endforeach
</div>
@else
<div class="empty-wishlist-container">
    <div class="icon-wrapper">
        <i class="far fa-heart"></i>
    </div>
    <h3>Wishlist Anda Kosong</h3>
    <p>Simpan item favorit Anda di sini agar tidak ketinggalan.</p>
    <a href="{{ route('catalog.index') }}" class="btn btn-primary mt-3">Mulai Berbelanja</a>
</div>
@endif

@endsection

{{-- ======================================================= --}}
{{-- STYLING DAN RESPONSIVE CSS UNTUK WISHLIST --}}
{{-- ======================================================= --}}
@push('styles')
<style>
    .wishlist-header {
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }

    .wishlist-grid {
        display: grid;
        /* Tampilan default untuk desktop: 3 kolom */
        grid-template-columns: repeat(3, 1fr);
        gap: 2rem;
        /* Jarak antar item */
    }

    .wishlist-item-container {
        position: relative;
        display: flex;
        flex-direction: column;
        height: 100%;
        border: 1px solid transparent;
        /* Border transparan untuk stabilitas layout */
        border-radius: 4px;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .wishlist-item-container:hover {
        border-color: #e0e0e0;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    /* Mengambil alih style product card agar fit 100% */
    .wishlist-item-container .product-card {
        flex-grow: 1;
        box-shadow: none;
        /* Hilangkan shadow bawaan jika ada */
    }

    .wishlist-item-container .product-card:hover {
        transform: none;
        /* Hilangkan efek hover bawaan */
    }

    .remove-wishlist-form {
        padding: 0.75rem 1rem 1rem 1rem;
        background-color: #fff;
        border-top: 1px solid #f0f0f0;
    }

    .btn-remove-wishlist {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        width: 100%;
        padding: 0.6rem;
        font-size: 0.85rem;
        font-weight: 600;
        text-align: center;
        text-transform: uppercase;
        color: #dc3545;
        /* Merah */
        background-color: transparent;
        border: 1px solid #f8d7da;
        /* Border merah muda */
        border-radius: 4px;
        cursor: pointer;
        transition: all 0.2s ease-in-out;
    }

    .btn-remove-wishlist:hover {
        background-color: #dc3545;
        color: #fff;
        border-color: #dc3545;
    }

    /* Styling untuk container saat wishlist kosong */
    .empty-wishlist-container {
        border: 2px dashed #e0e0e0;
        border-radius: 8px;
        padding: 4rem 2rem;
        text-align: center;
        margin-top: 2rem;
        background-color: #f8f9fa;
    }

    .empty-wishlist-container .icon-wrapper {
        font-size: 3.5rem;
        color: #ccc;
        margin-bottom: 1.5rem;
    }

    .empty-wishlist-container h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-wishlist-container p {
        color: #6c757d;
        margin-bottom: 1.5rem;
    }

    /* === RESPONSIVE BREAKPOINTS === */

    /* Tablet (lebar max 992px) */
    @media (max-width: 992px) {
        .wishlist-grid {
            /* Tampilan menjadi 2 kolom */
            grid-template-columns: repeat(2, 1fr);
            gap: 1.5rem;
        }
    }

    /* Mobile (lebar max 768px) */
    @media (max-width: 768px) {
        .wishlist-grid {
            /* Tampilan menjadi 2 kolom dengan gap lebih kecil */
            gap: 1rem;
        }

        .wishlist-header {
            text-align: center;
        }
    }

    /* Small Mobile (lebar max 480px) */
    @media (max-width: 480px) {
        .wishlist-grid {
            /* Tampilan menjadi 1 kolom */
            grid-template-columns: 1fr;
        }

        .empty-wishlist-container {
            padding: 3rem 1.5rem;
        }

        .empty-wishlist-container h3 {
            font-size: 1.3rem;
        }
    }
</style>
@endpush