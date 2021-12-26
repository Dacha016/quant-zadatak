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
$router->setNamespace("App\Controllers");
$router->get('/profile', "ProfileController@index");
$router->get('/home', "HomeController@index");
$router->get('/registration', "AuthController@registration");
$router->post('/registration', "AuthController@registration");
$router->get('/login', "AuthController@login");
$router->post('/login', "AuthController@login");
$router->get('/logout', "AuthController@logout");












$router->get('/users', "UserController@index");  //test

