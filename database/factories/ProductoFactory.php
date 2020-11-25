<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Producto;
use Faker\Generator as Faker;

$factory->define(Producto::class, function (Faker $faker) {
    return [
        'producto' => $faker->unique()->word,
        'cantidad' => $faker->numberBetween($min=0, $max=100)
    ];
});
