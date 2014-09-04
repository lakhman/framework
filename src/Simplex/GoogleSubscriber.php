<?php

/**
 * A single subscriber can host as many listeners as you want on as many events as needed.
 * So we could return more events in the "getSubscribedEvents" method in the same subscriber
 */

namespace Simplex;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class GoogleListener
 *
 * An EventSubscriber knows himself what events he is interested in.
 * If an EventSubscriber is added to an EventDispatcherInterface, the manager invokes
 * {@link getSubscribedEvents} and registers the subscriber as a listener for all
 * returned events.
 *
 * @package Simplex
 */

class GoogleSubscriber implements EventSubscriberInterface
{
    /**
     * When the subscriber is called, we add the GA CODE to the response object
     *
     * @param \Simplex\ResponseEvent $event
     */
    public function onResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();

        // In the listener, we add the Google Analytics code only if the response
        // is not a redirection, if the requested format is HTML, and if the response content type is HTML
        // (these conditions demonstrate the ease of manipulating the Request and Response data from your code).
        if ($response->isRedirection()
            || ($response->headers->has('Content-Type') && false === strpos($response->headers->get('Content-Type'), 'html'))
            || 'html' !== $event->getRequest()->getRequestFormat()
        ) {
            return;
        }

        $response->setContent($response->getContent().' : GA CODE');
    }

    /**
     * Returns an array of event names this subscriber wants to listen to.
     *
     * The array keys are event names and the value can be:
     *
     *  * The method name to call (priority defaults to 0)
     *  * An array composed of the method name to call and the priority
     *  * An array of arrays composed of the method names to call and respective
     *    priorities, or 0 if unset
     *
     * For instance:
     *
     *  * array('eventName' => 'methodName')
     *  * array('eventName' => array('methodName', $priority))
     *  * array('eventName' => array(array('methodName1', $priority), array('methodName2'))
     *
     * @return array The event names to listen to
     */
    public static function getSubscribedEvents()
    {
        return array('response' => 'onResponse');
    }
}