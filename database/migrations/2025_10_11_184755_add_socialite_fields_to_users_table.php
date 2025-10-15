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
        Schema::table('users', function (Blueprint $table) {
            // Ubah kolom password agar boleh kosong (nullable)
            $table->string('password')->nullable()->change();

            // Tambahkan kolom baru untuk menyimpan ID & nama provider (Google, dll)
            $table->string('provider_name')->nullable()->after('id');
            $table->string('provider_id')->nullable()->after('provider_name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Kembalikan kolom password menjadi tidak boleh kosong
            $table->string('password')->nullable(false)->change();

            // Hapus kolom yang ditambahkan
            $table->dropColumn(['provider_name', 'provider_id']);
        });
    }
};
