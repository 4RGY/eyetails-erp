<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\OrderStatusUpdated;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan.
     */
    public function index()
    {
        // PERUBAHAN: Tambahkan eager loading untuk 'items.product'
        $orders = Order::with('user', 'items.product')->latest()->paginate(15);
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail satu pesanan.
     */
    public function show(Order $order)
    {
        $order->load('items.product');
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Memperbarui pesanan (status dan nomor resi).
     */
    public function update(Request $request, Order $order)
    {
        $request->validate([
            'order_status' => 'required|in:Pending,Processing,Shipped,Completed,Cancelled',
            'tracking_number' => 'nullable|string|max:255',
        ]);

        $oldStatus = $order->order_status;

        $order->order_status = $request->order_status;
        $order->tracking_number = $request->tracking_number;
        $order->save();

        if ($oldStatus !== $order->order_status) {
            $user = $order->user;
            if ($user && $user->notif_order_updates) {
                try {
                    Mail::to($user->email)->send(new OrderStatusUpdated($order));
                } catch (\Exception $e) {
                    // Log error jika perlu
                }
            }
        }

        return redirect()->route('admin.orders.show', $order)->with('success', 'Pesanan berhasil diperbarui.');
    }
}
