@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')

@section('content')
<header class="admin-content-header">
    <h1>Pengaturan Website</h1>
    <p>Kelola konfigurasi dasar dan informasi kontak toko Anda.</p>
</header>

@if(session('success'))
<div class="alert alert-success">
    <i class="fa-solid fa-check-circle"></i> {{ session('success') }}
</div>
@endif
@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

{{-- Satu form utama untuk menyimpan semua perubahan --}}
<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data" class="settings-form">
    @csrf
    @method('PUT')

    <div class="settings-layout">
        {{-- KOLOM KIRI --}}
        <div class="left-column">
            {{-- Pengaturan Umum --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3>Pengaturan Umum</h3>
                </div>
                <div class="admin-card-content">
                    <div class="form-group">
                        <label for="site_name">Nama Website/Toko</label>
                        <input type="text" name="site_name" id="site_name" class="form-control"
                            value="{{ old('site_name', $settings['site_name']) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="site_description">Deskripsi Singkat</label>
                        <textarea name="site_description" id="site_description" rows="3" class="form-control"
                            required>{{ old('site_description', $settings['site_description']) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- Informasi Kontak --}}
            <div class="admin-card mt-4">
                <div class="admin-card-header">
                    <h3>Informasi Kontak</h3>
                </div>
                <div class="admin-card-content">
                    <div class="form-group">
                        <label for="default_email">Email Layanan Pelanggan</label>
                        <input type="email" name="default_email" id="default_email" class="form-control"
                            value="{{ old('default_email', $settings['default_email']) }}" required>
                    </div>
                    <div class="form-group">
                        <label for="default_phone">Nomor Telepon/WhatsApp</label>
                        <input type="text" name="default_phone" id="default_phone" class="form-control"
                            value="{{ old('default_phone', $settings['default_phone']) }}">
                    </div>
                    <div class="form-group">
                        <label for="address">Alamat Pusat/Kantor</label>
                        <textarea name="address" id="address" rows="3"
                            class="form-control">{{ old('address', $settings['address']) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN --}}
        <div class="right-column">
            {{-- Logo Website (Hanya Tampilan) --}}
            <div class="admin-card">
                <div class="admin-card-header">
                    <h3>Logo Website</h3>
                </div>
                <div class="admin-card-content">
                    <h1 class="form-text" style="margin-top: 10px;">eyetails.co</h1>
                </div>
            </div>

            {{-- Favicon --}}
            <div class="admin-card mt-4">
                <div class="admin-card-header">
                    <h3>Favicon</h3>
                </div>
                <div class="admin-card-content">
                    <img src="{{ $settings['favicon_path'] ? asset('storage/' . $settings['favicon_path']) : 'https://via.placeholder.com/32x32/111/fff?text=E' }}"
                        alt="Favicon Saat Ini" class="favicon-preview">

                    @if($settings['favicon_path'])
                    <a href="{{ route('admin.settings.remove', 'favicon_path') }}" class="btn btn-danger btn-sm"
                        onclick="return confirm('Anda yakin ingin menghapus favicon?');"
                        style="margin-top: 10px; display: inline-block;">Hapus Favicon</a>
                    @endif

                    <div class="form-group mt-3">
                        <label for="favicon_file">Ganti Favicon (.ico/.png)</label>
                        <input type="file" name="favicon_file" id="favicon_file" class="form-control-file">
                        <small class="form-text">Ukuran harus 16x16px atau 32x32px.</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Tombol Simpan untuk form utama --}}
    <div class="form-submit-fixed">
        <button type="submit" class="btn btn-primary btn-large">SIMPAN SEMUA PENGATURAN</button>
    </div>
</form>

@endsection

@push('styles')
<style>
    .btn-sm {
        padding: 5px 10px;
        font-size: 0.8rem;
    }

    .btn-danger {
        background-color: #dc3545;
        color: white;
        border: none;
        cursor: pointer;
        text-decoration: none;
        border-radius: 4px;
    }

    .settings-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 2rem;
        align-items: flex-start;
    }

    .left-column,
    .right-column {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }

    .admin-card-content {
        padding: 1.5rem;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .form-control,
    .form-control-file {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        font-size: 1rem;
        box-sizing: border-box;
    }

    .logo-preview {
        max-width: 200px;
        border: 1px solid #eee;
        padding: 10px;
        border-radius: 4px;
    }

    .favicon-preview {
        width: 32px;
        height: 32px;
        border: 1px solid #eee;
        padding: 4px;
        border-radius: 4px;
    }

    .form-submit-fixed {
        position: sticky;
        bottom: 0;
        background: rgba(255, 255, 255, 0.95);
        padding: 1rem 20px;
        border-top: 1px solid #e5e7eb;
        z-index: 999;
        margin-top: 2rem;
        text-align: right;
    }

    .btn-large {
        padding: 12px 30px;
        font-size: 1rem;
    }

    @media (max-width: 992px) {
        .settings-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush