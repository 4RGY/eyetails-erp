@extends('layouts.app')

@section('title', 'eyetails.co - Official Website')

@section('content')

{{-- HERO CAROUSEL --}}
<section class="hero-carousel">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide slide slide-1">
                <img src="https://shiningbright.co.id/cdn/shop/files/BANNER-WEB-SHINING-BRIGHT-X-SUPERMAN-3_1920x864.jpg?v=1719204128"
                    alt="New Collection" class="slide-image">
                <div class="slide-content">
                    <span class="subtitle">Official Collaboration</span>
                    <h1>SHINING BRIGHT X SUPERMAN</h1>
                    <p>Koleksi eksklusif yang menggabungkan ikon pop kultur dengan gaya urban khas kami.</p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-primary">Lihat Koleksi</a>
                </div>
            </div>
            <div class="swiper-slide slide slide-2">
                <img src="https://shiningbright.co.id/cdn/shop/files/BANNER-WEB-SHINING-BRIGHT-2_1920x864.jpg?v=1718855655"
                    alt="Core Collection" class="slide-image">
                <div class="slide-content">
                    <span class="subtitle">Core Collection 2025</span>
                    <h2>REDEFINED & REBORN</h2>
                    <p>Temukan kembali esensi gaya Anda dengan koleksi inti terbaru dari kami.</p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-secondary">Jelajahi Sekarang</a>
                </div>
            </div>
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>

{{-- NEW ARRIVALS SECTION --}}
<section class="product-showcase-section container">
    <div class="section-header">
        <h2>New Arrivals</h2>
        <p>Baru saja mendarat. Jadilah yang pertama memiliki koleksi terbaru kami.</p>
    </div>
    <div class="horizontal-scroll-wrapper">
        <div class="product-grid-horizontal">
            @foreach ($newArrivals as $product)
            <x-product-card :product="$product" />
            @endforeach
        </div>
    </div>
</section>

{{-- SHOP BY CATEGORY --}}
<section class="category-section">
    <div class="container">
        <div class="section-header">
            <h2>Shop by Category</h2>
            <p>Apapun gayamu, temukan item yang sempurna di sini.</p>
        </div>
        <div class="category-grid">
            @foreach ($categories as $category)
            <a href="{{ route('catalog.index', ['category' => $category->slug]) }}" class="category-card">
                <img src="https://via.placeholder.com/400x533/222/fff?text={{ urlencode($category->name) }}"
                    alt="{{ $category->name }}">
                <div class="category-card-overlay">
                    <h3 class="category-card-title">{{ $category->name }}</h3>
                </div>
            </a>
            @endforeach
        </div>
    </div>
</section>

{{-- MOST WANTED SECTION --}}
<section class="product-showcase-section container">
    <div class="section-header">
        <h2>Most Wanted</h2>
        <p>Item yang paling banyak dicari. Dapatkan sebelum kehabisan.</p>
    </div>
    <div class="most-wanted-grid">
        @foreach ($mostWanted as $product)
        <x-product-card :product="$product" />
        @endforeach
    </div>
</section>

{{-- BRAND VALUE --}}
<section class="brand-value">
    <div class="container value-grid">
        <div class="value-item">
            <i class="fas fa-shipping-fast"></i>
            <h3>PENGIRIMAN CEPAT</h3>
            <p>Untuk semua pesanan di seluruh Indonesia.</p>
        </div>
        <div class="value-item">
            <i class="fas fa-award"></i>
            <h3>KUALITAS PREMIUM</h3>
            <p>Jaminan bahan terbaik dan tahan lama.</p>
        </div>
        <div class="value-item">
            <i class="fas fa-retweet"></i>
            <h3>GARANSI TUKAR</h3>
            <p>Pengembalian atau penukaran mudah 7 hari.</p>
        </div>
    </div>
</section>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            autoplay: {
                delay: 4000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            grabCursor: true,
            speed: 800,
            effect: "slide",
            fadeEffect: {
                crossFade: true
            },
        });
    });
</script>
@endpush