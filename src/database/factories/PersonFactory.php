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

$factory->define(App\Person::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'mail' => $faker->safeEmail,
        'age' => random_int(1, 99)
    ];
});
