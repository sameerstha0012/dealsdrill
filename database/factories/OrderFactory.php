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

$factory->define(App\Order::class, function (Faker $faker) {
    static $password;

    return [
        'token' => str_random(30),
        'pickup_address' => $faker->randomElement(["O'Hare International Airport, Chicago, IL, United States", "12345 South Michigan Avenue, Chicago, IL, United States", "Chicago Midway International Airport, Chicago, IL, United States", "Chicago, IL, United States"]),
        'destination_address' => $faker->randomElement(["O'Hare International Airport, Chicago, IL, United States", "Wisconsin Dells, WI, United States", "SpringHill Suites by Marriott Bloomington, North College Avenue, Bloomington, IN, United States"]),
        'state' => $faker->randomElement(["IL", "IN", "WI", 'TX', 'GA']),
        'distance' => rand(20, 50),
        'pickup_date' => date('Y-m-d H:m:00'),
        'no_of_passenger' => rand(1, 3),
        'no_of_luggage' => rand(1, 3),
        'airlines_info' => $faker->randomElement([null, "Aeromexico", "Etihad"]),
        'vehicle_id' => function () {
            // return factory(App\Vehicle::class)->create()->id;
            return App\Vehicle::inRandomOrder()->first()->id;
        },
        'user_id' => function () {
            // return factory(App\User::class)->create()->id;
            return App\User::inRandomOrder()->first()->id;
        },
        'sub_total' => rand(20, 50),
        'total' => rand(50, 80),
        'status' => $faker->randomElement(["Pending", "Cancelled", 'Confirmed', 'Completed']),
    ];
});
