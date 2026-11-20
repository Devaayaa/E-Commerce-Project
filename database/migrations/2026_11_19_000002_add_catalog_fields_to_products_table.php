<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('category', 30)->nullable()->index()->after('description');
            $table->string('emoji', 16)->nullable()->after('category');
            $table->decimal('original_price', 12, 2)->nullable()->after('price');
            $table->unsignedTinyInteger('discount')->nullable()->after('original_price');
            $table->unsignedInteger('sold')->default(0)->after('stock');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['category', 'emoji', 'original_price', 'discount', 'sold']);
        });
    }
};
