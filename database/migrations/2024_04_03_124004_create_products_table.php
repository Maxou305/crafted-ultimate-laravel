<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 50);
            $table->string('description', 200);
            $table->string('story', 200);
            $table->float('price', 2);
            $table->integer('quantity');
            $table->string('image');
            $table->string('category', 20);
            $table->string('color', 20);
            $table->string('material', 20);
            $table->string('size', 10);
            $table->foreignUuid('shop_id')->constrained('shops');
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
