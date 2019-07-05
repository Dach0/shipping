<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ship;

class Order extends Model
{
    protected $guarded = [];

    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }

    public function destination()
    {
        return $this->belongsTo(Destination::class);
    }
}
