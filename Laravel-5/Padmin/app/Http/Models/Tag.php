<?php

namespace lvadmin\Http\Models;

use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $table = "tags";

    protected $fillable = ['name'];

    public function articles(){
        return $this->belongsToMany('lvadmin\Http\Models\Article')->withTimestamps();
    }
}
