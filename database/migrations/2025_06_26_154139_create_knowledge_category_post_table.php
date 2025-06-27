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
        Schema::create('knowledge_category_post', function (Blueprint $table) {
            $table->id();
            $table->foreignId('knowledge_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('knowledge_post_id')->constrained()->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knowledge_category_post');
    }
};
