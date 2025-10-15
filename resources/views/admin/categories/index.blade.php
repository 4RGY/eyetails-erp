@extends('admin.layouts.app')

@section('title', 'Manajemen Kategori')

@section('content')
<header class="admin-content-header">
    <h1>Manajemen Kategori</h1>
    <p>Kelola semua kategori produk untuk toko Anda.</p>
</header>

<div class="admin-card">
    <div class="admin-card-header-with-button">
        <h2>Daftar Kategori</h2>
        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Kategori
        </a>
    </div>

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="alert alert-success">
        <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="alert alert-danger">
        <i class="fa-solid fa-times-circle"></i> {{ session('error') }}
    </div>
    @endif

    <div class="admin-table-container">
        <table class="admin-table modern-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                    <th>Slug</th>
                    <th>Jumlah Produk</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categories as $category)
                <tr>
                    <td data-label="ID">{{ $category->id }}</td>
                    <td data-label="Nama Kategori"><strong>{{ $category->name }}</strong></td>
                    <td data-label="Slug">{{ $category->slug }}</td>
                    <td data-label="Jumlah Produk">{{ $category->products_count }}</td>
                    <td data-label="Aksi">
                        <div class="action-buttons">
                            <a href="{{ route('admin.categories.edit', $category->id) }}" class="btn-action btn-edit"
                                title="Edit"><i class="fa-solid fa-pencil-alt"></i></a>
                            <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
                                onsubmit="return confirm('Anda yakin ingin menghapus kategori ini?');"
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
                    <td colspan="5" class="text-center p-4">Belum ada kategori yang ditambahkan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
    <div class="admin-card-footer">
        {{ $categories->links() }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Common styles for alerts, buttons, headers */
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

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
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

    /* Modern & Responsive Table Design */
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

    /* Action Buttons - Standardized */
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
        transition: transform 0.2s;
    }

    .btn-action:hover {
        transform: scale(1.1);
    }

    .btn-edit {
        background-color: #16a34a;
    }

    /* Green */
    .btn-delete {
        background-color: #ef4444;
    }

    /* Red */
    .admin-card-footer {
        padding: 15px 20px;
        border-top: 1px solid var(--border-color);
    }

    /* RESPONSIVE: Table to Card on Mobile */
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