<?php
// framework/front.php

require_once __DIR__.'/../src/autoload.php';

// View the `src/ReqResRef.php` - Read the comments

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Exposing a single PHP script to the end user is a design pattern called the "front controller".
 *
 * http://example.com/front.php/hello?name=Fabien
 * http://example.com/front.php/bye
 *
 * `/hello` and `/bye` are the page paths.
 *
 * Most web servers like Apache or nginx are able to rewrite the incoming URLs and remove the front controller script
 * so that your users will be able to type http://example.com/hello?name=Fabien, which looks much better.
 */

// Create our Request & Response Objects object (View ReqResRef.php)
$request = Request::createFromGlobals();
$response = new Response();

// $map associates URL paths with their corresponding PHP script paths.
$map = array(
    '/hello' => __DIR__.'/../src/pages/hello.php',
    '/bye'   => __DIR__.'/../src/pages/bye.php',
);

// Get our path and check its in our $map
$path = $request->getPathInfo();

if (isset($map[$path])) {
    ob_start();
    include $map[$path];
    $response->setContent(ob_get_clean()); // Set out
} else {
    // if the client asks for a path that is not defined in the URL map, we return a custom 404 page;
    $response->setStatusCode(404);
    $response->setContent('Not Found');
}


/**
 * TODO: Important: Call the prepare method : (We do this in a later part)
 */

// Send our Response
$response->send();