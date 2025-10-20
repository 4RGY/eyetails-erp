@extends('admin.layouts.app')

@section('title', 'Detail Pesanan #' . $order->id)

@section('content')
<header class="admin-content-header">
    <a href="{{ route('admin.orders.index') }}" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pesanan
    </a>
    <h1>Detail Pesanan #{{ $order->id }}</h1>
    <p>Tanggal Pesanan: {{ $order->created_at->format('d F Y, H:i') }}</p>
</header>

@if(session('success'))
<div class="alert alert-success">
    <i class="fa-solid fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

<div class="order-detail-layout">
    {{-- Kolom Kiri: Detail Item & Pengiriman --}}
    <div class="main-column">
        {{-- Card untuk Item yang Dipesan --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Item yang Dipesan</h3>
            </div>
            <div class="admin-table-container">
                <table class="admin-table">
                    <thead>
                        <tr>
                            <th>Produk</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                        <tr>
                            <td>
                                {{-- =============================================== --}}
                                {{-- PERUBAHAN: Menambahkan Gambar & Detail Varian --}}
                                {{-- =============================================== --}}
                                <div class="product-cell">
                                    <div class="product-cell-image">
                                        @if($item->product && $item->product->primary_image)
                                        <img src="{{ asset('storage/' . $item->product->primary_image) }}"
                                            alt="{{ $item->product_name }}">
                                        @else
                                        <img src="https://via.placeholder.com/80x100/F0F0F0?text=Produk"
                                            alt="{{ $item->product_name }}">
                                        @endif
                                    </div>
                                    <div class="product-cell-info">
                                        <strong>{{ $item->product_name }}</strong>
                                        @if($item->size)
                                        <small class="variant-info">Ukuran: {{ $item->size }}</small>
                                        @endif
                                        <small class="sku-info">SKU: {{ $item->product->sku ?? 'N/A' }}</small>
                                    </div>
                                </div>
                                {{-- =============================================== --}}
                            </td>
                            <td>Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                            <td>x {{ $item->quantity }}</td>
                            <td>Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Card untuk Info Pengiriman & Pelanggan --}}
        <div class="admin-card mt-6">
            <div class="admin-card-header">
                <h3>Informasi Detail</h3>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">Nama Pelanggan</span>
                    <span class="info-value">{{ $order->customer_name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nomor Telepon</span>
                    <span class="info-value">{{ $order->phone ?? 'Tidak ada' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $order->customer_email }}</span>
                </div>
                <div class="info-item full-width">
                    <span class="info-label">Alamat Pengiriman</span>
                    <span class="info-value">{{ $order->shipping_address }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Metode Pengiriman</span>
                    <span class="info-value">{{ $order->shipping_method ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Metode Pembayaran</span>
                    <span class="info-value">{{ $order->payment_method ?? 'N/A' }}</span>
                </div>
            </div>

            {{-- Tampilkan bukti pembayaran jika ada --}}
            @if($order->payment_proof)
            <div class="admin-card-footer" style="padding: 15px; border-top: 1px solid var(--border-color);">
                <h4 style="margin: 0 0 10px 0;">Bukti Pembayaran</h4>
                <a href="{{ asset('storage/' . $order->payment_proof) }}" target="_blank">
                    <img src="{{ asset('storage/' . $order->payment_proof) }}" alt="Bukti Pembayaran"
                        style="max-width: 100%; border-radius: 6px;">
                </a>
            </div>
            @endif
        </div>
    </div>

    {{-- Kolom Kanan: Ringkasan & Update Status --}}
    <div class="side-column">

        {{-- CARD BARU: RINGKASAN FINANSIAL --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Ringkasan Finansial</h3>
            </div>
            <div class="financial-summary">
                <div class="summary-line">
                    <span>Subtotal</span>
                    <span>Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
                </div>
                <div class="summary-line">
                    <span>Pengiriman</span>
                    <span>Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
                </div>
                @if($order->points_used > 0)
                <div class="summary-line discount">
                    <span>Diskon Poin</span>
                    <span>- Rp {{ number_format($order->points_used * 100, 0, ',', '.') }}</span>
                </div>
                @endif
                @if($order->promo_discount > 0)
                <div class="summary-line discount">
                    <span>Diskon Promo</span>
                    <span>- Rp {{ number_format($order->promo_discount, 0, ',', '.') }}</span>
                </div>
                @endif
                <div class="summary-line total">
                    <span>Grand Total</span>
                    <span>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>
        {{-- BATAS CARD BARU --}}

        <div class="admin-card mt-6">
            <div class="admin-card-header">
                <h3>Update Pesanan</h3>
            </div>
            <div class="summary-card-body">
                {{-- Form Update --}}
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="tracking_number">Nomor Resi Pengiriman</label>
                        <input type="text" name="tracking_number" id="tracking_number" class="form-control"
                            value="{{ old('tracking_number', $order->tracking_number) }}"
                            placeholder="Contoh: JNE123456789">
                    </div>

                    <hr>

                    <div class="form-group">
                        <label for="order_status">Status Pesanan</label>
                        <select name="order_status" id="order_status" class="form-control">
                            <option value="Pending" {{ $order->order_status == 'Pending' ? 'selected' : '' }}>Pending
                            </option>
                            <option value="Processing" {{ $order->order_status == 'Processing' ? 'selected' : ''
                                }}>Processing</option>
                            <option value="Shipped" {{ $order->order_status == 'Shipped' ? 'selected' : '' }}>Shipped
                            </option>
                            <option value="Completed" {{ $order->order_status == 'Completed' ? 'selected' : ''
                                }}>Completed</option>
                            <option value="Cancelled" {{ $order->order_status == 'Cancelled' ? 'selected' : ''
                                }}>Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-full">Update Pesanan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .back-link {
        color: var(--primary-accent);
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 1rem;
        display: inline-block;
    }

    .order-detail-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        align-items: flex-start;
    }

    .main-column {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .admin-table {
        width: 100%;
        border-collapse: collapse;
    }

    .admin-table th,
    .admin-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid var(--border-color);
        vertical-align: middle;
    }

    .admin-table th {
        background-color: #f8f9fa;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    /* CSS untuk sel produk yang lebih informatif */
    .product-cell {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .product-cell-image {
        width: 50px;
        height: 50px;
        flex-shrink: 0;
    }

    .product-cell-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: 4px;
    }

    .product-cell-info small {
        display: block;
        color: #6c757d;
        font-size: 0.85rem;
    }

    .info-grid {
        padding: 15px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .info-value {
        font-weight: 600;
    }

    .full-width {
        grid-column: 1 / -1;
    }

    .summary-card-body {
        padding: 15px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: 600;
        font-size: 0.9rem;
        display: block;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    .btn-primary {
        background-color: var(--primary-accent);
        color: white;
        margin-top: 15px;
    }

    .w-full {
        width: 100%;
    }

    .mt-6 {
        margin-top: 1.5rem;
    }

    .alert-success {
        background-color: #e6f9f0;
        color: #00874e;
        border: 1px solid #b3e6d1;
    }

    hr {
        border: none;
        border-top: 1px solid var(--border-color);
        margin: 20px 0;
    }

    /* Style untuk financial summary */
    .financial-summary {
        padding: 15px;
    }

    .summary-line {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
        border-bottom: 1px solid #f0f0f0;
    }

    .summary-line:last-child {
        border: none;
    }

    .summary-line.discount {
        color: #198754;
    }

    .summary-line.total {
        font-weight: 700;
        font-size: 1.1rem;
        border-top: 2px solid #ddd;
        margin-top: 5px;
        padding-top: 10px;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .order-detail-layout {
            grid-template-columns: 1fr;
            /* Stack kolom di layar kecil */
        }
    }
</style>
@endsection