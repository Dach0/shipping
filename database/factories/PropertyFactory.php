<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Property;
use Faker\Generator as Faker;

$factory->define(Property::class, function (Faker $faker) {
    return [
        'property_name' => $faker->randomElement($array = array ('consumption', 'crew_number', 'max_speed')),
        'property_amount' => $faker->numberBetween($min = 15, $max = 50), 
   ];
});
