<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Metrik Utama (Stat Cards)
        $totalRevenue = Order::where('order_status', 'Completed')->sum('total_amount');
        $totalOrders = Order::count();
        $totalCustomers = User::where('is_admin', false)->count();
        $pendingOrders = Order::where('order_status', 'Pending')->count();

        // 2. Laporan Penjualan (Grafik Garis - 30 hari terakhir)
        $salesData = Order::where('order_status', 'Completed')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total_amount) as total')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        // Format data untuk Chart.js
        $salesChartLabels = $salesData->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d M'));
        $salesChartData = $salesData->pluck('total');

        // 3. Laporan Produk Terlaris (Top 5)
        $bestSellingProducts = OrderItem::select(
            'product_name',
            DB::raw('SUM(quantity) as total_sold')
        )
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->whereIn('orders.order_status', ['Completed', 'Shipped', 'Processing'])
            ->groupBy('product_name')
            ->orderBy('total_sold', 'desc')
            ->take(5)
            ->get();

        // 4. Laporan Pengguna Baru (7 hari terakhir) sebagai simulasi pengunjung
        $newUsersData = User::where('created_at', '>=', Carbon::now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        $userChartLabels = $newUsersData->pluck('date')->map(fn($date) => Carbon::parse($date)->format('d M'));
        $userChartData = $newUsersData->pluck('count');

        // 5. Distribusi Status Pesanan (Grafik Donat)
        $orderStatusDistribution = Order::select('order_status', DB::raw('COUNT(*) as count'))
            ->groupBy('order_status')
            ->pluck('count', 'order_status');

        return view('admin.dashboard', compact(
            'totalRevenue',
            'totalOrders',
            'totalCustomers',
            'pendingOrders',
            'salesChartLabels',
            'salesChartData',
            'bestSellingProducts',
            'userChartLabels',
            'userChartData',
            'orderStatusDistribution'
        ));
    }
}
