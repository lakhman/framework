<?php
// Front controller

// Composer Autoloader
require_once __DIR__.'/../vendor/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing;
use Symfony\Component\HttpKernel;

// Get all our routes from `src/app.php` to pass to the UrlMatcher below
$routes = include __DIR__.'/../src/app.php';
$sc = include __DIR__.'/../src/container.php';

$sc->setParameter('charset', 'UTF-8');
$sc->setParameter('routes', include __DIR__.'/../src/app.php');

$request = Request::createFromGlobals();
//$request = Request::create('/is_leap_year/2012');

// Get our `Framework` from our service container
$response = $sc->get('framework')->handle($request);

// Send our Response
$response->send();