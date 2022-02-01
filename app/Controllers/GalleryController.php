<?php

namespace App\Controllers;


use App\Models\Gallery;
use App\Blade\Blade;

class GalleryController extends Controller
{
    public function __construct()
    {
        parent::__construct(new Gallery());
    }

    /**
     * List of logged user galleries
     * @return void
     */
    public function indexGalleries()
    {

        $pages = $this->model->getPages($_SESSION["username"]);
        $result = $this->model->index($_SESSION["username"]);

        Blade::render("/galleries", compact("result", "pages"));

    }

    /**
     * List of gallery comments
     * @param $id
     * @return void
     */
    public function indexGalleryComments($id)
    {

        $result = $this->model->indexComments($id);
        $result = $result["data"]["comments"];
        $gallery = $this->model->show($id);
        $gallery = $gallery["data"]["gallery"];

        Blade::render("/galleryComments", compact("result", "gallery"));

    }

    /**
     * Show not logged user galleries.
     * If logged user role is "user" show galleries which are not hidden or nsfw
     * if logged user role is "admin" or "moderator" show all galleries
     */
    public function notLoggedUserGalleries($slug)
    {

        if ($_SESSION["role"] === "user") {

            $pages = $this->model->getPagesVisible($slug);
            $result = $this->model->indexHiddenOrNsfw($slug);

        } else {

            $result = $this->model->index($slug);
            $pages = $this->model->getPages($slug);

        }

        Blade::render("/galleries", compact("result", "pages"));

    }

    /**
     * Create new gallery
     * @return void
     */
    public function create()
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {

            Blade::render("/createGallery");

        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {

            $result = $this->model->createGallery();

            if (isset($result["data"]["error"])) {

                $error = $result["data"]["error"];

                Blade::render("/createGallery", compact("error"));

            } else {

                header("Location: /profile/galleries?page=1");
            }
        }
    }

    /**
     * Insert data in comment table
     * @return void
     */
    public function createComment()
    {

        $result = $this->model->createGalleryComment();

        if (isset($result["data"]["error"])) {

            $error = $result["data"]["error"];
//            Blade::render("/createComment", compact("error"));

        }

        header("Location: /comments/galleries/{$_POST["galleryId"]}");

    }

    /**
     * Update gallery of logger user and other users
     * @return void
     */
    public function updateGallery($id)
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {

            $result = $this->model->show($id);
            $result = $result["data"]["gallery"];

            Blade::render("/updateGallery", compact("result"));

        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {


            $this->model->update();

            if ($_POST["userId"] == $_SESSION["id"]) {

                header("Location: /profile/galleries?page=1");
            }

            if ($_POST["userId"] !== $_SESSION["id"]) {

                header("Location: /profile/users/" . $_POST["userUsername"] . "?page=1");
            }
        }
    }

    /**
     * Delete all data from gallery and aly other table with gallery_id
     * @return void
     */
    public function delete($id)
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {

            $result = $this->model->show($id);
            $result = $result["data"]["gallery"];

            Blade::render("/deleteGallery", compact("result"));

        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {

            $this->model->deleteGallery($_POST["galleryId"]);

            if ($_POST["userId"] === $_SESSION["id"]) {

                header("Location: /profile/galleries?page=1");

            } else {

                header("Location: /profile/users/" . $_POST["userUsername"] . "?page=1");
            }
        }
    }
}
