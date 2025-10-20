@extends('layouts.app')

@section('title', 'Lacak Pesanan #' . $order->id)

@section('content')

<section class="page-header container text-center">
    <h1>Lacak Pesanan #{{ $order->id }}</h1>
    <p>Tanggal Pesan: {{ $order->created_at->format('d F Y, H:i') }}</p>
</section>

<section class="order-detail-container container">
    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif

    <div class="order-detail-layout">
        {{-- Kolom Kiri: Detail Pesanan & Produk --}}
        <div class="order-main-content">
            {{-- Rincian Pembayaran --}}
            <div class="order-block">
                <div class="block-header">
                    <h3>Rincian Pembayaran</h3>
                </div>
                <div class="block-content">
                    <div class="summary-line">
                        <span>Subtotal</span>
                        <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                    </div>
                    <div class="summary-line">
                        <span>Pengiriman ({{ $order->shipping_method ?? 'N/A' }})</span>
                        <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                    </div>
                    @if($order->points_used > 0)
                    <div class="summary-line discount-line">
                        <span>Diskon Poin ({{ $order->points_used }} Poin)</span>
                        <span>- Rp {{ number_format($order->points_used * 100, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    @if($order->promo_code)
                    <div class="summary-line discount-line">
                        <span>Diskon Promo ({{ $order->promo_code }})</span>
                        <span>- Rp {{ number_format($order->promo_discount, 0, ',', '.') }}</span>
                    </div>
                    @endif
                    <div class="summary-line total-line">
                        <span>Total Pembayaran</span>
                        <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>

            {{-- Detail Produk --}}
            <div class="order-block">
                <div class="block-header">
                    <h3>Detail Produk</h3>
                </div>
                <div class="block-content">
                    @foreach($order->items as $item)
                    <div class="product-item">
                        {{-- PERBAIKAN: Menambahkan class="product-image" --}}
                        @if($item->product && $item->product->primary_image)
                        <img src="{{ asset('storage/' . $item->product->primary_image) }}"
                            alt="{{ $item->product_name }}" class="product-image">
                        @else
                        <img src="https://via.placeholder.com/80x100/F0F0F0?text=Produk" alt="{{ $item->product_name }}"
                            class="product-image">
                        @endif
                        <div class="product-info">
                            <span class="product-name">{{ $item->product_name }}</span>

                            @if($item->size)
                            <p class="product-variant">Ukuran: <strong>{{ $item->size }}</strong></p>
                            @endif

                            <p class="product-qty-price">x{{ $item->quantity }} @ Rp {{ number_format($item->price, 0,
                                ',', '.') }}</p>
                            <div class="item-actions">
                                @if($order->order_status === 'Completed')
                                @if($item->returnRequest)
                                <div class="return-status-wrapper">
                                    <span>Status Pengembalian: <strong>{{ $item->returnRequest->status
                                            }}</strong></span>
                                    @if($item->returnRequest->admin_notes)<div class="admin-note"><strong>Catatan
                                            Admin:</strong> {{ $item->returnRequest->admin_notes }}</div>@endif
                                </div>
                                @else
                                <a href="{{ route('reviews.create', $item) }}" class="btn-action-sm btn-review">Tulis
                                    Ulasan</a>
                                <a href="{{ route('returns.create', $item) }}" class="btn-action-sm btn-return">Ajukan
                                    Pengembalian</a>
                                @endif
                                @endif
                            </div>
                        </div>
                        <div class="product-subtotal">Rp {{ number_format($item->price * $item->quantity, 0, ',', '.')
                            }}</div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Status, Resi & Alamat --}}
        <div class="order-sidebar">
            <div class="order-block">
                <div class="block-header">
                    <h3>Status Pengiriman</h3>
                </div>
                <div class="block-content status-block">
                    <div class="current-status">
                        <p>Status Saat Ini</p>
                        <span class="order-status status-{{ Str::slug($order->order_status) }}">{{ $order->order_status
                            }}</span>
                    </div>
                    @if($order->shipping_method)
                    <div class="tracking-info">
                        <p>Metode Pengiriman</p>
                        <span class="tracking-number">{{ $order->shipping_method }}</span>
                    </div>
                    @endif
                    @if($order->tracking_number)
                    <div class="tracking-info">
                        <p>Nomor Resi</p>
                        <span class="tracking-number">{{ $order->tracking_number }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <div class="order-block">
                <div class="block-header">
                    <h3>Alamat Pengiriman</h3>
                </div>
                <div class="block-content shipping-info">
                    <p><strong>{{ $order->customer_name }}</strong></p>
                    <p>{{ $order->shipping_address }}</p>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    /* ... (CSS lainnya tidak berubah) ... */
    .product-variant {
        font-size: 0.9rem;
        color: #6c757d;
        margin: 5px 0;
    }

    .order-detail-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 30px;
        align-items: flex-start
    }

    .order-block {
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        margin-bottom: 25px
    }

    .block-header {
        padding: 15px 20px;
        border-bottom: 1px solid #e0e0e0
    }

    .block-header h3 {
        margin: 0;
        font-size: 1.1rem
    }

    .block-content {
        padding: 20px
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 10px 0;
        border-bottom: 1px solid #f0f0f0
    }

    .summary-line:last-child {
        border-bottom: 0
    }

    .summary-line span:first-child {
        color: #666
    }

    .summary-line span:last-child {
        font-weight: 600
    }

    .summary-line.discount-line span {
        color: #198754
    }

    .summary-line.total-line {
        padding-top: 15px;
        border-top: 1px solid #ddd;
        font-size: 1.2rem;
        color: #1a1a1a
    }

    .order-status {
        padding: 5px 12px;
        border-radius: 15px;
        font-size: .8rem;
        font-weight: 700
    }

    .status-pending {
        background-color: #fff0c2;
        color: #7a5a00
    }

    .status-processing {
        background-color: #d1ecf1;
        color: #0c5460
    }

    .status-shipped {
        background-color: #d6eaff;
        color: #004085
    }

    .status-completed {
        background-color: #d4edda;
        color: #155724
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24
    }

    .status-block {
        display: flex;
        flex-direction: column;
        gap: 15px
    }

    .current-status p,
    .tracking-info p {
        margin: 0 0 5px;
        font-size: .9rem;
        color: #666
    }

    .tracking-number {
        font-family: monospace;
        background-color: #f0f0f0;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 1rem;
        display: inline-block;
        border: 1px solid #ddd
    }

    .product-item {
        display: flex;
        gap: 15px;
        padding: 15px 0;
        border-bottom: 1px solid #f0f0f0
    }

    .product-item:last-child {
        border-bottom: 0;
        padding-bottom: 0
    }

    .product-image {
        width: 80px;
        height: 100px;
        object-fit: cover;
        border-radius: 4px
    }

    .product-info {
        flex: 1
    }

    .product-name {
        font-weight: 600
    }

    .product-qty-price {
        font-size: .9rem;
        color: #666;
        margin: 5px 0
    }

    .product-subtotal {
        font-weight: 600
    }

    .item-actions {
        margin-top: 10px;
        display: flex;
        gap: 10px;
        align-items: center
    }

    .btn-action-sm {
        padding: 5px 12px;
        font-size: .8rem;
        border-radius: 4px;
        text-decoration: none;
        font-weight: 600;
        white-space: nowrap;
        border: 1px solid
    }

    .btn-review {
        border-color: #198754;
        color: #198754
    }

    .btn-return {
        border-color: #dc3545;
        color: #dc3545
    }

    .return-status-wrapper {
        font-size: .85rem;
        background-color: #f8f9fa;
        padding: 8px 12px;
        border-radius: 4px;
        border: 1px solid #dee2e6
    }

    .admin-note {
        font-size: .8rem;
        margin-top: 5px;
        padding-top: 5px;
        border-top: 1px dashed #ccc
    }

    .shipping-info p {
        margin: 0 0 5px
    }

    @media (max-width: 992px) {
        .order-detail-layout {
            grid-template-columns: 1fr
        }

        .order-main-content {
            grid-row: 2
        }

        .order-sidebar {
            grid-row: 1
        }
    }

    @media (max-width:480px) {
        .product-item {
            flex-wrap: wrap
        }

        .product-subtotal {
            width: 100%;
            text-align: right;
            margin-top: 10px
        }
    }
</style>

@endsection