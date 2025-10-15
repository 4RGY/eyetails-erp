<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('users', function (Blueprint $table) {
            // Tambahkan kolom setelah 'tier' atau kolom terakhir yang relevan
            $table->boolean('notif_promo')->default(true)->after('tier');
            $table->boolean('notif_order_updates')->default(true)->after('notif_promo');
        });
    }

    public function down(): void {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['notif_promo', 'notif_order_updates']);
        });
    }
};