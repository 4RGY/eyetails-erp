<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserOrderController extends Controller
{
    public function __construct()
    {
        // Hanya pengguna terautentikasi yang bisa mengakses fitur ini
        $this->middleware('auth');
    }

    /**
     * Menampilkan daftar semua riwayat pesanan pengguna.
     */
    public function index()
    {
        // Ambil pesanan yang dibuat oleh user_id yang sedang login, dengan eager loading itemnya
        $orders = Order::where('user_id', Auth::id())
            ->with('items')
            ->latest()
            ->paginate(10);

        return view('riwayat.index', compact('orders'));
    }

    /**
     * Menampilkan detail dan status lacak pesanan.
     */
    public function tracking(Order $order)
    {
        // Pastikan pengguna hanya bisa melihat pesanannya sendiri
        if ($order->user_id !== Auth::id()) {
            abort(403, 'Anda tidak diizinkan mengakses pesanan ini.');
        }

        // Eager load relasi returnRequests dari setiap item
        $order->load('items.returnRequest');

        return view('riwayat.tracking', compact('order'));
    }
}
