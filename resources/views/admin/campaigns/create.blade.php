@extends('admin.layouts.app')

@section('title', 'Kirim Email Promo')

@section('content')
<header class="admin-content-header">
    <h1>Kirim Email Promosi</h1>
    <p>Buat dan kirim email marketing ke semua pelanggan yang setuju menerima notifikasi.</p>
</header>

<div class="admin-card">
    <div class="admin-card-body">

        @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="alert alert-info">
            Email ini akan dikirimkan ke <strong>{{ $subscriberCount }}</strong> pelanggan.
        </div>

        <form action="{{ route('admin.campaigns.send') }}" method="POST" class="admin-form">
            @csrf
            <div class="form-group">
                <label for="subject">Subjek Email</label>
                <input type="text" name="subject" id="subject" class="form-control" value="{{ old('subject') }}"
                    required>
            </div>

            <div class="form-group">
                <label for="content">Isi Email</label>
                <textarea name="content" id="content" rows="12" class="form-control"
                    required>{{ old('content') }}</textarea>
                <small class="form-text text-muted">Anda bisa menggunakan baris baru, email akan diformat secara
                    otomatis.</small>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary"
                    onclick="return confirm('Anda yakin ingin mengirim email ini ke {{ $subscriberCount }} pelanggan?')">
                    <i class="fa-solid fa-paper-plane"></i> Kirim Sekarang
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 6px;
        font-weight: 500;
    }

    .alert-success {
        background-color: #e6f9f0;
        color: #00874e;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
    }

    .alert-info {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .admin-form .form-group {
        margin-bottom: 25px;
    }

    .admin-form label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: .9rem;
    }

    .admin-form .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
    }

    .form-text {
        font-size: .85rem;
        color: #6c757d;
        margin-top: 5px;
    }

    .form-actions {
        margin-top: 15px;
    }

    .btn-primary {
        background-color: var(--primary-accent);
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
</style>
@endpush