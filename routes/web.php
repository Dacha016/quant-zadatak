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
$router->post("/profile/galleries/{id}/{id}", "ImageController@show"); //get single image from gallery
$router->post("/profile/images/{id}", "ImageController@show"); //get single image from profile
$router->post("/update/images/{id}", "ImageController@update");  //update image from logged user gallery
// not logged user
$router->get("/profile/users", "UserController@index");// other users
$router->get("/profile/users/{id}/{id}", "ImageController@showNotLoggedUserImages");//show no logged user images
$router->get("/profile/users/{id}", "GalleryController@notLoggedUserGalleries"); // Not logged user galleries
$router->get('/profile/users/{id}/{id}', "ImageController@index");  //images from gallery
$router->post("/profile/users/{id}/{id}/{id}", "ImageController@show"); // no logged user get single image
//image comments
$router->get("/comments/users/{id}/{id}/{id}", "ImageController@indexComments"); // comments
$router->post("/comments/users/{id}/{id}/{id}", "ImageController@indexComments"); // comments
$router->get("/profile/comments/images/{id}", "ImageController@indexComments"); // comments of images on profile page
$router->post("/profile/comments/images/{id}", "ImageController@indexComments"); //comments
$router->get("/profile/comments/galleries/{id}/{id}", "ImageController@indexComments"); // comments of images in galleries
$router->post("/profile/comments/galleries/{id}/{id}", "ImageController@indexComments"); //comments
$router->post('/create/comments', "ImageController@createComments"); //create comment
// gallery comments
$router->get("/profile/comments/galleries/{id}", "GalleryController@indexComments"); // comments of  gallery
$router->post("/profile/comments/galleries/{id}", "GalleryController@indexComments");// comments of  gallery
$router->get("/profile/comments/users/{id}/{id}", "GalleryController@indexComments"); // comments of other users gallery
$router->post("/profile/comments/users/{id}/{id}", "GalleryController@indexComments");
$router->post('/gallery/comment', "GalleryController@createComment"); //create comment

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




