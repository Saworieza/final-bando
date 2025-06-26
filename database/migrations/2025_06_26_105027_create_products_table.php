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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade'); // seller
        $table->string('name');
        $table->text('description')->nullable();
        $table->string('sku')->unique();
        $table->string('category')->nullable();
        $table->string('tags')->nullable(); // comma-separated
        $table->decimal('price', 10, 2);
        $table->unsignedInteger('min_order_qty')->default(1);
        $table->enum('status', ['active', 'inactive', 'out_of_stock'])->default('active');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
