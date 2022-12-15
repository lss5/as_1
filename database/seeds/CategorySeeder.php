<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create(['name' => 'Hardware', 'uniq_name' => 'hardware', 'sort' => '10']);
        Category::create(['name' => 'Power supply', 'uniq_name' => 'powersupply', 'sort' => '20']);
        Category::create(['name' => 'Accessories', 'uniq_name' => 'accessories', 'sort' => '30']);
        Category::create(['name' => 'Other', 'uniq_name' => 'other', 'sort' => '40']);
    }
}
