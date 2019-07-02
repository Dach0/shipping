<?php

namespace App\Http\Controllers;

use App\Ship;
use Illuminate\Http\Request;
use App\Http\Requests\StoreShipRequest;
use App\Http\Requests\UpdateShipRequest;

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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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
        // $ship = Ship::findOrFail($id)->with('properties')->get();    -> vraća sve veze!?

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
