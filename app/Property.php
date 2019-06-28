<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Ship;

class Property extends Model
{
    public function ships()
    {
        return $this->belongsToMany(Ship::class);
    }
}
