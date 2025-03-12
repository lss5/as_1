<?php

use App\Models\Category;
use App\Models\Listing;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = factory(Listing::class, 5)->create()->each(function ($product) {
            $product->categories()->attach(Category::where('uniq_name', 'hardware')->first()->id);
        });
    }
}
