@extends('admin.layouts.app')

@section('title', 'Inbox Pesan Pelanggan')

@section('content')
<header class="admin-content-header">
    <h1>Inbox Pesan Pelanggan</h1>
    <p>Lihat dan balas semua percakapan dari pelanggan.</p>
</header>

<div class="admin-card">
    <div class="admin-card-header">
        <h2>Daftar Percakapan</h2>
    </div>

    <div class="admin-table-container">
        <table class="admin-table modern-table">
            <thead>
                <tr>
                    <th>Pelanggan</th>
                    <th>Subjek / Produk</th>
                    <th>Balasan Terakhir</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($conversations as $conversation)
                <tr class="{{ !$conversation->is_read_by_admin ? 'unread-row' : '' }}">
                    <td data-label="Pelanggan">
                        <strong>{{ $conversation->user->name }}</strong><br>
                        <small>{{ $conversation->user->email }}</small>
                    </td>
                    <td data-label="Subjek">{{ $conversation->subject }}</td>
                    <td data-label="Terakhir Dibalas">{{ $conversation->last_reply_at->diffForHumans() }}</td>
                    <td data-label="Status">
                        @if(!$conversation->is_read_by_admin)
                        <span class="status-badge status-new">Baru</span>
                        @else
                        <span class="status-badge status-read">Sudah Dibaca</span>
                        @endif
                    </td>
                    <td data-label="Aksi">
                        <a href="{{ route('admin.chat.show', $conversation) }}" class="btn-action btn-view"
                            title="Lihat & Balas">
                            <i class="fa-solid fa-reply"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center p-4">Tidak ada percakapan.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($conversations->hasPages())
    <div class="admin-card-footer">
        {{ $conversations->links() }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
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

    .unread-row {
        background-color: #f0f9ff;
        font-weight: 600;
    }

    .status-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.8rem;
    }

    .status-new {
        background-color: #ffe4e6;
        color: #be123c;
    }

    .status-read {
        background-color: #f3f4f6;
        color: #4b5563;
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