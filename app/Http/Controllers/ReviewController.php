<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function __construct()
    {
        // Pastikan hanya user yang sudah login yang bisa mengakses
        $this->middleware('auth');
    }

    /**
     * Menampilkan form untuk menulis ulasan baru.
     */
    public function create(OrderItem $item)
    {
        // Keamanan: Pastikan item ini milik user yang sedang login
        $order = Order::find($item->order_id);
        if ($order->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        // Keamanan: Pastikan pesanan sudah selesai
        if ($order->order_status !== 'Completed') {
            return redirect()->route('order.tracking', $order)->with('error', 'Anda hanya bisa mereview produk dari pesanan yang sudah selesai.');
        }

        // Keamanan: Pastikan produk ini belum direview oleh user dari pesanan ini
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $item->product_id)
            ->where('order_id', $item->order_id)
            ->exists();

        if ($existingReview) {
            return redirect()->route('order.tracking', $order)->with('error', 'Anda sudah mereview produk ini.');
        }

        return view('reviews.create', compact('item'));
    }

    /**
     * Menyimpan ulasan baru ke database.
     */
    public function store(Request $request)
    {
        // 1. Validasi data yang masuk
        $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'rating' => 'required|integer|min:1|max:5',
            'content' => 'required|string|min:10',
        ]);

        $item = OrderItem::find($request->order_item_id);
        $order = Order::find($item->order_id);

        // 2. Double-check keamanan
        if ($order->user_id !== Auth::id() || $order->order_status !== 'Completed') {
            abort(403, 'TINDAKAN TIDAK DIIZINKAN');
        }

        // 3. Simpan ulasan
        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $item->product_id,
            'order_id' => $item->order_id,
            'rating' => $request->rating,
            'content' => $request->content,
            'is_approved' => true, // Default langsung disetujui
        ]);

        // 4. Redirect kembali ke halaman detail pesanan dengan pesan sukses
        return redirect()->route('order.tracking', $order)->with('success', 'Terima kasih! Ulasan Anda telah berhasil dipublikasikan.');
    }
}
