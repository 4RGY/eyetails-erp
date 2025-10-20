@extends('admin.layouts.app')

@section('title', 'Manajemen Pengiriman')

@section('content')
<header class="admin-content-header">
    <h1>Manajemen Pengiriman</h1>
    <p>Kelola semua metode pengiriman dan biaya yang tersedia untuk pelanggan.</p>
    <div class="header-actions">
        <a href="{{ route('admin.shipping.create') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Metode
        </a>
    </div>
</header>

<div class="admin-card">
    <div class="admin-card-body">
        @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        {{-- Wrapper untuk tabel agar bisa scroll horizontal di layar kecil --}}
        <div class="admin-table-container">
            {{-- Mengganti class 'table' menjadi 'modern-table' agar sesuai dengan CSS --}}
            <table class="modern-table">
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
                    @forelse ($shippingOptions as $shippingOption)
                    <tr>
                        {{-- Menambahkan atribut data-label untuk tampilan responsif --}}
                        <td data-label="Nama Layanan"><strong>{{ $shippingOption->name }}</strong></td>
                        <td data-label="Deskripsi">{{ $shippingOption->description ?? '-' }}</td>
                        <td data-label="Biaya">Rp {{ number_format($shippingOption->cost, 0, ',', '.') }}</td>
                        <td data-label="Status">
                            {{-- Menggunakan class dari CSS baru --}}
                            @if ($shippingOption->is_active)
                            <span class="status-badge status-available">Aktif</span>
                            @else
                            <span class="status-badge status-out">Tidak Aktif</span>
                            @endif
                        </td>
                        <td data-label="Aksi">
                            <div class="action-buttons">
                                {{-- Menggunakan class dari CSS baru --}}
                                <a href="{{ route('admin.shipping.edit', $shippingOption->id) }}"
                                    class="btn-action btn-edit" title="Edit">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <form action="{{ route('admin.shipping.destroy', $shippingOption->id) }}" method="POST"
                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus metode ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action btn-delete" title="Hapus">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="text-center">Belum ada metode pengiriman yang ditambahkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="admin-card-footer">
            {{-- Menggunakan pagination yang lebih sesuai dengan style custom --}}
            {{ $shippingOptions->links('vendor.pagination.semantic-ui') }}
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Menggunakan style yang konsisten dengan modul lain */
    .alert {
        padding: 1rem;
        margin-bottom: 1.5rem;
        /* Menambah margin bawah */
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

    .header-actions {
        margin-top: 1rem;
    }

    .btn-primary {
        background-color: var(--primary-accent);
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        /* Menjaga layout icon dan teks */
        align-items: center;
        gap: 8px;
        transition: background-color 0.2s;
    }

    .btn-primary:hover {
        background-color: #4338ca;
        /* Warna sedikit lebih gelap saat hover */
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
        align-items: center;
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
        text-decoration: none;
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
        border-top: 1px solid var(--border-color, #e5e7eb);
        margin-top: 1rem;
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
            overflow: hidden;
            /* Mencegah konten keluar dari border-radius */
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