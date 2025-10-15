@extends('admin.layouts.app')

@section('title', 'Detail Pelanggan: ' . $user->name)

@section('content')
<header class="admin-content-header">
    <a href="{{ route('admin.users.index') }}" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Pengguna
    </a>
    <h1>Detail Pelanggan</h1>
    <p>Lihat informasi lengkap dan riwayat pesanan untuk {{ $user->name }}.</p>
</header>

<div class="user-detail-layout">
    {{-- Kolom Kiri: Info Pelanggan --}}
    <div class="info-column">
        <div class="admin-card">
            <div class="admin-card-header">
                <h3><i class="fa-solid fa-user-circle"></i> Informasi Profil</h3>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">ID Pelanggan</span>
                    <span class="info-value">#{{ $user->id }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Nama Lengkap</span>
                    <span class="info-value">{{ $user->name }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Alamat Email</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tanggal Bergabung</span>
                    <span class="info-value">{{ $user->created_at->format('d F Y') }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Role</span>
                    <span class="info-value">
                        @if($user->is_admin)
                        <span class="role-badge role-admin">Admin</span>
                        @else
                        <span class="role-badge role-customer">Pelanggan</span>
                        @endif
                    </span>
                </div>
            </div>
            <div class="admin-card-footer">
                <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary"><i
                        class="fa-solid fa-pencil-alt"></i> Edit Pengguna</a>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Riwayat Pesanan --}}
    <div class="history-column">
        <div class="admin-card">
            <div class="admin-card-header">
                <h3><i class="fa-solid fa-history"></i> Riwayat Pesanan ({{ $orders->total() }})</h3>
            </div>
            <div class="admin-table-container">
                <table class="admin-table modern-table">
                    <thead>
                        <tr>
                            <th>ID Pesanan</th>
                            <th>Tanggal</th>
                            <th>Total</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($orders as $order)
                        <tr>
                            <td data-label="ID Pesanan"><strong><a href="{{ route('admin.orders.show', $order) }}">#{{
                                        $order->id }}</a></strong></td>
                            <td data-label="Tanggal">{{ $order->created_at->format('d M Y') }}</td>
                            <td data-label="Total">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</td>
                            <td data-label="Status"><span
                                    class="status-badge status-{{ Str::slug($order->order_status) }}">{{
                                    $order->order_status }}</span></td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center p-4">Pelanggan ini belum memiliki pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($orders->hasPages())
            <div class="admin-card-footer">
                {{ $orders->links() }}
            </div>
            @endif
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .back-link {
        color: var(--primary-accent);
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 1rem;
        display: inline-block;
    }

    .user-detail-layout {
        display: grid;
        grid-template-columns: 1fr 2fr;
        /* Kolom info lebih kecil dari kolom riwayat */
        gap: 2rem;
        align-items: flex-start;
    }

    .admin-card-header h3 {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        font-size: 1.1rem;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
        padding: 1.5rem;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 0.8rem;
        color: #6c757d;
        margin-bottom: 0.25rem;
        text-transform: uppercase;
    }

    .info-value {
        font-weight: 600;
        font-size: 1rem;
    }

    .role-badge {
        padding: 4px 10px;
        border-radius: 15px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .role-admin {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .role-customer {
        background-color: #e2e3e5;
        color: #383d41;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 5px;
        text-transform: uppercase;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    .btn-primary {
        background-color: var(--primary-accent);
        color: white;
    }

    /* Tabel Riwayat Pesanan */
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
    }

    .modern-table td a {
        text-decoration: none;
        color: var(--primary-accent);
        font-weight: 700;
    }

    .modern-table tbody tr:hover {
        background-color: #f8f9fa;
    }

    .text-center {
        text-align: center;
    }

    .p-4 {
        padding: 1.5rem;
    }

    .status-badge {
        padding: 5px 10px;
        border-radius: 15px;
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

    /* RESPONSIVE */
    @media (max-width: 992px) {
        .user-detail-layout {
            grid-template-columns: 1fr;
            /* 1 kolom di mobile */
        }
    }
</style>
@endpush