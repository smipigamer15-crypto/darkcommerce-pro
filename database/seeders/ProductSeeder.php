<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        Product::truncate();
        ProductImage::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        
        $brands = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
        $names = [
            'Wireless Headphones', 'Smart Watch', 'Running Shoes', 'Gaming Monitor',
            'Bluetooth Speaker', 'Laptop Pro', 'Tablet', 'T-Shirt', 'Earbuds',
            'Mechanical Keyboard', 'USB-C Hub', 'Webcam HD', 'Mouse Pad', 'Phone Case',
            'Screen Protector', 'Charger', 'Cable', 'Backpack', 'Sunglasses', 'Wallet',
            'Desk Lamp', 'Coffee Maker', 'Water Bottle', 'Notebook', 'Pen Set',
            'Desk Organizer', 'Monitor Stand', 'Cable Management', 'Plant Pot'
        ];

        foreach ($names as $index => $name) {
            $price = rand(10, 2000) + rand(0, 99) / 100;
            $hasDiscount = rand(0, 1);
            
            $product = Product::create([
                'name' => $name . ' ' . rand(1, 10),
                'slug' => \Str::slug($name . '-' . uniqid()),
                'sku' => 'SKU-' . strtoupper(\Str::random(8)),
                'description' => 'Premium quality ' . strtolower($name) . ' with excellent features and modern design.',
                'short_description' => 'High-quality ' . strtolower($name),
                'price' => $price,
                'discount_price' => $hasDiscount ? round($price * rand(70, 90) / 100, 2) : null,
                'stock' => rand(0, 200),
                'brand_id' => $brands[array_rand($brands)],
                'is_active' => true,
                'is_featured' => rand(0, 1) === 1,
            ]);
            
            ProductImage::create([
                'product_id' => $product->id,
                'url' => 'https://picsum.photos/seed/' . $product->slug . '/600/600',
                'alt_text' => $product->name,
                'is_primary' => true,
                'sort_order' => 0,
            ]);
        }

        $categories = Category::all();
        $allProducts = Product::all();

        foreach ($allProducts as $product) {
            $product->categories()->attach(
                $categories->random(rand(1, 3))->pluck('id')->toArray()
            );
        }
    }
}