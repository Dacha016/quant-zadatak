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
$router->get('/profile/galleries', "GalleryController@indexGalleries"); // galleries in profile
$router->get("/profile/galleries/{id}/{id}", "ImageController@showImageInGallery"); //get single image from gallery
$router->get('/profile/galleries/{id}', "ImageController@indexImage");  //images from gallery
$router->get("/profile/images/{id}", "ImageController@showImage"); //get single image from profile
$router->post("/profile/update/images/{id}", "ImageController@updateImage");  //update image from logged user gallery
// not logged user
$router->get("/profile/users", "UserController@indexUsers");// other users
$router->get("/profile/users/{slug}/{id}/{id}", "ImageController@showImageInNotLoggedUserGallery");//not logged user image
$router->get("/profile/users/{slug}/{id}", "ImageController@notLoggedUserImages");  //images from gallery
$router->get("/profile/users/{slug}", "GalleryController@notLoggedUserGalleries"); // Not logged user galleries
$router->post("/update/images/{id}", "ImageController@updateImage");  //update image from logged user gallery

//image comments
$router->get("/comments/users/{slug}/{id}/{id}", "ImageController@notLoggedUserImageComments"); // comments
$router->get("/profile/comments/galleries/{id}/{id}", "ImageController@loggedUserImageComments"); // comments of images in galleries
$router->get("/home/images/{id}", "ImageController@indexComments");
$router->get("/profile/comments/images/{id}", "ImageController@indexComments"); // comments of images on profile page

$router->post('/image/comments', "ImageController@createComments"); //create comment
// gallery comments
$router->get("/comments/galleries/{id}", "GalleryController@indexGalleryComments"); // comments of  gallery
$router->get("/profile/comments/users/{slug}/{id}", "GalleryController@indexComments"); // comments of other users gallery
$router->post('/gallery/comment', "GalleryController@createComment"); //create comment

$router->get("/profile/update/gallery/{id}","GalleryController@updateGallery");
$router->post("/profile/update/gallery/{id}","GalleryController@updateGallery");

$router->get("/profile/updateAccount","UserController@updateAccount");
$router->post("/profile/updateAccount","UserController@updateAccount");

$router->get("/profile/update/users/{slug}","UserController@updateUser");
$router->post("/profile/update/users/{slug}","UserController@updateUser");

$router->post('/delete/image/{id}', "ImageController@delete");
$router->get('/delete/gallery/{id}', "GalleryController@delete");
$router->post('/delete/gallery/{id}', "GalleryController@delete");

$router->post("/addImage/galleries/{id}", "ImageController@insertInGallery");
$router->post("/addImage", "ImageController@create");

$router->get("/profile/subscription", "SubscriptionController@subscription");
$router->post("/profile/subscription", "SubscriptionController@subscription");
$router->get("/subscription/{slug}", "SubscriptionController@indexSubscriptionList");