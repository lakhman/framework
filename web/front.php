<?php
// framework/front.php

// Use composer's autoloader instead of the Symfony Class Loader (from part 1)
require_once __DIR__.'/../vendor/autoload.php';

// View the `src/ReqResRef.php` - Read the comments

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;

/**
 * Render template function, we can use this within our controllers to render our template
 *
 * @param $request
 *
 * @return \Symfony\Component\HttpFoundation\Response
 */
function render_template($request)
{
    // Start output buffering
    ob_start();

    // Extract all our route params, so in templates we can now just use `$name` for `$_GET['name']`
    // Request attributes lets you attach additional information about the Request that is not directly related to the HTTP Request data.
    extract($request->attributes->all(), EXTR_SKIP);

    // Include our template file - Route names are used for template names;
    include sprintf(__DIR__.'/../src/pages/%s.php', $_route);

    // Set our Response
    return new Response(ob_get_clean());
}

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
$resolver = new HttpKernel\Controller\ControllerResolver();

// Load our framework
$framework = new Simplex\Framework($matcher, $resolver);
$response = $framework->handle($request);

// Send our Response
$response->send();