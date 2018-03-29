<?php

namespace Marcosricardoss\Restful\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class Keyword extends Eloquent {
    
    public $timestamps = false;
    
    protected $fillable = ['name'];
    protected $hidden = ['pivot'];

}