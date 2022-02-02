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

        $result = $this->model->indexHomePage();
        $result = $result["data"]["images"];

        Blade::render("/home", compact("result"));

    }

    /**
     * List of users image on profile page
     * @return void
     */
    public function indexProfile()
    {

        $monthlyNumberOfPictures = $this->model->lastMonthImages();

        $result = $this->model->indexProfilePage($_SESSION["id"]);

        $result = $result["data"]["images"];

        Blade::render("/profile", compact("result", "monthlyNumberOfPictures"));

    }

    /**
     * List of images in gallery
     * @return void
     */
    public function indexImage($id)
    {

        $result = $this->model->index($id);
        $result = $result["data"]["images"];

        $monthlyNumberOfPictures = $this->model->lastMonthImages();

        if ($result == null) {
            $gallery = new Gallery();
            $gallery = $gallery->show($id);
            $galleryId = $gallery["data"]["gallery"]->galleryId;
            $userId = $gallery["data"]["gallery"]->userId;

        } else {

            $galleryId = $result[0]->galleryId;
            $userId = $result[0]->userId;

        }


        Blade::render("/images", compact("result", "galleryId", "userId", "monthlyNumberOfPictures"));

    }

    /**
     * Show not logged users images
     * @return void
     */
    public function notLoggedUserImages($slug, $id)
    {

        $monthlyNumberOfPictures = $this->model->lastMonthImages();

        $result = $this->model->index($id);
        $result = $result["data"]["images"];

        $galleryId = $result[0]->galleryId;
        $userId = $result[0]->userId;

        Blade::render("/images", compact("result", "galleryId", "userId", "monthlyNumberOfPictures"));

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
    public function loggedUserImageComments($galleryId, $id)
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
    public function notLoggedUserImageComments($slug, $galleryId, $id)
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

        if (isset($result["data"]["error"])) {

            $error = $result["data"]["error"];
            $image = $this->model->showInGallery($id);
            $image = $image["data"]["image"];

            if (!$image) {

                $image = $this->model->show($id);
                $image = $image["data"]["image"];
            }

            Blade::render("/imageComment", compact("image", "error"));

        } else {

            $image = $this->model->showInGallery($id);
            
            if (isset($image["data"]["error"])) {

                $image = $this->model->show($id);

            }

            $image = $image["data"]["image"];
            $result = $result["data"]["comments"];

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
        $result = $result["data"]["image"];

        Blade::render("/imageUpdate", compact("result"));

    }

    /**
     * Show image in gallery
     * @param $slug
     * @param $id
     * @return void
     */
    public function showImageInGallery($slug, $id)
    {

        $result = $this->model->showInGallery($id);
        $result = $result["data"]["image"];

        Blade::render("/imageUpdate", compact("result"));

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
        $result = $result["data"]["image"];

        Blade::render("/imageUpdate", compact("result"));

    }

    /**
     * Insert image in image table
     * @return void
     */
    public function create()
    {

        $result = $this->model->createImage();

        $monthlyNumberOfPictures = $this->model->lastMonthImages();

        if (isset($result["data"]["error"])) {

            $error = $result["data"]["error"];

            Blade::render("/profile", compact("error", "monthlyNumberOfPictures"));
        } else {

            header("Location: /profile");

        }

    }

    /**
     * Insert image in image_gallery table
     * @param $id
     * @return void
     */
    public function insertInGallery($id)
    {

        $result = $this->model->createImage();

        $monthlyNumberOfPictures = $this->model->lastMonthImages();

        if (isset($result["data"]["error"])) {

            $error = $result["data"]["error"];

            Blade::render("/profile", compact("error", "monthlyNumberOfPictures"));

        } else {

            header("Location: /profile/galleries/{$id}");

        }
    }

    /**
     * Update image
     * @return void
     */
    public function updateImage($id)
    {

        $this->model->update();
        $result = $this->model->showInGallery($id);
        $result = $result["data"]["image"];

        if ($result) {

            if ($_SESSION["username"] !== $result->username && $_SESSION["role"] === "moderator") {

                $this->model->createLogg($result->galleryId);

                header("Location: /profile/users/" . $result->username . "/" . $result->galleryId . "page=1");

            } else {

                header("Location: /profile/galleries/" . $result->galleryId . "page=1");

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

        $result = $this->model->createImageComments();

        if (isset($result["data"]["error"])) {

            $error = $result["data"]["error"];
            $image = $this->model->showInGallery($_POST["imageId"]);
            $image = $image["data"]["image"];

            if (!$image) {

                $image = $this->model->show($_POST["imageId"]);
                $image = $image["data"]["image"];
            }

            Blade::render("/imageComment", compact("image", "error"));

        } else {

            if (isset($_POST["galleryId"]) && $_SESSION["username"] !== $_POST["username"]) {

                header("Location: /comments/users/{$_POST['username']}/{$_POST["galleryId"]}/{$_POST['imageId']}");
            } elseif (isset($_POST["galleryId"]) && $_SESSION["username"] == $_POST["username"]) {

                header("Location: /profile/comments/galleries/{$_POST["galleryId"]}/{$_POST['imageId']}");

            } else {

                header("Location: /profile/comments/images/{$_POST['imageId']}");

            }

        }

    }

    /**
     * Delete image
     * @return void
     */
    public function delete($id)
    {

        $this->model->deleteImage($id);

        if (isset($_POST["galleryId"])) {

            if ($_POST["userId"] == $_SESSION["id"]) {

                header("Location: /profile/galleries/" . $_POST["galleryId"] . "?page=0");

            } else {

                header("Location: /profile/users/" . $_POST["userId"] . "/" . $_POST["galleryId"] . "?page=0");

            }
        } else {

            header("Location: /profile");
        }
    }

}