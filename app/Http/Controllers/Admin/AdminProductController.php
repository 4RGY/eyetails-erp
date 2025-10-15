<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class AdminProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk.
     */
    public function index()
    {
        // Eager load variants untuk kalkulasi total stok
        $products = Product::with('category', 'variants')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    /**
     * Menampilkan form untuk membuat produk baru.
     */
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Menyimpan produk baru ke dalam database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'required|string|unique:products,sku',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'variants' => 'required|array|min:1',
            'variants.*.size' => 'required|string|max:255',
            'variants.*.quantity' => 'required|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            // 1. Simpan data produk utama
            $productData = $request->except(['image', 'variants']);
            $productData['slug'] = Str::slug($request->name);

            if ($request->hasFile('image')) {
                $productData['image'] = $request->file('image')->store('products', 'public');
            }

            $product = Product::create($productData);

            // 2. Simpan varian produk
            foreach ($request->variants as $variantData) {
                $product->variants()->create([
                    'size' => $variantData['size'],
                    'quantity' => $variantData['quantity'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Produk baru berhasil ditambahkan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Menampilkan form untuk mengedit produk.
     */
    public function edit($id)
    {
        $product = Product::with('variants')->findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Memperbarui data produk di database.
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0|lt:price',
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'variants' => 'required|array|min:1',
            'variants.*.size' => 'required|string|max:255',
            'variants.*.quantity' => 'required|integer|min:0',
        ]);

        try {
            DB::beginTransaction();

            // 1. Update data produk utama
            $productData = $request->except(['image', 'variants']);
            $productData['slug'] = Str::slug($request->name);

            if ($request->hasFile('image')) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
                $productData['image'] = $request->file('image')->store('products', 'public');
            }

            $product->update($productData);

            // 2. Sinkronisasi varian produk
            $product->variants()->delete();
            foreach ($request->variants as $variantData) {
                $product->variants()->create([
                    'size' => $variantData['size'],
                    'quantity' => $variantData['quantity'],
                ]);
            }

            DB::commit();

            return redirect()->route('admin.products.index')
                ->with('success', 'Data produk berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }


    /**
     * Menghapus produk dari database.
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }
}
