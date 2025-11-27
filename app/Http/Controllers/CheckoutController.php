<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\ProductVariant; // <-- 1. PASTIKAN MODEL INI DI-IMPORT
use App\Models\Promotion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Models\ShippingMethod;
use App\Models\PaymentMethod;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CheckoutController extends Controller
{
    /**
     * Menampilkan halaman checkout.
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong!');
        }

        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));

        $user = Auth::user();
        $defaultShipping = [
            'name' => $user->name ?? '',
            'email' => $user->email ?? '',
            'address' => $user->address ?? '',
            'phone' => $user->phone ?? ''
        ];

        $shippingMethods = ShippingMethod::where('is_active', true)->get();
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        $userPoints = Auth::check() ? Auth::user()->loyalty_points : 0;
        $shippingCost = $shippingMethods->first()->cost ?? 0;
        $promoDiscount = session()->get('promo_discount', 0);
        $total = $subtotal + $shippingCost - $promoDiscount;

        return view('checkout.index', compact(
            'cart',
            'subtotal',
            'shippingCost',
            'total',
            'defaultShipping',
            'userPoints',
            'shippingMethods',
            'paymentMethods'
        ));
    }

    /**
     * Memproses pesanan.
     */
    public function placeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'shipping_address' => 'required|string',
            'phone' => 'required|string|max:20',
            'payment_method_id' => 'required|exists:payment_methods,id',
            'points_to_use' => 'nullable|numeric|min:0',
            'payment_proof' => 'nullable|image|mimes:jpg,jpeg,png,heic|max:2048',
            'shipping_method_id' => 'required|exists:shipping_methods,id',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        try {
            DB::beginTransaction();

            $selectedShipping = ShippingMethod::findOrFail($request->shipping_method_id);
            $selectedPayment = PaymentMethod::findOrFail($request->payment_method_id);

            // Tentukan perhitungan total, diskon, poin, dll.
            $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
            $shippingCost = $selectedShipping->cost;
            $promoDiscount = session()->get('promo_discount', 0);
            $promoCode = session()->get('promo_code', null);
            $totalBeforeDiscounts = $subtotal + $shippingCost;

            $pointsUsed = 0;
            $pointsDiscount = 0;

            if (Auth::check() && $request->filled('points_to_use')) {
                $user = Auth::user();
                $pointsToUse = (int) $request->points_to_use;

                if ($pointsToUse > $user->loyalty_points) {
                    throw new \Exception('Jumlah poin yang digunakan melebihi poin yang Anda miliki.');
                }

                $discountValue = $pointsToUse * 100;

                if (($discountValue + $promoDiscount) > $totalBeforeDiscounts) {
                    $discountValue = $totalBeforeDiscounts - $promoDiscount;
                    $pointsToUse = floor($discountValue / 100);
                }

                $user->decrement('loyalty_points', $pointsToUse);
                $pointsUsed = $pointsToUse;
                $pointsDiscount = $discountValue;
            }

            $paymentProofPath = null;
            if ($request->hasFile('payment_proof')) {
                $paymentProofPath = $request->file('payment_proof')->store('proofs', 'public');
            }

            $totalAmount = $totalBeforeDiscounts - $pointsDiscount - $promoDiscount;

            // 1. BUAT ORDER
            $order = Order::create([
                'user_id' => Auth::id(),
                'customer_name' => $request->customer_name,
                'customer_email' => $request->customer_email,
                'phone' => $request->phone,
                'shipping_address' => $request->shipping_address,
                'payment_method' => $selectedPayment->name,
                'payment_proof' => $paymentProofPath,
                'subtotal' => $subtotal,
                'shipping_cost' => $shippingCost,
                'shipping_method' => $selectedShipping->name,
                'total_amount' => $totalAmount,
                'order_status' => 'Pending',
                'points_used' => $pointsUsed,
                'promo_code' => $promoCode,
                'promo_discount' => $promoDiscount,
            ]);

            // 2. BUAT ORDER ITEMS DAN KURANGI STOK
            foreach ($cart as $id => $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item['product_id'],
                    'product_name' => $item['name'],
                    'size' => $item['size'],
                    'price' => $item['price'],
                    'quantity' => $item['quantity'],
                ]);

                // Logika Pengurangan Stok
                $variant = ProductVariant::where('product_id', $item['product_id'])
                    ->where('size', $item['size'])
                    ->first();

                if ($variant) {
                    if ($variant->quantity < $item['quantity']) {
                        throw new \Exception('Stok untuk produk ' . $item['name'] . ' ukuran ' . $item['size'] . ' tidak mencukupi.');
                    }
                    $variant->decrement('quantity', $item['quantity']);
                } else {
                    throw new \Exception('Varian produk ' . $item['name'] . ' ukuran ' . $item['size'] . ' tidak ditemukan.');
                }
            }

            // 3. LOGIKA PROMO DAN LOYALTY
            if (session()->has('promo_id')) {
                Promotion::find(session('promo_id'))->increment('usage_count');
            }

            if (Auth::check()) {
                $user = Auth::user();
                $pointsEarned = floor($subtotal / 10000);
                if ($pointsEarned > 0) $user->increment('loyalty_points', $pointsEarned);

                $lifetime_spend = Order::where('user_id', $user->id)->where('order_status', 'Completed')->sum('total_amount') + $totalAmount;
                $newTier = ($lifetime_spend > 5000000) ? 'Gold' : (($lifetime_spend > 1000000) ? 'Silver' : 'Bronze');
                if ($user->tier !== $newTier) {
                    $user->tier = $newTier;
                    $user->save();
                }
            }

            DB::commit();
            session()->forget(['cart', 'promo_id', 'promo_code', 'promo_discount']);

            // ==========================================================
            // LOGIKA PENGARAHAN SESUAI METODE PEMBAYARAN (YANG DIUBAH)
            // ==========================================================
            if (strtolower(trim($selectedPayment->name)) == 'Midtrans.') {
                

                // JALUR BARU (Midtrans):
                // Kita ubah status order jadi 'unpaid'
                $order->update(['order_status' => 'unpaid']);

                // Redirect ke halaman pembayaran Midtrans (PaymentController)
                return redirect()->route('checkout.payment', $order->id);
            } else {

                // JALUR LAMA (Transfer Manual, COD, dll):
                // Langsung ke halaman tracking
                return redirect()->route('order.tracking', $order->id)
                    ->with('success', 'Pesanan Anda berhasil dibuat! Terima kasih telah berbelanja.');
            }
            // ==========================================================
            // AKHIR LOGIKA PENGARAHAN
            // ==========================================================
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Checkout Error: " . $e->getMessage());
            return redirect()->route('checkout.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Menerapkan kode promo.
     */
    public function applyPromo(Request $request)
    {
        $request->validate(['promo_code' => 'required|string']);
        $promo = Promotion::where('code', $request->promo_code)->first();

        if (!$promo || !$promo->is_active) {
            return redirect()->back()->with('promo_error', 'Kode voucher tidak valid atau sudah tidak aktif.');
        }
        if (($promo->start_date && $promo->start_date->isFuture()) || ($promo->end_date && $promo->end_date->isPast())) {
            return redirect()->back()->with('promo_error', 'Kode voucher tidak berlaku untuk periode saat ini.');
        }
        if ($promo->usage_limit !== null && $promo->usage_count >= $promo->usage_limit) {
            return redirect()->back()->with('promo_error', 'Kode voucher telah mencapai batas penggunaan.');
        }

        $cart = session()->get('cart', []);
        $subtotal = array_sum(array_map(fn($item) => $item['price'] * $item['quantity'], $cart));
        $discount = 0;

        if ($promo->type == 'percentage') {
            $discount = ($subtotal * $promo->value) / 100;
            if ($promo->max_discount && $discount > $promo->max_discount) {
                $discount = $promo->max_discount;
            }
        } elseif ($promo->type == 'fixed_amount') {
            $discount = $promo->value > $subtotal ? $subtotal : $promo->value;
        }

        session(['promo_id' => $promo->id, 'promo_code' => $promo->code, 'promo_discount' => $discount]);
        return redirect()->back()->with('promo_success', 'Kode voucher "' . $promo->code . '" berhasil diterapkan!');
    }

    /**
     * Menghapus kode promo.
     */
    public function removePromo()
    {
        session()->forget(['promo_id', 'promo_code', 'promo_discount']);
        return redirect()->back()->with('promo_success', 'Kode voucher berhasil dihapus.');
    }
}
