<?php

namespace App\Http\Controllers;

use App\Ship;
use Illuminate\Http\Request;
use App\Http\Requests\StoreShipRequest;
use App\Http\Requests\UpdateShipRequest;
use App\Http\Requests\UpdateShipExpencesRequest;
use Illuminate\Support\Facades\Auth;
use App\ShipHasProperty;

class ShipController extends Controller
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
        return Ship::with(['shipHasProperties' => function($query) {
                                $query->where('active', true);
                        }, 'shipHasProperties.property'])->get();
    }

    /**
     * Display a list of ships with expenses.
     *
     * @return \Illuminate\Http\Response
     */
    public function shipsWithExpences()
    {
       return Ship::with(['shipHasExpences' => function($query){
            $query->where('active', true);
       }])->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreShipRequest $request)
    {
        Ship::create(['boat_name' => $request->boat_name])->addProperty($request)->addStandardExpences();

        return ['message' => 'Kreiran brod'];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Ship  $ship
     * @return \Illuminate\Http\Response
     */
    public function show(Ship $ship)
    {
        return $ship->getPropertiesForShip($ship);        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Ship  $ship
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateShipRequest $request, Ship $ship)
    {

        $ship->updateProperty($ship, $request)->update(['boat_name' => $request->boat_name]);
        return ['msg' => 'Azurirani podaci o brodu'];
    }

    public function updateExpences(UpdateShipExpencesRequest $request, Ship $ship)
    {
        $ship->updateExpence($ship, $request);
        return ['msg' => 'Azurirani troškovi o brodu'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Ship  $ship
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ship $ship)
    {
        $ship->delete();
        return ['msg' => 'Obrisan brod'];
    }
}
