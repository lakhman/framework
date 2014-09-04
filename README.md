Framework built with Symfony Components
=======================================

These mini frameworks are built using this article.

http://fabien.potencier.org/article/50/create-your-own-framework-on-top-of-the-symfony2-components-part-1

You will have to install the composer dependencies after downloading the version.

```
composer install
```

then, You can run each version from the command line using PHP's built in server using:

```
# Version 1 & 2
php -S localhost:9000 index.php
```

```
# Version 3+
php -S localhost:9000 -t web
```

---

## Part 1 - Introducing the Symfony2 Class Loader Component

[Tag v1 - (2a87c38649c03172ae4227a930db3ab151a577d2)](https://github.com/Lakhman/framework/releases/tag/v1)

Here we setup the basics, we use Symfony's class loader to autoload our classes. We change this later to use composer's but its an example of using the Symfony2 Class Loader.

## Part 2 - Introducing the Symfony2 HTTP Foundation Component

[Tag v2 - (6fc05490d88cac1fc46dbdefaedb65330301c153)](https://github.com/Lakhman/framework/releases/tag/v2)

We learn about the HTTP Foundation Component, it allows us an OOP way to interface with super globals and also gives us a more secure way to get a clients IP address, amongst other things.

## Part 3 - The front controller pattern and some basic routing

[Tag v3 - (f210f6c13243d655e4c818eeb311e4fab9f09aa3)](https://github.com/Lakhman/framework/releases/tag/v3)

We clean up our directory structure and switch to a `front controller` pattern, and add some basic routing, we enhance on this in the next part to make use of Symfony's Routing Component.

The host `document root` now points to the `web` directory, all of our php files are now served through `web/front.php`, this secures our application further as our files are no longer mapped directly mapped to the URL.

Now we use the following php command to run our server.

```
php -S localhost:9000 -t web
```

Access the `/hello` and `/bye` pages using:

```
http://localhost:9000/front.php/hello?name=Fabien
http://localhost:9000/front.php/bye?name=Fabien
```

I have added a `src/ReqResRef.php` as a reference for the Request and Response object, read the comments.

## Part 4 - Introducing the Symfony2 Routing Component

[Tag v4 - (a5bbff813a471f07ce555e34e42c01bdca897112)](https://github.com/Lakhman/framework/releases/tag/v4)

In this part we learn about the Symfony2 Routing Component. First we refactor our `v3` code a little.

[e6d1508d320b7c9ec6dbae45a550784cedb8e313](https://github.com/Lakhman/framework/commit/e6d1508d320b7c9ec6dbae45a550784cedb8e313)

Now we've done that, we introduce the Symfony Routing Component.

The url maps in `front.php` are removed and we now create a few `Routes` in `app.php` within a `RouteCollection`, we return this to our `front.php`, we pass them `$routes` onto a `URL Matcher`, along with a RequestContext `$context`, which we create from the current `$request`, this gives the Matcher access to things like parameters and host information.

When we call the `$matcher->match($request->getPathInfo())`, if it finds a match, it will return all the parameters for that route (only route parameters, i.e: no $_GET params). If it don't find a match it will thrown a `Routing\Exception\ResourceNotFoundException`. We then `extract` those variables and render the template.

Be sure to checkout `src/pages/hello.php`, It shows how you can generate routes using the route name, so if you change the route, you don't have to go through all your templates and change them (their generated for us!).

Also moved the commented RequestResponseReference (ReqResRef.php) into a wiki here:

[https://github.com/Lakhman/framework/wiki/Request-Response-Info](https://github.com/Lakhman/framework/wiki/Request-Response-Info)

## Part 5 - Matching Routes to Controllers

[Tag v5 - (db8c6a4240513a45066caffa48929b1561fe4f1c)](https://github.com/Lakhman/framework/releases/tag/v5)

In this part, we add our controllers to our routes using the `_controller` key in `src/app.php`. We then use that to call the controller and action we want, we can use the new `render_template` function in `front.php` within the controller to render our template and return a response. We can then choose to alter that response to send it.

## Part 6 - Introducing the Symfony2 HTTP Kernel

[Tag v6 - (9bb3846a1d845b6f61d1f9c5f6f57ef309131ce3)](https://github.com/Lakhman/framework/releases/tag/v6)

We learn about the HTTP Kernel, specifically it's controller resolver. A controller resolver knows how to determine the controller to execute and the arguments to pass to it, based on a Request object. It uses type hinting to pass arguments which allows us to pass the `Request $request` when required as well as the router arguments.

## Part 7 - Making our framework more reusable

[Tag v7 - (50586ec3a897f0066157b51d2494d80c12399d9a)](https://github.com/Lakhman/framework/releases/tag/v7)

Currently the framework is not as organised as it could be, so we refactor the code to split things up and make the framework more reusable. Now things are starting to look a little more familiar.

 - **web/front.php**: The front controller; the only exposed PHP code that makes the interface with the client (it gets the Request and sends the Response) and provides the boiler-plate code to initialize the framework and our application;

 - **src/Simplex**: The reusable framework code that abstracts the handling of incoming Requests (by the way, it makes your controllers/templates easily testable -- more about that later on);

 - **src/Calendar**: Our application specific code (the controllers and the model); A Calendar app in this example.

 - **src/app.php**: The application configuration/framework customization. (Currently hold routes)

## Part 8 - PHPUnit - Testing our framework

[Tag v8 - (8929b95eb07886bb1e673be95b0554467cfdff94)](https://github.com/Lakhman/framework/releases/tag/v8)

In this lesson, we setup some basic PHPUnit testing. We test our `is_leap_year` function.

Run the following command to run all tests and place code coverage reports in the `cov` folder.

```
phpunit --coverage-html=cov
```

## Part 9 - Introducting the Event Dispatcher & Subscribers

[Tag v9 - (60366439c336d35b9735b73200d63e8156cdf146)](https://github.com/Lakhman/framework/releases/tag/v9)


In this section, we learn about the Event Dispatcher, Listeners & Subscribers (which are kind of the same thing). 

The Symfony2 EventDispatcher Component implements a lightweight version of the Observer pattern.

Basically, we create a `$dispatcher`, add our Subscribers `(GoogleSubscriber)`, pass it through to our `Simplex\Framework`, where we dispatch the events. If the event fired is name `response`, the `GoogleSubscriber:onResponse` will fire (as it subscribes to the `reponse` event - through the implemented `getSubscribedEvents` method.).

```php
use Symfony\Component\EventDispatcher\EventDispatcher;

// Event Dispatcher
$dispatcher = new EventDispatcher();

// A subscriber knows about all the events it is interested in and
// pass this information to the dispatcher via the `getSubscribedEvents()` method within the Listener.
$dispatcher->addSubscriber(new Simplex\GoogleSubscriber());

$framework = new Simplex\Framework($dispatcher, $matcher, $resolver);
```

In our `Framework` we accept it, and `dispatch` an event named `response` before returning the response.
```php
// dispatch a response event
$this->dispatcher->dispatch('response', new ResponseEvent($response, $request));
```
The `GoogleSubscriber` subscribed to this event and does something with the response.

```php
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class GoogleSubscriber implements EventSubscriberInterface
{
    /**
     * Run this code and manipulate the request
     */
    public function onResponse(ResponseEvent $event)
    {
        $response = $event->getResponse();
        $response->setContent($response->getContent().' : GA CODE');
    }

    /**
     * View the `EventSubscriberInterface` docs
     */
    public static function getSubscribedEvents()
    {
        // return array('response' => array('onResponse', -255)); // Priorities
        return array('response' => 'onResponse');
    }
}
```

Also, we learned about priorities.

> To tell the dispatcher to run a listener early, change the priority to a positive number; negative numbers can be used for low priority listeners. Here, we want the GoogleSubscriber listener to be executed last, so change the priority to -255