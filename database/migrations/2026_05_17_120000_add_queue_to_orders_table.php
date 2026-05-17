<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // queue_type: 1 = Cash (priority), 2 = QRIS/Non-cash
            $table->unsignedTinyInteger('queue_type')->nullable()->after('payment_method');
            // queue_number: sequential per queue_type per day
            $table->unsignedSmallInteger('queue_number')->nullable()->after('queue_type');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['queue_type', 'queue_number']);
        });
    }
};
