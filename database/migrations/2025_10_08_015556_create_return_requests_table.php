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
        Schema::create('return_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_item_id')->constrained()->onDelete('cascade');

            $table->enum('type', ['Return', 'Exchange'])->comment('Jenis permintaan: Pengembalian Dana atau Tukar Barang');
            $table->text('reason');
            $table->enum('status', ['Pending', 'Approved', 'Rejected', 'Processing', 'Completed'])->default('Pending');
            $table->text('admin_notes')->nullable(); // Catatan dari admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('return_requests');
    }
};
