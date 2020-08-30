<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use Faker\Generator as Faker;

$factory->define( \App\Shopping::class, function (Faker $faker) {
    return [
            'name' => $faker->company,
            'price' => $faker->randomNumber()
    ];
});
