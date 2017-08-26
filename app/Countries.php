<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    //
    protected $fillable = [
        'iso_abbr','name','nicename','iso_name','numcode','phonecode',
    ];

    public function setNameAttribute($value)
    {
    	$this->attributes['name'] = strtoupper($value);
    }
}
