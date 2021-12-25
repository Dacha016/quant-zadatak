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
$router->get('/', function () {include "../resource/views/home.php";});
$router->get('/signup', function () {include "../resource/views/signup.php";});
$router->setNamespace("App\Controllers");
$router->post('/signup', "UserController@registration");
$router->get('/users', "UserController@index");
$router->get('/login', function () {include "../resource/views/login.php";});
$router->get('/user/id', "User@show");
//$router->post('/signup', "User@registration");
$router->get('/users',"User@index");


