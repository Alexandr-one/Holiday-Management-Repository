<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(\App\Application::class, function (Faker $faker) {
    return [
        'user_id' => 1,
        'date_start' => 2022-03-12,
        'date_finish' => 2022-03-14,
        'status' => \App\Classes\ApplicationStatusEnum::CONFIRMED,
        'number_of_days' => 5,
    ];
});
