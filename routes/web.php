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
$router->get('/home', "HomeController@index");
$router->get('/registration', "AuthController@registration");
$router->post('/registration', "AuthController@registration");
$router->get('/login', "AuthController@login");
$router->post('/login', "AuthController@login");
$router->post('/logout', "AuthController@logout");

$router->get('/profile', "ProfileController@imagesOnTheMainPage"); // images on the main page
$router->get('/profile/galleries', "ProfileController@indexGalleries"); // galleries in profile
$router->get('/gallery/{id}', "ProfileController@showImages");  //images from gallery
$router->post("/profile/gallery/{id}", "ProfileController@getImage");//get single picture
$router->post("/update/{slug}", "ProfileController@updateImage");  //update image from logged user gallery
$router->get("/profile/users", "UserController@index");// other users
$router->get("/profile/users/{slug}", "UserController@showGalleries"); // Not logged user galleries
//$router->get("/gallery/update/{slug}",)

$router->post('/delete/image{slug}', "ProfileController@deleteImage");


$router->get("/profile/moderator/users/{id}", "UserController@showGalleries"); // Not logged user galleries





$router->get("/profile/admin/users/{slug}", "UserController@showGalleries"); // Not logged user galleries




