<?php

use Illuminate\Database\Seeder;
use App\Animal;

class AnimalsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Animal::truncate();

        Animal::create(['name' => 'Собака', 'cat_id' => 0]);
        Animal::create(['name' => 'Кошка', 'cat_id' => 0]);
        Animal::create(['name' => 'Попугай', 'cat_id' => 0]);
    }
}
