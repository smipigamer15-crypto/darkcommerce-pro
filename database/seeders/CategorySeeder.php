<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Electronics',
            'Fashion',
            'Home & Garden',
            'Sports',
            'Books',
            'Toys',
            'Health',
            'Automotive',
            'Food',
            'Music',
        ];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => str()->slug($category),
            ]);
        }
    }
}