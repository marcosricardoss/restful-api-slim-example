<?php

namespace Marcosricardoss\Restful\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

class User extends Eloquent {
    
    protected $fillable = ['username', 'password', 'role'];

    /**
     * Get the black list tokens of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function blacklistedTokens() {
        return $this->hasMany("Marcosricardoss\Restful\Model\BlacklistedToken", 'user_id');
    }

    /**
     * Get the posts of the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\hasMany
     */
    public function posts() {
        return $this->hasMany('Marcosricardoss\Restful\Model\Post', 'created_by');
    }

}