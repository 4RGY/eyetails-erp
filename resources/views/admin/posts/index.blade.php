@extends('admin.layouts.app')

@section('title', 'Manajemen Blog')

@section('content')
<header class="admin-content-header">
    <h1>Manajemen Blog</h1>
    <p>Buat, edit, dan kelola semua artikel untuk blog eyetails.co.</p>
</header>

<div class="admin-card">
    <div class="admin-card-header-with-button">
        <h2>Daftar Artikel</h2>
        <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Tulis Artikel Baru
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
                    <th>Judul Artikel</th>
                    <th>Status</th>
                    <th>Tanggal Publikasi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($posts as $post)
                <tr>
                    <td data-label="Judul"><strong>{{ Str::limit($post->title, 60) }}</strong></td>
                    <td data-label="Status">
                        @if($post->published_at && $post->published_at <= now()) <span
                            class="status-badge status-published">Published</span>
                            @elseif($post->published_at && $post->published_at > now())
                            <span class="status-badge status-scheduled">Scheduled</span>
                            @else
                            <span class="status-badge status-draft">Draft</span>
                            @endif
                    </td>
                    <td data-label="Tanggal Publikasi">{{ $post->published_at ? $post->published_at->format('d M Y,
                        H:i') : 'N/A' }}</td>
                    <td data-label="Aksi">
                        <div class="action-buttons">
                            <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn-action btn-edit"
                                title="Edit"><i class="fa-solid fa-pencil-alt"></i></a>
                            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST"
                                onsubmit="return confirm('Anda yakin ingin menghapus artikel ini?');"
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
                    <td colspan="4" class="text-center p-4">Belum ada artikel yang ditulis.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($posts->hasPages())
    <div class="admin-card-footer">
        {{ $posts->links('vendor.pagination.semantic-ui') }}
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

    /* Status Badges */
    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-weight: 600;
        font-size: 0.8rem;
    }

    .status-published {
        background-color: #c8e6c9;
        color: #155724;
    }

    .status-scheduled {
        background-color: #bbdefb;
        color: #0d47a1;
    }

    .status-draft {
        background-color: #e2e3e5;
        color: #383d41;
    }

    .admin-card-footer {
        padding: 15px 20px;
        border-top: 1px solid var(--border-color);
    }

    .text-center {
        text-align: center;
    }

    .p-4 {
        padding: 1.5rem;
    }

    /* Responsive */
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