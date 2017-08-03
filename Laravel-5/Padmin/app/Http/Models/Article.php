<?php

namespace lvadmin\Http\Models\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Article extends Model {
  protected $table = "articles";

  protected $fillable = ['title', 'content', 'user_id', 'category_id'];


  public function category() {
    return $this->belongsTo('lvadmin\Http\Models\Category');
  }

  public function user() {
    return $this->belongsTo('lvadmin\Http\Models\User');
  }

  public function tags() {
    return $this->belongsToMany('lvadmin\Http\Models\Tag');
  }

  public function images() {
    return $this->hasMany('lvadmin\Http\Models\Image');
  }
}
