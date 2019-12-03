<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Table;
use Faker\Generator as Faker;

$factory->define(Table::class, function (Faker $faker) {
    return [
        'number' => $faker->numberBetween(1, 100),
        'restaurant_id' => factory(Restaurant::class)
    ];
});
