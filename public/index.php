<?php
if (PHP_SAPI == 'cli-server') {
    # To help the built-in PHP dev server, check if the request was actually for
    # something which should probably be served as a static file
    $url  = parse_url($_SERVER['REQUEST_URI']);
    $file = __DIR__ . $url['path'];
    if (is_file($file)) {
        return false;
    }
}

# set timezone for timestamps etc
date_default_timezone_set('UTC');

require __DIR__ . '/../vendor/autoload.php';

# getting instance of app
$app = (new Marcosricardoss\RestAPI\App(__DIR__.'/../'))->get();

# Run app
$app->run();
