@extends('admin.layouts.app')

@section('title', 'Edit Metode Pembayaran')

@section('content')
<header class="admin-content-header">
    {{-- Menggunakan variabel $payment --}}
    <h1>Edit Metode Pembayaran</h1>
    <p>Perbarui detail untuk metode pembayaran "{{ $payment->name }}".</p>
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

        {{-- Menggunakan variabel $payment untuk route --}}
        <form action="{{ route('admin.payments.update', $payment) }}" method="POST" class="admin-form modern-form">
            @csrf
            @method('PUT')
            <div class="form-row">
                <div class="form-group">
                    <label for="name">Nama Metode</label>
                    <input type="text" name="name" id="name" class="form-control"
                        value="{{ old('name', $payment->name) }}" required>
                </div>
                <div class="form-group">
                    <label for="code">Kode Unik</label>
                    <input type="text" name="code" id="code" class="form-control"
                        value="{{ old('code', $payment->code) }}" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group full-width">
                    <label for="description">Deskripsi <small>(Opsional)</small></label>
                    <textarea name="description" id="description" rows="3"
                        class="form-control">{{ old('description', $payment->description) }}</textarea>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Status</label>
                    <div class="form-check">
                        <input type="hidden" name="is_active" value="0">
                        <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{
                            old('is_active', $payment->is_active) ? 'checked' : '' }}>
                        <label for="is_active" class="form-check-label">Aktifkan metode pembayaran ini</label>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Metode</button>
                <a href="{{ route('admin.payments.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection

@push('styles')
{{-- Menggunakan style yang sama dengan form create --}}
<style>
    .modern-form .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 1.5rem;
        margin-bottom: 1.5rem;
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