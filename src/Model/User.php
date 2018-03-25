<?php

namespace Marcosricardoss\Restful\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent {
    
    protected $fillable = ['username', 'password', 'role'];

    public function blacklistedTokens() {
        return $this->hasMany("Marcosricardoss\Restful\Model\BlacklistedToken", 'user_id');
    }

    public function posts() {
        return;
    }

}