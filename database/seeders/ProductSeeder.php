<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str; // <-- 1. TAMBAHKAN IMPORT INI

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan kategori sudah ada
        $tshirtId = Category::where('name', 'T-Shirt')->first()->id;
        $hoodieId = Category::where('name', 'Hoodie & Sweater')->first()->id;
        $celanaId = Category::where('name', 'Celana')->first()->id;
        $aksesorisId = Category::where('name', 'Aksesoris')->first()->id;

        // Produk 1: T-Shirt
        Product::create([
            'category_id' => $tshirtId,
            'name' => 'Classic Logo Tee - Black',
            'slug' => Str::slug('Classic Logo Tee - Black'), // <-- 2. TAMBAHKAN SLUG
            'description' => 'Kaos katun premium dengan logo eyetails.co klasik. Desain minimalis yang cocok untuk gaya sehari-hari.',
            'price' => 250000,
            'sku' => 'ET-TEE-001',
            'stock_quantity' => 150,
        ]);

        // Produk 2: Hoodie
        Product::create([
            'category_id' => $hoodieId,
            'name' => 'Essential Oversized Hoodie - Grey',
            'slug' => Str::slug('Essential Oversized Hoodie - Grey'), // <-- 3. TAMBAHKAN SLUG
            'description' => 'Hoodie oversized dengan bahan fleece tebal, cocok untuk gaya streetwear modern dan nyaman.',
            'price' => 550000,
            'sale_price' => 499000, // Contoh produk promo
            'sku' => 'ET-HD-002',
            'stock_quantity' => 80,
        ]);

        // Produk 3: Celana
        Product::create([
            'category_id' => $celanaId,
            'name' => 'Urban Cargo Pants - Olive',
            'slug' => Str::slug('Urban Cargo Pants - Olive'), // <-- 4. TAMBAHKAN SLUG
            'description' => 'Celana kargo fungsional dengan potongan modern, dibuat dari bahan twill yang kuat.',
            'price' => 450000,
            'sku' => 'ET-PNT-003',
            'stock_quantity' => 120,
        ]);

        // Produk 4: Aksesoris
        Product::create([
            'category_id' => $aksesorisId,
            'name' => 'Minimalist Beanie - Navy',
            'slug' => Str::slug('Minimalist Beanie - Navy'), // <-- 5. TAMBAHKAN SLUG
            'description' => 'Beanie rajut simpel untuk melengkapi gaya kasual Anda di cuaca yang lebih dingin.',
            'price' => 150000,
            'sku' => 'ET-ACC-004',
            'stock_quantity' => 200,
        ]);
    }
}
