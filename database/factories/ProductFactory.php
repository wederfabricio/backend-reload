<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Product;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Product::class, function (Faker $faker) {
    return [
        'ref' => str_pad(strtoupper($faker->randomLetter()), 4,$faker->randomNumber(3)) ,
        'quantity' => $faker->randomNumber(3),
        'resume' => $faker->sentence(6, true),
        'price_ht' => $faker->randomFloat(2,1),
        'price_ttc' => $faker->randomFloat(2,1),
        'desc' => $faker->paragraph(2, true),
        'active' => $faker->boolean(80),
        'category_id' => function () {
            $categories = App\Category::all();

            return $categories->count() > 0
                ? $categories[rand(0, $categories->count()-1)]->id
                : factory(App\Category::class)->create();
        }
    ];
});
