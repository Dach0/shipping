<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Expence extends Model
{
    protected $fillable = ['expence_name', 'expence_amount'];
}
