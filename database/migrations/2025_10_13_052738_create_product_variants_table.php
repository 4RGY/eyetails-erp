<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('size'); // Contoh: 'S', 'M', 'L', 'XL'
            $table->integer('quantity');
            $table->timestamps();

            // Satu produk tidak boleh punya ukuran yang sama lebih dari sekali
            $table->unique(['product_id', 'size']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
