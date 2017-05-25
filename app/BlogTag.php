<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogTag extends Model
{
    //
    protected $fillable = array('tag');

    public function posts() {
        return $this->belongsToMany('App\Post','blog_post_tags','post_id','tag_id');
    }
}
