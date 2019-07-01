<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Ship;
use Faker\Generator as Faker;

$factory->define(Ship::class, function (Faker $faker) {
    return [
        'boat_name' => $faker->unique()->randomElement($array = array ('Vardar', 'Kapetan kuka', 'Barakuda', 'Sezonac', 'Jegulja'), $count = 1), 
    ];
});
