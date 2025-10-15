<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('promotion_user', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotion_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('used_at')->nullable(); // Untuk menandai kapan tiket/kode digunakan
            $table->timestamps(); // Ini akan berfungsi sebagai 'claimed_at'

            // Mencegah satu user mengklaim tiket yang sama lebih dari sekali
            $table->unique(['promotion_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('promotion_user');
    }
};
