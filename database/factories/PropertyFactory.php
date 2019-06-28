<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Property;
use Faker\Generator as Faker;

$factory->define(Property::class, function (Faker $faker) {
    return [
        'consumption' => $faker->numberBetween($min = 15, $max = 50), 
        'crew_number' => $faker->numberBetween($min = 15, $max = 50),
        'max_speed' => $faker->numberBetween($min = 15, $max = 50)
   ];
});
