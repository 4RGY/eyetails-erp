@extends('admin.layouts.app')

@section('title', 'CRM - Manajemen Pelanggan')

@section('content')
<header class="admin-content-header">
    <h1>Manajemen Hubungan Pelanggan (CRM)</h1>
    <p>Kelola data, interaksi, dan status semua pelanggan Anda.</p>
</header>

{{-- Kartu Statistik CRM --}}
<div class="admin-widgets-grid">
    <div class="widget-card">
        <div class="widget-icon"><i class="fa-solid fa-users"></i></div>
        <div class="widget-info">
            <span class="widget-label">Total Pelanggan</span>
            <span class="widget-value">{{ $customerStats['total_customers'] }}</span>
        </div>
    </div>
    <div class="widget-card">
        <div class="widget-icon"><i class="fa-solid fa-user-plus"></i></div>
        <div class="widget-info">
            <span class="widget-label">Pelanggan Baru Bulan Ini</span>
            <span class="widget-value">{{ $customerStats['new_customers_this_month'] }}</span>
        </div>
    </div>
    <div class="widget-card">
        <div class="widget-icon"><i class="fa-solid fa-money-bill-wave"></i></div>
        <div class="widget-info">
            <span class="widget-label">Total Pendapatan (Selesai)</span>
            <span class="widget-value">Rp {{ number_format($customerStats['total_revenue'], 0, ',', '.') }}</span>
        </div>
    </div>
</div>


<div class="admin-card mt-6">
    <div class="admin-card-header-with-button">
        <h2>Daftar Pelanggan</h2>
        {{-- Form Pencarian --}}
        <form action="{{ route('admin.crm.index') }}" method="GET" class="search-form">
            <input type="text" name="search" placeholder="Cari nama atau email..." value="{{ request('search') }}">
            <button type="submit"><i class="fa-solid fa-search"></i></button>
        </form>
    </div>

    <div class="admin-table-container">
        <table class="admin-table modern-table">
            <thead>
                <tr>
                    <th>Nama Pelanggan</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Total Pesanan</th>
                    <th>Total Belanja</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customers as $customer)
                <tr>
                    <td data-label="Nama"><strong>{{ $customer->name }}</strong></td>
                    <td data-label="Email">{{ $customer->email }}</td>
                    <td data-label="Status"><span class="status-badge status-lead">{{ $customer->status }}</span></td>
                    <td data-label="Total Pesanan">{{ $customer->orders_count }}</td>
                    <td data-label="Total Belanja">Rp {{ number_format($customer->orders_sum_total_amount ?? 0, 0, ',',
                        '.') }}</td>
                    <td data-label="Aksi">
                        <a href="{{ route('admin.crm.show', $customer) }}" class="btn-action btn-view"
                            title="Lihat Detail">
                            <i class="fa-solid fa-eye"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center p-4">Tidak ada data pelanggan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($customers->hasPages())
    <div class="admin-card-footer">
        {{ $customers->links() }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .mt-6 {
        margin-top: 1.5rem;
    }

    .admin-card-header-with-button {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid var(--border-color);
        flex-wrap: wrap;
        gap: 10px;
    }

    .search-form {
        display: flex;
    }

    .search-form input {
        border: 1px solid #ccc;
        padding: 8px 12px;
        border-radius: 4px 0 0 4px;
    }

    .search-form button {
        padding: 8px 12px;
        border: 1px solid var(--primary-accent);
        background-color: var(--primary-accent);
        color: white;
        cursor: pointer;
        border-radius: 0 4px 4px 0;
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
    }

    .modern-table th,
    .modern-table td {
        padding: 1rem 1.5rem;
        text-align: left;
        vertical-align: middle;
        border-bottom: 1px solid #e9ecef;
    }

    .modern-table th {
        background-color: #f8f9fa;
        font-weight: 600;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .status-lead {
        background-color: #dbeafe;
        color: #1e40af;
    }

    .btn-action {
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        color: #fff;
        text-decoration: none;
    }

    .btn-view {
        background-color: #3b82f6;
    }
</style>
@endpush