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
$router->get("/profile/galleries/newGallery", "GalleryController@create"); // get form
$router->post("/profile/galleries/newGallery", "GalleryController@create"); //post data
$router->get("/update/images/{slug}", "ImageController@showImage"); //get single image from profile
$router->post("/update/images/{slug}", "ImageController@updateImage");  //update image from logged user gallery
// not logged user
$router->get("/profile/users", "UserController@indexUsers");// other users

$router->get("/galleries/{slug}", "ImageController@indexImage");  //images from gallery
$router->get("/users/{slug}", "GalleryController@indexGalleries"); //  user galleries

//image comments

$router->get("/images/{slug}", "ImageController@comments");
$router->post('/image/comments', "ImageController@createComments"); //create comment
// gallery comments
$router->get("/comments/galleries/{slug}", "GalleryController@indexGalleryComments"); // comments of  gallery
$router->get("/profile/comments/users/{slug}/{slug}", "GalleryController@indexComments"); // comments of other users gallery
$router->post('/gallery/comment', "GalleryController@createComment"); //create comment

$router->get("/update/gallery/{slug}", "GalleryController@updateGallery");
$router->post("/update/gallery/{slug}", "GalleryController@updateGallery");

$router->get("/profile/updateAccount", "UserController@updateAccount");
$router->post("/profile/updateAccount", "UserController@updateAccount");

$router->get("/profile/update/users/{slug}", "UserController@updateUser");
$router->post("/profile/update/users/{slug}", "UserController@updateUser");

$router->post('/delete/images/{slug}', "ImageController@delete");
$router->get('/delete/galleries/{slug}', "GalleryController@delete");
$router->post('/delete/galleries/{slug}', "GalleryController@delete");


$router->post("/addImage", "ImageController@create");

$router->get("/profile/subscription", "SubscriptionController@subscription");
$router->post("/profile/subscription", "SubscriptionController@subscription");
$router->get("/subscription/{slug}", "SubscriptionController@indexSubscriptionList");