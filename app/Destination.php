<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Order;

class Destination extends Model
{
    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
