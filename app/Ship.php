<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\ShipHasProperty;
use App\ShipHasExpence;
use App\Order;

class Ship extends Model
{

    use SoftDeletes;

    protected $guarded=[];

    public function shipHasProperties()
    {
        return $this->hasMany(ShipHasProperty::class);
    }
    
    public function addProperty($property)
    {
        return $this->shipHasProperties()->createMany([
        [
            'property_id' => 1,
            'property_amount' => $property->consumption,
            'active' => true,
        ],
        [
            'property_id' => 2,
            'property_amount' => $property->crew_number,
            'active' => true,
        ],
        [
            'property_id' => 3,
            'property_amount' => $property->max_speed,
            'active' => true,
        ]
        ]);
    
    }



    public function shipHasExpences()
    {
        return $this->hasMany(ShipHasExpence::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
