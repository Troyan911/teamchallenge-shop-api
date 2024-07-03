<?php

namespace Database\Factories;

use App\Enums\Products\Gender;
use App\Enums\Products\Size;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = "Вишиванка " . fake()->unique()->words(1, true);
        $slug = Str::of($title)->slug();
        $price = fake()->randomFloat(2, 10, 100);
        $newPrice = fake()->randomFloat(2, 5, $price * 0.95);

        return [
            'title' => $title,
            'slug' => $slug,
            'directory' => $slug,
            'description' => fake()->sentence(rand(1, 5), true),
            'gender' => $this->faker->randomElement(Gender::cases())->value,
            //todo
            //            'size' => $this->faker->randomElement(Size::cases())->value,
            'SKU' => fake()->unique()->ean13(),
            'price' => $price,
            'new_price' => (rand(1, 5) % 2 === 0 ? $newPrice : null),
            'thumbnail' => fake()->imageUrl(),
        ];
    }
}
