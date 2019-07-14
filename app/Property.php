<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ship;

class Property extends Model
{

    protected $guarded=[];

    public function shipHasProperties()
    {
        return $this->hasMany(ShipHasProperty::class);
    }
}
