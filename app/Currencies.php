<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currencies extends Model
{
    //
    protected $fillable = [
        'country','symbol','exchange_rate',
    ];
}
