<?php

namespace App\Controllers;
session_start();
use App\Blade\Blade;
use App\Models\Gallery;
use App\Models\Image;

class ProfileController
{
    protected Image $image;
    protected Gallery $gallery;

    public function __construct()
    {
        $this->image = new Image;
        $this->gallery = new Gallery;
    }

    public function imagesOnTheMainPage()
    {
        $result = $this->image->imagesOnTheMainPage();
        Blade::render("/profile", compact("result"));
    }
    /**
     * List of users gallery
     * @return void
     */
    public function indexGalleries()
    {
        $result = $this->gallery->indexGalleries($_SESSION["id"]);
        Blade::render("/gallery", compact("result"));
    }

    /**
     * List of gallery images
     * @return void
     */
    public function showGalleries()
    {
        $result = $this->image->showGalleries($_SESSION["id"]);
        Blade::render("/images", compact("result"));
    }

    /**
     * Get only one image to update
     * @return void
     */
    public function getImage()
    {
        $result = $this->image->getImage($_POST["adminModeratorUpdate"]);
        Blade::render("/image", compact("result") );
    }
    public function updateImage()
    {
        $hidden = (isset($_POST['hidden']) == '1' ? '1' : '0');
        $nsfw = (isset($_POST['nsfw']) == '1' ? '1' : '0');
        $slug = $_POST["update"];
        $this->image->updateImage($slug, $hidden, $nsfw);
        header("Location: http://localhost/profile");

    }

    public function deleteImage(){
        $this->image->deleteImage($_POST["delete"]);
        header("Location: http://localhost/profile");
        Blade::render("/profile");

    }
}

