<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $wishlistItems = $user->wishlist()->with('product')->get();

        return view('akun.wishlist', compact('wishlistItems'));
    }

    /**
     * Ganti nama method menjadi 'toggle' agar lebih konsisten dengan route.
     */
    public function toggle(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
        ]);

        $productId = $request->product_id;
        $userId = Auth::id();

        $wishlistItem = Wishlist::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            $message = 'Produk berhasil dihapus dari Wishlist.';
        } else {
            Wishlist::create(['user_id' => $userId, 'product_id' => $productId]);
            $message = 'Produk berhasil ditambahkan ke Wishlist.';
        }

        return redirect()->back()->with('success', $message);
    }
}
