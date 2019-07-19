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
        return Order::orderBy('created_at', 'DESC')->with('destination','ship')->get();
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


    public function calculatePrice()
    {
        return Order::calculatePrice(\Request::get('dest_id'),  \Request::get('ship_id'));
    }
    
}
