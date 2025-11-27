<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        // Eager load variants untuk kalkulasi stok di halaman katalog
        $productsQuery = Product::with('category', 'variants');

        // Filtering
        if ($request->has('category') && $request->category !== 'all') {
            $category = Category::where('slug', $request->category)->firstOrFail();
            $productsQuery->where('category_id', $category->id);
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'price_asc':
                $productsQuery->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $productsQuery->orderBy('price', 'desc');
                break;
            default:
                $productsQuery->latest();
                break;
        }

        $products = $productsQuery->paginate(12)->appends($request->query());

        return view('katalog.index', [
            'products' => $products,
            'categories' => $categories,
            'currentCategory' => $request->category ?? 'all'
        ]);
    }

    /**
     * Menampilkan halaman detail produk.
     */
    public function show(Product $product)
    {
        // GANTI 'reviews.order' menjadi 'reviews.orderItem' agar sesuai
        // dengan yang kamu panggil di view ('show.blade.php')
        $product->load('variants', 'reviews.user', 'reviews.orderItem');

        return view('katalog.show', compact('product'));
    }

    public function promo(Request $request)
    {
        // Eager load variants juga di sini untuk konsistensi
        $products = Product::with('category', 'variants')
            ->whereNotNull('sale_price')
            ->whereColumn('sale_price', '<', 'price')
            ->latest()
            ->paginate(12);

        return view('promo.index', compact('products'));
    }
}
