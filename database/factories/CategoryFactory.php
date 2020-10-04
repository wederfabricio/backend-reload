<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Category;
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

$factory->define(Category::class, function (Faker $faker) {
    return [
        'desc' => ucfirst($faker->unique()->word()),
        'parent_id' => function () {

            $categories = App\Category::all();

            return $categories->count() > 2
                ? $categories[rand(0, $categories->count()-1)]->id
                : null;
        }
    ];
});
