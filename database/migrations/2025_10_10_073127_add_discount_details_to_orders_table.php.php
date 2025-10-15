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
        Schema::table('orders', function (Blueprint $table) {
            // Kolom untuk menyimpan kode promo yang digunakan
            $table->string('promo_code')->nullable()->after('points_used');
            // Kolom untuk menyimpan jumlah potongan dari promo
            $table->unsignedBigInteger('promo_discount')->default(0)->after('promo_code');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['promo_code', 'promo_discount']);
        });
    }
};
