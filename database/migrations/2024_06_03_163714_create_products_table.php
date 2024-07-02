<?php

use App\Enums\Products\Gender;
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
        $genders = array_map(fn ($enum) => $enum->value, Gender::cases());
        Schema::create('products', function (Blueprint $table) use ($genders) {
            $table->id();
            $table->string('slug')->unique();
            $table->string('directory')->unique();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('SKU', 35);
            $table->enum('gender', $genders)->nullable();
            $table->float('price', unsigned: true)->startingValue(0);
            $table->float('new_price', unsigned: true)->startingValue(1)->nullable();
            $table->string('thumbnail')->nullable();
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
