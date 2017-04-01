<?php

use Phalcon\Loader;

// Creates the autoloader
$loader = new Loader();

// Register some namespaces
$loader->registerNamespaces(
    [
       "Dau"    => dirname(__FILE__) . "/Dau/",
    ]
);

// Register autoloader
$loader->register();