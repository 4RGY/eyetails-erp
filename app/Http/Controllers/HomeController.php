<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Ambil 8 produk terbaru untuk "New Arrivals"
        $newArrivals = Product::with('category')->latest()->take(8)->get();

        // Ambil 4 produk acak untuk "Most Wanted"
        $mostWanted = Product::with('category')->inRandomOrder()->take(4)->get();

        // Ambil semua kategori untuk "Shop by Category"
        $categories = Category::all();

        return view('home', compact('newArrivals', 'mostWanted', 'categories'));
    }
}
