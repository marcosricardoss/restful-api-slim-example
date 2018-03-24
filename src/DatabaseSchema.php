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

    public static function createBlacklistedTokensTable() {
        if (!Capsule::schema()->hasTable('blacklisted_tokens')) {
            Capsule::schema()->create('blacklisted_tokens', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('user_id');
                $table->string('token_jti')->unique();
            });
        }
    }
    
}