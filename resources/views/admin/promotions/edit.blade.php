@extends('admin.layouts.app')

@section('title', 'Edit Promo: ' . $promotion->name)

@section('content')
<header class="admin-content-header">
    <h1>Edit Promo</h1>
    <p>Perbarui detail untuk promo "{{ $promotion->name }}".</p>
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

        <form action="{{ route('admin.promotions.update', $promotion->id) }}" method="POST" class="admin-form">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nama Promo</label>
                <input type="text" name="name" id="name" class="form-control"
                    value="{{ old('name', $promotion->name) }}" required>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="code">Kode Voucher (Opsional)</label>
                    <input type="text" name="code" id="code" class="form-control"
                        value="{{ old('code', $promotion->code) }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="type">Tipe Diskon</label>
                    <select name="type" id="type" class="form-control" required>
                        <option value="percentage" {{ old('type', $promotion->type) == 'percentage' ? 'selected' : ''
                            }}>Persentase (%)</option>
                        <option value="fixed_amount" {{ old('type', $promotion->type) == 'fixed_amount' ? 'selected' :
                            '' }}>Nominal Tetap (Rp)</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="value">Nilai Diskon</label>
                    <input type="number" name="value" id="value" class="form-control"
                        value="{{ old('value', $promotion->value) }}" required>
                </div>
                <div class="form-group col-md-6" id="max-discount-group"
                    style="display: {{ old('type', $promotion->type) == 'percentage' ? 'block' : 'none' }};">
                    <label for="max_discount">Maksimal Diskon (Rp) (Opsional)</label>
                    <input type="number" name="max_discount" id="max_discount" class="form-control"
                        value="{{ old('max_discount', $promotion->max_discount) }}">
                </div>
            </div>

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="start_date">Tanggal Mulai (Opsional)</label>
                    <input type="datetime-local" name="start_date" id="start_date" class="form-control"
                        value="{{ old('start_date', $promotion->start_date?->format('Y-m-d\TH:i')) }}">
                </div>
                <div class="form-group col-md-6">
                    <label for="end_date">Tanggal Selesai (Opsional)</label>
                    <input type="datetime-local" name="end_date" id="end_date" class="form-control"
                        value="{{ old('end_date', $promotion->end_date?->format('Y-m-d\TH:i')) }}">
                </div>
            </div>

            <div class="form-group">
                <label for="usage_limit">Batas Penggunaan (Opsional)</label>
                <input type="number" name="usage_limit" id="usage_limit" class="form-control"
                    value="{{ old('usage_limit', $promotion->usage_limit) }}">
            </div>

            <div class="form-group">
                <div class="form-check">
                    <input type="hidden" name="is_active" value="0">
                    <input type="checkbox" name="is_active" id="is_active" class="form-check-input" value="1" {{
                        old('is_active', $promotion->is_active) ? 'checked' : '' }}>
                    <label for="is_active" class="form-check-label">Aktifkan Promo</label>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Update Promo</button>
                <a href="{{ route('admin.promotions.index') }}" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

{{-- === EMBEDDED CSS === --}}
<style>
    .admin-form .form-row {
        display: flex;
        flex-wrap: wrap;
        gap: 20px;
    }

    .admin-form .form-group {
        flex: 1;
        min-width: calc(50% - 10px);
        margin-bottom: 25px;
    }

    .admin-form .form-group.col-md-6 {
        flex-basis: calc(50% - 10px);
    }

    .admin-form label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        font-size: 0.9rem;
    }

    .admin-form .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 1rem;
        box-sizing: border-box;
    }

    .form-text {
        font-size: 0.85rem;
        color: #6c757d;
        margin-top: 5px;
    }

    .form-actions {
        margin-top: 15px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
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

    .btn-primary {
        background-color: var(--primary-accent);
        color: white;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .alert-danger {
        background-color: #f8d7da;
        color: #721c24;
        padding: 1rem;
        border: 1px solid #f5c6cb;
        border-radius: .25rem;
        margin-bottom: 1rem;
    }

    .form-check {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .form-check-input {
        width: 1.2rem;
        height: 1.2rem;
    }

    .form-check-label {
        margin-bottom: 0;
        font-weight: normal;
    }

    @media (max-width: 768px) {

        .admin-form .form-group,
        .admin-form .form-group.col-md-6 {
            min-width: 100%;
        }
    }
</style>

@push('scripts')
<script>
    document.getElementById('type').addEventListener('change', function () {
        var maxDiscountGroup = document.getElementById('max-discount-group');
        if (this.value === 'percentage') {
            maxDiscountGroup.style.display = 'block';
        } else {
            maxDiscountGroup.style.display = 'none';
        }
    });
</script>
@endpush
@endsection