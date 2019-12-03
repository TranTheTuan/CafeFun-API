<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Address;
use App\Restaurant;
use Faker\Generator as Faker;

$factory->define(Address::class, function (Faker $faker) {
    return [
        'address_1' => $faker->streetAddress,
        'ward' => $faker->streetName,
        'district' => $faker->city,
        'province' => $faker->state,
        'restaurant_id' => factory(Restaurant::class),
    ];
});

