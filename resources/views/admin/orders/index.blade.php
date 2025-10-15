@extends('admin.layouts.app')

@section('title', 'Manajemen Pesanan')

@section('content')
<header class="admin-content-header">
    <h1>Manajemen Pesanan</h1>
    <p>Lihat dan kelola semua pesanan yang masuk ke sistem.</p>
</header>

<div class="admin-card">
    <div class="admin-card-header">
        <h2>Daftar Semua Pesanan</h2>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="fa-solid fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="admin-table-container">
        <table class="admin-table modern-table">
            <thead>
                <tr>
                    <th>ID Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Ringkasan Item</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($orders as $order)
                <tr>
                    <td data-label="ID Pesanan">
                        <span class="order-id">#{{ $order->id }}</span>
                    </td>
                    <td data-label="Pelanggan">
                        <div class="customer-info-cell">
                            <strong>{{ $order->customer_name }}</strong>
                            <small>{{ $order->customer_email }}</small>
                        </div>
                    </td>
                    <td data-label="Tanggal">{{ $order->created_at->format('d M Y, H:i') }}</td>
                    <td data-label="Ringkasan Item">
                        <div class="item-summary-cell">
                            <span class="item-count">{{ $order->items->count() }} Item</span>
                            <small class="first-item">
                                @if($order->items->first())
                                {{ $order->items->first()->product_name }}
                                @if($order->items->first()->size)
                                (Size: {{ $order->items->first()->size }})
                                @endif
                                ...
                                @endif
                            </small>
                        </div>
                    </td>
                    <td data-label="Total">
                        <strong>Rp {{ number_format($order->total_amount, 0, ',', '.') }}</strong>
                    </td>
                    <td data-label="Status">
                        <span class="order-status status-{{ Str::slug($order->order_status) }}">
                            {{ $order->order_status }}
                        </span>
                    </td>
                    <td data-label="Aksi">
                        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn-action btn-view"
                            title="Lihat Detail">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center p-4">Belum ada pesanan yang masuk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($orders->hasPages())
    <div class="admin-card-footer pagination-footer">
        {{ $orders->links() }}
    </div>
    @endif
</div>

@push('styles')
<style>
    .alert {
        padding: 1rem;
        margin: 1rem;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
    }

    .alert-success {
        background-color: #e6f9f0;
        color: #00874e;
        border: 1px solid #b3e6d1;
    }

    .admin-table-container {
        overflow-x: auto;
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
    }

    .modern-table th {
        padding: 1rem 1.5rem;
        text-align: left;
        background-color: #f8f9fa;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        color: #6c757d;
        border-bottom: 2px solid #e9ecef;
    }

    .modern-table td {
        padding: 1rem 1.5rem;
        text-align: left;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
        color: #343a40;
    }

    .modern-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    /* Detail Tambahan di Tabel */
    .order-id {
        font-weight: 700;
    }

    .customer-info-cell {
        display: flex;
        flex-direction: column;
    }

    .customer-info-cell small {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .item-summary-cell .item-count {
        font-weight: 600;
        display: block;
    }

    .item-summary-cell .first-item {
        color: #6c757d;
        font-size: 0.85rem;
        max-width: 200px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: block;
    }

    /* Status Badge */
    .order-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .status-pending {
        background-color: #ffe082;
        color: #856404;
    }

    .status-processing {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .status-shipped {
        background-color: #bbdefb;
        color: #0d47a1;
    }

    .status-completed {
        background-color: #c8e6c9;
        color: #155724;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }

    /* Tombol Aksi */
    .btn-action {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #fff;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        text-decoration: none;
        transition: transform 0.2s;
    }

    .btn-action:hover {
        transform: scale(1.1);
    }

    .btn-view {
        background-color: #0d6efd;
    }

    /* === PAGINATION STYLING - FIXED === */
    .pagination-footer {
        padding: 15px 20px;
        border-top: 1px solid #e9ecef;
        display: block;
    }

    /* Sembunyikan teks "Showing 1 to 15 of 16 results" */
    .pagination-footer nav>div:first-child {
        display: none !important;
    }

    .pagination-footer nav>div:last-child {
        display: none !important;
    }

    /* Tampilkan hanya pagination links */
    .pagination-footer nav>div:nth-child(2) {
        display: flex !important;
        justify-content: flex-start;
        align-items: center;
        gap: 5px;
    }

    /* Sembunyikan semua SVG arrow */
    .pagination-footer svg {
        display: none !important;
    }

    /* Style untuk pagination list */
    .pagination-footer nav ul {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
        gap: 5px;
    }

    .pagination-footer nav ul li {
        list-style: none;
    }

    /* Style untuk link pagination */
    .pagination-footer a,
    .pagination-footer span {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 12px;
        min-width: 40px;
        height: 36px;
        border: 1px solid #ddd;
        border-radius: 6px;
        text-decoration: none;
        color: #343a40;
        background-color: white;
        transition: all 0.2s;
        font-size: 0.9rem;
        font-weight: 500;
    }

    /* Halaman aktif */
    .pagination-footer .active span {
        background-color: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }

    /* Hover effect */
    .pagination-footer a:hover {
        background-color: #f8f9fa;
        border-color: #0d6efd;
        color: #0d6efd;
    }

    /* Disabled state */
    .pagination-footer .disabled span {
        opacity: 0.5;
        cursor: not-allowed;
        background-color: #f8f9fa;
    }

    /* Tampilkan teks Previous dan Next */
    .pagination-footer a[rel="prev"]::before {
        content: "‹ ";
    }

    .pagination-footer a[rel="next"]::after {
        content: " ›";
    }

    /* Responsive Table to Card */
    @media (max-width: 992px) {
        .modern-table thead {
            display: none;
        }

        .modern-table tr,
        .modern-table td {
            display: block;
            width: 100%;
            box-sizing: border-box;
        }

        .modern-table tr {
            margin-bottom: 1rem;
            border: 1px solid #e9ecef;
            border-radius: 8px;
        }

        .modern-table td {
            text-align: right;
            padding-left: 50%;
            position: relative;
            border-bottom: 1px solid #f0f0f0;
        }

        .modern-table td:last-child {
            border-bottom: none;
        }

        .modern-table td:before {
            content: attr(data-label);
            position: absolute;
            left: 1.5rem;
            width: calc(50% - 2rem);
            text-align: left;
            font-weight: 600;
            color: #6c757d;
            font-size: 0.8rem;
            text-transform: uppercase;
        }

        .pagination-footer {
            justify-content: flex-start;
        }
    }
</style>
@endpush
@endsection