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

    public function index()
    {
        $result = $this->gallery->indexProfile($_SESSION["id"]);
        Blade::render("/profile", compact("result"));
    }
    public function galleryImage()
    {
        $result = $this->image->indexProfile($_SESSION["id"]);
        Blade::render("/image", compact("result"));
    }
    public function updatePicture()
    {
        $this->image->updatePicture($_POST["hidden"], $_POST["nsfw"], $_POST["update"]);
        header("Location: http://localhost/profile");
    }

    public function deleteImage(){
        $this->image->deleteImage($_POST["delete"]);
        header("Location: http://localhost/profile");
        Blade::render("/profile");

    }
}

