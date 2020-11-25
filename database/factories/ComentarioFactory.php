<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Comentario;
use Faker\Generator as Faker;

$factory->define(Comentario::class, function (Faker $faker) {
    return [
        'comentario' => $faker->sentence(3),
        'usuario_id' => App\Models\User::all()->random()->id,
        'producto_id' => App\Models\Producto::all()->random()->id
    ];
});
