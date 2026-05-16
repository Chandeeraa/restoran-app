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
        Schema::create('store_settings', function (Blueprint $table) {
            $table->id();
            $table->string('store_name')->default('Restoran App');
            $table->text('store_address')->nullable();
            $table->string('store_phone')->nullable();
            $table->decimal('tax_rate', 5, 2)->default(0); // e.g., 11.00 for 11%
            $table->decimal('service_charge_rate', 5, 2)->default(0); // e.g., 5.00 for 5%
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('store_settings');
    }
};
