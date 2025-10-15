@extends('akun.master')

@section('title', 'Percakapan | eyetails.co')

@section('account-content')
<div class="chat-container">
    <div class="header">
        <a href="{{ route('chat.index') }}" class="back-link mb-2"><i class="fas fa-arrow-left"></i> Kembali ke
            Inbox</a>
        <h2 class="dashboard-title">{{ $conversation->subject }}</h2>
        @if($conversation->product)
        <p>Terkait produk: <a href="{{ route('catalog.show', $conversation->product) }}" class="text-link">{{
                $conversation->product->name }}</a></p>
        @endif
    </div>

    <div class="chat-box" id="chat-box">
        @foreach ($conversation->messages as $message)
        <div class="message-bubble {{ $message->user_id === Auth::id() ? 'sent' : 'received' }}">
            <div class="message-content">
                <p>{{ $message->body }}</p>
            </div>
            <small class="message-timestamp">{{ $message->created_at->format('d M, H:i') }}</small>
        </div>
        @endforeach
    </div>

    <div class="reply-form">
        <form action="{{ route('chat.send', $conversation) }}" method="POST">
            @csrf
            <textarea name="body" rows="4" placeholder="Tulis balasan Anda di sini..." required></textarea>
            <button type="submit" class="btn btn-primary">Kirim Balasan</button>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .back-link {
        font-weight: 600;
        text-decoration: none;
        color: var(--primary-accent);
    }

    .text-link {
        text-decoration: underline;
    }

    .chat-box {
        height: 500px;
        overflow-y: auto;
        padding: 1.5rem;
        background: #f8f9fa;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }

    .message-bubble {
        max-width: 75%;
        padding: 0.75rem 1rem;
        border-radius: 18px;
        line-height: 1.5;
    }

    .message-bubble p {
        margin: 0;
    }

    .message-bubble.sent {
        background-color: var(--primary-accent, #4f46e5);
        color: white;
        border-bottom-right-radius: 4px;
        align-self: flex-end;
    }

    .message-bubble.received {
        background-color: #fff;
        border: 1px solid #e9ecef;
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

    .reply-form {
        margin-top: 1.5rem;
    }

    .reply-form textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 1rem;
        border: 1px solid #ccc;
        border-radius: 6px;
        resize: vertical;
        margin-bottom: 1rem;
    }

    .reply-form button {
        width: 100%;
    }
</style>
@endpush

@push('scripts')
<script>
    // Auto-scroll ke pesan terakhir
    const chatBox = document.getElementById('chat-box');
    chatBox.scrollTop = chatBox.scrollHeight;
</script>
@endpush