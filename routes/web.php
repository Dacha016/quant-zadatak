<?php
/**
 * Routes
 *
 * PHP version 8
 *
 * @category Routes
 * @package  Router
 * @author   DaliborMarinkovic <dalibor.marinkovic@quantoxtechnology.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://github.com/Dacha016/quant-zadatak
 */

use Bramus\Router\Router;

$router = new Router;

$router->get(
    "/", "\App\Controllers\UserController@show" 
);

$router->get(
    '/about', function () { 
         echo $_SERVER["REQUEST_URI"];
        echo "radi bez public";
    }
);


$router->get(
    "/test", "\App\Controllers\UserController@show" 
);

$router->run();

