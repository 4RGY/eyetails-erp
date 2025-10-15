@extends('layouts.app')

@section('title', 'Keranjang Belanja | eyetails.co')

@section('content')

<section class="page-header container text-center">
    <h1>KERANJANG BELANJA</h1>
</section>

<section class="cart-content container">
    @if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($cart && count($cart) > 0)
    <div class="cart-layout">
        {{-- Kolom Kiri: Daftar Item --}}
        <main class="cart-items-list">
            @foreach($cart as $id => $item)
            <div class="cart-item">
                <div class="item-image">
                    @if($item['image'])
                    <img src="{{ asset('storage/' . $item['image']) }}" alt="{{ $item['name'] }}">
                    @else
                    <img src="https://via.placeholder.com/100x120/F0F0F0?text=Produk" alt="{{ $item['name'] }}">
                    @endif
                </div>
                <div class="item-details">
                    <h3>{{ $item['name'] }}</h3>

                    {{-- =============================================== --}}
                    {{-- PERUBAHAN 1: MENAMPILKAN UKURAN DI KERANJANG --}}
                    {{-- =============================================== --}}
                    @if(isset($item['size']))
                    <p class="item-variant">Ukuran: <strong>{{ $item['size'] }}</strong></p>
                    @endif
                    {{-- =============================================== --}}

                    <p class="item-price">Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                    <a href="{{ route('cart.remove', $id) }}" class="remove-link"
                        onclick="return confirm('Yakin ingin menghapus produk ini?')">
                        <i class="fas fa-trash-alt"></i> Hapus
                    </a>
                </div>
                <div class="item-actions">
                    <form action="{{ route('cart.update') }}" method="POST" class="quantity-form">
                        @csrf
                        <input type="hidden" name="id" value="{{ $id }}">
                        <button type="button" class="quantity-btn minus">-</button>
                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1"
                            class="quantity-input" readonly>
                        <button type="button" class="quantity-btn plus">+</button>
                    </form>
                </div>
                <div class="item-subtotal">
                    Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}
                </div>
            </div>
            @endforeach
        </main>

        {{-- Kolom Kanan: Ringkasan Pesanan --}}
        <aside class="cart-summary">
            <div class="summary-content">
                <h2>Ringkasan Pesanan</h2>
                <div class="summary-line">
                    <span>Subtotal ({{ count($cart) }} item)</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>
                <div class="summary-line total-price">
                    <span>Total</span>
                    <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
                </div>

                <a href="/checkout" class="btn btn-primary btn-large w-full">LANJUT KE CHECKOUT</a>
                <a href="{{ route('catalog.index') }}" class="btn btn-outline w-full mt-3">Lanjut Belanja</a>
            </div>
        </aside>
    </div>
    @else
    {{-- Tampilan Keranjang Kosong --}}
    <div class="empty-cart-container">
        <div class="icon-wrapper">
            <i class="fas fa-shopping-cart"></i>
        </div>
        <h3>Keranjang Anda Kosong</h3>
        <p>Sepertinya Anda belum menambahkan produk apapun ke keranjang.</p>
        <a href="{{ route('catalog.index') }}" class="btn btn-primary">Mulai Berbelanja</a>
    </div>
    @endif
</section>

@endsection

@push('styles')
{{-- Tambahkan style untuk detail varian --}}
<style>
    .item-variant {
        font-size: 0.9rem;
        color: #6c757d;
        margin: 0.25rem 0;
    }
    .cart-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        /* 2/3 untuk item, 1/3 untuk summary */
        gap: 2.5rem;
        align-items: flex-start;
    }

    /* Styling Item di Keranjang */
    .cart-item {
        display: grid;
        grid-template-columns: 100px 1fr auto auto;
        /* Gambar | Detail | Aksi | Subtotal */
        gap: 1.5rem;
        align-items: center;
        background-color: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1.5rem;
        margin-bottom: 1rem;
    }

    .item-image img {
        width: 100%;
        border-radius: 6px;
        object-fit: cover;
    }

    .item-details h3 {
        font-size: 1.1rem;
        font-weight: 600;
        margin: 0 0 0.25rem;
    }

    .item-price {
        color: #6c757d;
        margin: 0;
    }

    .remove-link {
        color: #dc3545;
        font-size: 0.85rem;
        text-decoration: none;
        margin-top: 0.5rem;
        display: inline-block;
    }

    .remove-link:hover {
        text-decoration: underline;
    }

    /* Kontrol Kuantitas Baru */
    .quantity-form {
        display: flex;
        align-items: center;
        border: 1px solid #ccc;
        border-radius: 6px;
    }

    .quantity-btn {
        background: none;
        border: none;
        font-size: 1.2rem;
        cursor: pointer;
        padding: 0.5rem 0.75rem;
        color: #333;
    }

    .quantity-input {
        width: 50px;
        text-align: center;
        border: none;
        font-size: 1rem;
        -moz-appearance: textfield;
        /* Firefox */
    }

    .quantity-input::-webkit-outer-spin-button,
    .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none;
        margin: 0;
        /* Chrome, Safari, Edge, Opera */
    }

    .item-subtotal {
        font-size: 1.1rem;
        font-weight: 700;
        text-align: right;
    }

    /* Ringkasan Pesanan (Summary) */
    .cart-summary {
        position: sticky;
        /* Membuat summary tetap di layar */
        top: 100px;
    }

    .summary-content {
        background-color: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1.5rem;
    }

    .summary-content h2 {
        font-size: 1.5rem;
        margin: 0 0 1.5rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #e0e0e0;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
    }

    .summary-line.total-price {
        font-size: 1.2rem;
        font-weight: 700;
        padding-top: 1rem;
        border-top: 1px solid #e0e0e0;
    }

    .w-full {
        width: 100%;
    }

    .mt-3 {
        margin-top: 0.75rem;
    }

    /* Tampilan Keranjang Kosong */
    .empty-cart-container {
        border: 2px dashed #e0e0e0;
        border-radius: 8px;
        padding: 4rem 2rem;
        text-align: center;
        margin-top: 2rem;
        background-color: #f8f9fa;
    }

    .empty-cart-container .icon-wrapper {
        font-size: 3.5rem;
        color: #ccc;
        margin-bottom: 1.5rem;
    }

    .empty-cart-container h3 {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .empty-cart-container p {
        color: #6c757d;
        margin-bottom: 1.5rem;
    }

    /* === RESPONSIVE BREAKPOINTS === */
    @media (max-width: 992px) {
        .cart-layout {
            grid-template-columns: 1fr;
            /* 1. Ubah jadi 1 kolom */
        }

        .cart-summary {
            position: static;
            /* 2. Hapus sticky */
            grid-row: 1;
            /* 3. Pindahkan summary ke atas */
            margin-bottom: 2rem;
        }
    }

    @media (max-width: 768px) {
        .cart-item {
            grid-template-columns: 80px 1fr;
            /* Ubah layout item */
            grid-template-rows: auto auto auto;
            padding: 1rem;
        }

        .item-image {
            grid-row: 1 / span 3;
        }

        .item-details {
            grid-column: 2;
        }

        .item-actions {
            grid-column: 2;
        }

        .item-subtotal {
            grid-column: 2;
            text-align: left;
            margin-top: 0.5rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const quantityForms = document.querySelectorAll('.quantity-form');

        quantityForms.forEach(form => {
            const minusBtn = form.querySelector('.minus');
            const plusBtn = form.querySelector('.plus');
            const input = form.querySelector('.quantity-input');

            minusBtn.addEventListener('click', function() {
                let currentValue = parseInt(input.value);
                if (currentValue > 1) {
                    input.value = currentValue - 1;
                    form.submit(); // Otomatis kirim form saat nilai berubah
                }
            });

            plusBtn.addEventListener('click', function() {
                let currentValue = parseInt(input.value);
                input.value = currentValue + 1;
                form.submit(); // Otomatis kirim form saat nilai berubah
            });
        });
    });
</script>
@endpush