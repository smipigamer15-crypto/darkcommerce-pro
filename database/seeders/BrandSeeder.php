<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = ['Apple', 'Samsung', 'Sony', 'Nike', 'Adidas', 'Microsoft', 'Google', 'Dell', 'LG', 'Bose'];

        foreach ($brands as $brand) {
            Brand::create([
                'name' => $brand,
                'slug' => str()->slug($brand),
            ]);
        }
    }
}