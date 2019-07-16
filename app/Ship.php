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

    /**
   * Override parent boot and Call deleting event
   *
   * @return void
   */
   protected static function boot() 
    {
      parent::boot();

      static::deleting(function($ship) {
         foreach ($ship->shipHasProperties()->get() as $property) {
            $property->update(array('active' => false));    
            $property->delete();
         }
      });
    }

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

    public function getPropertiesForShip($ship)
    {
        $consumption = null;
        $crew_number = null;
        $max_speed = null;

        foreach ($ship->shipHasProperties as $property) {
            if($property->property_id == 1){
                $consumption = $property->property_amount;
            }
            if($property->property_id == 2){
                $crew_number = $property->property_amount;
            }
            if($property->property_id == 3){
                $max_speed = $property->property_amount;
            }
        }

        return [ 'boat_id' => $ship->id, 'boat_name' => $ship->boat_name, 'consumption' => $consumption, 'crew_number' => $crew_number, 'max_speed' => $max_speed ];

    }

    public function updateProperty($ship, $request)
    {
        foreach ($ship->shipHasProperties()->get() as $property) {
            $property->update(array( 'active' => false));    
         }

        $ship->addProperty($request);

        return $this;
    }

    public function deactivateProperty($ship_id)
    {
        ShipHasProperty::where('ship_id', $ship_id)->update(array('active' => false));
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
