<?php
// framework/front.php

// Front controller

// Composer Autoloader
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;
use Symfony\Component\HttpKernel\HttpCache\Store;

//$request = Request::createFromGlobals();
$request = Request::create('/is_leap_year/2012');

// Get all our routes from `src/app.php` to pass to the UrlMatcher below
$routes = include __DIR__.'/../src/app.php';

// Based on the information stored in the RouteCollection instance, a UrlMatcher instance can match URL paths
$context = new Routing\RequestContext();
$context->fromRequest($request);
$matcher = new Routing\Matcher\UrlMatcher($routes, $context);
$resolver = new HttpKernel\Controller\ControllerResolver();

// Event Dispatcher
$dispatcher = new EventDispatcher();

// A subscriber knows about all the events it is interested in and
// pass this information to the dispatcher via the `getSubscribedEvents()` method within the Listener.
$dispatcher->addSubscriber(new Simplex\ContentLengthSubscriber());
$dispatcher->addSubscriber(new Simplex\GoogleSubscriber());

// Load our framework
$framework = new Simplex\Framework($dispatcher, $matcher, $resolver);
$framework = new HttpCache($framework, new Store(__DIR__.'/../cache'), null, ['debug' => true]);
$response = $framework->handle($request);

//echo $response; // show the headers and output

// Send our Response
$response->send();