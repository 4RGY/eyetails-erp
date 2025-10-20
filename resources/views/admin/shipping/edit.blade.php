@extends('admin.layouts.app')

@section('title', 'Edit Metode Pengiriman')

@section('content')
<header class="admin-content-header">
    <h1>Edit Metode Pengiriman</h1>
    <p>Perbarui detail untuk metode pengiriman "{{ $shippingOption->name }}".</p>
</header>

<div class="admin-card">
    <div class="admin-card-body">
        @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Whoops!</strong> Ada beberapa masalah dengan input Anda.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        {{-- KESALAHAN ADA DI BARIS INI, CLASS SEHARUSNYA DI DALAM TAG FORM --}}
        <form action="{{ route('admin.shipping.update', $shippingOption->id) }}" method="POST"
            class="admin-form modern-form">
            @csrf
            @method('PUT') {{-- Method PUT untuk proses update --}}

            <div class="form-row">
                <div class="form-group">
                    <label for="name">Nama Layanan</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', $shippingOption->name) }}" required>
                </div>
                <div class="form-group">
                    <label for="cost">Biaya (Rp)</label>
                    <input type="number" name="cost" id="cost" class="form-control"
                        value="{{ old('cost', $shippingOption->cost) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group full-width">
                    <label for="description">Deskripsi <small>(Opsional)</small></label>
                    <textarea name="description" id="description" rows="3"
                        class="form-control">{{ old('description', $shippingOption->description) }}</textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Status</label>
                    <div class="form-check">
                        {{-- Hidden input untuk memastikan nilai 0 dikirim jika checkbox tidak dicentang --}}
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{
                            old('is_active', $shippingOption->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Aktifkan metode pengiriman ini</label>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Metode</button>
                <a href="{{ route('admin.shipping.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Menggunakan style yang sama dengan form create untuk konsistensi */
    .modern-form .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .modern-form .form-group {
        margin-bottom: 0;
    }

    .modern-form .form-group.full-width {
        grid-column: 1 / -1;
    }

    .modern-form label:not(.form-check-label) {
        display: block;
        font-weight: 600;
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
        color: #374151;
    }

    .modern-form .form-control {
        width: 100%;
        padding: 0.75rem 1rem;
        border: 1px solid #d1d5db;
        border-radius: 6px;
        font-size: 1rem;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .modern-form .form-control:focus {
        outline: 0;
        border-color: var(--primary-accent, #4f46e5);
        box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 10px;
        padding-top: 0.5rem;
    }

    .form-check-input {
        width: 1.2rem;
        height: 1.2rem;
    }

    .form-check-label {
        font-weight: normal !important;
        margin-bottom: 0 !important;
    }

    .form-actions {
        margin-top: 2rem;
        padding-top: 1.5rem;
        border-top: 1px solid #e5e7eb;
        display: flex;
        gap: 0.75rem;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 5px;
        text-transform: uppercase;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
    }

    .btn-secondary {
        background-color: #e5e7eb;
        color: #374151;
    }

    .btn-secondary:hover {
        background-color: #d1d5db;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        padding: 1rem;
        border: 1px solid #f5c6cb;
        border-radius: .25rem;
        margin-bottom: 1rem;
    }
</style>
@endpush