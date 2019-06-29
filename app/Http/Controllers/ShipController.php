<?php

namespace App\Http\Controllers;

use App\Ship;
use Illuminate\Http\Request;
use App\Http\Requests\StoreShipRequest;

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

        $ship = Ship::create([ 'boat_name' => $request->boat_name]);

        $ship->properties()->attach($request->property_id);

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
        //
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
    public function update(Request $request, Ship $ship)
    {
        //
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
       
        $ship->properties()->detach($ship->pivot->property_id);
        $ship->delete();
        return ['msg' => 'Obrisan brod'];
    }
}
