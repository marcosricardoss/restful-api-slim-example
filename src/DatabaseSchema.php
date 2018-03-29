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
        self::createCategoriesTable();
        self::createKeywordsTable();
        self::createPostKeywordsTable();
        self::createPostTable();
        self::createBlacklistedTokensTable();
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

    public static function createCategoriesTable() {
        if (!Capsule::schema()->hasTable('categories')) {
            Capsule::schema()->create('categories', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');                
            });
        }
    }

    public static function createKeywordsTable() {
        if (!Capsule::schema()->hasTable('keywords')) {
            Capsule::schema()->create('keywords', function (Blueprint $table) {
                $table->increments('id');
                $table->string('name');
            });
        }
    }

    public static function createPostKeywordsTable(){
        if (!Capsule::schema()->hasTable('post_keywords')) {
            Capsule::schema()->create('post_keywords', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('post_id');
                $table->integer('keyword_id');
            });
        }
    }

    public static function createPostTable() {
        if (!Capsule::schema()->hasTable('posts')) {
            Capsule::schema()->create('posts', function (Blueprint $table) {
                $table->increments('id');
                $table->string('title');                
                $table->text('content')->nullable(); 
                $table->integer('category_id')->nullable();
                $table->integer('created_by');
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
                $table->timestamps();
            });
        }
    }
    
}