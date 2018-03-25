<?php

use Illuminate\Database\Capsule\Manager as Capsule;

use Marcosricardoss\Restful\Model\User;

class TestDatabasePopulator {
    
    /**
     * Populate test Database with tests values.
     *
     * @return Pyjac\NaijaEmoji\Model\User
     */
    public static function populate()
    {
        Capsule::beginTransaction();
        try {
            $user = User::firstOrCreate(['username' => 'tester', 'password' => password_hash('test', PASSWORD_DEFAULT), 'role' => 'member']);
            Capsule::commit();
            # all good
        } catch (\Exception $e) {
            Capsule::rollback();
            throw $e;
            # something went wrong
        }
        
        # create user
        return $user;
    }
}