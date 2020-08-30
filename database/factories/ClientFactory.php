<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define(App\Client::class, function (Faker $faker) {
    return [
        'tel_number' => $faker->phoneNumber,
        'email' => $faker->unique()->safeEmail
    ];
});
