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
$router->get('/home', "ImageController@index");
$router->get('/registration', "AuthController@registration");
$router->post('/registration', "AuthController@registration");
$router->get('/login', "AuthController@login");
$router->post('/login', "AuthController@login");
$router->get('/logout', "AuthController@logout");

$router->get('/profile', "ImageController@imagesOnTheMainPage"); // images on the main page
$router->get("/profile/galleries/newGallery","GalleryController@createGallery"); // get form
$router->post("/profile/galleries/newGallery","GalleryController@createGallery"); //post data
$router->get('/profile/galleries', "GalleryController@indexGalleries"); // galleries in profile
$router->get('/profile/galleries/{id}', "ImageController@showImages");  //images from gallery
$router->post("/profile/galleries/{id}/{id}", "ImageController@getImage"); //get single image
$router->post("/update/{id}/{id}", "ImageController@updateImage");  //update image from logged user gallery
$router->get("/profile/users", "UserController@index");// other users
$router->get("/profile/users/{id}/{id}", "ImageController@showNotLoggedUserImages");//show no logged user images
$router->get("/profile/users/{id}", "GalleryController@showGalleries"); // Not logged user galleries
$router->post("/profile/users/{id}/{id}/{id}", "ImageController@getImage"); // no logged user get single image
$router->post("/profile/update/gallery/{id}","GalleryController@updateGallery");
$router->get("/profile/updateAccount","UserController@updateAccount");
$router->post("/profile/update/users/{id}","UserController@updateUser");
$router->post("/profile/updateAccount","UserController@updateAccount");

$router->post('/delete/image/{id}', "ImageController@deleteImage");
$router->post('/delete/gallery/{id}', "GalleryController@deleteGallery");








$router->get("/profile/admin/users/{slug}", "UserController@showGalleries"); // Not logged user galleries




