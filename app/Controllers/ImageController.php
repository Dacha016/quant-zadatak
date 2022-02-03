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
    public function indexImage($slug)
    {

        $result = $this->model->index($slug);
        $result = $result["data"]["images"];

        $monthlyNumberOfPictures = $this->model->lastMonthImages();

        if ($result == null) {

            $gallery = new Gallery();
            $gallery = $gallery->show($slug);

            $galleryId = $gallery["data"]["gallery"]->galleryId;
            $userId = $gallery["data"]["gallery"]->userId;

        } else {

            $galleryId = $result[0]->galleryId;
            $userId = $result[0]->userId;

        }

        Blade::render("/images", compact("result", "galleryId", "userId", "monthlyNumberOfPictures"));

    }

    /**
     * Find image and bind with comments
     * @param $id
     * @return void
     */
    public function comments($slug)
    {

        $result = $this->model->imageComments($slug);

        if (isset($result["data"]["error"])) {

            $error = $result["data"]["error"];
            $image = $this->model->showInGallery($slug);
            $image = $image["data"]["image"];

            if (!$image) {

                $image = $this->model->show($slug);
                $image = $image["data"]["image"];
            }

            Blade::render("/imageComment", compact("image", "error"));

        } else {

            $image = $this->model->showInGallery($slug);

            if (isset($image["data"]["error"])) {

                $image = $this->model->show($slug);

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
    public function showImage($slug)
    {

        $result = $this->model->show($slug);

        if (!$result) {

            $result = $this->model->showInGallery($slug);
        }

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
    public function updateImage($slug)
    {

        $this->model->update();
        $result = $this->model->showInGallery($slug);
        $result = $result["data"]["image"];

        if ($result) {

            if ($_SESSION["username"] !== $result->username && $_SESSION["role"] === "moderator") {

                $this->model->createLogg($result->galleryId);

            } else {

                header("Location: /galleries/" . $result->gallerySlug);

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
            $image = $this->model->showInGallery($_POST["slug"]);
            $image = $image["data"]["image"];

            if (!$image) {

                $image = $this->model->show($_POST["slug"]);
                $image = $image["data"]["image"];
            }

            Blade::render("/imageComment", compact("image", "error"));

        } else {

            header("Location: /images/{$_POST['slug']}");

        }

    }

    /**
     * Delete image
     * @return void
     */
    public function delete($slug)
    {

        $this->model->deleteImage($slug);

        if (isset($_POST["gallerySlug"])) {

            header("Location: /galleries/" . $_POST["gallerySlug"]);

        } else {

            header("Location: /profile");
        }
    }

}