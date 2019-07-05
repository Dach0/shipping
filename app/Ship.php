<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Property;
use App\Expence;
use App\Order;

class Ship extends Model
{

    protected $guarded=[];

    public function properties()
    {
        return $this->belongsToMany(Property::class);
    }

    public function expences()
    {
        return $this->belongsToMany(Expence::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
