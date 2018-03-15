<?php

namespace Marcosricardoss\Restful\Security;

use Marcosricardoss\Restful\Model\User;

class UserAuthenticator {
    /**
     * Authenticate username and password against database.
     *
     * @param string $username
     * @param string $password
     *
     * @return bool
     */
    public static function authenticate($username, $password) {
        
        $user = User::where('username', $username)->get();
        
        if ($user->isEmpty()) {
            return false;
        }        
        $user = $user->first();
        if (password_verify($password, $user->password)) {
            return $user;
        }
        
        return false;
    }
}