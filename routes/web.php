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
$router->get('/', function () {
    include "../resources/views/home.php";});
$router->post('/',  function () {
    include "../resources/views/home.php";});
$router->get('/signup', function () {
    include "../resources/views/signup.php";});
$router->get('/login', function () {
    include "../resources/views/login.php";});
$router->get('/profile', function () {
    include "../resources/views/profile.php";});
$router->setNamespace("App\Controllers");
$router->post('/signup', "UserController@registration");
$router->post('/login', "UserController@login");
$router->get('/logout', "UserController@logout");
$router->get('/pb', "GalleryController@index");






$router->get('/users', "UserController@index");  //test

