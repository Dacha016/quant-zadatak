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
    public function deleteImage(){
        $result = $this->deleteImage($_POST["delete"]);
        header("Location: http://localhost/profile");
        Blade::render("/profile");

    }
}
$image = new Image;
if ($_SERVER["REQUEST_METHOD"]==="post") {
    if ($_POST["name"] === "delete") {
       $image->deleteImage();
        exit();
    }
}
