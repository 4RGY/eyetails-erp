@extends('akun.master')

@section('title', 'Pengaturan Akun | eyetails.co')

@section('account-content')

<div class="profile-settings-layout">
    {{-- Update Profile Information --}}
    <div class="profile-card">
        @include('profile.partials.update-profile-information-form')
    </div>

    {{-- CARD BARU UNTUK NOTIFIKASI --}}
    <div class="profile-card">
        @include('profile.partials.update-notifications-form')
    </div>

    {{-- Update Password --}}
    <div class="profile-card">
        @include('profile.partials.update-password-form')
    </div>

    {{-- Delete User Account --}}
    <div class="profile-card">
        @include('profile.partials.delete-user-form')
    </div>
</div>
@endsection


{{-- ======================================================= --}}
{{-- CSS LENGKAP UNTUK TAMPILAN PROFIL & TOGGLE SWITCH --}}
{{-- ======================================================= --}}
@push('styles')
<style>
    /* CSS Umum untuk Kartu dan Form */
    .profile-settings-layout {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .profile-card {
        background-color: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 2rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
    }

    .profile-header {
        font-size: 1.5rem;
        font-weight: 600;
        color: #1a1a1a;
        margin: 0;
    }

    .profile-subtitle {
        color: #6c757d;
        margin-top: 0.25rem;
        margin-bottom: 2rem;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .profile-form .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .profile-form .form-group {
        margin-bottom: 1.5rem;
    }

    .profile-form label:not(.toggle-switch) {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: 600;
        font-size: 0.9rem;
    }

    .profile-form .form-input {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #ccc;
        border-radius: 6px;
        font-size: 1rem;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .profile-form .form-input:focus {
        outline: 0;
        border-color: var(--primary-accent, #4f46e5);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .form-divider {
        border: none;
        border-top: 1px solid #eee;
        margin: 0.5rem 0 2rem 0;
    }

    .form-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    /* ==================================== */
    /* === CSS PERBAIKAN TOGGLE SWITCH === */
    /* ==================================== */
    .toggle-switch {
        position: relative;
        display: flex;
        align-items: flex-start;
        /* Ubah ke flex-start agar sejajar dari atas */
        width: 100%;
        cursor: pointer;
        -webkit-tap-highlight-color: transparent;
    }

    .toggle-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: relative;
        flex-shrink: 0;
        width: 44px;
        height: 24px;
        background-color: #ccc;
        border-radius: 34px;
        transition: .4s;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 16px;
        width: 16px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        border-radius: 50%;
        transition: .4s;
    }

    input:checked+.slider {
        background-color: var(--primary-accent, #4f46e5);
    }

    input:checked+.slider:before {
        transform: translateX(20px);
    }

    .toggle-switch-content {
        margin-left: 12px;
    }

    .label-text {
        font-weight: 600;
        color: #333;
        display: block;
    }

    .toggle-description {
        font-size: .9rem;
        color: #6c757d;
        margin-top: 0.1rem;
        /* Kurangi margin atas */
        padding-left: 0;
    }

    /* ==================================== */

    @media (max-width: 768px) {
        .profile-card {
            padding: 1.5rem;
        }

        .profile-form .form-row {
            grid-template-columns: 1fr;
            gap: 0;
        }
    }
</style>
@endpush