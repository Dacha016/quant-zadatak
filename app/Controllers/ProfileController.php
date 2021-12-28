<?php

namespace App\Controllers;
session_start();
use App\Blade\Blade;
use App\Models\Image;

class ProfileController
{
    protected Image $image;

    public function __construct()
    {
        $this->image = new Image;
    }

    public function index()
    {
        $result =$this->image->indexProfile($_SESSION["id"]);
        Blade::render("/profile", compact("result"));
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

