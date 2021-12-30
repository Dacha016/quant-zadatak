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
     * List of users gallery
     * @return void
     */
    public function indexGalleries()
    {
        $result = $this->gallery->indexGalleries($_SESSION["id"]);
        Blade::render("/galleries", compact("result"));
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
        if ($_SESSION["role"] === "user") {
            $result = $this->gallery->showUserGalleries($id);
        } else {
            $result = $this->gallery->showUserGalleriesAll($id);
        }
        Blade::render("/galleries", compact("result"));
    }
    public function updateGallery()
    {
        $_POST["hidden"] = (isset($_POST['hidden']) == '1' ? '1' : '0');
        $_POST["nsfw"] = (isset($_POST['nsfw']) == '1' ? '1' : '0');
        $this->gallery->updateGallery($_POST["description"], $_POST["hidden"], $_POST["nsfw"],$_POST["galleryId"]);
        if ($_POST["user_id"] === $_SESSION["id"]) {
            header("Location: http://localhost/profile/galleries");
        }
        if ($_POST["user_id"] !== $_SESSION["id"]) {
            header("Location: http://localhost/profile/users/". $_POST["user_id"]);
        }
    }
}

