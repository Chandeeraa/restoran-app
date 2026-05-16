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
        Schema::table('menus', function (Blueprint $table) {
            $table->boolean('track_stock')->default(false)->after('is_best_seller'); // apakah stok dikelola?
            $table->integer('stock')->default(0)->after('track_stock'); // jumlah stok
            $table->integer('low_stock_threshold')->default(5)->after('stock'); // alert jika stok <= ini
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('menus', function (Blueprint $table) {
            $table->dropColumn(['track_stock', 'stock', 'low_stock_threshold']);
        });
    }
};
