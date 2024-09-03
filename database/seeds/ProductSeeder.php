<?php

use Illuminate\Database\Seeder;
use App\Category;
use App\Listing;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = factory(Listing::class, 5)->create()->each(function ($product) {
            $product->categories()->attach(Category::where('uniq_name', 'hardware')->first()->id);
        });
    }
}
