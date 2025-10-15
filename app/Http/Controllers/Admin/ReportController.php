<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // --- 1. Tentukan Rentang Tanggal ---
        $startDate = Carbon::parse($request->input('start_date', Carbon::now()->startOfMonth()));
        $endDate = Carbon::parse($request->input('end_date', Carbon::now()->endOfMonth()));

        // --- 2. Query Dasar ---
        $ordersQuery = Order::where('order_status', 'Completed')
            ->whereBetween('created_at', [$startDate, $endDate->copy()->endOfDay()]);

        $orders = $ordersQuery->clone()->latest()->get();

        // --- 3. Hitung Statistik Utama (KPI) ---
        $totalRevenue = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        $totalItemsSold = $orders->reduce(fn($carry, $order) => $carry + $order->items->sum('quantity'), 0);

        // --- 4. Siapkan Data untuk Grafik Garis (Tren Pendapatan) ---
        $dailyRevenue = $ordersQuery->clone()
            ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(total_amount) as total'))
            ->groupBy('date')->orderBy('date', 'asc')->get()
            ->pluck('total', 'date')
            ->mapWithKeys(fn($total, $date) => [Carbon::parse($date)->format('d M') => $total])
            ->toArray();

        // --- 5. Ambil Data Produk Terlaris ---
        $topProducts = OrderItem::whereIn('order_id', $orders->pluck('id'))
            ->select('product_name', DB::raw('SUM(quantity) as total_quantity'), DB::raw('SUM(price * quantity) as total_sales'))
            ->groupBy('product_name')->orderBy('total_quantity', 'desc')->take(10)->get();

        // --- 6. (ADVANCE) Data Komposisi Pendapatan per Kategori untuk Donut Chart ---
        $salesByCategory = OrderItem::whereIn('order_id', $orders->pluck('id'))
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->select('categories.name as category_name', DB::raw('SUM(order_items.price * order_items.quantity) as total_category_sales'))
            ->groupBy('categories.name')
            ->pluck('total_category_sales', 'category_name')
            ->toArray();

        return view('admin.reports.index', compact(
            'startDate',
            'endDate',
            'totalRevenue',
            'totalOrders',
            'totalItemsSold',
            'dailyRevenue',
            'topProducts',
            'salesByCategory'
        ));
    }
    public function printPDF(Request $request)
    {
        // 1. Ambil data dengan logika yang sama seperti di method index
        $startDate = Carbon::parse($request->input('start_date', Carbon::now()->startOfMonth()));
        $endDate = Carbon::parse($request->input('end_date', Carbon::now()->endOfMonth()));

        $orders = Order::where('order_status', 'Completed')
            ->whereBetween('created_at', [$startDate, $endDate->copy()->endOfDay()])
            ->latest()
            ->get();

        $totalRevenue = $orders->sum('total_amount');
        $totalOrders = $orders->count();
        $totalItemsSold = $orders->reduce(fn($carry, $order) => $carry + $order->items->sum('quantity'), 0);

        // 2. Siapkan data untuk dikirim ke view PDF
        $data = [
            'orders' => $orders,
            'startDate' => $startDate,
            'endDate' => $endDate,
            'totalRevenue' => $totalRevenue,
            'totalOrders' => $totalOrders,
            'totalItemsSold' => $totalItemsSold,
        ];

        // 3. Load view, render menjadi PDF, dan paksa download
        $pdf = Pdf::loadView('admin.reports.print', $data);
        $fileName = 'laporan-penjualan-' . $startDate->format('d-m-Y') . '-sampai-' . $endDate->format('d-m-Y') . '.pdf';

        return $pdf->download($fileName);
    }
}
