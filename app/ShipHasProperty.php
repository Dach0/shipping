<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ship;
use App\Property;

class ShipHasProperty extends Model
{
    protected $guarded = [];
    
    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }
    
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
