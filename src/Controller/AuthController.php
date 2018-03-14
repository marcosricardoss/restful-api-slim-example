<?php

namespace Marcosricardoss\Restful\Controller;

use Marcosricardoss\Restful\Model\User;
use Marcosricardoss\Restful\Helpers;

final class AuthController {

     /**
     * Register a user.
     *
     * @param Slim\Http\Request  $request
     * @param Slim\Http\Response $response
     *
     * @return Slim\Http\Response
     */
    public function register($request, $response) {
        
        $userData = $request->getParsedBody();        


        if ($this->validateUserData($userData)) {
            return $response->withJson(['message' => 'Username or Password field not provided.'], 400);
        }
     
        if (User::where('username', $userData['username'])->first()) {
            return $response->withJson(['message' => 'Username already exist.'], 409);
        }
        
        User::firstOrCreate(
                [
                    'username' => $userData['username'],
                    'password' => password_hash($userData['password'], PASSWORD_DEFAULT),
                    'role'     => 'member',
                ]);
        
        return $response->withJson(['message' => 'User successfully created.'], 201);
    }   

     /**
     * Validate user data are correct.
     *
     * @param array $userData
     *
     * @return bool
     */
    private function validateUserData($userData) {
        return !$userData || !Helpers::keysExistAndNotEmptyString(['username', 'password'], $userData);
    }

}