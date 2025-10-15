@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
<header class="admin-content-header">
    <h1>Dashboard Analitik</h1>
    <p>Ringkasan performa toko Anda secara keseluruhan.</p>
</header>

{{-- 1. KARTU METRIK UTAMA --}}
<div class.="stat-cards-container">
    <div class="stat-card">
        <div class="card-icon" style="background-color: #e6f9f0;">
            <i class="fa-solid fa-dollar-sign" style="color: #00874e;"></i>
        </div>
        <div class="card-info">
            <span class="info-label">Total Pendapatan</span>
            <span class="info-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="card-icon" style="background-color: #e3f2fd;">
            <i class="fa-solid fa-box" style="color: #0d6efd;"></i>
        </div>
        <div class="card-info">
            <span class="info-label">Total Pesanan</span>
            <span class="info-value">{{ number_format($totalOrders) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="card-icon" style="background-color: #fff0e3;">
            <i class="fa-solid fa-users" style="color: #fd7e14;"></i>
        </div>
        <div class="card-info">
            <span class="info-label">Total Pelanggan</span>
            <span class="info-value">{{ number_format($totalCustomers) }}</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="card-icon" style="background-color: #fce4e4;">
            <i class="fa-solid fa-hourglass-half" style="color: #dc3545;"></i>
        </div>
        <div class="card-info">
            <span class="info-label">Pesanan Pending</span>
            <span class="info-value">{{ number_format($pendingOrders) }}</span>
        </div>
    </div>
</div>

<div class="dashboard-grid">
    {{-- 2. GRAFIK LAPORAN PENJUALAN --}}
    <div class="admin-card chart-card-full">
        <div class="admin-card-header">
            <h3>Laporan Penjualan (30 Hari Terakhir)</h3>
        </div>
        <div class="admin-card-content">
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    {{-- 3. LAPORAN PRODUK TERLARIS --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h3>Produk Terlaris (Top 5)</h3>
        </div>
        <div class="admin-card-content">
            <ul class="product-list">
                @forelse($bestSellingProducts as $product)
                <li>
                    <span class="product-name">{{ $product->product_name }}</span>
                    <span class="product-sold">{{ $product->total_sold }} terjual</span>
                </li>
                @empty
                <li class="empty">Belum ada data penjualan.</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- 5. GRAFIK STATUS PESANAN --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h3>Distribusi Status Pesanan</h3>
        </div>
        <div class="admin-card-content" style="position: relative; height:300px;">
            <canvas id="orderStatusChart"></canvas>
        </div>
    </div>

    {{-- 4. GRAFIK LAPORAN PENGGUNA BARU --}}
    <div class="admin-card chart-card-full">
        <div class="admin-card-header">
            <h3>Pengguna Baru (7 Hari Terakhir)</h3>
        </div>
        <div class="admin-card-content">
            <canvas id="newUsersChart"></canvas>
        </div>
    </div>
</div>

@push('styles')
<style>
    .stat-cards-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 1.5rem;
        margin-bottom: 2rem;
    }

    .stat-card {
        background-color: #fff;
        border-radius: 8px;
        padding: 1.5rem;
        display: flex;
        align-items: center;
        gap: 1.5rem;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        border: 1px solid var(--border-color);
    }

    .card-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .card-info .info-label {
        font-size: 0.9rem;
        color: #6c757d;
        display: block;
    }

    .card-info .info-value {
        font-size: 1.8rem;
        font-weight: 700;
    }

    .dashboard-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    .chart-card-full {
        grid-column: 1 / -1;
    }

    .product-list {
        list-style: none;
        padding: 0;
    }

    .product-list li {
        display: flex;
        justify-content: space-between;
        padding: 0.85rem 0.25rem;
        border-bottom: 1px solid #f0f0f0;
    }

    .product-list li:last-child {
        border: none;
    }

    .product-list .product-name {
        font-weight: 600;
    }

    .product-list .product-sold {
        font-weight: 500;
        color: #6c757d;
    }

    .product-list .empty {
        color: #999;
        text-align: center;
        padding: 1rem 0;
    }
</style>
@endpush

@push('scripts')
{{-- Include Chart.js dari CDN --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
    const ctxSales = document.getElementById('salesChart');
    const ctxUsers = document.getElementById('newUsersChart');
    const ctxOrderStatus = document.getElementById('orderStatusChart');
    
    // 1. Grafik Penjualan (Line Chart)
    new Chart(ctxSales, {
        type: 'line',
        data: {
            labels: @json($salesChartLabels),
            datasets: [{
                label: 'Pendapatan',
                data: @json($salesChartData),
                fill: true,
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });

    // 2. Grafik Pengguna Baru (Bar Chart)
    new Chart(ctxUsers, {
        type: 'bar',
        data: {
            labels: @json($userChartLabels),
            datasets: [{
                label: 'Pengguna Baru',
                data: @json($userChartData),
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: { y: { beginAtZero: true } }
        }
    });

    // 3. Grafik Status Pesanan (Doughnut Chart)
    const orderStatusData = @json($orderStatusDistribution);
    new Chart(ctxOrderStatus, {
        type: 'doughnut',
        data: {
            labels: Object.keys(orderStatusData),
            datasets: [{
                label: 'Jumlah Pesanan',
                data: Object.values(orderStatusData),
                backgroundColor: [
                    '#FFC107', // Pending
                    '#0D6EFD', // Processing
                    '#6F42C1', // Shipped
                    '#198754', // Completed
                    '#DC3545'  // Cancelled
                ],
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
        }
    });
});
</script>
@endpush
@endsection