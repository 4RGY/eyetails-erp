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
                                {{ $order->items->first()->product_name }}...
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
    <div class="admin-card-footer">
        {{ $orders->links('vendor.pagination.semantic-ui') }}
    </div>
    @endif
</div>

@push('styles')
<style>
    /* ... CSS untuk .alert, .modern-table, .order-status, dll. tetap sama ... */
    .alert {
        padding: 1rem;
        margin: 0 20px 20px;
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
        padding: 12px 20px;
        text-align: left;
        background-color: #f8f9fa;
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
        color: #6c757d;
        border-bottom: 2px solid var(--border-color);
    }

    .modern-table td {
        padding: 15px 20px;
        text-align: left;
        vertical-align: middle;
        border-bottom: 1px solid var(--border-color);
        color: var(--text-primary);
    }

    .modern-table tbody tr:last-child td {
        border-bottom: none;
    }

    .modern-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .order-id {
        font-weight: 700;
        color: var(--primary-accent);
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

    .order-status {
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: capitalize;
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

    .btn-action {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #fff;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        text-decoration: none;
        transition: transform 0.2s, background-color 0.2s;
    }

    .btn-action:hover {
        transform: scale(1.1);
    }

    .btn-view {
        background-color: var(--primary-accent);
    }

    .btn-view:hover {
        background-color: #4338ca;
    }

    /* === PAGINATION STYLING (FINAL) === */
    .admin-card-footer {
        padding: 15px 20px;
        border-top: 1px solid var(--border-color);
    }

    .pagination {
        display: flex;
        justify-content: flex-end;
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .pagination .page-item {
        margin: 0 4px;
    }

    .pagination .page-link,
    .pagination .page-item.disabled .page-link,
    .pagination .page-item.active .page-link {
        display: flex;
        align-items: center;
        justify-content: center;
        min-width: 40px;
        height: 40px;
        padding: 0 14px;
        border: 1px solid var(--border-color);
        border-radius: 6px;
        color: var(--text-primary);
        text-decoration: none;
        background-color: #fff;
        transition: all 0.2s ease;
        font-weight: 500;
        font-size: 0.9rem;
    }

    .pagination .page-link:hover {
        background-color: #f1f1f1;
        border-color: #d1d1d1;
    }

    .pagination .page-item.active .page-link {
        background-color: var(--primary-accent);
        color: white;
        border-color: var(--primary-accent);
        cursor: default;
    }

    .pagination .page-item.disabled .page-link {
        color: #9ca3af;
        background-color: var(--admin-bg);
        cursor: not-allowed;
    }

    .pagination svg,
    .dark\:text-gray-400 {
        display: none !important;
    }

    /* MODIFIKASI DI SINI */
    .pagination .page-item:first-child .page-link::before {
        content: '<< ';
        /* Panah < dihapus */
    }

    .pagination .page-item:last-child .page-link::after {
        content: ' >>';
        /* Panah > dihapus */
    }

    /* === RESPONSIVE TABLE (CARD VIEW) === */
    @media (max-width: 992px) {
        .modern-table thead {
            display: none;
        }

        .modern-table tr {
            display: block;
            margin-bottom: 1.5rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            overflow: hidden;
        }

        .modern-table tbody tr:last-child {
            margin-bottom: 0;
        }

        .modern-table td {
            display: flex;
            justify-content: space-between;
            align-items: center;
            text-align: right;
            padding: 12px 15px;
            border-bottom: 1px solid var(--border-color);
        }

        .modern-table td:last-child {
            border-bottom: none;
        }

        .modern-table td::before {
            content: attr(data-label);
            font-weight: 600;
            color: #6c757d;
            font-size: 0.8rem;
            text-transform: uppercase;
            text-align: left;
            margin-right: 1rem;
        }

        .pagination {
            justify-content: center;
        }
    }
</style>
@endpush
@endsection