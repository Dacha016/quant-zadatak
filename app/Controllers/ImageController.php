<?php

namespace App\Controllers;

use App\Blade\Blade;
use App\Models\Gallery;
use App\Models\Image;
use App\Models\Subscription;

class ImageController extends Controller
{

    public function __construct()
    {
        parent::__construct(new Image());
    }
    /**
     * List of image on home page which are not hidden or nsfw
     * @return void
     */
    public function indexHome()
    {
        $result =$this->model->indexHomePage();
        Blade::render("/home", compact("result"));
    }

    /**
     * List of users image on profile page
     * @return void
     */
    public function indexProfile()
    {
        $monthlyNumberOfPictures = $this->lastMonthImages();
        $result = $this->model->indexProfilePage($_SESSION["id"]);
        Blade::render("/profile", compact("result", "monthlyNumberOfPictures"));
    }

    /**
     * List of images in gallery
     * @return void
     */
    public function indexImage($id)
    {
        $result = $this->model->index($id);
        $gallery = new Gallery;
        $gallery = $gallery->show($id);
        Blade::render("/images", compact("result", "gallery"));}

    /**
     * Show not logged users images
     * @return void
     */
    public function notLoggedUserImages($slug,$id)
    {
        $result = $this->model->index($id);
        $gallery = new Gallery;
        $gallery = $gallery->show($id);
        Blade::render("/images", compact("result", "gallery"));

    }

    /**
     * Comments of image on profile page
     * @param $id
     * @return void
     */
    public function indexComments($id)
    {
        $this->comments($id);
    }

    /**
     * Comments of image in logged user gallery
     * @param $galleryId
     * @param $id
     * @return void
     */
    public function loggedUserImageComments($galleryId,$id)
    {
        $this->comments($id);
    }

    /**
     * Comments of not logged user picture
     * @param $slug
     * @param $galleryId
     * @param $id
     * @return void
     */
    public function notLoggedUserImageComments($slug,$galleryId,$id)
    {
        $this->comments($id);
    }

    /**
     * Find image and bind with comments
     * @param $id
     * @return void
     */
    public function comments($id)
    {
        $result = $this->model->imageComments($id);
        if ($result == null) {
            $error = "Be the first to comment";
            $image = $this->model->showInGallery($id);
            if (!$image) {
                $image = $this->model->show($id);
            }
            Blade::render("/imageComment", compact("result", "image", "error"));
        }else {
            $image = $this->model->showInGallery($id);
            if (!$image) {
                $image = $this->model->show($id);
            }
            Blade::render("/imageComment", compact("result", "image"));
        }
    }

    /**
     * Get only one image to update
     * @return void
     */
    public function showImage($id)
    {
        $result = $this->model->show($id);
        Blade::render("/imageUpdate", compact("result") );
    }

    /**
     * Show image in gallery
     * @param $slug
     * @param $id
     * @return void
     */
    public function showImageInGallery($slug,$id)
    {
         $result = $this->model->showInGallery($id);
         Blade::render("/imageUpdate", compact("result") );
    }

    /**
     * Show image in not logged user gallery
     * @param $slug
     * @param $galleryId
     * @param $id
     * @return void
     */
    public function showImageInNotLoggedUserGallery($slug, $galleryId, $id)
    {
        $result = $this->model->showInGallery($id);
        Blade::render("/imageUpdate", compact("result") );
    }

    /**
     * Insert image in image table
     * @return void
     */
    public function create()
    {
        $slug = str_replace(" ","-", $_POST["fileName"]);
        $slug = strtolower($slug);
        $imageData = [
            "userId" => $_SESSION["id"],
            "fileName" => $_POST["fileName"],
            "nsfw" => $this->model->getNsfw(),
            "hidden" => $this->model->getHidden(),
            "slug" => $slug
        ];
        $this->model->createImage($imageData);
        header("Location: /profile");
    }

    /**
     * Insert image in image_gallery table
     * @param $id
     * @return void
     */
    public function insertInGallery($id)
    {
        $slug = str_replace(" ","-", $_POST["fileName"]);
        $slug = strtolower($slug);
        $imageData = [
            "userId" => $_SESSION["id"],
            "fileName" => $_POST["fileName"],
            "nsfw" => $this->model->getNsfw(),
            "hidden" => $this->model->getHidden(),
            "slug" => $slug,
            "galleryId" => $id
        ];
        $this->model->createImage($imageData);
        $result = $this->model->selectLastImageId($imageData["userId"]);
        $imageData["imageId"] = $result->id;
        $this->model->insertImageIngallery($imageData);
        header("Location: /profile/galleries/{$imageData['galleryId']}");
    }

    /**
     * Update image
     * @return void
     */
    public function updateImage($id)
    {
        $hidden = isset($_POST['hidden'])  ? '1' : '0';
        $nsfw = isset($_POST['nsfw']) ? '1' : '0';
        $imageData = [
            "imageId" => $_POST["imageId"],
            "hidden" => $hidden,
            "nsfw" => $nsfw,
            "imageName" => $_POST["imageName"],
            "userUsername" => $_POST["userUsername"],
            "sessionUsername" => $_SESSION["username"],
            "userId" => $_POST["userId"],
        ];
        $this->model->active($imageData);

        if (isset($_POST["galleryId"])) {
            $imageData["galleryId"] = $_POST["galleryId"];
            if ($_SESSION["username"] == $_POST["userUsername"]) {
                header("Location: /profile/galleries/" . $imageData["galleryId"] . "page=1");
            } else{
                $this->model->createLogg($imageData);
                header("Location: /profile/users/".$imageData["userUsername"]."/" . $imageData["galleryId"]."page=1");
            }
        } else {
            header("Location: /profile");
        }
    }

    /**
     * Create image comment
     * @return void
     */
    public function createComments()
    {
        $commentData = [
            "username" => $_POST["username"],
            "imageId" => $_POST["imageId"],
            "userId" => $_SESSION["id"],
            "comment" => $_POST["comment"]
        ];
        $this->model->createImageComments($commentData);

        if (isset($_POST["galleryId"]) && $commentData["userId"] !== $_POST["userId"]) {
            header("Location: /comments/users/{$commentData['username']}/{$_POST["galleryId"]}/{$commentData['imageId']}");
        } elseif (isset($_POST["galleryId"]) && $commentData["userId"] == $_POST["userId"]){
             header("Location: /profile/comments/galleries/{$_POST["galleryId"]}/{$commentData['imageId']}");
        }
        else {
            header("Location: /profile/comments/images/{$commentData['imageId']}");
        }
    }

    /**
     * Delete image
     * @return void
     */
    public function delete($id)
    {
        $imageData = [
            "galleryId" =>$_POST["galleryId"],
            "userId" => $_POST["userId"],
            "imageId" =>$_POST["imageId"]
        ];
        $this->model->deleteImage($imageData["imageId"]);

        if (isset($imageData["galleryId"])) {
            if ($imageData["userId"] == $_SESSION["id"]) {
                header("Location: /profile/galleries/".$imageData["galleryId"]."?page=0");
            } else {
                header("Location: /profile/users/" . $imageData["userId"] . "/" . $imageData["galleryId"] . "?page=0");
            }
        } else {
            header("Location: /profile");
        }
    }

    /**
     * Number of uploaded images in last month
     * @return mixed
     */
    public function lastMonthImages()
    {
        $userSubscription = new Subscription;
        $user = $userSubscription->index($_SESSION["username"]);
        $date = $user[0]->start;
        return $this->model->imageCount($_SESSION["id"], $date);
    }
}