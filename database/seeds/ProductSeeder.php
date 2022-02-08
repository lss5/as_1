<?php

use Illuminate\Database\Seeder;
use App\Category;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = factory(App\Product::class, 300)->create()->each(function ($product) {
            $product->categories()->attach(Category::where('uniq_name', 'hardware')->first()->id);
        });
    }
}
