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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->integer('order_number')-> unique();
            $table->foreignUuid('user_id')->constrained('users')->onDelete('cascade');
            $table->float('price');
            $table->boolean('validatedStatus')->nullable();
            $table->string('shippingCountry')->nullable();
            $table->string('shippingMode')->nullable();
            $table->string('shippingPrice')->nullable();
            $table->string('creatorCode')->nullable();
            $table->string('promoCode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
