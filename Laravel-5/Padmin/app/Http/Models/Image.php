<?php

namespace lvadmin\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = "images";

    protected $fillable = ['name','articles_id'];

    public function article(){
      return $this->belongsTo('lvadmin\Http\Models\Article');
    }
}
