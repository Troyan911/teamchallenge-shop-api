<?php

namespace Database\Factories;

use App\Enums\Products\Gender;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductVariant>
 */
class ProductVariantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'color_id' => fake()->numberBetween(13,15),
            'size_id' => fake()->numberBetween(1,8),
            'quantity'=>fake()->numberBetween(1,10),
            'photo_id'=>(rand(1, 5) % 2 === 0 ? 106 : 107),
        ];
    }
}
