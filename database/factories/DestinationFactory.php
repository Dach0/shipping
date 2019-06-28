<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Destination;
use Faker\Generator as Faker;

$factory->define(Destination::class, function (Faker $faker) {
    return [
        'destination_name' =>  $faker->randomElement($array = array ('Tianjin', 'Bari', 'Rotterdam', 'Port Klang','Hamburg', 'Antwerp', 'Istanbul', 'Gdansk' )), 
        'distance' => $faker->numberBetween($min = 80, $max = 1200) 
    ];
});     
