Framework built with Symfony Components
=======================================

The framework was built using the following article from the creator of Symfony, Fabien Potencier.

http://fabien.potencier.org/article/50/create-your-own-framework-on-top-of-the-symfony2-components-part-1

You will have to install the composer dependencies after downloading the version.

```
composer install
```

then, You can run each version from the command line using PHP's built in server using:

```
php -S localhost:9000 index.php
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

[Tag v4 - (xxx)](https://github.com/Lakhman/framework/releases/tag/v4)

In this part we learn about the Symfony2 Routing Component. First we refactor our `v3` code a little.

[xxx](url)