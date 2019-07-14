<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ship;

class ShipHasExpence extends Model
{
    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }
}
