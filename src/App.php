<?php

namespace Marcosricardoss\RestAPI;

class App {

    protected $app;

    /**
     * Stores an instance of the Slim application.
     *
     * @var \Slim\App
     */
    public function __construct($envFilePath = '') {
        
        # settings
        $settings = require __DIR__.'/../src/settings.php';
        
        # app instance
        $app = new \Slim\App($settings);

        # dependencies
        require __DIR__.'/../src/dependencies.php';
        # routes
        require __DIR__.'/../src/routes.php';

        $this->app = $app;
        $this->setUpDatabaseManager();        
        $this->setUpDatabaseSchema();

    }


    /**
     * Setup Eloquent ORM.
     */
    private function setUpDatabaseManager()
    {
        # Register the database connection with Eloquent
        $capsule = $this->app->getContainer()->get('capsule');
        $capsule->setAsGlobal();
        $capsule->bootEloquent();
    }    


    /**
     * Create necessary database tables needed in the application.
     */
    private function setUpDatabaseSchema()
    {
        try {
            DatabaseSchema::createTables();
        } catch (\Exception $e) {
            # this exception would be caught by the global exception handler.
        }
    }

    /**
     * Get an instance of the application.
     *
     * @return \Slim\App
     */
    public function get() {
        return $this->app;
    }                   

}