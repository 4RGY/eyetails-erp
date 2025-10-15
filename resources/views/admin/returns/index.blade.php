@extends('admin.layouts.app')

@section('title', 'Manajemen Pengembalian')

@section('content')
<header class="admin-content-header">
    <h1>Manajemen Pengembalian & Penukaran</h1>
    <p>Kelola semua permintaan pengembalian atau penukaran barang dari pelanggan.</p>
</header>

<div class="admin-card">
    <div class="admin-card-header">
        <h2>Daftar Permintaan</h2>
    </div>

    @if(session('success'))
    <div class="alert alert-success">
        <i class="fa-solid fa-check-circle"></i>
        {{ session('success') }}
    </div>
    @endif

    <div class="admin-table-container">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>ID Permintaan</th>
                    <th>ID Pesanan</th>
                    <th>Pelanggan</th>
                    <th>Produk</th>
                    <th>Tipe</th>
                    <th>Status</th>
                    <th>Tanggal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($returnRequests as $request)
                <tr>
                    <td><strong>#{{ $request->id }}</strong></td>
                    <td>#{{ $request->order_id }}</td>
                    <td>{{ $request->user->name }}</td>
                    <td>{{ Str::limit($request->orderItem->product_name, 30) }}</td>
                    <td>
                        <span class="type-badge type-{{ strtolower($request->type) }}">{{ $request->type }}</span>
                    </td>
                    <td>
                        <span class="status-badge status-{{ strtolower($request->status) }}">
                            {{ $request->status }}
                        </span>
                    </td>
                    <td>{{ $request->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.returns.show', $request->id) }}" class="btn-action btn-view"
                            title="Lihat Detail">
                            <i class="fa-solid fa-eye"></i> Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center p-4">Belum ada permintaan pengembalian.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($returnRequests->hasPages())
    <div class="admin-card-footer">
        {{ $returnRequests->links() }}
    </div>
    @endif
</div>

{{-- CSS Tambahan --}}
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
        font-weight: 600;
        text-transform: uppercase;
        font-size: 0.8rem;
    }

    .admin-card-footer {
        padding: 15px 20px;
        border-top: 1px solid var(--border-color);
    }

    .btn-action {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 8px 12px;
        border-radius: 4px;
        color: #fff;
        border: none;
        cursor: pointer;
        font-size: 0.9rem;
        text-decoration: none;
    }

    .btn-view {
        background-color: #0d6efd;
    }

    .status-badge,
    .type-badge {
        padding: 4px 10px;
        border-radius: 15px;
        font-weight: 600;
        font-size: 0.8rem;
        text-align: center;
    }

    .status-pending {
        background-color: #ffe082;
        color: #856404;
    }

    .status-approved {
        background-color: #c8e6c9;
        color: #155724;
    }

    .status-rejected {
        background-color: #f8d7da;
        color: #721c24;
    }

    .status-processing {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .status-completed {
        background-color: #e2e3e5;
        color: #383d41;
    }

    .type-return {
        background-color: #f3e5f5;
        color: #6a1b9a;
    }

    .type-exchange {
        background-color: #e0f2f1;
        color: #00695c;
    }
</style>
@endsection