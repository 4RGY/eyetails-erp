<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\ReturnRequest;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // <-- Tambahkan ini

class ReturnRequestController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Menampilkan form untuk mengajukan pengembalian/penukaran.
     */
    public function create(OrderItem $item)
    {
        // ... (logika keamanan di method create tetap sama) ...
        $order = Order::find($item->order_id);
        if ($order->user_id !== Auth::id()) {
            abort(403, 'AKSES DITOLAK');
        }

        if ($order->order_status !== 'Completed') {
            return redirect()->route('order.tracking', $order)->with('error', 'Anda hanya bisa mengajukan pengembalian untuk pesanan yang sudah selesai.');
        }

        $existingRequest = ReturnRequest::where('order_item_id', $item->id)->exists();
        if ($existingRequest) {
            return redirect()->route('order.tracking', $order)->with('error', 'Anda sudah pernah mengajukan permintaan untuk produk ini.');
        }

        return view('returns.create', compact('item'));
    }

    /**
     * Menyimpan permintaan pengembalian/penukaran baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'order_item_id' => 'required|exists:order_items,id',
            'type' => 'required|in:Return,Exchange',
            'reason' => 'required|string|min:10',
            // Validasi untuk file bukti (opsional, maks 2MB)
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,mp4,mov|max:2048',
        ]);

        $item = OrderItem::find($request->order_item_id);
        $order = Order::find($item->order_id);

        if ($order->user_id !== Auth::id() || $order->order_status !== 'Completed') {
            abort(403, 'TINDAKAN TIDAK DIIZINKAN');
        }

        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            // Simpan file ke folder 'returns' di dalam 'storage/app/public'
            $attachmentPath = $request->file('attachment')->store('returns', 'public');
        }

        ReturnRequest::create([
            'order_id' => $item->order_id,
            'user_id' => Auth::id(),
            'order_item_id' => $item->id,
            'type' => $request->type,
            'reason' => $request->reason,
            'attachment_path' => $attachmentPath, // Simpan path file
            'status' => 'Pending',
        ]);

        return redirect()->route('order.tracking', $order)
            ->with('success', 'Permintaan Anda telah berhasil diajukan. Silakan tunggu konfirmasi dari admin.');
    }
}
