<?php

use Illuminate\Support\Str;
use Faker\Generator as Faker;

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

$factory->define(App\User::class, function (Faker $faker) {
    return [
        'clave_usuario' => $faker->unique()->firstName,
        'nombre_usuario' => $faker->firstName,
        'apellido_paterno'=>$faker->lastName,
        'apellido_materno'=>$faker->lastName,
        'email' => $faker->unique()->safeEmail,
        'email_verified_at' => now(),
        'password' => '$2y$10$TKh8H1.PfQx37YgCzwiKb.KjNyWgaHb9cbcoQgdIVFlYg7B77UdFm', // secret
        'remember_token' => Str::random(10),
        'institucion'=>'CGEMSySCyT',
        'puesto'=>'Analista',
        'autorizado'=>'0',
        'role_id'=>'1',
    ];
});
