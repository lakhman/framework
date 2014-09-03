<?php

use Symfony\Component\Routing;

// We can generate routes in templates like this, we reference the route name,
// so if the route ever changes, we don't have to go around updating all the url's in templates!!
// Awesome!

$generator = new Routing\Generator\UrlGenerator($routes, $context);

?>

<!-- framework/src/pages/hello.php -->

Hello <?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8') ?>

<br/>
<a href="<?php echo $generator->generate('hello', array('name' => 'Fabien')); ?>">Say Hello</a>

<br/>
<a href="<?php echo $generator->generate('bye'); ?>">Say Bye</a>