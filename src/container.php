<?php

use Symfony\Component\DependencyInjection;
use Symfony\Component\DependencyInjection\Reference;

/**
 * The goal of this file is to configure your objects and their dependencies.
 * Nothing is instantiated during this configuration step.
 * This is purely a static description of the objects you need to manipulate and how to create them.
 * Objects will be created on-demand when you access them from the container or when the container needs them to create other objects.
 */

$sc = new DependencyInjection\ContainerBuilder();

$sc->register('context', 'Symfony\Component\Routing\RequestContext');

$sc->register('matcher', 'Symfony\Component\Routing\Matcher\UrlMatcher')
    ->setArguments(array('%routes%', new Reference('context')));

$sc->register('resolver', 'Symfony\Component\HttpKernel\Controller\ControllerResolver');

// For instance, to create the router listener,
// we tell Symfony that its class name is Symfony\Component\HttpKernel\EventListener\RouterListeners,
// and that its constructor takes a matcher object (new Reference('matcher')).
// As you can see, each object is referenced by a name, a string that uniquely identifies each object.
// The name allows us to get an object and to reference it in other object definitions.
$sc->register('listener.router', 'Symfony\Component\HttpKernel\EventListener\RouterListener')
    ->setArguments(array(new Reference('matcher')));

$sc->register('listener.response', 'Symfony\Component\HttpKernel\EventListener\ResponseListener')
    ->setArguments(array('%charset%'));

$sc->register('listener.exception', 'Symfony\Component\HttpKernel\EventListener\ExceptionListener')
    ->setArguments(array('Calendar\\Controller\\ErrorController::exceptionAction'));

$sc->register('dispatcher', 'Symfony\Component\EventDispatcher\EventDispatcher')
    ->addMethodCall('addSubscriber', array(new Reference('listener.router')))
    ->addMethodCall('addSubscriber', array(new Reference('listener.response')))
    ->addMethodCall('addSubscriber', array(new Reference('listener.exception')));

$sc->register('framework', 'Simplex\Framework')
    ->setArguments(array(new Reference('dispatcher'), new Reference('resolver')));

return $sc;