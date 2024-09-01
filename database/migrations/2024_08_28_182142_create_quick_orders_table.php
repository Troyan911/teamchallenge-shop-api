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
        Schema::create('quick_orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name', 50);
            $table->string('phone_number', 50);
            $table->unsignedBigInteger('product_id');
            $table->integer('quantity');
            $table->string('delivery_address');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quick_orders');
    }
};
