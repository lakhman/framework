<?php
// framework/front.php

// Use composer's autoloader instead of the Symfony Class Loader (from part 1)
require_once __DIR__.'/../vendor/autoload.php';

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

// $map associates URL paths with their corresponding PHP script paths.
$map = array(
    '/hello' => 'hello',
    '/bye'   => 'bye',
);

// Get our path and check its in our $map
$path = $request->getPathInfo();

if (isset($map[$path])) {
    // Start output buffering
    ob_start();

    // Extract all our query params, so in templates we can now just use `$name` for `$_GET['name']`
    extract($request->query->all(), EXTR_SKIP);

    // Include our template file
    include sprintf(__DIR__.'/../src/pages/%s.php', $map[$path]);

    // Set our Response
    $response = new Response(ob_get_clean());
} else {
    // if the client asks for a path that is not defined in the URL map, we return a custom 404 page;
    $response = new Response('Not Found', 404);
}

/**
 * TODO: Important: Call the prepare method : (We do this in a later part)
 */

// Send our Response
$response->send();