<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: "Bank Transfer BCA", "GoPay"
            $table->string('code')->unique(); // Contoh: "bank_transfer", "gopay"
            $table->text('description')->nullable(); // Untuk instruksi, no. rekening, dll.
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
