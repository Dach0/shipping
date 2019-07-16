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
        Ship::create(['boat_name' => $request->boat_name])->addProperty($request);

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
    public function update(UpdateShipRequest $request, Ship $ship)
    {

        $ship->updateProperty($ship, $request)->update(['boat_name' => $request->boat_name]);
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
    public function destroy(Ship $ship)
    {
        $ship->delete();
        return ['msg' => 'Obrisan brod'];
    }
}
