<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ship;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShipHasExpence extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function ship()
    {
        return $this->belongsTo(Ship::class);
    }
}
