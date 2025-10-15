@extends('layouts.app')

@section('title', 'Ajukan Pengembalian | eyetails.co')

@section('content')

<section class="container">
    <div class="return-form-card">
        <div class="product-info-header">
            <img src="https://via.placeholder.com/100x120/F0F0F0?text=Produk" alt="{{ $item->product_name }}">
            <div>
                <p class="text-gray-600">Anda mengajukan pengembalian untuk:</p>
                <h2>{{ $item->product_name }}</h2>
                <p class="text-gray-500">Dari Pesanan #{{ $item->order_id }}</p>
            </div>
        </div>

        {{-- PERUBAHAN: Tambahkan enctype untuk upload file --}}
        <form action="{{ route('returns.store') }}" method="POST" class="auth-form" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="order_item_id" value="{{ $item->id }}">

            <div class="form-group mt-4">
                <label for="type">Jenis Permintaan</label>
                <select name="type" id="type" class="form-control" required>
                    <option value="">Pilih Jenis Permintaan</option>
                    <option value="Return" {{ old('type')=='Return' ? 'selected' : '' }}>Pengembalian Dana (Return)
                    </option>
                    <option value="Exchange" {{ old('type')=='Exchange' ? 'selected' : '' }}>Tukar Barang (Exchange)
                    </option>
                </select>
                @error('type') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            <div class="form-group mt-4">
                <label for="reason">Alasan Anda</label>
                <textarea id="reason" name="reason" rows="5" class="form-control"
                    placeholder="Contoh: Ukuran tidak sesuai, barang yang diterima rusak, dll."
                    required>{{ old('reason') }}</textarea>
                @error('reason') <span class="error-message">{{ $message }}</span> @enderror
            </div>

            {{-- FORM BARU UNTUK UPLOAD BUKTI --}}
            <div class="form-group mt-4">
                <label for="attachment">Lampirkan Bukti (Opsional)</label>
                <input type="file" name="attachment" id="attachment" class="form-control">
                <small class="form-text text-muted">Format: JPG, PNG, MP4, MOV. Maksimal 2MB.</small>
                @error('attachment') <span class="error-message">{{ $message }}</span> @enderror
            </div>


            <button type="submit" class="btn btn-primary w-full mt-4">AJUKAN PERMINTAAN</button>
            <a href="{{ route('order.tracking', $item->order_id) }}" class="btn btn-outline w-full mt-2">Batal</a>
        </form>
    </div>
</section>

{{-- Mirip dengan form review --}}
<style>
    .return-form-card {
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        padding: 40px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        max-width: 700px;
        margin: 40px auto;
    }

    .product-info-header {
        display: flex;
        align-items: center;
        gap: 20px;
        padding-bottom: 20px;
        margin-bottom: 20px;
        border-bottom: 1px solid #eee;
    }

    .product-info-header img {
        border-radius: 4px;
    }

    .product-info-header h2 {
        margin: 0;
    }

    .form-control {
        width: 100%;
        box-sizing: border-box;
    }

    .w-full {
        width: 100%;
        text-align: center;
    }

    .mt-2 {
        margin-top: 0.5rem;
    }

    .form-text {
        font-size: 0.85rem;
        color: #6c757d;
    }
</style>

@endsection