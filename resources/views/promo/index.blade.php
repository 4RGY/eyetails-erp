@extends('layouts.app')

@section('title', 'Promo Spesial | eyetails.co')

@section('content')

{{-- 1. HEADER YANG STYLISH --}}
<section class="promo-header">
    <div class="container text-center">
        <i class="fas fa-tags header-icon"></i>
        <h1>PROMO SPESIAL</h1>
        <p>Dapatkan penawaran terbaik untuk koleksi pilihan kami. Stok terbatas, jangan sampai kehabisan!</p>
    </div>
</section>

<section class="catalog-page container">
    <main class="product-listing" style="width: 100%;">
        <header class="listing-header">
            <h3>{{ $products->total() }} Produk Ditemukan</h3>
        </header>

        @if ($products->count())
        {{-- 2. GRID PRODUK DENGAN EFEK INTERAKTIF --}}
        <div class="product-grid promo-grid">
            @foreach ($products as $product)
            <x-product-card :product="$product" />
            @endforeach
        </div>

        <div class="pagination-area">
            {{ $products->links() }}
        </div>
        @else
        {{-- 3. TAMPILAN SAAT PROMO KOSONG --}}
        <div class="no-results-container">
            <div class="no-results-icon">
                <i class="far fa-sad-tear"></i>
            </div>
            <h3>Belum Ada Promo</h3>
            <p>Maaf, saat ini belum ada produk promo yang tersedia. Silakan cek kembali nanti!</p>
            <a href="{{ route('catalog.index') }}" class="btn btn-primary">Lihat Semua Produk</a>
        </div>
        @endif
    </main>
</section>

@endsection

{{-- ======================================================= --}}
{{-- CSS LENGKAP UNTUK TAMPILAN INTERAKTIF & MENARIK --}}
{{-- ======================================================= --}}
@push('styles')
<style>
    /* Header Baru */
    .promo-header {
        background: linear-gradient(45deg, #111827, #374151);
        color: #fff;
        padding: 4rem 0;
        margin-bottom: 3rem;
        /* Menambahkan margin bawah setelah header */
    }

    .promo-header .header-icon {
        font-size: 3rem;
        margin-bottom: 1rem;
        color: var(--primary-accent, #4f46e5);
    }

    .promo-header h1 {
        font-size: 2.8rem;
        letter-spacing: 2px;
        margin-bottom: 0.5rem;
    }

    .promo-header p {
        font-size: 1.1rem;
        color: #d1d5db;
        max-width: 600px;
        margin: 0 auto;
    }

    /* Grid Produk Interaktif */
    .promo-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        /* 4 kolom di desktop */
        gap: 1.5rem;
    }

    .promo-grid .product-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    /* Efek hover yang lebih jelas */
    .promo-grid .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    /* Penyesuaian header listing */
    .listing-header {
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .pagination-area {
        margin-top: 3rem;
    }

    /* Styling saat promo kosong */
    .no-results-container {
        border: 2px dashed #e0e0e0;
        border-radius: 8px;
        padding: 4rem 2rem;
        text-align: center;
        margin-top: 2rem;
        background-color: #f8f9fa;
    }

    .no-results-icon {
        font-size: 3.5rem;
        color: #ccc;
        margin-bottom: 1.5rem;
    }

    .no-results-container h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .no-results-container p {
        color: #6c757d;
        margin-bottom: 1.5rem;
    }

    /* === RESPONSIVE BREAKPOINTS === */
    @media (max-width: 1200px) {
        .promo-grid {
            grid-template-columns: repeat(3, 1fr);
            /* 3 kolom di desktop kecil */
        }
    }

    @media (max-width: 992px) {
        .promo-grid {
            grid-template-columns: repeat(2, 1fr);
            /* 2 kolom di tablet */
        }
    }

    @media (max-width: 768px) {
        .promo-header h1 {
            font-size: 2.2rem;
        }
    }

    @media (max-width: 576px) {
        .promo-grid {
            grid-template-columns: 1fr;
            /* 1 kolom di mobile */
        }
    }
</style>
@endpush