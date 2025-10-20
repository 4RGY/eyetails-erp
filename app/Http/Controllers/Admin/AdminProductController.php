<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage; // Tambahkan ini
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
        // Eager load relasi yang dibutuhkan
        $products = Product::with('category', 'variants', 'images')->latest()->paginate(10);
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
            'variants' => 'required|array|min:1',
            'variants.*.size' => 'required|string|max:255',
            'variants.*.quantity' => 'required|integer|min:0',
            // PERUBAHAN VALIDASI GAMBAR
            'images'   => 'nullable|array|max:7',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // 1. Simpan data produk utama (tanpa data gambar)
            $productData = $request->except(['images', 'variants']);
            $productData['slug'] = Str::slug($request->name);
            $product = Product::create($productData);

            // 2. Simpan varian produk
            foreach ($request->variants as $variantData) {
                $product->variants()->create($variantData);
            }

            // 3. LOGIKA BARU: Simpan multiple images
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $imageFile) {
                    $path = $imageFile->store('products', 'public');
                    $product->images()->create(['path' => $path]);
                }
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
        // Eager load gambar dan varian
        $product = Product::with('variants', 'images')->findOrFail($id);
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
            // ... validasi lainnya sama seperti store
            'sku' => 'required|string|unique:products,sku,' . $product->id,
            'images'   => 'nullable|array|max:7',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        try {
            DB::beginTransaction();

            // 1. Update data produk utama
            $productData = $request->except(['images', 'variants']);
            $productData['slug'] = Str::slug($request->name);
            $product->update($productData);

            // 2. Sinkronisasi varian produk
            $product->variants()->delete();
            foreach ($request->variants as $variantData) {
                $product->variants()->create($variantData);
            }

            // 3. LOGIKA BARU: Tambahkan gambar baru jika ada
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $imageFile) {
                    $path = $imageFile->store('products', 'public');
                    $product->images()->create(['path' => $path]);
                }
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
        $product = Product::with('images')->findOrFail($id);

        // Hapus semua gambar dari storage
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }

        // Hapus produk (dan relasi images akan terhapus otomatis karena onDelete('cascade'))
        $product->delete();

        return redirect()->route('admin.products.index')
            ->with('success', 'Produk berhasil dihapus.');
    }

    /**
     * Menghapus satu gambar produk secara spesifik.
     */
    public function destroyImage($imageId)
    {
        $image = ProductImage::findOrFail($imageId);
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'Gambar berhasil dihapus.');
    }
}
