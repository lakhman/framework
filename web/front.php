<?php
// framework/front.php

// Use composer's autoloader instead of the Symfony Class Loader (from part 1)
require_once __DIR__.'/../vendor/autoload.php';

// View the `src/ReqResRef.php` - Read the comments

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;

/**
 * Exposing a single PHP script to the end user is a design pattern called the "front controller".
 *
 * Most web servers like Apache or nginx are able to rewrite the incoming URLs and remove the front controller script
 * so that your users will be able to type http://example.com/hello?name=Fabien, which looks much better.
 *
 * http://example.com/front.php/hello/anil?param=value
 * http://example.com/hello/anil?param=value
 *
 * `/hello` and `/bye` are the Routes (view src/app.php)
 *
 */

// Create our Request & Response Objects object (View ReqResRef.php)
$request = Request::createFromGlobals();

// Get all our routes from `src/app.php` to pass to the UrlMatcher below
$routes = include __DIR__.'/../src/app.php';

// Based on the information stored in the RouteCollection instance, a UrlMatcher instance can match URL paths
$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);

// For Performance, we can dump our own `URLMatcher` in PHP or Apache Rewrite Rules!
//$dumper = new Routing\Matcher\Dumper\PhpMatcherDumper($routes);
//$dumper = new Routing\Matcher\Dumper\ApacheMatcherDumper($routes);
//echo $dumper->dump();exit;

// throws a Symfony\Component\Routing\Exception\ResourceNotFoundException
//print_r($matcher->match('/some-unknown-404-page')); exit;

try {
    // Start output buffering
    ob_start();

    // Extract all our query params, so in templates we can now just use `$name` for `$_GET['name']`

    // Send the `Request` to the `URLMatcher` to match a route, if it's found it will return all the variables
    extract($matcher->match($request->getPathInfo()), EXTR_SKIP);

    // Include our template file - Route names are used for template names;
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);

    // Set our Response
    $response = new Response(ob_get_clean());

} catch (Routing\Exception\ResourceNotFoundException $e) {

    // If the client asks for a path that is not defined in the URL map, we return a custom 404 page;
    $response = new Response('Not Found', 404);

} catch (Exception $e) {

    // Throw a 500 if some other error
    $response = new Response('An error occurred', 500);

}

/**
 * TODO: Important: Call the prepare method : (We do this in a later part)
 */

// Send our Response
$response->send();