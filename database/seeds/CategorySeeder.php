<?php

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        Category::create(['name' => 'Hardware', 'sort' => '10']);
        Category::create(['name' => 'Power supply', 'sort' => '20']);
        Category::create(['name' => 'Accessories', 'sort' => '30']);
        Category::create(['name' => 'Other', 'sort' => '40']);
    }
}
