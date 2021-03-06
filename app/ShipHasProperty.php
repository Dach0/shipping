<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ship;
use App\Property;
use App\Expence;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipHasProperty extends Model
{
    use SoftDeletes;
    
    protected $guarded = [];
    
    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }
    
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
    public function expence()
    {
        return $this->belongsTo(Expence::class);
    }
}
