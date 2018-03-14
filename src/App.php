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