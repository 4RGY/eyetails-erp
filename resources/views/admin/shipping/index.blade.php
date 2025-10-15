@extends('admin.layouts.app')

@section('title', 'Manajemen Pengiriman')

@section('content')
<header class="admin-content-header">
    <h1>Manajemen Pengiriman</h1>
    <p>Kelola semua metode pengiriman dan biaya yang tersedia untuk pelanggan.</p>
</header>

<div class="admin-card">
    <div class="admin-card-header-with-button">
        <h2>Daftar Metode Pengiriman</h2>
        <a href="{{ route('admin.shipping.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Metode
        </a>
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
                    <th>Nama Layanan</th>
                    <th>Deskripsi</th>
                    <th>Biaya</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($shippingMethods as $method)
                <tr>
                    <td data-label="Nama Layanan">
                        <strong>{{ $method->name }}</strong>
                    </td>
                    <td data-label="Deskripsi">{{ $method->description ?? '-' }}</td>
                    <td data-label="Biaya">Rp {{ number_format($method->cost, 0, ',', '.') }}</td>
                    <td data-label="Status">
                        @if($method->is_active)
                        <span class="status-badge status-available">Aktif</span>
                        @else
                        <span class="status-badge status-out">Nonaktif</span>
                        @endif
                    </td>
                    <td data-label="Aksi">
                        <div class="action-buttons">
                            <a href="{{ route('admin.shipping.edit', $method->id) }}" class="btn-action btn-edit"
                                title="Edit"><i class="fa-solid fa-pencil-alt"></i></a>
                            <form action="{{ route('admin.shipping.destroy', $method->id) }}" method="POST"
                                onsubmit="return confirm('Anda yakin ingin menghapus metode pengiriman ini?');"
                                style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-action btn-delete" title="Hapus"><i
                                        class="fa-solid fa-trash-alt"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center p-4">Belum ada metode pengiriman yang ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($shippingMethods->hasPages())
    <div class="admin-card-footer">
        {{ $shippingMethods->links() }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Menggunakan style yang konsisten dengan modul lain */
    .alert {
        padding: 1rem;
        margin: 1rem 0;
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

    .admin-card-header-with-button {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        border-bottom: 1px solid var(--border-color);
    }

    .btn-primary {
        background-color: var(--primary-accent);
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600;
    }

    /* Desain Tabel Modern & Responsif */
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

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .status-available {
        background-color: #d1fae5;
        color: #065f46;
    }

    .status-out {
        background-color: #fee2e2;
        color: #991b1b;
    }

    .action-buttons {
        display: flex;
        gap: 0.5rem;
    }

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
        transition: transform 0.2s, opacity 0.2s;
    }

    .btn-action:hover {
        transform: scale(1.1);
        opacity: 0.9;
    }

    .btn-edit {
        background-color: #16a34a;
    }

    .btn-delete {
        background-color: #ef4444;
    }

    .admin-card-footer {
        padding: 15px 20px;
        border-top: 1px solid var(--border-color);
    }

    /* RESPONSIVE: Mengubah Tabel jadi Card di Mobile */
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
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
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

        .action-buttons {
            justify-content: flex-end;
        }
    }
</style>
@endpush