<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Post;
class BlogPostComments extends Model
{
    //
    //comments table in database
    protected $fillable = array('on_post', 'names','email', 'body');

    // returns post of any comment
    public function post(){
        return $this->belongsTo('Post');
    }
}
