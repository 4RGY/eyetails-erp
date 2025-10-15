<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            // Foreign Key ke tabel categories [cite: 49]
            $table->foreignId('category_id')->constrained()->onDelete('cascade');

            $table->string('name');
            $table->text('description');
            $table->unsignedBigInteger('price'); // Harga Produk [cite: 44]
            $table->string('sku')->unique(); // SKU (Stock Keeping Unit)
            $table->integer('stock_quantity'); // Jumlah Stok saat ini [cite: 53]
            $table->string('image')->nullable(); // Gambar Produk [cite: 49]
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
