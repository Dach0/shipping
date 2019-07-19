<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Ship;
use App\Destination;

class Order extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }

    public static function calculatePrice($destination_id, $ship_id)
    {
        $ship = Ship::findOrFail($ship_id);
        $destination = Destination::findOrFail($destination_id);

        $consumption = null;
        $crew_number  = null;
        $max_speed = null;
        $avg_paycheck = null;
        $fuel_price = null;
        $food_price = null;
        $destination_distance = $destination->distance;

        foreach ($ship->shipHasProperties as $property) {
            if($property->property_id == 1){
                $consumption = $property->property_amount;
            }
            if($property->property_id == 2){
                $crew_number = $property->property_amount;
            }
            if($property->property_id == 3){
                $max_speed = $property->property_amount;
            }
        }
        foreach ($ship->shipHasExpences as $expence) {
            if($expence->expence_id == 1){
                $avg_paycheck = $expence->expence_amount;
            }
            if($expence->expence_id == 2){
                $fuel_price = $expence->expence_amount;
            }
            if($expence->expence_id == 3){
                $food_price = $expence->expence_amount;
            }
        }
        
        //brzin broda u km/h  -> čvorova * 1,85 
        $ship_speed = $max_speed * 1.85;
        
        //predje put za sati (h)
        $x = $destination_distance/$ship_speed;
        //dnevno predje kilometara
        $daily_pass = ($destination_distance*24)/$x;

        //dnevni trošak = broj_posade*(plata/30dana) + broj_posade*3obroka*cijena_hrane + daily_pass*consumption*fuel_price
        $price_per_day = $crew_number/30 + $crew_number*3*$food_price + $daily_pass*$consumption*$fuel_price;
        
        //trošak za ovu satnicu angažovanja broda
        $price = $price_per_day/24*$x;

        $total = round($price + 0.25*$price, 2); //zaokruži na dvije decimale


        return [ "potrošnja" => $consumption,
                 "broj posade" => $crew_number, 
                 "maks brzina" => $max_speed, 
                 "prosjecna plata" => $avg_paycheck,
                 "cijena goriva" => $fuel_price,
                 "cijena hrane" => $food_price,
                 "udaljenost destinacije" => $destination_distance,
                 "price" => $total];
    }
}
