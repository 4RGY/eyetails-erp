@extends('layouts.app')

@section('title', 'Lupa Password | eyetails.co')

@section('content')

<section class="auth-page-container container">
    <div class="auth-card">
        <h1>Lupa Password</h1>
        <p class="auth-subtitle">
            Masukkan alamat email Anda dan kami akan mengirimkan link untuk mereset password Anda.
        </p>

        @if(session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
        @endif

        <form method="POST" action="{{ route('password.email') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" :value="old('email')" required autofocus />
                @error('email') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary w-full">
                    Kirim Link Reset Password
                </button>
            </div>
            <p class="auth-footer-link"><a href="{{ route('login') }}">Kembali ke Login</a></p>
        </form>
    </div>
</section>

@endsection

{{-- Menggunakan CSS yang sama --}}
@push('styles')
<style>
    .auth-page-container {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 4rem 0;
        min-height: 80vh;
    }

    .auth-card {
        width: 100%;
        max-width: 450px;
        background-color: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 2.5rem;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    }

    .auth-card h1 {
        text-align: center;
        font-size: 1.8rem;
        margin-bottom: 0.5rem;
    }

    .auth-subtitle {
        text-align: center;
        color: #6c757d;
        margin-bottom: 2.5rem;
    }

    .auth-form .form-group {
        margin-bottom: 1.5rem;
    }

    .auth-form label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .auth-form input[type="email"] {
        width: 100%;
        padding: 0.8rem 1rem;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 1rem;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .auth-form input:focus {
        outline: 0;
        border-color: var(--primary-accent, #4f46e5);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .auth-form .form-actions {
        margin-top: 2rem;
    }

    .auth-form .w-full {
        width: 100%;
    }

    .auth-footer-link {
        margin-top: 1.5rem;
        text-align: center;
        font-size: 0.9rem;
    }

    .auth-footer-link a {
        color: var(--primary-accent, #4f46e5);
        font-weight: 600;
        text-decoration: none;
    }

    .error-message {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }
</style>
@endpush