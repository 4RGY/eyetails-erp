@extends('akun.master')

@section('title', 'Pesan Saya | eyetails.co')

@section('account-content')
<div class="chat-container">
    <div class="header">
        <h2 class="dashboard-title"><i class="far fa-comments"></i> Pesan Saya</h2>
        <p class="text-gray-600">Daftar semua percakapan Anda dengan admin.</p>
    </div>

    <div class="conversations-list">
        @forelse ($conversations as $conversation)
        <a href="{{ route('chat.show', $conversation) }}"
            class="conversation-item {{ !$conversation->is_read_by_user && $conversation->messages->last()->user_id != Auth::id() ? 'unread' : '' }}">
            <div class="item-product-info">
                @if($conversation->product && $conversation->product->image)
                <img src="{{ asset('storage/' . $conversation->product->image) }}"
                    alt="{{ $conversation->product->name }}">
                @else
                <img src="https://via.placeholder.com/60x80" alt="Produk">
                @endif
                <div>
                    <strong>{{ $conversation->subject }}</strong>
                    <p>Terakhir dibalas: {{ $conversation->last_reply_at->format('d M Y, H:i') }}</p>
                </div>
            </div>
            <i class="fas fa-chevron-right"></i>
        </a>
        @empty
        <div class="no-results-container">
            <h3>Anda belum memulai percakapan.</h3>
            <p>Punya pertanyaan tentang produk? Buka halaman produk dan klik tombol "Tanya Admin".</p>
        </div>
        @endforelse
    </div>

    @if($conversations->hasPages())
    <div class="pagination-area">
        {{ $conversations->links() }}
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .header {
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
        margin-bottom: 2rem;
    }

    .conversations-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .conversation-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem;
        background: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .conversation-item:hover {
        transform: translateY(-3px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.07);
    }

    .conversation-item.unread {
        border-left: 4px solid var(--primary-accent, #4f46e5);
    }

    .item-product-info {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .item-product-info img {
        width: 60px;
        border-radius: 4px;
    }

    .item-product-info strong {
        font-size: 1.1rem;
    }

    .item-product-info p {
        margin: 0;
        color: #6c757d;
        font-size: 0.9rem;
    }

    .no-results-container {
        text-align: center;
        padding: 3rem 0;
    }
</style>
@endpush