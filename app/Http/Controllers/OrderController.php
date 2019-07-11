<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use App\Destination;
use App\Ship;
use App\Http\Requests\StoreOrderRequest;

class OrderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Order::with('destination','ship')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreOrderRequest $request)
    {
        Order::create($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function calculatePrice()
    {
        $destination_id = \Request::get('dest_id');
        $ship_id = \Request::get('ship_id');

        $ship = Ship::findOrFail($ship_id);
        $destination = Destination::findOrFail($destination_id);

        $consumption = null;
        $crew_number  = null;
        $max_speed = null;
        $avg_paycheck = null;
        $fuel_price = null;
        $food_price = null;
        $destination_distance = $destination->distance;

        foreach ($ship->properties as $property) {
            if($property->property_name == 'consumption'){
                $consumption = $property->property_amount;
            }
            if($property->property_name == 'crew_number'){
                $crew_number = $property->property_amount;
            }
            if($property->property_name == 'max_speed'){
                $max_speed = $property->property_amount;
            }
        }
        foreach ($ship->expences as $expence) {
            if($expence->expence_name == 'avg_paycheck'){
                $avg_paycheck = $expence->expence_amount;
            }
            if($expence->expence_name == 'fuel_price'){
                $fuel_price = $expence->expence_amount;
            }
            if($expence->expence_name == 'food_price'){
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
