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
        Schema::create('shipping_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: "JNE REG" atau "SiCepat BEST"
            $table->text('description')->nullable(); // Contoh: "Estimasi 2-3 hari kerja"
            $table->unsignedBigInteger('cost'); // Biaya pengiriman dalam format angka (misal: 25000)
            $table->boolean('is_active')->default(true); // Untuk mengaktifkan/menonaktifkan opsi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_methods');
    }
};
