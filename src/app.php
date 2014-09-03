<?php
// src/app.php

use Symfony\Component\Routing;

// New Routing using Symfony2 Routing Component
$routes = new Routing\RouteCollection(); // Instead of an array for the URL map, the Routing component relies on a RouteCollection instance

// Add a route that describe the `/hello/SOMETHING` URL and add another one for the simple `/bye` one:
// Each entry in the collection is defined by a route name (`hello`) and a Route instance (new Route)
// which is defined by a route pattern (/hello/{name}) and an array of default values for route attributes (array('name' => 'World')).
$routes->add('hello', new Routing\Route('/hello/{name}', array('name' => 'World')));
$routes->add('bye', new Routing\Route('/bye/{name}', array('name' => 'Friend')));

return $routes;