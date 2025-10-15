@extends('layouts.app')

@section('title', 'Login Akun | eyetails.co')

@section('content')

<section class="auth-page-container container">
    <div class="auth-card">
        <h1>LOGIN</h1>
        <p class="auth-subtitle">Masukkan detail Anda untuk mengakses Akun Loyalitas.</p>
        

        @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
        @endif
        {{-- Menampilkan error dari Socialite Controller --}}
        @if (session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        @error('email')
        <div class="alert alert-error">Email atau password yang Anda masukkan salah.</div>
        @enderror

        <form method="POST" action="{{ route('login') }}" class="auth-form">
            @csrf

            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus
                    autocomplete="username">
            </div>

            <div class="form-group">
                <label for="password">Kata Sandi</label>
                <input id="password" type="password" name="password" required autocomplete="current-password">
            </div>

            <div class="auth-options">
                <label for="remember_me" class="remember-me">
                    <input id="remember_me" type="checkbox" name="remember">
                    <span>Ingat Saya</span>
                </label>

                @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}">
                    Lupa Kata Sandi?
                </a>
                @endif
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary w-full">
                    MASUK
                </button>
            </div>
        </form>

        {{-- ======================================================= --}}
        {{-- BAGIAN BARU UNTUK LOGIN DENGAN MEDIA SOSIAL --}}
        {{-- ======================================================= --}}
        <div class="social-login-divider">
            <span>ATAU LANJUTKAN DENGAN</span>
        </div>

        <a href="{{ route('google.redirect') }}" class="btn btn-social-login">
            <i class="fab fa-google"></i> Login dengan Google
        </a>
        {{-- ======================================================= --}}

        <p class="auth-footer-link">Belum punya akun? <a href="{{ route('register') }}">Daftar Sekarang</a></p>

    </div>
</section>

@endsection

{{-- Menggunakan CSS yang sama dengan halaman Register + tambahan --}}
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

    .auth-form input[type="text"],
    .auth-form input[type="email"],
    .auth-form input[type="password"] {
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

    .auth-footer-link a:hover {
        text-decoration: underline;
    }

    .error-message {
        color: #dc3545;
        font-size: 0.85rem;
        margin-top: 0.25rem;
    }

    .auth-options {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.9rem;
    }

    .auth-options .remember-me {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        color: #6c757d;
    }

    .auth-options a {
        color: var(--primary-accent, #4f46e5);
        font-weight: 500;
        text-decoration: none;
    }

    .auth-options a:hover {
        text-decoration: underline;
    }

    /* === CSS BARU UNTUK TOMBOL GOOGLE === */
    .social-login-divider {
        display: flex;
        align-items: center;
        text-align: center;
        color: #ccc;
        margin: 1.5rem 0;
    }

    .social-login-divider::before,
    .social-login-divider::after {
        content: '';
        flex: 1;
        border-bottom: 1px solid #eee;
    }

    .social-login-divider span {
        padding: 0 1rem;
        font-size: 0.8rem;
        font-weight: 500;
    }

    .btn-social-login {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 0.8rem 1rem;
        border: 1px solid #ccc;
        border-radius: 6px;
        background-color: #fff;
        color: #333;
        font-weight: 600;
        text-decoration: none;
        transition: background-color 0.2s;
        margin-bottom: 1.5rem;
    }

    .btn-social-login:hover {
        background-color: #f8f9fa;
    }

    .btn-social-login i {
        font-size: 1.2rem;
        margin-right: 0.75rem;
        color: #DB4437;
        /* Warna khas Google */
    }
</style>
@endpush