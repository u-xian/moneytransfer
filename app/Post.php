<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\BlogPostComments;
use App\BlogCategory;

class Post extends Model
{
    //
    protected $fillable = array('url', 'title', 'description', 'content', 'image', 'category_id','author_id');

    public function tags() {
        return $this->belongsToMany('App\BlogTag','blog_post_tags','post_id','tag_id');
    }
    public function comments(){
        return $this->hasMany('App\BlogPostComments','on_post');
    }
  // returns the instance of the user who is author of that post
    public function author(){
        return $this->belongsTo('App\User','author_id');
    }

    public function categories(){
        return $this->belongsTo('App\BlogCategory');
    }
}
