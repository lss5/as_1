<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'user_id' => function (array $product) {
            $users = App\User::where('name', 'like', '%Adminstrator%')->get();
            return $users->random()->id;
        },
        'country_id' => $faker->randomElement(array_keys(App\Country::all()->toArray())),
        'title' => $faker->text(70),
        'description' => $faker->text(4096),
        'price' => $faker->numberBetween(200, 900),
        'quantity' => $faker->numberBetween(50, 10000),
        'moq' => $faker->numberBetween(1, 50),
        'power' => $faker->numberBetween(1500, 5000),
        'hashrate' => $faker->numberBetween(12, 50),
        'hashrate_name' => 'ths',
    ];
});
