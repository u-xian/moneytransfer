<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transactions extends Model
{
    //
    protected $fillable = array('sender_id', 'receiver_number', 'amount', 'status', 'transaction_type','created_at','updated_at');

}
