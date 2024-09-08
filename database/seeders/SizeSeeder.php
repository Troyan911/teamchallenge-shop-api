<?php

namespace Database\Seeders;

use App\Enums\Products\Size;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (Size::cases() as $status) {
            DB::table('sizes')->insert([
                'name' => $status->value, // Or $status->name if you want the enum name
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
