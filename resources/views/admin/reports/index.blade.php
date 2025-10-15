@extends('admin.layouts.app')

@section('title', 'Laporan Penjualan')

@section('content')
<header class="admin-content-header">
    <h1>Laporan Penjualan</h1>
    <p>Analisis pendapatan dan penjualan berdasarkan rentang waktu.</p>
</header>

{{-- Filter Form --}}
<div class="admin-card">
    <form method="GET" action="{{ route('admin.reports.index') }}" class="filter-form">
        <div class="form-group">
            <label for="start_date">Tanggal Mulai</label>
            <input type="date" name="start_date" id="start_date" value="{{ $startDate->format('Y-m-d') }}"
                class="form-control">
        </div>
        <div class="form-group">
            <label for="end_date">Tanggal Selesai</label>
            <input type="date" name="end_date" id="end_date" value="{{ $endDate->format('Y-m-d') }}"
                class="form-control">
        </div>
        <button type="submit" class="btn btn-primary"><i class="fa-solid fa-filter"></i> Filter Laporan</button>
        <a href="{{ route('admin.reports.print', ['start_date' => $startDate->format('Y-m-d'), 'end_date' => $endDate->format('Y-m-d')]) }}"
            class="btn btn-primary" target="_blank">
            <i class="fa-solid fa-print"></i> Cetak PDF
        </a>
    </form>
</div>

{{-- KPI Cards --}}
<div class="admin-widgets-grid mt-6">
    <div class="widget-card">
        <div class="widget-icon" style="background-color: #e0f2fe;"><i class="fa-solid fa-money-bill-wave"
                style="color: #0ea5e9;"></i></div>
        <div class="widget-info">
            <span class="widget-label">Total Pendapatan</span>
            <span class="widget-value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
        </div>
    </div>
    <div class="widget-card">
        <div class="widget-icon" style="background-color: #dcfce7;"><i class="fa-solid fa-check-circle"
                style="color: #22c55e;"></i></div>
        <div class="widget-info">
            <span class="widget-label">Pesanan Selesai</span>
            <span class="widget-value">{{ $totalOrders }}</span>
        </div>
    </div>
    <div class="widget-card">
        <div class="widget-icon" style="background-color: #fef3c7;"><i class="fa-solid fa-box-open"
                style="color: #f59e0b;"></i></div>
        <div class="widget-info">
            <span class="widget-label">Item Terjual</span>
            <span class="widget-value">{{ $totalItemsSold }}</span>
        </div>
    </div>
</div>

{{-- Layout Baru untuk Grafik dan Produk Terlaris --}}
<div class="report-layout mt-6">
    {{-- Grafik Pendapatan --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h3><i class="fa-solid fa-chart-line"></i> Tren Pendapatan Harian</h3>
        </div>
        <div class="admin-card-body" style="height: 350px;">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- Donut Chart Komposisi Pendapatan --}}
    <div class="admin-card">
        <div class="admin-card-header">
            <h3><i class="fa-solid fa-chart-pie"></i> Pendapatan per Kategori</h3>
        </div>
        <div class="admin-card-body" style="height: 350px;">
            <canvas id="categoryChart"></canvas>
        </div>
    </div>
</div>

{{-- Produk Terlaris (Tabel) --}}
<div class="admin-card mt-6">
    <div class="admin-card-header">
        <h3><i class="fa-solid fa-star"></i> Top 10 Produk Terlaris</h3>
    </div>
    <div class="admin-table-container">
        <table class="admin-table modern-table">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Nama Produk</th>
                    <th>Jumlah Terjual</th>
                    <th>Total Omzet</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($topProducts as $index => $product)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td><strong>{{ $product->product_name }}</strong></td>
                    <td>{{ $product->total_quantity }} unit</td>
                    <td>Rp {{ number_format($product->total_sales, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="text-center p-4">Tidak ada data produk terjual pada periode ini.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@push('styles')
<style>
    .filter-form {
        display: flex;
        align-items: flex-end;
        gap: 20px;
        padding: 20px;
        flex-wrap: wrap;
    }

    .form-group label {
        font-weight: 600;
        font-size: 0.9rem;
        display: block;
        margin-bottom: 5px;
    }

    .form-control {
        padding: 10px;
        border-radius: 4px;
        border: 1px solid #ccc;
    }

    .btn-primary {
        background-color: var(--primary-accent);
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: 600;
        border: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }

    .mt-6 {
        margin-top: 1.5rem;
    }

    .admin-widgets-grid .widget-icon {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
    }

    .report-layout {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 20px;
        align-items: flex-start;
    }

    .admin-card-header h3 {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .admin-card-body {
        padding: 20px;
    }

    .modern-table {
        width: 100%;
        border-collapse: collapse;
    }

    .modern-table th,
    .modern-table td {
        padding: 12px 15px;
        text-align: left;
        border-bottom: 1px solid #e9ecef;
    }

    .modern-table th {
        background-color: #f8f9fa;
        font-size: 0.8rem;
        text-transform: uppercase;
    }

    .text-center {
        text-align: center;
    }

    .p-4 {
        padding: 1.5rem;
    }

    @media (max-width: 992px) {
        .report-layout {
            grid-template-columns: 1fr;
        }
    }
</style>
@endpush

@push('scripts')
{{-- CDN untuk Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Data dari PHP
        const dailyRevenueData = @json($dailyRevenue);
        const categorySalesData = @json($salesByCategory);

        // 1. Grafik Tren Pendapatan (Line Chart)
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: Object.keys(dailyRevenueData),
                datasets: [{
                    label: 'Pendapatan',
                    data: Object.values(dailyRevenueData),
                    backgroundColor: 'rgba(79, 70, 229, 0.1)',
                    borderColor: 'rgba(79, 70, 229, 1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.3
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { ticks: { callback: value => 'Rp ' + new Intl.NumberFormat('id-ID').format(value) } }
                },
                plugins: {
                    tooltip: { callbacks: { label: context => `Pendapatan: Rp ${new Intl.NumberFormat('id-ID').format(context.parsed.y)}` } }
                }
            }
        });

        // 2. Grafik Komposisi Kategori (Donut Chart)
        const categoryCtx = document.getElementById('categoryChart').getContext('2d');
        new Chart(categoryCtx, {
            type: 'doughnut',
            data: {
                labels: Object.keys(categorySalesData),
                datasets: [{
                    label: 'Omzet per Kategori',
                    data: Object.values(categorySalesData),
                    backgroundColor: [
                        'rgba(79, 70, 229, 0.8)', 'rgba(59, 130, 246, 0.8)',
                        'rgba(16, 185, 129, 0.8)', 'rgba(245, 158, 11, 0.8)',
                        'rgba(239, 68, 68, 0.8)', 'rgba(139, 92, 246, 0.8)'
                    ],
                    borderColor: '#fff',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const total = context.chart.getDatasetMeta(0).total;
                                const percentage = ((value / total) * 100).toFixed(2);
                                return `${label}: Rp ${new Intl.NumberFormat('id-ID').format(value)} (${percentage}%)`;
                            }
                        }
                    }
                }
            }
        });
    });
</script>
@endpush