<?php

use Bramus\Router\Router;
use Dotenv\Dotenv;
require_once realpath('../vendor/autoload.php');

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();
$router = new Router();
require realpath('../routes/web.php');
$router->run();

