@extends('akun.master')

@section('account-content')
{{-- Header --}}
<div class="dashboard-header">
    <h2 class="dashboard-title"><i class="fas fa-tachometer-alt"></i> Dashboard</h2>
    <p class="mb-4 text-gray-600">Selamat datang kembali! Ini adalah ringkasan aktivitas akun Anda.</p>
</div>

{{-- Grid Statistik Utama --}}
<div class="dashboard-grid stats-grid">
    {{-- Card Poin Loyalitas --}}
    <div class="dashboard-card">
        <div class="card-icon" style="color: #c59d00;"><i class="fas fa-medal"></i></div>
        <div class="card-content">
            <h4>Poin Loyalitas Anda</h4>
            <p>{{ number_format(Auth::user()->loyalty_points, 0, ',', '.') }} Poin</p>
        </div>
    </div>

    {{-- Card Tier --}}
    <div class="dashboard-card">
        <div class="card-icon" style="color: #6c757d;"><i class="fas fa-shield-alt"></i></div>
        <div class="card-content">
            <h4>Tier Keanggotaan</h4>
            <p class="tier-text-{{ strtolower(Auth::user()->tier) }}">{{ Auth::user()->tier }}</p>
        </div>
    </div>

    {{-- Card Total Pesanan --}}
    <div class="dashboard-card">
        <div class="card-icon" style="color: #0d6efd;"><i class="fas fa-receipt"></i></div>
        <div class="card-content">
            <h4>Total Pesanan</h4>
            <p>{{ $totalOrders }} Pesanan</p>
        </div>
    </div>
</div>

{{-- Panel Pesanan Terakhir --}}
<div class="latest-order-panel">
    <h3 class="panel-title">Pesanan Terakhir Anda</h3>
    @if($latestOrder)
    <div class="order-summary">
        <div class="order-info">
            <span class="order-id">Pesanan #{{ $latestOrder->id }}</span>
            <span class="order-date">{{ $latestOrder->created_at->format('d F Y') }}</span>
            <span class="order-status status-{{ Str::slug($latestOrder->order_status) }}">{{ $latestOrder->order_status
                }}</span>
        </div>
        <div class="order-details">
            <p>Total: <strong>Rp {{ number_format($latestOrder->total_amount, 0, ',', '.') }}</strong> ({{
                $latestOrder->items->count() }} item)</p>
        </div>
        <a href="{{ route('order.tracking', $latestOrder) }}" class="btn btn-primary btn-sm">Lacak & Lihat Detail</a>
    </div>
    @else
    <div class="no-order-info">
        <p>Anda belum memiliki riwayat pesanan.</p>
        <a href="{{ route('catalog.index') }}" class="btn btn-outline btn-sm">Mulai Belanja</a>
    </div>
    @endif
</div>

{{-- ======================================================= --}}
{{-- CSS LENGKAP DENGAN PENYESUAIAN RESPONSIVE --}}
{{-- ======================================================= --}}
<style>
    .dashboard-header {
        margin-bottom: 2rem;
    }

    .dashboard-title {
        font-size: 1.8rem;
        font-weight: 700;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        /* 3 kolom di desktop */
        gap: 1.5rem;
        margin-bottom: 2.5rem;
    }

    .dashboard-card {
        background-color: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 25px;
        display: flex;
        align-items: center;
        gap: 20px;
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
    }

    .card-icon {
        font-size: 2.5rem;
        flex-shrink: 0;
    }

    .card-content h4 {
        margin: 0;
        font-size: 0.9rem;
        color: #6c757d;
        text-transform: uppercase;
        font-weight: 600;
    }

    .card-content p {
        margin: 5px 0 0;
        font-size: 1.8rem;
        font-weight: 700;
        color: #212529;
    }

    /* Warna untuk teks tier */
    .tier-text-bronze {
        color: #cd7f32;
    }

    .tier-text-silver {
        color: #8a8a8a;
    }

    .tier-text-gold {
        color: #c59d00;
    }

    /* Panel Pesanan Terakhir */
    .latest-order-panel {
        background-color: #fff;
        border: 1px solid #e9ecef;
        border-radius: 8px;
        padding: 1.5rem 2rem;
    }

    .panel-title {
        font-size: 1.25rem;
        font-weight: 600;
        margin: 0 0 1.5rem 0;
        padding-bottom: 1rem;
        border-bottom: 1px solid #eee;
    }

    .order-summary {
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .order-info {
        display: flex;
        align-items: center;
        gap: 1rem;
        flex-wrap: wrap;
    }

    .order-id {
        font-weight: 700;
        font-size: 1.1rem;
    }

    .order-date {
        color: #6c757d;
    }

    .order-details p {
        margin: 0;
    }

    .no-order-info {
        text-align: center;
        padding: 2rem 0;
    }

    .no-order-info p {
        margin: 0 0 1rem 0;
        font-size: 1.1rem;
        color: #6c757d;
    }

    .btn-sm {
        padding: 0.5rem 1rem;
        font-size: 0.9rem;
    }

    /* Badge Status Pesanan */
    .order-status {
        padding: 5px 12px;
        border-radius: 15px;
        font-size: .8rem;
        font-weight: 700;
    }

    .status-pending {
        background-color: #fff0c2;
        color: #7a5a00;
    }

    .status-processing {
        background-color: #d1ecf1;
        color: #0c5460;
    }

    .status-shipped {
        background-color: #d6eaff;
        color: #004085;
    }

    .status-completed {
        background-color: #d4edda;
        color: #155724;
    }

    .status-cancelled {
        background-color: #f8d7da;
        color: #721c24;
    }


    /* === MEDIA QUERIES UNTUK RESPONSIVE === */
    @media (max-width: 992px) {
        .stats-grid {
            /* Ubah menjadi 2 kolom di tablet */
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 768px) {
        .stats-grid {
            /* Ubah menjadi 1 kolom di mobile */
            grid-template-columns: 1fr;
        }

        .order-summary {
            flex-direction: column;
            align-items: flex-start;
        }
    }

    @media (max-width: 480px) {
        .dashboard-title {
            font-size: 1.5rem;
        }

        .dashboard-card {
            flex-direction: column;
            text-align: center;
            gap: 10px;
        }

        .card-icon {
            margin-bottom: 5px;
        }

        .card-content h4 {
            font-size: 0.85rem;
        }

        .card-content p {
            font-size: 1.5rem;
        }

        .latest-order-panel {
            padding: 1.5rem;
        }

        .panel-title {
            font-size: 1.1rem;
        }
    }
</style>
@endsection