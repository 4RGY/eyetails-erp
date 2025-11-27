{{-- resources/views/reviews/create.blade.php --}}

@extends('layouts.app')

@section('title', 'Tulis Ulasan | eyetails.co')

{{--
======================================================================
TAMBAHAN CSS KUSTOM (INTERAKTIF, ASIK, RESPONSIF)
UNTUK KODE ASLI LU
======================================================================
--}}
@push('styles')
<style>
    /* Latar belakang halaman */
    .review-form-page-bg {
        padding-top: 2rem;
        padding-bottom: 3rem;
        background-color: #f8f9fa;
        /* Latar belakang abu-abu muda */
        min-height: 80vh;
    }

    @media (min-width: 768px) {
        .review-form-page-bg {
            padding-top: 3rem;
        }
    }

    /* Kartu Form (dari class .review-form-card Anda) */
    .review-form-card {
        max-width: 700px;
        /* Biar gak terlalu lebar di desktop */
        margin: 0 auto;
        background-color: #ffffff;
        border-radius: 8px;
        border: 1px solid #ddd;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        overflow: hidden;
    }

    /* Header Info Produk (dari class .product-info-header Anda) */
    .product-info-header {
        display: flex;
        align-items: center;
        gap: 1.5rem;
        padding: 1.5rem 2rem;
        border-bottom: 1px solid #e5e7eb;
    }

    .product-info-header img {
        width: 80px;
        /* Bikin gambar lebih gede dikit */
        height: auto;
        border-radius: 4px;
        border: 1px solid #eee;
    }

    .product-info-header h2 {
        font-size: 1.25rem;
        font-weight: 600;
        color: #333;
    }

    /* class .text-gray-600 Anda */
    .text-gray-600 {
        font-size: 0.9rem;
        color: #666;
        margin-bottom: 0.25rem;
    }

    /* Form (dari class .auth-form Anda) */
    .auth-form {
        padding: 2rem;
    }

    /* Grup Form (dari class .form-group Anda) */
    .form-group {
        margin-bottom: 1.75rem;
    }

    .form-group label {
        display: block;
        font-size: 1rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 0.75rem;
    }

    /* Textarea (dari class .form-input Anda) */
    .form-input {
        display: block;
        width: 100%;
        min-height: 120px;
        resize: vertical;
        padding: 0.85rem 1rem;
        font-size: 1rem;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 4px;
        transition: border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out;
    }

    .form-input:focus {
        border-color: #0056b3;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgba(0, 86, 179, 0.25);
    }

    /* Error (dari class .error-message Anda) */
    .error-message {
        color: #dc3545;
        font-size: 0.875em;
        margin-top: 0.25rem;
        display: block;
    }

    /* =================================================
       CSS INTERAKTIF ASYIK UNTUK STAR RATING
       (dari class .star-rating Anda)
       ================================================= */
    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        /* Dibalik agar :hover ~ berfungsi */
        justify-content: flex-end;
        /* Biar nempel kanan */
        gap: 0.25rem;
    }

    .star-rating input[type="radio"] {
        display: none;
        /* Sembunyikan radio button */
    }

    .star-rating label {
        font-size: 2.25rem;
        /* Ukuran bintang */
        color: #d1d5db;
        /* Bintang mati (abu-abu) */
        cursor: pointer;
        transition: color 0.2s ease, transform 0.1s ease;
    }

    .star-rating label:hover {
        transform: scale(1.1);
        /* Bintang jadi gede dikit pas di-hover */
    }

    /* Logika :hover dan :checked (ini bagian interaktifnya) */
    .star-rating:not(:hover) input[type="radio"]:checked~label,
    .star-rating:hover label:hover,
    .star-rating:hover label:hover~label {
        color: #f59e0b;
        /* Bintang nyala (kuning) */
    }

    /* =================================================
       CSS TOMBOL SUBMIT (dari class .btn Anda)
       ================================================= */
    .btn.btn-primary.w-full {
        display: block;
        width: 100%;
        font-weight: 600;
        color: #fff;
        text-align: center;
        cursor: pointer;
        background-color: #0056b3;
        border: 1px solid #0056b3;
        padding: 0.85rem 1.5rem;
        font-size: 1.1rem;
        letter-spacing: 0.5px;
        border-radius: 4px;
        transition: background-color 0.2s ease, border-color 0.2s ease, transform 0.1s ease;
        text-decoration: none;
    }

    .btn.btn-primary.w-full:hover {
        background-color: #004494;
        /* Warna lebih gelap pas hover */
        border-color: #004494;
        transform: translateY(-1px);
        /* Tombol naik dikit */
        color: #fff;
    }
</style>
@endpush


{{--
======================================================================
KONTEN HTML (KODE ANDA + 1 BUG FIX)
======================================================================
--}}
@section('content')

{{-- (REVISI) Tambahin wrapper <section> biar ada background abu-abu --}}
    <section class="container review-form-page-bg">
        <div class="review-form-card">

            <div class="product-info-header">
                @if($item->product && $item->product->primary_image)
                <img src="{{ asset('storage/' . $item->product->primary_image) }}" alt="{{ $item->product_name }}"
                    class="product-image">
                @else
                <img src="https://via.placeholder.com/80x100/F0F0F0?text=Produk" alt="{{ $item->product_name }}" class="product-image">
                @endif
                <div>
                    <p class="text-gray-600">Anda sedang mengulas:</p>
                    {{-- (ASLI) Gw gak ubah ini biar gak error PHP lagi --}}
                    <h2>{{ $item->product_name }}</h2>
                </div>
            </div>

            {{-- (ASLI) form lu, gw gak tambahin enctype --}}
            <form action="{{ route('reviews.store') }}" method="POST" class="auth-form">
                @csrf
                <input type="hidden" name="order_item_id" value="{{ $item->id }}">

                {{-- (REVISI & FIX) Controller butuh product_id, tambahkan ini --}}
                <input type="hidden" name="product_id" value="{{ $item->product_id }}">

                <div class="form-group">
                    <label for="rating">Rating Anda</label>
                    <div class="star-rating">
                        {{-- (ASLI) Kode bintang lu --}}
                        <input type="radio" id="star5" name="rating" value="5" required /><label for="star5"
                            title="5 stars">★</label>
                        <input type="radio" id="star4" name="rating" value="4" /><label for="star4"
                            title="4 stars">★</label>
                        <input type="radio" id="star3" name="rating" value="3" /><label for="star3"
                            title="3 stars">★</label>
                        <input type="radio" id="star2" name="rating" value="2" /><label for="star2"
                            title="2 stars">★</label>
                        <input type="radio" id="star1" name="rating" value="1" /><label for="star1"
                            title="1 star">★</label>
                    </div>
                    @error('rating') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <div class="form-group mt-4">
                    <label for="content">Ulasan Anda</label> {{-- (FIX) ganti for="content" -> "content" --}}

                    {{-- (FIX) ganti id="content" -> "content" dan name="content" -> "content" --}}
                    <textarea id="content" name="content" rows="5" class="form-input"
                        placeholder="Bagaimana pendapat Anda tentang produk ini?"
                        required>{{ old('content') }}</textarea>

                    {{-- (FIX) ganti error "content" -> "content" --}}
                    @error('content') <span class="error-message">{{ $message }}</span> @enderror
                </div>

                <button type="submit" class="btn btn-primary w-full mt-4">KIRIM ULASAN</button>
            </form>
        </div>
    </section>

    @endsection

    {{-- (REVISI) Gak perlu @push('scripts') lagi karena gak ada upload foto --}}