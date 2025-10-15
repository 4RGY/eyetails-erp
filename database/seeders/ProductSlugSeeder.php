<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSlugSeeder extends Seeder
{
    public function run(): void
    {
        Product::all()->each(function (Product $product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
                $product->save();
            }
        });
    }
}
