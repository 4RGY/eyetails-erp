<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Midtrans\Config; // <-- WAJIB
use Midtrans\Notification; // <-- WAJIB
use App\Models\Order; // <-- WAJIB [cite: uploaded:app/Models/Order.php]
use Illuminate\Support\Facades\Log; // <-- WAJIB
use Illuminate\Support\Facades\DB; // <-- WAJIB untuk cek koneksi

class MidtransWebhookController extends Controller
{
    public function handle(Request $request)
    {
        // 1. Set Konfigurasi Server Key (FIX: Gunakan config() BUKAN env())
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production', false);

        $orderIdFull = null; // Inisialisasi untuk logging error

        try {
            if (empty(Config::$serverKey)) {
                throw new \Exception("Midtrans Server Key is missing in webhook configuration.");
            }

            // Cek koneksi DB (Penyebab error 20:44:11 [cite: user])
            try {
                DB::connection()->getPdo();
            } catch (\Exception $e) {
                Log::error("Webhook DB Connection Error: " . $e->getMessage());
                throw new \Exception("Webhook Error: Database connection failed.");
            }
            
            // 2. Buat instance notifikasi Midtrans
            $notification = new Notification();

            // 3. Ambil data notifikasi
            $transaction = $notification->transaction_status;
            $orderIdFull = $notification->order_id; // (Format: ID-TIMESTAMP)
            $fraud = $notification->fraud_status;

            // 4. Ambil order_id asli (tanpa timestamp)
            // (Kita pakai $midtransOrderId dari PaymentController)
            $order = Order::where('midtrans_order_id', $orderIdFull)->first(); 

            if (!$order) {
                // Jika tidak ketemu, coba cari pakai metode lama (ID-TIMESTAMP)
                $orderId = explode('-', $orderIdFull)[0];
                $order = Order::find($orderId); // [cite: uploaded:app/Models/Order.php]
            }

            if (!$order) {
                Log::warning("Webhook Warning: Order ID " . $orderIdFull . " not found. Responding 200 to prevent retry.");
                // Wajib 200 OK agar Midtrans tidak kirim ulang
                return response()->json(['message' => 'Order not found, skipping update.'], 200);
            }

            // 5. Logika pembaruan status
            if ($transaction == 'settlement' || ($transaction == 'capture' && $fraud == 'accept')) {
                $order->update(['order_status' => 'Paid']);
            } else if ($transaction == 'pending') {
                $order->update(['order_status' => 'Waiting Payment']);
            } else if (in_array($transaction, ['deny', 'cancel', 'expire'])) {
                $order->update(['order_status' => 'Cancelled']);
            }

            Log::info("Webhook Success: Order " . $order->id . " updated to " . $order->order_status . " from Midtrans status: " . $transaction);
            
            // Wajib 200 OK
            return response()->json(['message' => 'Notification processed successfully.'], 200);

        } catch (\Exception $e) {
            // FIX: Perbaikan syntax logging dari gambar [cite: uploaded:image_2374f8.png-1668cbb3-3a40-4c61-8798-c55fce4e83f9]
            $logOrderId = $orderIdFull ?: 'N/A';
            Log::error("Webhook General Error (Order ID: {$logOrderId}): " . $e->getMessage());
            
            return response()->json(['message' => 'Error processing notification, please retry.'], 500);
        }
    }
}