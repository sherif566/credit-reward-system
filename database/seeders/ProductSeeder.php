<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\OfferPool;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // createe 5 categories
        $categories = Category::factory()->count(5)->create();

        // create 10 products with random categories
        $products = Product::factory()->count(10)->make()->each(function ($product) use ($categories) {
            $product->category_id = $categories->random()->id;
            $product->save();
        });

        // Add 5 random products to the offer pool
        $products->random(5)->each(function ($product) {
            OfferPool::create(['product_id' => $product->id]);
        });
    }
}
