<?php

namespace Simplex;

use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\HttpKernel\Controller\ControllerResolverInterface;
use Symfony\Component\HttpKernel\HttpKernelInterface;

class Framework implements HttpKernelInterface
{
    protected $matcher;
    protected $resolver;
    protected $dispatcher;

    /**
     * Accept our Dispatcher, UrlMatcher, Controller Resolver (from front.php)
     *
     * @param \Simplex\EventDispatcher                                             $dispatcher
     * @param \Symfony\Component\Routing\Matcher\UrlMatcherInterface               $matcher
     * @param \Symfony\Component\HttpKernel\Controller\ControllerResolverInterface $resolver
     */
    public function __construct(EventDispatcher $dispatcher, UrlMatcherInterface $matcher, ControllerResolverInterface $resolver)
    {
        $this->matcher = $matcher;
        $this->resolver = $resolver;
        $this->dispatcher = $dispatcher;
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
    public function handle(Request $request, $type = HttpKernelInterface::MASTER_REQUEST, $catch = true)
    {
        try {
            $request->attributes->add($this->matcher->match($request->getPathInfo()));

            $controller = $this->resolver->getController($request);
            $arguments = $this->resolver->getArguments($request, $controller);

            $response = call_user_func_array($controller, $arguments);

        } catch (ResourceNotFoundException $e) {
            $response = new Response('Not Found', 404);
        } catch (\Exception $e) {
            $response = new Response($e->getMessage(), 500);
        }

        // dispatch a response event
        $this->dispatcher->dispatch('response', new ResponseEvent($response, $request));

        return $response;
    }
}