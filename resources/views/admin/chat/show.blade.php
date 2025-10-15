@extends('admin.layouts.app')

@section('title', 'Balas Pesan')

@section('content')
<header class="admin-content-header">
    <a href="{{ route('admin.chat.index') }}" class="back-link"><i class="fa-solid fa-arrow-left"></i> Kembali ke
        Inbox</a>
    <h1>Percakapan dengan {{ $conversation->user->name }}</h1>
    @if($conversation->product)
    <p>Terkait produk: <a href="{{ route('catalog.show', $conversation->product) }}" target="_blank">{{
            $conversation->product->name }}</a></p>
    @endif
</header>

<div class="crm-detail-layout">
    {{-- Kolom Kiri: Chat Box --}}
    <div class="main-column">
        <div class="admin-card">
            <div class="chat-box" id="chat-box">
                @foreach ($conversation->messages as $message)
                <div class="message-bubble {{ $message->user->is_admin ? 'sent' : 'received' }}">
                    <div class="message-header">
                        <strong>{{ $message->user->is_admin ? 'Anda' : $message->user->name }}</strong>
                    </div>
                    <div class="message-content">
                        <p>{{ $message->body }}</p>
                    </div>
                    <small class="message-timestamp">{{ $message->created_at->format('d M, H:i') }}</small>
                </div>
                @endforeach
            </div>
            <div class="admin-card-footer">
                <form action="{{ route('admin.chat.send', $conversation) }}" method="POST">
                    @csrf
                    <textarea name="body" rows="4" class="form-control" placeholder="Tulis balasan Anda di sini..."
                        required></textarea>
                    <button type="submit" class="btn btn-primary mt-2">Kirim Balasan</button>
                </form>
            </div>
        </div>
    </div>
    {{-- Kolom Kanan: Info Pelanggan --}}
    <div class="side-column">
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Profil Pelanggan</h3>
            </div>
            <div class="admin-card-body">
                <p><strong>Nama:</strong> {{ $conversation->user->name }}</p>
                <p><strong>Email:</strong> {{ $conversation->user->email }}</p>
                <p><strong>Tier:</strong> {{ $conversation->user->tier }}</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .back-link {
        font-weight: 600;
        text-decoration: none;
        color: var(--primary-accent);
        margin-bottom: 1rem;
        display: inline-block;
    }

    .crm-detail-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        align-items: flex-start;
    }

    .chat-box {
        height: 60vh;
        overflow-y: auto;
        padding: 1.5rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .message-bubble {
        max-width: 80%;
        padding: 0.75rem 1rem;
        border-radius: 18px;
        line-height: 1.5;
    }

    .message-header {
        font-size: 0.8rem;
        margin-bottom: 4px;
        color: #666;
    }

    .message-bubble.sent .message-header {
        color: rgba(255, 255, 255, 0.8);
    }

    .message-bubble p {
        margin: 0;
    }

    .message-bubble.sent {
        background-color: #374151;
        color: white;
        border-bottom-right-radius: 4px;
        align-self: flex-end;
    }

    .message-bubble.received {
        background-color: #f3f4f6;
        border: 1px solid #e5e7eb;
        border-bottom-left-radius: 4px;
        align-self: flex-start;
    }

    .message-timestamp {
        font-size: 0.75rem;
        color: #999;
        margin-top: 5px;
        display: block;
    }

    .message-bubble.sent .message-timestamp {
        text-align: right;
        color: rgba(255, 255, 255, 0.7);
    }

    .admin-card-footer {
        padding: 1.5rem;
        border-top: 1px solid #eee;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
        padding: 1rem;
        border: 1px solid #ccc;
        border-radius: 6px;
        resize: vertical;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-primary {
        background-color: var(--primary-accent);
        color: white;
        width: 100%;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
        width: 100%;
        margin-top: 1rem;
    }

    .mt-2 {
        margin-top: 0.5rem;
    }
</style>
@endpush

@push('scripts')
<script>
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endpush