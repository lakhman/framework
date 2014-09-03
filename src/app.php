<?php
// src/app.php

use Symfony\Component\Routing;

// The Routing component relies on a RouteCollection instance
$routes = new Routing\RouteCollection();

// Add a route that describe the `/hello/SOMETHING` URL and add another one for the simple `/bye` one:
// Each entry in the collection is defined by a route name (`hello`) and a Route instance (new Route)
// which is defined by a route pattern (/hello/{name}) and an array of default values for route attributes (array('name' => 'World')).
$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', array(
    'year' => null,
    '_controller' => 'Calendar\\Controller\\LeapYearController::indexAction'
)));

return $routes;