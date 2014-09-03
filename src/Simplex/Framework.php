<?php

namespace Simplex;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\HttpKernel\Controller\ControllerResolver;

class Framework
{
    protected $matcher;
    protected $resolver;

    /**
     * Accept our UrlMatcher & Controller Resolver (from front.php)
     *
     * @param \Symfony\Component\Routing\Matcher\UrlMatcher               $matcher
     * @param \Symfony\Component\HttpKernel\Controller\ControllerResolver $resolver
     */
    public function __construct(UrlMatcher $matcher, ControllerResolver $resolver)
    {
        $this->matcher = $matcher;
        $this->resolver = $resolver;
    }

    /**
     * Handle our request
     *
     * 1. Match the routes
     * 2. Resolve our controller & arguments
     * 3. Return the Response from the resolved controller
     *
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return mixed|\Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request)
    {
        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->resolver->getController($request);
            $arguments = $this->resolver->getArguments($request, $controller);

            return call_user_func_array($controller, $arguments);
        } catch (ResourceNotFoundException $e) {
            return new Response('Not Found', 404);
        } catch (\Exception $e) {
            return new Response($e->getMessage(), 500);
        }
    }
}