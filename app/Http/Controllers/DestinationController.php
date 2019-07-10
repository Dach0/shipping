<?php

namespace App\Http\Controllers;

use App\Destination;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDestinationRequest;
use App\Http\Requests\UpdateDestinationRequest;

class DestinationController extends Controller
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
        return Destination::all();
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
    public function store(StoreDestinationRequest $request)
    {
        if (\Gate::allows('isAdmin') || \Gate::allows('isOperator') ){

            $destination = Destination::create($request->all());
    
            return ['message' => 'Destinacija kreirana', 'data' => response()->json($destination)];
        }
        abort(403, 'Unauthorized action.');
    }

    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDestinationRequest $request, $id)
    {
        Destination::findOrFail($id)->update($request->all());

        return['message' => 'Izmijenjeni podaci o destinaciji'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Destination  $destination
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       Destination::findOrFail($id)->delete();

        return['message' => 'Obrisan podatak o destinaciji'];
    }
}
