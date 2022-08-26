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

$factory->define(App\Vehicle::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->randomElement(['sedan', 'executive sedan', 'van', 'suv', 'shuttle van', 'limo']),
        'code' => $faker->randomElement(['sedan', 'esedan', 'van', 'suv', 'shuttle']),
        'luggage_capacity' => rand(1, 2),
        'passenger_capacity' => rand(1, 2),
        'status' => 'Active',
        'order' => rand(1, 2),
    ];
});
