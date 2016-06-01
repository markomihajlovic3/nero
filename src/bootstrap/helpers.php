<?php

use Nero\Core\Http\JsonResponse;
use Nero\Core\Http\RedirectResponse;
use Nero\Core\Http\ViewResponse;


/**
 * Get the base path from the config array
 *
 * @return string
 */
function basePath()
{
    //$config = require __DIR__ . "/../config/conf.php";
    return config('base_path');
}


/**
 * Create a full url from path
 *
 * @param string $path
 * @return string
 */
function url($path)
{
    return basePath() . $path;
}


/**
 * Return hidden form input field with the http method
 *
 * @param string $value
 * @return string
 */
function method($value)
{
    return "<input name=\"_method\" type=\"hidden\" value=\"$value\"/>";
}


/**
 * Easy access to IoC container,bad practice, oh well...
 *
 * @return Pimple\Container or instance of requested service
 */
function container($service = "")
{
    global $container;

    if($service == "")
        return $container;

    return $container[$service];
}


/**
 * CSS helper, generates link element for linking css files
 *
 * @param string $path
 * @return string 
 */
function css($path)
{
    return "<link href=\"" . basePath() . $path . "\" rel=\"stylesheet\"/>";
}


/**
 * Javascript helper, returns script tag
 *
 * @param string $path
 * @return string
 */
function javascript($path)
{
    return "<script src=\"" . $path . "\"></script>";
}


/**
 * Helper for creating a view response
 *
 * @return Nero\Core\Http\ViewResponse
 */
function view()
{
    return new ViewResponse;
}


/**
 * Helper for creating a json response
 *
 * @param array $data 
 * @return Nero\Core\Http\JsonResponse
 */
function json($data = [])
{
    return new JsonResponse($data);
}


/**
 * Helper for creating a redirect response
 *
 * @param string to 
 * @return Nero\Core\Http\RedirectResponse
 */
function redirect($to = "")
{
    return new RedirectResponse($to);
}


/**
 * Utility function for accessing config
 *
 * @param string $key 
 * @return mixed
 */
function config($key = "")
{
    $config = require __DIR__ . "/../app/conf.php";

    if($key != "")
        return $config[$key];

    return $config;
}


/**
 * Utility for checking if the array is multidimensional
 *
 * @param array $array 
 * @return bool
 */
function isMultidimensional(array $array)
{
    if (count($array) == count($array, COUNT_RECURSIVE))
        return false;
    else
        return true;
}


/**
 * Check if a string starts with another one
 *
 * @param string $pattern 
 * @param string $string 
 * @return bool
 */
function stringStartsWith($pattern, $string)
{
    if(strpos($string, $pattern) === 0)
        return true;

    return false;
}


/**
 * Check if the app is in development mode,used for error feedback
 *
 * @return bool
 */
function inDevelopment()
{
    if(config('build') == 'development')
        return true;
    else
        return false;
}


/**
 * Flash a message to session
 *
 * @param string $name 
 * @param string $value 
 * @return mixed
 */
function flash($name, $value = "")
{
    $session = container('Session');

    if(isset($name) && $value != ""){
        //set a new flash message
        $session->destroyFlash();
        $session->flash($name, $value);
        return true;
    }
    else if(isset($name) && $value == ""){
        //retrive the flash message and destroy it
        $flash = $session->getFlash($name);
        $session->destroyFlash();
        return $flash;
    }
}
