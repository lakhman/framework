<?php
// framework/front.php

// Composer Autoloader
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;

/**
 * Exposing a single PHP script to the end user is a design pattern called the "front controller".
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