<?php 
namespace API;

/**
 * Author wildpenguin@gmail.com
 * Main entry file 
 */
require 'autoloader.php';

// instantiate the loader
$loader = new \API\Psr4AutoloaderClass;

// register the autoloader
$loader->register();

// register the base directories for the namespace prefix
$loader->addNamespace('API', 'src');

$config = include('.config.php');
$app = new App($config);
$app->start();




