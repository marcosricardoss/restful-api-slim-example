<?php

namespace Marcosricardoss\Restful;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

class DatabaseSchema {
    
    /**
     * Create needed tables in database.
     */
    public static function createTables() {
        self::createUsersTable();        
    }

    private static function createUsersTable() {
        if (!Capsule::schema()->hasTable('users')) {
            Capsule::schema()->create('users', function (Blueprint $table) {
                $table->increments('id');
                $table->string('username');
                $table->string('role');
                $table->string('password');
                $table->timestamps();
            });
        }
    }
    
}