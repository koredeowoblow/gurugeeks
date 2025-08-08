<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'business'],
            ['name' => 'entertainment'],
            ['name' => 'general'],
            ['name' => 'health'],
            ['name' => 'science'],
            ['name' => 'sports'],
            ['name' => 'technology'],
        ];

        Category::insert($categories); // ✅ Correct method for multiple records
    }
}
