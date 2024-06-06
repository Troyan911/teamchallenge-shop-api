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
            $table->string('slug')->unique();
            $table->string('directory')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('SKU', 35);
            $table->float('price', unsigned: true)->startingValue(1);
            $table->float('new_price', unsigned: true)->startingValue(1)->nullable();
            $table->unsignedInteger('quantity')->startingValue(0);
            $table->string('thumbnail');
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
