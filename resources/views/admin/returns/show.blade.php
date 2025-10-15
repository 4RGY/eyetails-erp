@extends('admin.layouts.app')

@section('title', 'Detail Permintaan Pengembalian #' . $returnRequest->id)

@section('content')
<header class="admin-content-header">
    <a href="{{ route('admin.returns.index') }}" class="back-link">
        <i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar Permintaan
    </a>
    <h1>Detail Permintaan #{{ $returnRequest->id }}</h1>
    <p>Tinjau dan proses permintaan pengembalian atau penukaran barang.</p>
</header>

@if(session('success'))
<div class="alert alert-success">
    <i class="fa-solid fa-check-circle"></i>
    {{ session('success') }}
</div>
@endif

<div class="return-detail-layout">
    {{-- Kolom Kiri: Detail Permintaan & Bukti --}}
    <div class="main-column">
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Detail Permintaan</h3>
            </div>
            <div class="info-grid">
                <div class="info-item">
                    <span class="info-label">ID Pesanan</span>
                    {{-- PERBAIKAN FINAL: Kirim seluruh objek $returnRequest->order --}}
                    @if($returnRequest->order)
                    <span class="info-value"><a href="{{ route('admin.orders.show', $returnRequest->order) }}">#{{
                            $returnRequest->order_id }}</a></span>
                    @else
                    <span class="info-value">#{{ $returnRequest->order_id }} (Data Pesanan Tidak Ditemukan)</span>
                    @endif
                </div>
                <div class="info-item">
                    <span class="info-label">Pelanggan</span>
                    {{-- PERBAIKAN FINAL: Kirim seluruh objek $returnRequest->user --}}
                    @if($returnRequest->user)
                    <span class="info-value"><a href="{{ route('admin.users.show', $returnRequest->user) }}">{{
                            $returnRequest->user->name }}</a></span>
                    @else
                    <span class="info-value">(Data Pengguna Tidak Ditemukan)</span>
                    @endif
                </div>
                <div class="info-item">
                    <span class="info-label">Produk</span>
                    <span class="info-value">{{ $returnRequest->orderItem->product_name ?? 'N/A' }}</span>
                </div>
                <div class="info-item">
                    <span class="info-label">Tipe Permintaan</span>
                    <span class="info-value">{{ $returnRequest->type }}</span>
                </div>
                <div class="info-item full-width">
                    <span class="info-label">Alasan Pelanggan</span>
                    <p class="reason-text">{{ $returnRequest->reason }}</p>
                </div>
            </div>
        </div>

        @if($returnRequest->attachment_path)
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Bukti dari Pelanggan</h3>
            </div>
            <div class="admin-card-body">
                @php
                $extension = pathinfo($returnRequest->attachment_path, PATHINFO_EXTENSION);
                @endphp
                @if(in_array($extension, ['jpg', 'jpeg', 'png', 'gif']))
                <a href="{{ asset('storage/' . $returnRequest->attachment_path) }}" target="_blank">
                    <img src="{{ asset('storage/' . $returnRequest->attachment_path) }}" alt="Bukti Pengembalian"
                        style="max-width: 100%; border-radius: 6px;">
                </a>
                @elseif(in_array($extension, ['mp4', 'mov']))
                <video controls width="100%" style="border-radius: 6px;">
                    <source src="{{ asset('storage/' . $returnRequest->attachment_path) }}"
                        type="video/{{ $extension }}">
                    Browser Anda tidak mendukung pemutar video.
                </video>
                @else
                <a href="{{ asset('storage/' . $returnRequest->attachment_path) }}" target="_blank"
                    class="btn btn-secondary">Lihat Lampiran</a>
                @endif
            </div>
        </div>
        @endif
    </div>


    {{-- Kolom Kanan: Aksi Admin --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h3>Tindakan Admin</h3>
        </div>
        <div class="admin-card-body">
            <form action="{{ route('admin.returns.update', $returnRequest->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="status">Ubah Status Permintaan</label>
                    <select name="status" id="status" class="form-control">
                        <option value="Pending" @selected($returnRequest->status == 'Pending')>Menunggu Persetujuan
                        </option>
                        <option value="Approved" @selected($returnRequest->status == 'Approved')>Disetujui</option>
                        <option value="Rejected" @selected($returnRequest->status == 'Rejected')>Ditolak</option>
                        <option value="Processing" @selected($returnRequest->status == 'Processing')>Sedang Diproses
                        </option>
                        <option value="Completed" @selected($returnRequest->status == 'Completed')>Selesai</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="admin_notes">Catatan untuk Pelanggan (Opsional)</label>
                    <textarea name="admin_notes" id="admin_notes" rows="4" class="form-control"
                        placeholder="Contoh: Silakan kirim barang ke alamat gudang kami...">{{ old('admin_notes', $returnRequest->admin_notes) }}</textarea>
                </div>
                <button type="submit" class="btn btn-primary w-full">Update Permintaan</button>
            </form>
        </div>
    </div>
</div>

<style>
    .back-link {
        color: var(--primary-accent);
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 1rem;
        display: inline-block;
    }

    .return-detail-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        align-items: flex-start;
    }

    .main-column {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .info-grid {
        padding: 15px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-label {
        font-size: 0.8rem;
        color: #6c757d;
    }

    .info-value {
        font-weight: 600;
    }

    .info-value a {
        text-decoration: none;
        color: var(--primary-accent);
    }

    .full-width {
        grid-column: 1 / -1;
    }

    .reason-text {
        background-color: #f8f9fa;
        border-left: 3px solid var(--primary-accent);
        padding: 10px;
        margin: 0;
    }

    .admin-card-body {
        padding: 15px;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group label {
        font-weight: 600;
        font-size: 0.9rem;
        display: block;
        margin-bottom: 5px;
    }

    .form-control {
        width: 100%;
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
        box-sizing: border-box;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: 600;
        border: none;
        cursor: pointer;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }

    .btn-primary {
        background-color: var(--primary-accent);
        color: white;
        margin-top: 10px;
    }

    .btn-secondary {
        background-color: #6c757d;
        color: white;
    }

    .w-full {
        width: 100%;
    }

    .alert {
        padding: 1rem;
        margin-bottom: 1rem;
        border-radius: 6px;
        display: flex;
        align-items: center;
        gap: 10px;
        font-weight: 500;
    }

    .alert-success {
        background-color: #e6f9f0;
        color: #00874e;
        border: 1px solid #b3e6d1;
    }
</style>
@endsection