@extends('akun.master')

@section('title', 'Riwayat Pesanan | eyetails.co')

@section('account-content')

<div class="order-history-container">
    <div class="header">
        <h2 class="dashboard-title"><i class="fas fa-history"></i> Riwayat Pesanan</h2>
        <p class="text-gray-600">Daftar semua pesanan yang pernah Anda lakukan di eyetails.co.</p>
    </div>

    @if ($orders->count())
    <div class="order-list-container">
        @foreach ($orders as $order)
        <div class="order-card">
            <div class="order-card-header">
                <div class="order-info">
                    <span class="order-id">Pesanan #{{ $order->id }}</span>
                    <span class="order-date">{{ $order->created_at->format('d F Y') }}</span>
                </div>
                <span class="order-status status-{{ Str::slug($order->order_status) }}">
                    {{ $order->order_status }}
                </span>
            </div>

            <div class="order-card-body">
                {{-- AWAL PERUBAHAN: Menampilkan preview gambar produk --}}
                <div class="item-preview-container">
                    @foreach($order->items->take(4) as $item) {{-- Ambil maks 4 gambar --}}
                    <div class="item-preview">
                        @if($item->product && $item->product->primary_image)
                        <img src="{{ asset('storage/' . $item->product->primary_image) }}" alt="{{ $item->product_name }}">
                        @else
                        <img src="https://via.placeholder.com/80x100/F0F0F0?text=Produk"
                            alt="{{ $item->product_name }}">
                        @endif
                    </div>
                    @endforeach
                    @if($order->items->count() > 4)
                    <div class="item-preview-more">
                        +{{ $order->items->count() - 4 }}
                    </div>
                    @endif
                </div>
                {{-- AKHIR PERUBAHAN --}}

                <div class="order-summary-and-action">
                    <div class="order-total">
                        <span>Total Belanja</span>
                        <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                    </div>
                    <a href="{{ route('order.tracking', $order) }}" class="btn btn-detail">
                        <span>Lihat Detail</span>
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    @if($orders->hasPages())
    <div class="pagination-area">
        {{ $orders->links() }}
    </div>
    @endif

    @else
    <div class="no-results-container">
        <h3>Anda Belum Memiliki Riwayat Pesanan</h3>
        <p>Semua pesanan yang Anda buat akan muncul di sini.</p>
        <a href="{{ route('catalog.index') }}" class="btn btn-primary mt-3">Mulai Belanja</a>
    </div>
    @endif
</div>

@endsection

@push('styles')
<style>
    .order-history-container .header {
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }

    .order-list-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
        /* Jarak antar kartu pesanan */
    }

    .order-card {
        background-color: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .order-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .order-card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #f0f0f0;
        flex-wrap: wrap;
        gap: 0.5rem;
    }

    .order-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .order-id {
        font-weight: 700;
        font-size: 1.1rem;
        color: #1a1a1a;
    }

    .order-date {
        color: #6c757d;
        font-size: 0.9rem;
    }

    .order-card-body {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .item-preview-container {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .item-preview {
        width: 60px;
        height: 60px;
        border-radius: 4px;
        overflow: hidden;
        border: 1px solid #eee;
    }

    .item-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .item-preview-more {
        width: 60px;
        height: 60px;
        border-radius: 4px;
        background-color: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #6c757d;
        border: 1px solid #eee;
    }

    .order-summary-and-action {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .order-total {
        text-align: right;
    }

    .order-total span {
        display: block;
        font-size: 0.85rem;
        color: #6c757d;
    }

    .order-total strong {
        font-size: 1.2rem;
        color: #1a1a1a;
    }

    .btn-detail {
        background-color: #f8f9fa;
        color: #333;
        padding: 8px 15px;
        border-radius: 20px;
        text-decoration: none;
        font-weight: 600;
        font-size: .9rem;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        border: 1px solid #e0e0e0;
        transition: all 0.2s;
    }

    .btn-detail:hover {
        background-color: var(--primary-accent, #4f46e5);
        color: #fff;
        border-color: var(--primary-accent, #4f46e5);
    }

    .btn-detail i {
        transition: transform 0.2s;
    }

    .btn-detail:hover i {
        transform: translateX(3px);
    }

    .order-status {
        padding: 5px 12px;
        border-radius: 15px;
        font-size: .8rem;
        font-weight: 700;
    }

    .status-pending {
        background-color: #fff0c2;
        color: #7a5a00;
    }

    .status-processing {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .status-shipped {
        background-color: #d6eaff;
        color: #004085;
    }

    .status-completed {
        background-color: #d4edda;
        color: #155724;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }

    .pagination-area {
        margin-top: 2rem;
    }

    .no-results-container {
        text-align: center;
        padding: 3rem 0;
    }
</style>
@endpush