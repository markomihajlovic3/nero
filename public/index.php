<?php

/*******************************************************************
 * This is the front controller which bootstraps the autoload file,
 * creates the services container(used for dependency injection),
 * and passes the request to the application for further handling.
 * Ultimately it sends the apps returned response to the user.
 *******************************************************************/

use Nero\Exceptions\ExceptionManager;

//report all errors(for development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


//Require the autoloader
require_once __DIR__ . "/../vendor/autoload.php";


//Include helper functions to make our lives easier
require_once __DIR__ . "/../src/bootstrap/helpers.php";


//Load up the services container
$container = require_once  __DIR__ . "/../src/bootstrap/container.php";


//Bootstrap the application
try {
    //get the instance of the app from the container 
    $app = container('App');

    //get the request
    $request = container('Request');

    //lets handle the request
    $response = $app->handle($request);

    //send the response back to the user
    $response->send();

    //lets terminate the app
    $app->terminate();
}
catch(\Exception $e){
    //handle the exception, format it to a view
    ExceptionManager::handleException($e)->send();
}


