<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('payment_method', 30)->default('bank_transfer')->after('total');
            $table->string('recipient_name')->nullable()->after('payment_method');
            $table->string('recipient_phone', 30)->nullable()->after('recipient_name');
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['payment_method', 'recipient_name', 'recipient_phone']);
        });
    }
};
