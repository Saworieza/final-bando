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
        Schema::create('quotes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('buyer_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('seller_id')->constrained('users')->onDelete('cascade');
            $table->string('item_name'); // Product name at time of quote
            $table->text('message'); // Quote request message
            $table->integer('quantity')->default(1);
            $table->decimal('requested_price', 10, 2)->nullable(); // If buyer suggests a price
            $table->decimal('quoted_price', 10, 2)->nullable(); // Seller's response price
            $table->enum('status', ['pending', 'replied', 'accepted', 'rejected', 'fulfilled'])->default('pending');
            $table->text('seller_response')->nullable(); // Seller's response message
            $table->timestamp('responded_at')->nullable(); // When seller responded
            $table->timestamps();
            
            // Indexes for better performance
            $table->index(['buyer_id', 'status']);
            $table->index(['seller_id', 'status']);
            $table->index(['product_id', 'status']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quotes');
    }
};