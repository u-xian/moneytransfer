<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customerfile extends Model
{
    //
    protected $fillable = [
        'name','size','type','customer_id',
    ];

    

    public function customer()
    {
        return $this->belongsTo('App\Customers','customer_id','id');
    }

}
