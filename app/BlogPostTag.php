<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPostTag extends Model
{
    //
    protected $fillable = array('post_id', 'tag_id');
}
