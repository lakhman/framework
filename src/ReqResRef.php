<?php // framework/ReqResRef.php

// This page is no longer used, it is used as a reference for the request and response objects
exit;

require_once __DIR__ . '/autoload.php';

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Writing web code is about interacting with HTTP. So, the fundamental principles of our framework should be centered around the HTTP specification.
 * The HTTP specification describes how a client (a browser for instance) interacts with a server (our application via a web server). The dialog between the client and the server is specified by well-defined messages, requests and responses: the client sends a request to the server and based on this request, the server returns a response.
 * In PHP, the request is represented by global variables ($_GET, $_POST, $_FILE, $_COOKIE, $_SESSION...) and the response is generated by functions (echo, header, setcookie, ...).
 * The first step towards better code is to use an Object-Oriented approach; that's the main goal of the Symfony2 `HttpFoundation` component:
 * replacing the default PHP global variables and functions by an Object-Oriented layer.
 */

// The createFromGlobals() method creates a Request object based on the current PHP global variables.
$request = Request::createFromGlobals();

/**
 * The Request Class
 *
 * With the Request class, you have all the request information at your fingertips thanks to a nice and simple API:
 *
 * $request->getPathInfo(); // the URI being requested (e.g. /about) minus any query parameters
 * $request->query->get('foo'); // retrieve GET variables
 * $request->request->get('bar', 'default value if bar does not exist'); // retrieve POST variables
 * $request->server->get('HTTP_HOST'); // retrieve SERVER variables
 * $request->files->get('foo'); // retrieves an instance of UploadedFile identified by foo
 * $request->cookies->get('PHPSESSID'); // retrieve a COOKIE value
 * $request->headers->get('host'); // retrieve an HTTP request header, with normalized, lowercase keys
 * $request->headers->get('content_type'); // retrieve an HTTP request header, with normalized, lowercase keys
 * $request->getMethod();    // GET, POST, PUT, DELETE, HEAD
 * $request->getLanguages(); // an array of languages the client accepts
 * $request->getClientIp(); // Get the client ip
 *
 * You can also simulate a request:
 * $request = Request::create('/ReqResRef.php?name=Fabien');
 */

// In this example we will get the name variable
$input = $request->get('name', 'World');

/**
 * The Response Class
 *
 * With the Response class, you can easily tweak the response:
 *
 * $response = new Response();
 * $response->setContent('Hello world!');
 * $response->setStatusCode(200);
 * $response->headers->set('Content-Type', 'text/html');
 * // configure the HTTP cache headers
 * $response->setMaxAge(10);
 *
 * To debug a Response, cast it to a string; it will return the HTTP representation of the response (headers and content).
 */

$response = new Response(sprintf('Hello %s', htmlspecialchars($input, ENT_QUOTES, 'UTF-8')));

/**
 * TODO: Call the prepare method : (We do this in a later part)
 * Before the send() call, we should have added a call to the prepare() method ($response->prepare($request);) to ensure that our Response were compliant with the HTTP specification.
 * For instance, if we were to call the page with the HEAD method, it would have removed the content of the Response.
 */

// The send() method sends the Response object back to the client (it first outputs the HTTP headers followed by the content)
$response->send();

/**
 * Last but not the least, these classes, like every other class in the Symfony code,
 * have been audited for security issues by an independent company. And being an
 * Open-Source project also means that many other developers around the world have
 * read the code and have already fixed potential security problems. When was the
 * last you ordered a professional security audit for your home-made framework?
 */