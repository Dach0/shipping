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
         foreach ($ship->shipHasExpences()->get() as $expence) {
            $expence->update(array('active' => false));    
            $expence->delete();
         }
      });
    }

    public function shipHasProperties()
    {
        return $this->hasMany(ShipHasProperty::class);
    }
    
    public function addProperty($property)
    {
        $this->shipHasProperties()->createMany([
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
    
        return $this;
    }

    //drugi nacin za popunjavanje editShipProperty fronta, ako ne uzmem direktno podatke nego preko apija
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


    public function addStandardExpences()
    {
        $this->shipHasExpences()->createMany([
        [
            'expence_id' => 1,
            'expence_amount' => 1800,
            'active' => true,
        ],
        [
            'expence_id' => 2,
            'expence_amount' => 0.6,
            'active' => true,
        ],
        [
            'expence_id' => 3,
            'expence_amount' => 2.5,
            'active' => true,
        ]
        ]);
    
    }
    
    public function updateExpence($ship, $request)
    {
        foreach ($ship->shipHasExpences()->get() as $expence) {
            $expence->update(array( 'active' => false));    
         }

        $this->shipHasExpences()->createMany([
        [
            'expence_id' => 1,
            'expence_amount' => $request->avg_paycheck,
            'active' => true,
        ],
        [
            'expence_id' => 2,
            'expence_amount' => $request->fuel_price,
            'active' => true,
        ],
        [
            'expence_id' => 3,
            'expence_amount' => $request->food_price,
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
