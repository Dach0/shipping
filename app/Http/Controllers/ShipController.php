<?php

namespace App\Http\Controllers;

use App\Ship;
use Illuminate\Http\Request;
use App\Http\Requests\StoreShipRequest;
use App\Http\Requests\UpdateShipRequest;
use App\Http\Requests\UpdateShipExpencesRequest;
use Illuminate\Support\Facades\Auth;

class ShipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Ship::with('properties')->get();
    }

    /**
     * Display a list of ships with expenses.
     *
     * @return \Illuminate\Http\Response
     */
    public function shipsWithExpences()
    {
       return Ship::with('expences')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShipRequest $request)
    {
        $ship = Ship::create(['boat_name' => $request->boat_name]);

        $ship->properties()->attach([$request->selected_consumption, $request->selected_max_speed, $request->selected_crew_number]);

        $ship->expences()->attach([1,2,3]);

        return ['message' => 'Kreiran brod'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ship  $ship
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return Ship::with('properties','expences')->findOrFail($id);  -> ako hoću da hendlujem na frontu

        $ship = Ship::findOrFail($id);
        $consumption_id = null;
        $crew_number_id = null;
        $max_speed_id = null;

        foreach ($ship->properties as $property) {
            if($property->property_name == 'consumption'){
                $consumption_id = $property->id;
            }
            if($property->property_name == 'crew_number'){
                $crew_number = $property->id;
            }
            if($property->property_name == 'max_speed'){
                $max_speed = $property->id;
            }
        }

        return [ 'boat_id' => $ship->id, 'boat_name' => $ship->boat_name, 'consumption_id' => $consumption_id, 'crew_number_id' => $crew_number, 'max_speed_id' => $max_speed ];
        
    }

    public function showExpence($id)
    {
        return Ship::with('expences')->findOrFail($id);
        //kod za jedan dbro sa expensijima
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Ship  $ship
     * @return \Illuminate\Http\Response
     */
    public function edit(Ship $ship)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ship  $ship
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShipRequest $request)
    {
        $ship = Ship::findOrFail($request->id);
        $ship->properties()->detach();
        $ship->properties()->attach([$request->selected_consumption, $request->selected_max_speed, $request->selected_crew_number]);
        $ship->update(['boat_name' => $request->boat_name]);
        return ['msg' => 'Azurirani podaci o brodu'];
    }

    public function updateExpences($id, UpdateShipExpencesRequest $request)
    {
        $ship = Ship::findOrFail($id);
        $ship->expences()->detach();
        $ship->expences()->attach([$request->avg_paycheck_id, $request->fuel_price_id, $request->food_price_id]);
        $ship->update(['boat_name' => $request->boat_name]);
        return ['msg' => 'Azurirani troškovi o brodu'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ship  $ship
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ship = Ship::findOrFail($id);
 
        $ship->properties()->detach();

        $ship->delete();
        return ['msg' => 'Obrisan brod'];
    }
}
