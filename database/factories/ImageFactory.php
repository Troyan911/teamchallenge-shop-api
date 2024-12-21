<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'path' => (rand(1, 5) % 2 === 0 ? 'TestImages/embroidered-t-shirt-men.jpeg' : 'TestImages/embroidered-t-shirt-women.jpg'),
            'imageable_id'=>1,
            'imageable_type'=>1,
        ];
    }
}
