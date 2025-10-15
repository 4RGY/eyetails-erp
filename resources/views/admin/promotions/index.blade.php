@extends('admin.layouts.app')

@section('title', 'Manajemen Promo')

@section('content')
<header class="admin-content-header">
    <h1>Manajemen Promo & Voucher</h1>
    <p>Buat dan kelola semua event diskon, kode voucher, dan promo otomatis.</p>
</header>

<div class="admin-card">
    <div class="admin-card-header-with-button">
        <h2>Daftar Promo</h2>
        <a href="{{ route('admin.promotions.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tambah Promo Baru
        </a>
    </div>

    @if(session('success'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
        x-transition:leave="transition ease-in duration-300" x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0" class="alert alert-success">
        <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    <div class="admin-table-container">
        <table class="admin-table modern-table">
            <thead>
                <tr>
                    <th>Nama Promo</th>
                    <th>Kode</th>
                    <th>Tipe</th>
                    <th>Nilai</th>
                    <th>Status</th>
                    <th>Penggunaan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($promotions as $promo)
                <tr>
                    <td data-label="Nama"><strong>{{ $promo->name }}</strong></td>
                    <td data-label="Kode"><span class="code-badge">{{ $promo->code ?? 'N/A' }}</span></td>
                    <td data-label="Tipe">{{ $promo->type == 'percentage' ? 'Persentase' : 'Nominal Tetap' }}</td>
                    <td data-label="Nilai">
                        @if($promo->type == 'percentage')
                        {{ rtrim(rtrim($promo->value, '0'), '.') }}%
                        @else
                        Rp {{ number_format($promo->value, 0, ',', '.') }}
                        @endif
                    </td>
                    <td data-label="Status">
                        @if($promo->is_active)
                        <span class="status-badge status-approved">Aktif</span>
                        @else
                        <span class="status-badge status-rejected">Nonaktif</span>
                        @endif
                    </td>
                    <td data-label="Penggunaan">{{ $promo->usage_count }} / {{ $promo->usage_limit ?? '∞' }}</td>
                    <td data-label="Aksi">
                        <div class="action-buttons">
                            <a href="{{ route('admin.promotions.edit', $promo->id) }}" class="btn-action btn-edit"
                                title="Edit"><i class="fa-solid fa-pencil-alt"></i></a>
                            <form action="{{ route('admin.promotions.destroy', $promo->id) }}" method="POST"
                                onsubmit="return confirm('Anda yakin ingin menghapus promo ini?');"
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
                    <td colspan="7" class="text-center p-4">Belum ada promo yang dibuat.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($promotions->hasPages())
    <div class="admin-card-footer">
        {{ $promotions->links() }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    /* Common styles */
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

    .btn-primary {
        background-color: var(--primary-accent);
        color: white;
        padding: 10px 15px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        border: none;
    }

    .text-center {
        text-align: center;
    }

    .p-4 {
        padding: 1.5rem;
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

    /* Modern Table */
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

    /* Action Buttons */
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

    /* Badges */
    .status-badge,
    .code-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .status-approved {
        background-color: #c8e6c9;
        color: #155724;
    }

    .status-rejected {
        background-color: #f8d7da;
        color: #721c24;
    }

    .code-badge {
        background-color: #e2e3e5;
        color: #383d41;
        font-family: 'Courier New', Courier, monospace;
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