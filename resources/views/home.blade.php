@extends('layouts.app')

@section('title', 'eyetails.co - Official Website')

@section('content')

{{-- HERO CAROUSEL --}}
<section class="hero-carousel">
    <div class="swiper mySwiper">
        <div class="swiper-wrapper">
            <div class="swiper-slide slide slide-1">
                <img src="{{ asset('storage/banners/car.jpg') }}"
                    alt="New Collection" class="slide-image">
                <div class="slide-content">
                    <span class="subtitle">OFFICIAL COLLABORATION</span>
                    <h1>EYETAILS X PORSCHE</h1>
                    <p>Sebuah kolaborasi ikonik antara performa legendaris dan desain urban futuristik. Dibuat untuk mereka yang hidup cepat,
                    berpikir tajam, dan tampil berkelas.</p>
                    <a href="{{ route('catalog.index') }}" class="btn btn-primary">Lihat Koleksi</a>
                </div>
            </div>
            <div class="swiper-slide slide slide-2">
                <img src="{{ asset('storage/banners/ousel.jpg') }}"
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
                {{-- ====================================================== --}}
                {{-- PERUBAHAN UTAMA ADA DI BLOK @if INI --}}
                {{-- ====================================================== --}}
                @if($category->image_path)
                <img src="{{ asset('storage/' . $category->image_path) }}" alt="{{ $category->name }}">
                @else
                <img src="https://via.placeholder.com/400x533/222/fff?text={{ urlencode($category->name) }}"
                    alt="{{ $category->name }}">
                @endif
                {{-- ====================================================== --}}
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