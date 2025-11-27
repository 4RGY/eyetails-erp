<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log; // Tambahkan ini
use Midtrans\Config; // Tambahkan ini
use Midtrans\Snap; // Tambahkan ini

class PaymentController extends Controller
{
    /**
     * Menampilkan halaman pembayaran dan membuat Snap Token
     */
    public function show(Order $order)
    {
        // 1. Keamanan: Pastikan order ini milik user yang login
        if ($order->user_id != Auth::id()) {
            abort(403, 'Akses Ditolak.');
        }

        // 2. Keamanan: Jika order sudah lunas, lempar ke riwayat
        if ($order->order_status == 'paid' || $order->order_status == 'completed') {
            return redirect()->route('riwayat.index')->with('info', 'Pesanan ini sudah dibayar.');
        }

        // 3. Set Konfigurasi Midtrans dari .env
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        // 4. Siapkan parameter untuk Midtrans
        // Gunakan 'total_amount' dari order Anda
        $params = [
            'transaction_details' => [
                // Order ID harus unik! Kita pakai ID order + timestamp
                'order_id' => $order->id . '-' . time(),
                'gross_amount' => $order->total_amount,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'email' => $order->customer_email,
                'phone' => $order->phone,
            ],
            // Anda bisa tambahkan 'item_details' jika mau menampilkan rincian barang
        ];

        try {
            // 5. Dapatkan Snap Token
            $snapToken = Snap::getSnapToken($params);

            // 6. Tampilkan view pembayaran baru
            return view('checkout.payment', [
                'order' => $order,
                'snapToken' => $snapToken,
            ]);
        } catch (\Exception $e) {
            Log::error("Midtrans Snap Token Error: " . $e->getMessage());
            return redirect()->route('riwayat.index')->with('error', 'Gagal memproses pembayaran. Silakan coba lagi. (' . $e->getMessage() . ')');
        }
    }
}
