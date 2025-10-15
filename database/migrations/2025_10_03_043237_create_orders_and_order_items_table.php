<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Tabel Utama: orders
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // User yang membuat pesanan (NULL jika Guest Checkout)
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');

            // Detail Pengiriman & Pelanggan (untuk Guest Checkout)
            $table->string('customer_name');
            $table->string('customer_email');
            $table->text('shipping_address');

            $table->enum('order_status', ['Pending', 'Processing', 'Shipped', 'Completed', 'Cancelled'])->default('Pending');
            $table->string('payment_method')->nullable();
            $table->unsignedBigInteger('subtotal');
            $table->unsignedBigInteger('shipping_cost')->default(0);
            $table->unsignedBigInteger('total_amount'); // Total Akhir

            // Kolom untuk Integrasi Loyalitas (Jika poin digunakan)
            $table->integer('points_used')->default(0);

            $table->timestamps();
        });

        // Tabel Detail: order_items
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('restrict');

            $table->string('product_name'); // Simpan nama produk saat itu (data historis)
            $table->unsignedBigInteger('price');
            $table->integer('quantity');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
