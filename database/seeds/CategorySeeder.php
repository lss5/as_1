<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create(['name' => 'Hardware', 'uniq_name' => 'hardware', 'sort' => '1']);
        Category::create(['name' => 'Power supply', 'uniq_name' => 'powersupply', 'sort' => '1']);
        Category::create(['name' => 'Accessories', 'uniq_name' => 'accessories', 'sort' => '1']);
        Category::create(['name' => 'Other', 'uniq_name' => 'other', 'sort' => '1']);
    }
}
