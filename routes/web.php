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
$router->get('/home', "ImageController@indexHome");
$router->get('/registration', "AuthController@registration");
$router->post('/registration', "AuthController@registration");
$router->get('/login', "AuthController@login");
$router->post('/login', "AuthController@login");
$router->get('/logout', "AuthController@logout");

$router->get('/profile', "ImageController@indexProfile"); // images on the main page
$router->get("/profile/galleries/newGallery","GalleryController@create"); // get form
$router->post("/profile/galleries/newGallery","GalleryController@create"); //post data
$router->get('/profile/galleries', "GalleryController@index"); // galleries in profile
$router->get('/profile/galleries/{id}', "ImageController@index");  //images from gallery
$router->post("/profile/galleries/{id}/{id}", "ImageController@show"); //get single image
$router->post("/update/{id}/{id}", "ImageController@update");  //update image from logged user gallery
$router->get("/profile/users", "UserController@index");// other users
$router->get("/profile/users/{id}/{id}", "ImageController@showNotLoggedUserImages");//show no logged user images

$router->get("/profile/users/{id}", "GalleryController@notLoggedUserGalleries"); // Not logged user galleries
$router->post("/profile/users/{id}/{id}/{id}", "ImageController@show"); // no logged user get single image
$router->get("/comments/users/{id}/{id}", "ImageController@indexComments"); // no logged user get single image
$router->post("/comments/users/{id}/{id}", "ImageController@indexComments"); // no logged user get single image
$router->post('/create/comments', "ImageController@createComments");
$router->get("/profile/update/gallery/{id}","GalleryController@update");
$router->post("/profile/update/gallery/{id}","GalleryController@update");


$router->get("/profile/updateAccount","UserController@updateAccount");
$router->post("/profile/updateAccount","UserController@updateAccount");

$router->get("/profile/update/users/{id}","UserController@updateUser");
$router->post("/profile/update/users/{id}","UserController@updateUser");

$router->post('/delete/image/{id}', "ImageController@delete");
$router->get('/delete/gallery/{id}', "GalleryController@delete");
$router->post('/delete/gallery/{id}', "GalleryController@delete");








$router->get("/profile/admin/users/{slug}", "UserController@showGalleries"); // Not logged user galleries




