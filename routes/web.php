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

use App\Controllers\UserController;
use App\Models\User;
use Bramus\Router\Router;

$router = new Router;

// $router->get(
//     '/', function () {
//         $u= new UserController;
//         $u->show();
// );
$router->get(
    '/', function () { 
        // echo 'About Page Contents';
        echo $_SERVER["REQUEST_URI"];
    }
);
// $router->get(
//     "/", "\App\Controllers\UserController@show" 
// );
// $router->get(
//     "/", "\App\Controllers\UserController@show" 
// );

$router->run();

