<?php

namespace App\Controllers;

if (!session_start()) {
    session_start();
}
use App\Models\Gallery;
use App\Blade\Blade;



class GalleryController
{

    protected Gallery $gallery;

    public function __construct()
    {
        $this->gallery = new Gallery;
    }
    /**
     * List of logged user galleries
     * @return void
     */
    public function indexGalleries()
    {
        $pages = $this->gallery->getPages($_SESSION["id"]);
        $result = $this->gallery->indexGalleries($_SESSION["id"]);
        Blade::render("/galleries", compact("result","pages"));
    }

    /**
     * Show different permissions for different user
     * @return void
     */
    public function showGalleries()
    {
        $id = $_SERVER["REQUEST_URI"];
        $id = explode("/", $id);
        $n = count($id);
        $id = $id[$n - 1];
        $id = explode("?", $id);
        $id = $id[0];

        if ($_SESSION["role"] === "user") {
            $pages = $this->gallery->getPagesVisible($id);
            $result = $this->gallery->showUserGalleries($id);
        } else {
            $result = $this->gallery->showUserGalleriesAll($id);
            $pages = $this->gallery->getPages($id);
        }
        Blade::render("/galleries", compact("result", "pages"));
    }

    /**
     * Create new gallery
     * @return void
     */
    public function createGallery()
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {
            Blade::render("/createGallery");

        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $userId = $_SESSION["id"];
            $name = trim($_POST["name"]);
            $description = trim($_POST["description"]);
            $hidden = (isset($_POST['hidden']) == '1' ? '1' : '0');
            $nsfw = (isset($_POST['nsfw']) == '1' ? '1' : '0');
            $slug = str_replace(" ","-", $name);
            $slug = strtolower($slug);
            $this->gallery->createGallery($userId, $name, $nsfw, $hidden, $description, $slug);
            header("Location: http://localhost/profile/galleries?page=0");
        }

    }

    /**
     * Update gallery of logger user and other users
     * @return void
     */
    public function updateGallery()
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {
            $galleryId = $_SERVER["REQUEST_URI"];
            $galleryId = explode("/", $galleryId);
            $n = count($galleryId);
            $galleryId = $galleryId[$n - 1];
            $galleryId =  explode("?", $galleryId);
            $galleryId = $galleryId[0];
            $result = $this->gallery->show( $galleryId);

            Blade::render("/updateGallery", compact("result"));

        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
            $hidden = (isset($_POST['hidden']) == '1' ? '1' : '0');
            $nsfw = (isset($_POST['nsfw']) == '1' ? '1' : '0');
            $galleryData =[
                "userId" => $_POST["userId"],
                "galleryId"=> $_POST["galleryId"],
                "name" => trim($_POST["name"]),
                "slug" =>$_POST["slug"],
                "description" => trim($_POST["description"]),
                "hidden" => $hidden,
                "nsfw" => $nsfw,
                "userUsername" => $_POST["userUsername"],
                "sessionName" =>$_SESSION["username"]
            ];
            if ($_POST["userId"] !== $_SESSION["id"] && $_SESSION["role"] === "moderator") {
                $this->gallery->createLogg($galleryData);
            }
            $this->gallery->updateGallery($galleryData);
            if ($galleryData["userId"] == $_SESSION["id"]) {
                header("Location: http://localhost/profile/galleries?page=0");
            }
            if ($galleryData["userId"] !== $_SESSION["id"]) {
                header("Location: http://localhost/profile/users/" . $galleryData["userId"] . "?page=0");
            }
        }
    }

    /**
     * Delete all data from gallery and aly other table with gallery_id
     * @return void
     */
    public function deleteGallery()
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {
            $galleryId = $_SERVER["REQUEST_URI"];
            $galleryId = explode("/", $galleryId);
            $n = count($galleryId);
            $galleryId = $galleryId[$n - 1];
            $galleryId =  explode("?", $galleryId);
            $galleryId = $galleryId[0];
            $result = $this->gallery->show( $galleryId);
            Blade::render("/deleteGallery", compact("result"));

        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
            $userId = $_POST["userId"];
            $galleryId = $_POST["galleryId"];
            $this->gallery->deleteGallery($galleryId);
            if ($userId === $_SESSION["id"]) {
                header("Location: http://localhost/profile/galleries?page=0");
            } else {
                header("Location: http://localhost/profile/users/" . $userId . "?page=0");
            }
        }
    }
}

