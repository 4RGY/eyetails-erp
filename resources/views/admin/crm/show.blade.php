@extends('admin.layouts.app')

@section('title', 'Detail Pelanggan: ' . $customer->name)

@section('content')
<header class="admin-content-header">
    <a href="{{ route('admin.crm.index') }}" class="back-link"><i class="fa-solid fa-arrow-left"></i> Kembali ke Daftar
        Pelanggan</a>
    <h1>Profil Pelanggan</h1>
    <p>Detail lengkap, riwayat, dan interaksi untuk <strong>{{ $customer->name }}</strong>.</p>
</header>

@if(session('success'))
<div class="alert alert-success">{{ session('success') }}</div>
@endif

<div class="crm-detail-layout">
    {{-- Kolom Kiri: Profil & Aksi --}}
    <div class="left-column">
        {{-- Card Profil --}}
        <div class="admin-card">
            <div class="admin-card-body text-center">
                <i class="fa-solid fa-user-circle" style="font-size: 80px; color: #ccc;"></i>
                <h2 style="margin: 10px 0 5px 0;">{{ $customer->name }}</h2>
                <p style="margin: 0; color: #666;">{{ $customer->email }}</p>
            </div>
            <div class="info-grid">
                <div class="info-item"><span>Tier</span><strong>{{ $customer->tier }}</strong></div>
                <div class="info-item"><span>Poin</span><strong>{{ $customer->loyalty_points }}</strong></div>
                <div class="info-item"><span>Status</span><strong>{{ $customer->status }}</strong></div>
                <div class="info-item"><span>Bergabung</span><strong>{{ $customer->created_at->format('d M Y')
                        }}</strong></div>
            </div>
        </div>

        {{-- Card Update Status --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Update Status Pelanggan</h3>
            </div>
            <div class="admin-card-body">
                <form action="{{ route('admin.crm.status.update', $customer) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="form-group">
                        <select name="status" class="form-control">
                            <option value="Lead" @selected($customer->status == 'Lead')>Lead</option>
                            <option value="Customer" @selected($customer->status == 'Customer')>Customer</option>
                            <option value="VIP" @selected($customer->status == 'VIP')>VIP</option>
                            <option value="Blocked" @selected($customer->status == 'Blocked')>Blocked</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-full">Update Status</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Kolom Kanan: Riwayat & Interaksi --}}
    <div class="right-column">
        {{-- Card Riwayat Interaksi --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>Riwayat Interaksi</h3>
            </div>
            <div class="interaction-log">
                @forelse($customer->interactions as $interaction)
                <div class="log-item">
                    <p class="log-note">"{{ $interaction->notes }}"</p>
                    <small class="log-meta">Dicatat oleh <strong>{{ $interaction->admin->name ?? 'Sistem' }}</strong>
                        via <strong>{{ $interaction->channel }}</strong> pada {{ $interaction->created_at->format('d M
                        Y, H:i') }}</small>
                </div>
                @empty
                <p class="text-center p-4">Belum ada riwayat interaksi.</p>
                @endforelse
            </div>
            <div class="admin-card-footer">
                <form action="{{ route('admin.crm.interaction.add', $customer) }}" method="POST">
                    @csrf
                    <h4>Tambah Catatan Interaksi Baru</h4>
                    <div class="form-group">
                        <textarea name="notes" rows="3" class="form-control" placeholder="Tulis catatan di sini..."
                            required></textarea>
                    </div>
                    <div class="form-row">
                        <select name="channel" class="form-control" required>
                            <option value="Email">Email</option>
                            <option value="Telepon">Telepon</option>
                            <option value="WhatsApp">WhatsApp</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                        <button type="submit" class="btn btn-primary">Simpan Catatan</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Card Riwayat Pesanan --}}
        <div class="admin-card">
            <div class="admin-card-header">
                <h3>10 Pesanan Terakhir</h3>
            </div>
            <div class="admin-table-container">
                <table class="admin-table">
                    <tbody>
                        @forelse ($customer->orders as $order)
                        <tr>
                            <td><a href="{{ route('admin.orders.show', $order) }}"><strong>#{{$order->id}}</strong></a>
                            </td>
                            <td>{{ $order->created_at->format('d M Y') }}</td>
                            <td>Rp {{ number_format($order->total_amount) }}</td>
                            <td><span
                                    class="status-badge status-{{ Str::slug($order->order_status) }}">{{$order->order_status}}</span>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center p-4">Tidak ada riwayat pesanan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .back-link {
        color: var(--primary-accent);
        text-decoration: none;
        font-weight: 600;
        margin-bottom: 1rem;
        display: inline-block;
    }

    .alert-success {
        background-color: #e6f9f0;
        color: #00874e;
        padding: 1rem;
        border-radius: 6px;
        margin-bottom: 1rem;
    }

    .crm-detail-layout {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 2rem;
        align-items: flex-start;
    }

    .left-column,
    .right-column {
        display: flex;
        flex-direction: column;
        gap: 2rem;
    }

    .admin-card-body {
        padding: 1.5rem;
    }

    .text-center {
        text-align: center;
    }

    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1rem;
        padding: 1rem 1.5rem;
        border-top: 1px solid #eee;
    }

    .info-item {
        display: flex;
        flex-direction: column;
    }

    .info-item span {
        color: #666;
        font-size: 0.8rem;
    }

    .form-group {
        margin-bottom: 1rem;
    }

    .form-control {
        width: 100%;
        padding: 0.75rem;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box;
    }

    .btn {
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: 600;
        border: none;
        cursor: pointer;
    }

    .btn-primary {
        background-color: var(--primary-accent);
        color: white;
    }

    .w-full {
        width: 100%;
    }

    .interaction-log {
        max-height: 300px;
        overflow-y: auto;
        padding: 1.5rem;
    }

    .log-item {
        border-bottom: 1px solid #eee;
        padding-bottom: 1rem;
        margin-bottom: 1rem;
    }

    .log-item:last-child {
        border: none;
        margin: 0;
        padding: 0;
    }

    .log-note {
        margin: 0 0 0.5rem 0;
        font-style: italic;
    }

    .log-meta {
        font-size: 0.8rem;
        color: #666;
    }

    .admin-card-footer {
        padding: 1.5rem;
        border-top: 1px solid #eee;
        background-color: #f8f9fa;
    }

    .admin-card-footer h4 {
        margin: 0 0 1rem 0;
    }

    .form-row {
        display: flex;
        gap: 1rem;
    }

    .admin-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #eee;
    }

    .admin-table tr:last-child td {
        border: none;
    }

    .status-badge {
        padding: 4px 10px;
        border-radius: 15px;
        font-size: 0.8rem;
        font-weight: 600;
    }

    .status-completed {
        background-color: #c8e6c9;
        color: #155724;
    }

    .status-pending {
        background-color: #ffe082;
        color: #856404;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }

    .p-4 {
        padding: 1.5rem;
    }

    @media(max-width: 992px) {
        .crm-detail-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush