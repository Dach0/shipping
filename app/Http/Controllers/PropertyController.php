<?php

namespace App\Http\Controllers;

use App\Property;
use Illuminate\Http\Request;
use App\Http\Requests\StorePropertyRequest;

class PropertyController extends Controller
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
        return Property::all();
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePropertyRequest $request)
    {
        Property::create($request->all());

        return ['msg' => 'Kreiran property'];
    }

}
