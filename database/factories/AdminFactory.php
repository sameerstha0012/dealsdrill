<?php

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

$factory->define(App\Admin::class, function (Faker $faker) {
    static $password;

    return [
        // 'name' => $faker->name,
        // 'email' => $faker->unique()->safeEmail,
        'name' => 'admin',
        'email' => 'zanam.rewasoft@gmail.com',
        'password' => $password ?: $password = bcrypt('12345678'),
        'status' => 'Active',
        'verified' => true,
    ];
});
