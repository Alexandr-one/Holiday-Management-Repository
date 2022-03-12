<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use Faker\Generator as Faker;

$factory->define(\App\Organization::class, function (Faker $faker) {
    return [
        'name' => 'Ryzhakoff',
        'director_id' => 1,
        'max_duration_of_vacation' => 60,
        'min_duration_of_vacation' => 20
    ];
});
