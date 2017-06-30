<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;

class BlogCategory extends Model
{
    //
    protected $fillable = array('category');

    public function post(){
        return $this->hasMany('App\Post','category_id');
    }
}
