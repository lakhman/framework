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

$request = Request::createFromGlobals();
//$request = Request::create('/is_leap_year/2012');

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

// RouterListener is an implementation of the same logic we had in our framework:
// it matches the incoming request and populates the request attributes with route parameters.
$dispatcher->addSubscriber(new HttpKernel\EventListener\RouterListener($matcher));

// Add our error controller handler
$dispatcher->addSubscriber(new HttpKernel\EventListener\ExceptionListener('Calendar\\Controller\\ErrorController::exceptionAction'));

// In part 2, we have talked about the Response::prepare() method, which ensures that a Response is compliant
// with the HTTP specification. It is probably a good idea to always call it just before sending the Response
// to the client; that's what the ResponseListener does
$dispatcher->addSubscriber(new HttpKernel\EventListener\ResponseListener('UTF-8'));

// do you want out of the box support for streamed responses? Just subscribe to StreamedResponseListener:
// And in your controller, return a StreamedResponse instance instead of a Response instance.
//$dispatcher->addSubscriber(new HttpKernel\EventListener\StreamedResponseListener());

// Our custom response listener - if a string is returned, convert it to an object
$dispatcher->addSubscriber(new Simplex\StringResponseListener());

// Load our framework
$framework = new Simplex\Framework($dispatcher, $resolver);
$response = $framework->handle($request);

// Send our Response
$response->send();