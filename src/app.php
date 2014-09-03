<?php
// src/app.php

use Symfony\Component\Routing;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

/**
 * Our leap year checker
 *
 * @param null $year
 *
 * @return bool
 */
function is_leap_year($year = null) {
    if (null === $year) {
        $year = date('Y');
    }

    return 0 == $year % 400 || (0 == $year % 4 && 0 != $year % 100);
}

class LeapYearController
{
    public function indexAction(Request $request, $year)
    {
        if (is_leap_year($year)) {
            return new Response('Yep, this is a leap year! ' . $request->attributes->get('year'));
        }

        return new Response('Nope, this is not a leap year.');
    }
}

// The Routing component relies on a RouteCollection instance
$routes = new Routing\RouteCollection();

// Add a route that describe the `/hello/SOMETHING` URL and add another one for the simple `/bye` one:
// Each entry in the collection is defined by a route name (`hello`) and a Route instance (new Route)
// which is defined by a route pattern (/hello/{name}) and an array of default values for route attributes (array('name' => 'World')).
$routes->add('leap_year', new Routing\Route('/is_leap_year/{year}', array(
    'year' => null,
    '_controller' => 'LeapYearController::indexAction'
)));

return $routes;