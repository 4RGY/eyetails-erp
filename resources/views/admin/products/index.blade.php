@extends('admin.layouts.app')

@section('title', 'Manajemen Produk')

@section('content')
<header class="admin-content-header">
    <h1>Manajemen Produk</h1>
    <p>Kelola semua produk yang ditampilkan di toko Anda.</p>
</header>

<div class="admin-card">
    <div class="admin-card-header-with-button">
        <h2>Daftar Produk</h2>
        <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Produk Baru
        </a>
    </div>

    @if(session('success'))
    {{-- Notifikasi dengan Alpine.js untuk auto-hide --}}
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0">
        <div class="alert alert-success">
            <i class="fa-solid fa-check-circle"></i>
            <span>{{ session('success') }}</span>
            <button @click="show = false" class="close-alert-btn">&times;</button>
        </div>
    </div>
    @endif

    <div class="admin-table-container">
        <table class="admin-table modern-table">
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>SKU</th>
                    <th>Harga</th>
                    <th>Stok Varian</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                <tr>
                    <td data-label="Produk">
                        <div class="product-info-cell">
                            @if($product->primary_image)
                            <img src="{{ asset('storage/' . $product->primary_image) }}" alt="{{ $product->name }}"
                                class="product-thumbnail">
                            @else
                            <img src="https://via.placeholder.com/60x60/F0F0F0?text=No+Img" alt="No Image"
                                class="product-thumbnail">
                            @endif
                            <div>
                                <span class="product-name-cell">{{ $product->name }}</span>
                                <small class="product-category-cell">{{ $product->category->name ?? 'N/A' }}</small>
                            </div>
                        </div>
                    </td>
                    <td data-label="SKU">{{ $product->sku }}</td>
                    <td data-label="Harga">
                        @if($product->sale_price && $product->sale_price < $product->price)
                            <span class="price-original">Rp {{ number_format($product->price, 0, ',', '.') }}</span><br>
                            <strong class="price-sale">Rp {{ number_format($product->sale_price, 0, ',', '.')
                                }}</strong>
                            @else
                            Rp {{ number_format($product->price, 0, ',', '.') }}
                            @endif
                    </td>
                    <td data-label="Stok Varian">
                        <div class="variant-list">
                            @forelse($product->variants as $variant)
                            <div class="variant-item">
                                <span class="variant-size">{{ $variant->size }}</span>:
                                <span class="variant-quantity">{{ $variant->quantity }}</span>
                            </div>
                            @empty
                            <span class="variant-item-empty">Stok belum diatur</span>
                            @endforelse
                        </div>
                    </td>
                    <td data-label="Status">
                        @if($product->totalStock() > 0)
                        <span class="status-badge status-available">Tersedia</span>
                        @else
                        <span class="status-badge status-out">Habis</span>
                        @endif
                    </td>
                    <td data-label="Aksi">
                        <div class="action-buttons">
                            <a href="{{ route('admin.products.edit', $product->id) }}" class="btn-action btn-edit"
                                title="Edit"><i class="fa-solid fa-pencil-alt"></i></a>
                            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini?');"
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
                    <td colspan="6" class="text-center p-4">Belum ada produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
    <div class="admin-card-footer">
        {{ $products->links('vendor.pagination.semantic-ui') }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* ... (CSS umum lainnya seperti alert, header, dll) ... */

    /* === PAGINATION STYLES === */
    .pagination {
    display: flex;
    justify-content: flex-end; /* Posisi di kanan */
    list-style: none;
    padding: 0;
    margin-top: 20px;
    }
    
    .pagination .page-item {
    margin: 0 4px;
    }
    
    .pagination .page-link,
    .pagination .page-item.disabled .page-link,
    .pagination .page-item.active .page-link {
    display: block;
    padding: 8px 14px;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    color: var(--text-primary);
    text-decoration: none;
    background-color: #fff;
    transition: all 0.2s ease;
    font-weight: 500;
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
    opacity: 0.7;
    }
    
    /* Mengganti teks "Previous" & "Next" bawaan Laravel */
    .pagination .page-link[rel="prev"]::after {
    content: ' Sebelumnya';
    }
    
    .pagination .page-link[rel="next"]::before {
    content: 'Berikutnya ';
    }
    
    .pagination .page-link[rel="prev"],
    .pagination .page-link[rel="next"] {
    font-weight: 600;
    }
    
    /* Menghilangkan panah bawaan */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
    padding: 8px 14px;
    }
    
    .alert {
        padding: 1rem;
        margin: 1rem 0;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
        position: relative;
    }

    .alert-success {
        background-color: #e6f9f0;
        color: #00874e;
        border: 1px solid #b3e6d1;
    }

    .close-alert-btn {
        background: none;
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        position: absolute;
        top: 50%;
        right: 1rem;
        transform: translateY(-50%);
        color: #00874e;
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

    .admin-table-container {
        overflow-x: auto;
    }

    /* === PERBAIKAN UTAMA ADA DI SINI === */
    .product-info-cell {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .product-thumbnail {
        width: 60px;
        height: 60px;
        object-fit: cover;
        /* Memastikan gambar tidak gepeng */
        border-radius: 4px;
        flex-shrink: 0;
    }

    .product-name-cell {
        font-weight: 600;
        display: block;
    }

    .product-category-cell {
        color: #6c757d;
        font-size: 0.85rem;
    }

    .price-original {
        text-decoration: line-through;
        color: #999;
        font-size: 0.85rem;
    }

    .price-sale {
        color: #dc3545;
    }

    /* ==================================== */

    /* Styling Varian */
    .variant-list {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .variant-item {
        background-color: #f3f4f6;
        padding: 3px 8px;
        border-radius: 4px;
        font-size: 0.85rem;
        display: inline-block;
    }

    .variant-size {
        font-weight: 600;
    }

    .variant-item-empty {
        color: #9ca3af;
        font-style: italic;
    }

    /* Styling tabel dan responsivitas lainnya */
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
        transition: transform 0.2s;
    }

    .btn-action:hover {
        transform: scale(1.1);
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

        .product-info-cell {
            justify-content: flex-end;
        }

        .action-buttons {
            justify-content: flex-end;
        }
    }
</style>
@endpush