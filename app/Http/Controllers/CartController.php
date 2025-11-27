<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductVariant; // <-- TAMBAHKAN INI
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Menampilkan halaman keranjang belanja.
     */
    public function index()
    {
        $cart = session()->get('cart', []);

        $total = array_sum(array_map(function ($item) {
            return $item['price'] * $item['quantity'];
        }, $cart));

        return view('keranjang.index', compact('cart', 'total'));
    }

    /**
     * Menambahkan produk ke keranjang (VERSI BARU DENGAN UKURAN).
     */
    public function add(Request $request, Product $product)
    {
        $request->validate([
            'size' => 'required|string',
            'quantity' => 'required|integer|min:1',
        ]);

        $size = $request->input('size');
        $quantity = $request->input('quantity');

        // Cek ketersediaan stok untuk ukuran yang dipilih
        $variant = $product->variants()->where('size', $size)->first();

        if (!$variant || $variant->quantity < $quantity) {
            return redirect()->back()->with('error', 'Stok untuk ukuran ' . $size . ' tidak mencukupi.');
        }

        // ID unik di keranjang adalah "product_id-size"
        $cartId = $product->id . '-' . $size;
        $cart = session()->get('cart', []);

        if (isset($cart[$cartId])) {
            // Jika sudah ada, update kuantitas
            $cart[$cartId]['quantity'] += $quantity;
        } else {
            // Jika belum ada, tambahkan item baru
            $cart[$cartId] = [
                "id" => $cartId,
                "product_id" => $product->id,
                "name" => $product->name,
                "quantity" => $quantity,
                "price" => $product->sale_price ?? $product->price,
                "size" => $size, // <-- SIMPAN UKURAN
                "image" => $product->primary_image,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', $product->name . ' (Ukuran: ' . $size . ') berhasil ditambahkan ke keranjang!');
    }


    /**
     * Memperbarui kuantitas produk di keranjang.
     */
    public function update(Request $request)
    {
        if ($request->id && $request->quantity) {
            $cart = session()->get('cart');

            if (isset($cart[$request->id])) {
                // Di sini Anda bisa menambahkan validasi stok ulang jika diperlukan
                $cart[$request->id]["quantity"] = $request->quantity;
                session()->put('cart', $cart);
                session()->flash('success', 'Keranjang berhasil diperbarui.');
            }
        }
        return redirect()->back();
    }

    /**
     * Menghapus produk dari keranjang.
     */
    public function remove($id)
    {
        $cart = session()->get('cart');
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        return redirect()->back()->with('success', 'Produk berhasil dihapus dari keranjang.');
    }
}
