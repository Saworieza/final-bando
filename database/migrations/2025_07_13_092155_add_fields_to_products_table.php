<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->string('sku')->unique()->nullable();
            $table->integer('stock_qty')->default(0);
            $table->integer('min_order_qty')->default(1);
            $table->decimal('weight', 8, 2)->nullable();
            $table->string('dimensions')->nullable(); // L*W*H
            $table->text('warranty')->nullable();
            $table->text('return_policy')->nullable();
            $table->enum('status', ['Active', 'Inactive', 'OutOfStock'])->default('Active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
