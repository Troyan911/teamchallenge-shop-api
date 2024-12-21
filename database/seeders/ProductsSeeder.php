<?php

namespace Database\Seeders;

use App\Models\Image;
use App\Models\Product;
use App\Models\ProductVariant;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        $howManyProductsToCreate=5;
//        Product::factory($howManyProductsToCreate)
//            ->count(50)
//            ->variants(1)
//            ->create();
        Product::factory()
            ->count(2)
            ->has(ProductVariant::factory()->count(6),'variants')
            ->create();
//        Image::factory()
//            ->count(2)
//            ->create();
    }
}
