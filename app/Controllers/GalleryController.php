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
    public function indexGalleries($slug)
    {

        if ($_SESSION["role"] === "user") {

            $pages = $this->model->getPagesVisible($slug);

            $result = $this->model->indexHiddenOrNsfw($slug);

        } else {

            $result = $this->model->index($slug);

            $pages = $this->model->getPages($slug);

        }

        $result = $result["data"]["galleries"];

        Blade::render("/galleries", compact("result", "pages"));

    }

    /**
     * List of gallery comments
     * @param $id
     * @return void
     */
    public function indexGalleryComments($slug)
    {

        $result = $this->model->indexComments($slug);
        $result = $result["data"]["comments"];
        $gallery = $this->model->show($slug);
        $gallery = $gallery["data"]["gallery"];

        Blade::render("/galleryComments", compact("result", "gallery"));

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

                header("Location: /users/{$_SESSION['username']}?page=1");
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
            Blade::render("/createComment", compact("error"));

        }

        header("Location: /comments/galleries/{$_POST["slug"]}");

    }

    /**
     * Update gallery of logger user and other users
     * @return void
     */
    public function updateGallery($slug)
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {

            $result = $this->model->show($slug);
            $result = $result["data"]["gallery"];

            Blade::render("/updateGallery", compact("result"));

        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {

            $this->model->update($slug);


            header("Location: /users/" . $_POST["userUsername"] . "?page=1");

        }
    }

    /**
     * Delete all data from gallery and aly other table with gallery_id
     * @return void
     */
    public function delete($slug)
    {

        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {

            $result = $this->model->show($slug);
            $result = $result["data"]["gallery"];

            Blade::render("/deleteGallery", compact("result"));

        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {

            $this->model->deleteGallery($_POST["slug"]);

            header("Location: /users/" . $_POST["userUsername"] . "?page={$_POST['page']}");

        }
    }
}
