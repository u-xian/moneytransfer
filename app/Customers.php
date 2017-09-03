<?php

namespace App;

use Laravel\Cashier\Billable;
use Laravel\Cashier\Contracts\Billable as BillableContract;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customers extends Model
{
    use Billable;
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name','last_name','sex', 'nid','phone','dob','nationality','user_id','customer_status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * Get the photos for the customer.
     */
    public function photos()
    {
        return $this->hasOne('App\Customerfile','customer_id','id');
    }
}
