<?php

// framework/autoload.php

/**
 * Symfony2 follows the de-facto PHP standard, PSR-0, for class names and autoloading.
 * The Symfony2 ClassLoader Component provides an autoloader that implements this PSR-0 standard.
 */

// View composer.json - "symfony/class-loader": "2.1.*"
// we tell Composer that our project depends on the Symfony2 ClassLoader component, version 2.1.0 or later.
require_once __DIR__.'/vendor/symfony/class-loader/Symfony/Component/ClassLoader/UniversalClassLoader.php';

use Symfony\Component\ClassLoader\UniversalClassLoader;

$loader = new UniversalClassLoader();
$loader->register();