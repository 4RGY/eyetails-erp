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
            //
            // Tambahkan kolom gender dan tanggal lahir (nullable agar tidak wajib saat ini)
            $table->enum('gender', ['Laki-laki', 'Perempuan', 'Lainnya'])->nullable()->after('email');
            $table->date('date_of_birth')->nullable()->after('gender');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('gender');
            $table->dropColumn('date_of_birth');
        });
    }
};
