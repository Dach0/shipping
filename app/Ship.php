<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Property;

class Ship extends Model
{

    protected $guarded=[];

    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }
}
