<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\User;
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

$factory->define(User::class, function (Faker $faker) {
    return [
        'fio' => 'Рыжаков Александр Николаевич',
        'fio_parent_case' => 'Рыжакова Александра Николаевича',
        'email' => $faker->email,
        'email_verified_at' => now(),
        'password' => '$2y$10$CycaZqZRuTnlFzXTr361/.GUZTUtCqSR8nGw6v0vtENmKQPx0Xov6', // password
        'remember_token' => Str::random(10),
        'position_id' => 1,
        'status' => \App\Classes\UserStatusEnum::ACTIVE,
        'role' => \App\Classes\UserRolesEnum::ADMIN,
        'address' => $faker->address,
    ];
});
