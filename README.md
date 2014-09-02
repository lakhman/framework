Framework built with Symfony Components
=======================================

The framework was built using the following article from the creator of Symfony, Fabien Potencier.

http://fabien.potencier.org/article/50/create-your-own-framework-on-top-of-the-symfony2-components-part-1

You can run these from the command line using PHP's built in server using:

```
php -S localhost:9000 index.php
```

## Part 1 - Introducing the Symfony2 Class Loader Component

Tag `v1` - 2a87c38649c03172ae4227a930db3ab151a577d2

Here we setup the basics, we use Symfony's class loader to autoload our classes. We change this later to use composer's but its an example of using the Symfony2 Class Loader.

## Part 2 - Introducing the Symfony2 HTTP Foundation Component

Tag: `v2`

We learn about the HTTP Foundation Component, it allows us an OOP way to interface with super globals and also gives us a more secure way to get a clients IP address, amongst other things.