@extends('layouts.app')

@section('title', $product->name . ' | eyetails.co')

@section('content')

<section class="product-detail-page container">
    {{-- Breadcrumb --}}
    <div class="breadcrumb">
        <a href="{{ route('catalog.index') }}">Katalog</a>
        <i class="fas fa-chevron-right"></i>
        <a href="{{ route('catalog.index', ['category' => $product->category->slug]) }}">{{ $product->category->name ??
            'Uncategorized' }}</a>
        <i class="fas fa-chevron-right"></i>
        <span>{{ $product->name }}</span>
    </div>

    {{-- Layout Produk dengan Alpine.js --}}
    <div class="product-layout" x-data="{
        variants: {{ json_encode($product->variants) }},
        selectedSize: null,
        selectedVariant: null,
        quantity: 1,
        updateVariant() {
            this.selectedVariant = this.variants.find(v => v.size === this.selectedSize);
            this.quantity = 1; // Reset kuantitas setiap ganti ukuran
        },
        get stockStatus() {
            if (!this.selectedVariant) return 'Pilih ukuran';
            if (this.selectedVariant.quantity > 0) return `Tersedia (${this.selectedVariant.quantity})`;
            return 'Habis';
        },
        get isOutOfStock() {
            return !this.selectedVariant || this.selectedVariant.quantity <= 0;
        },
        get maxQuantity() {
            return this.selectedVariant ? this.selectedVariant.quantity : 1;
        }
    }">
        {{-- Galeri Produk --}}
        <div class="product-gallery">
            <div style="--swiper-navigation-color: #fff; --swiper-pagination-color: var(--primary-accent)"
                class="swiper main-image-swiper">
                <div class="swiper-wrapper">
                    @forelse($product->images as $image)
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/' . $image->path) }}"
                            alt="{{ $product->name }} image {{ $loop->iteration }}">
                    </div>
                    @empty
                    <div class="swiper-slide">
                        <img src="https://via.placeholder.com/600x600/F0F0F0?text=No+Image" alt="No image available">
                    </div>
                    @endforelse
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        
            <div thumbsSlider="" class="swiper thumbnail-swiper">
                <div class="swiper-wrapper">
                    @foreach($product->images as $image)
                    <div class="swiper-slide">
                        <img src="{{ asset('storage/' . $image->path) }}"
                            alt="{{ $product->name }} thumbnail {{ $loop->iteration }}">
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Info Produk --}}
        <div class="product-info-area">
            <h1 class="product-title">{{ $product->name }}</h1>
            <div class="price-and-status">
                @if($product->sale_price && $product->sale_price < $product->price)
                    <div class="product-price-detail-promo">
                        <span class="promo-price">Rp {{ number_format($product->sale_price, 0, ',', '.') }}</span>
                        <span class="original-price-detail">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                    @else
                    <p class="product-price-detail">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    @endif
                    <p class="product-stock-status"
                        :class="{ 'in-stock': selectedVariant && selectedVariant.quantity > 0, 'out-of-stock': !selectedVariant || selectedVariant.quantity <= 0 }"
                        x-text="stockStatus">
                    </p>
            </div>
            <div class="product-description">
                <p>{!! nl2br(e($product->description)) !!}</p>
            </div>
            <form action="{{ route('cart.add', $product->slug) }}" method="POST" class="add-to-cart-form">
                @csrf
                <div class="product-variants">
                    <label class="variant-label">Pilih Ukuran:</label>
                    <div class="size-options">
                        @forelse ($product->variants as $variant)
                        <div class="size-option">
                            <input type="radio" name="size" id="size_{{ $variant->size }}" value="{{ $variant->size }}"
                                x-model="selectedSize" @change="updateVariant()"
                                :disabled="{{ $variant->quantity <= 0 }}">
                            <label for="size_{{ $variant->size }}"
                                class="{{ $variant->quantity <= 0 ? 'disabled' : '' }}">{{ $variant->size }}</label>
                        </div>
                        @empty
                        <p>Ukuran untuk produk ini belum tersedia.</p>
                        @endforelse
                    </div>
                </div>
                <div class="product-actions">
                    <div class="quantity-selector">
                        <label for="quantity">Jumlah:</label>
                        <input type="number" id="quantity" name="quantity" x-model="quantity" min="1" :max="maxQuantity"
                            :disabled="isOutOfStock" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-large" :disabled="isOutOfStock">
                        <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                    </button>
                </div>
            </form>
            <div class="secondary-actions">
                <form method="POST" action="{{ route('wishlist.toggle') }}">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product->id }}">
                    <button type="submit" class="btn btn-outline btn-wishlist">
                        <i class="far fa-heart"></i>
                        @auth
                        {{ Auth::user()->wishlist()->where('product_id', $product->id)->exists() ? 'Hapus dari' :
                        'Tambah ke' }} Wishlist
                        @else
                        Tambah ke Wishlist
                        @endauth
                    </button>
                </form>
                @auth
                <button type="button" class="btn btn-outline btn-chat" id="ask-admin-btn">
                    <i class="far fa-comment-dots"></i> Tanya Admin
                </button>
                @endauth
            </div>
        </div>
    </div>
</section>

{{-- Bagian Ulasan Pelanggan yang Diperbarui --}}
<section class="reviews-section container">
    <h2 class="section-title">Ulasan Pelanggan ({{ $product->reviews->count() }})</h2>
    @if($product->reviews->count())
    <div class="reviews-list">
        @foreach($product->reviews as $review)
        @php
        // Logika untuk menemukan item yang diulas dari pesanan terkait
        $reviewedItem = null;
        if ($review->order) {
        // Cari item di dalam pesanan yang cocok dengan produk yang sedang dilihat
        $reviewedItem = $review->order->items->firstWhere('product_id', $product->id);
        }
        @endphp
        <div class="review-card">
            <div class="review-header">
                <div class="review-author-info">
                    <span class="user-name">{{ $review->user->name }}</span>
                    <span class="review-date">{{ $review->created_at->format('d F Y') }}</span>
                </div>
                <div class="review-stars">
                    @for ($i = 0; $i < 5; $i++) <i class="{{ $i < $review->rating ? 'fas' : 'far' }} fa-star"></i>
                        @endfor
                </div>
            </div>

            {{-- Info Produk & Ukuran yang Dibeli --}}
            @if($reviewedItem)
            <div class="reviewed-product-info">
                <i class="fas fa-check-circle"></i> Pembelian Terverifikasi:
                <strong>{{ $reviewedItem->product_name }}
                    @if($reviewedItem->size)
                    (Ukuran: {{ $reviewedItem->size }})
                    @endif
                </strong>
            </div>
            @endif

            <p class="review-content">{{ $review->content }}</p>
        </div>
        @endforeach
    </div>
    @else
    <div class="no-reviews">
        <p>Belum ada ulasan untuk produk ini. Jadilah yang pertama!</p>
    </div>
    @endif
</section>

{{-- Modal Chat --}}
@auth
<div class="chat-modal-overlay" id="chat-modal-overlay"></div>
<div class="chat-modal" id="chat-modal">
    <div class="modal-header">
        <h3>Tanya Tentang Produk</h3>
        <button class="close-modal-btn" id="close-modal-btn">&times;</button>
    </div>
    <div class="modal-body">
        <div class="modal-product-info">
            <img src="{{ $product->primary_image ? asset('storage/' . $product->primary_image) : 'https://via.placeholder.com/80x100' }}"
                alt="{{ $product->name }}">
            <div>
                <p><strong>{{ $product->name }}</strong></p>
                <span>Sampaikan pertanyaan Anda di bawah ini.</span>
            </div>
        </div>
        <form action="{{ route('chat.start') }}" method="POST">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <div class="form-group">
                <textarea name="message" rows="5" placeholder="Contoh: Halo, apakah produk ini ada ukuran XXL?" required
                    minlength="10"></textarea>
            </div>
            <button type="submit" class="btn btn-primary w-full">Kirim Pesan</button>
        </form>
    </div>
</div>
@endauth

@endsection

@push('styles')
<style>
    /* Halaman Detail Produk */
    .product-detail-page {
        padding: 2rem 0 4rem 0;
    }

    product-detail-container {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 3rem;
    max-width: 1200px;
    margin: 3rem auto;
    padding: 0 1.5rem;
    }
    
    /* Styling untuk galeri gambar */
    .product-gallery {
    width: 100%;
    max-width: 550px; /* Batas lebar maks galeri */
    }
    
    .main-image-swiper {
    width: 100%;
    border-radius: 12px;
    border: 1px solid #e5e7eb;
    }
    .main-image-swiper .swiper-slide {
    aspect-ratio: 1 / 1; /* Membuat gambar utama selalu kotak */
    }
    .main-image-swiper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    }
    
    /* Styling untuk thumbnail navigasi */
    .thumbnail-swiper {
    margin-top: 1rem;
    padding: 5px; /* Sedikit padding agar border tidak terpotong */
    }
    .thumbnail-swiper .swiper-slide {
    width: 25%;
    height: 100px;
    opacity: 0.6;
    cursor: pointer;
    transition: opacity 0.3s ease;
    border-radius: 8px;
    overflow: hidden;
    }
    .thumbnail-swiper .swiper-slide:hover {
    opacity: 1;
    }
    .thumbnail-swiper .swiper-slide-thumb-active {
    opacity: 1;
    border: 2px solid var(--primary-accent, #4f46e5);
    }
    .thumbnail-swiper img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    }
    
    /* Styling untuk info produk */
    .product-info-details h1 {
    font-size: 2rem;
    font-weight: 700;
    margin-top: 0;
    margin-bottom: 0.5rem;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 2rem;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .breadcrumb a {
        color: #6c757d;
        text-decoration: none;
    }

    .breadcrumb a:hover {
        color: #1a1a1a;
    }

    /* Ukuran gambar lebih kecil */
    .product-layout {
        display: grid;
        grid-template-columns: 2fr 3fr;
        /* Gambar lebih kecil (40%), Info lebih besar (60%) */
        gap: 3rem;
        align-items: start;
    }

    .main-product-image {
        width: 100%;
        border-radius: 8px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
    }

    .product-info-area {
        padding-top: 7px;
    }

    .product-title {
        font-size: 2.2rem;
        font-weight: 700;
        margin: 0 0 1rem 0;
        text-transform: uppercase;
    }

    .price-and-status {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 1rem;
        border-bottom: 1px solid #eee;
        padding-bottom: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .product-price-detail {
        font-size: 1.8rem;
        font-weight: 600;
        margin: 0;
    }

    .product-price-detail-promo {
        display: flex;
        align-items: baseline;
        gap: 1rem;
    }

    .promo-price {
        font-size: 1.8rem;
        font-weight: 700;
        color: #d9534f;
    }

    .original-price-detail {
        text-decoration: line-through;
        color: #999;
        font-size: 1.2rem;
    }

    .product-stock-status {
        font-weight: 600;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        font-size: 0.85rem;
    }

    .in-stock {
        background-color: #d4edda;
        color: #155724;
    }

    .out-of-stock {
        background-color: #f8d7da;
        color: #721c24;
    }

    .product-description {
        line-height: 1.7;
        color: #333;
        margin-bottom: 2rem;
    }

    /* Varian Ukuran */
    .product-variants {
        margin-bottom: 1.5rem;
    }

    .variant-label {
        font-weight: 600;
        margin-bottom: 0.75rem;
        display: block;
    }

    .size-options {
        display: flex;
        flex-wrap: wrap;
        gap: 0.75rem;
    }

    .size-option input[type="radio"] {
        display: none;
    }

    .size-option label {
        display: inline-block;
        padding: 0.75rem 1.25rem;
        border: 2px solid #e0e0e0;
        border-radius: 4px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.2s ease;
    }

    .size-option label.disabled {
        color: #ccc;
        background-color: #f8f9fa;
        cursor: not-allowed;
        text-decoration: line-through;
    }

    .size-option input[type="radio"]:checked+label {
        border-color: var(--primary-accent, #4f46e5);
        background-color: #f4f3ff;
        color: var(--primary-accent, #4f46e5);
    }

    .size-option input[type="radio"]:not(:disabled)+label:hover {
        border-color: #a0a0a0;
    }

    .add-to-cart-form {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .product-actions {
        display: grid;
        grid-template-columns: auto 1fr;
        gap: 1rem;
    }

    .quantity-selector {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .quantity-selector input {
        width: 60px;
        text-align: center;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .btn-large {
        flex-grow: 1;
        padding: 0.8rem;
    }

    .btn-large:disabled {
        background-color: #ccc;
        border-color: #ccc;
        cursor: not-allowed;
    }

    .secondary-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        margin-top: 1rem;
    }

    /* CSS BARU & MODIFIKASI UNTUK ULASAN */
    .reviews-section {
        border-top: 1px solid #eee;
        padding-top: 3rem;
        margin-top: 3rem;
    }

    .section-title {
        font-size: 1.8rem;
        margin-bottom: 2rem;
        text-align: center;
    }

    .reviews-list {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        max-width: 800px;
        margin: 0 auto;
    }

    .review-card {
        background-color: #fff;
        border: 1px solid #eee;
        border-radius: 8px;
        padding: 1.5rem;
    }

    .review-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1rem;
    }

    .review-author-info {
        display: flex;
        flex-direction: column;
    }

    .user-name {
        font-weight: 600;
        font-size: 1.1rem;
    }

    .review-date {
        font-size: 0.85rem;
        color: #6c757d;
    }

    .review-stars {
        color: #f5c518;
        font-size: 1.1rem;
        flex-shrink: 0;
    }

    .reviewed-product-info {
        font-size: 0.9rem;
        color: #155724;
        background-color: #d4edda;
        border: 1px solid #c3e6cb;
        border-radius: 4px;
        padding: 0.5rem 1rem;
        margin-bottom: 1rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .review-content {
        margin: 0;
        color: #333;
        line-height: 1.6;
    }

    .no-reviews {
        text-align: center;
        padding: 2rem;
    }

    /* Modal Styling */
    .chat-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1001;
        display: none;
    }

    .chat-modal {
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: white;
        border-radius: 8px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
        z-index: 1002;
        width: 90%;
        max-width: 500px;
        display: none;
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #eee;
    }

    .modal-header h3 {
        margin: 0;
    }

    .close-modal-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
    }

    .modal-body {
        padding: 1.5rem;
    }

    .modal-product-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-bottom: 1rem;
    }

    .modal-product-info img {
        width: 60px;
        border-radius: 4px;
    }

    .modal-product-info p {
        margin: 0;
    }

    .modal-product-info span {
        font-size: 0.9rem;
        color: #666;
    }

    .form-group textarea {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        resize: vertical;
        box-sizing: border-box;
    }

    .w-full {
        width: 100%;
    }

    /* Responsive */
    @media(max-width: 992px) {
        .product-layout {
            grid-template-columns: 1fr;
        }
    }

    @media(max-width: 576px) {
        .product-actions {
            grid-template-columns: 1fr;
        }

        .secondary-actions {
            grid-template-columns: 1fr;
        }

        .review-header {
            flex-direction: column;
            align-items: flex-start;
            gap: 0.5rem;
        }
    }
</style>
@endpush

@push('scripts')
{{-- Script untuk modal (tidak berubah) --}}
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Inisialisasi slider thumbnail
        var thumbsSwiper = new Swiper(".thumbnail-swiper", {
            spaceBetween: 10,
            slidesPerView: 4, // Tampilkan 4 thumbnail sekaligus
            freeMode: true,
            watchSlidesProgress: true,
        });

        // Inisialisasi slider utama dan hubungkan dengan thumbnail
        var mainSwiper = new Swiper(".main-image-swiper", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: thumbsSwiper,
            },
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        @auth
        const askAdminBtn = document.getElementById('ask-admin-btn');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const modalOverlay = document.getElementById('chat-modal-overlay');
        const modal = document.getElementById('chat-modal');

        if(askAdminBtn) {
            askAdminBtn.addEventListener('click', () => {
                if(modalOverlay) modalOverlay.style.display = 'block';
                if(modal) modal.style.display = 'block';
            });
        }
        
        const closeModal = () => {
            if(modalOverlay) modalOverlay.style.display = 'none';
            if(modal) modal.style.display = 'none';
        }

        if(closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
        if(modalOverlay) modalOverlay.addEventListener('click', closeModal);
        @endauth
    });
</script>
@endpush