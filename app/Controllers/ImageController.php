<?php

namespace App\Controllers;

if (!session_start()) {
    session_start();
}

use App\Blade\Blade;
use App\Models\Image;

class ImageController
{
    protected Image $image;

    public function __construct()
    {
        $this->image = new Image;
    }
    public function indexHome()
    {
        $result =$this->image->indexHome();
        Blade::render("/home", compact("result"));
    }

    /**
     * List of users image on profile page
     * @return void
     */
    public function indexProfile()
    {
        $result = $this->image->indexProfile();
        Blade::render("/profile", compact("result"));
    }

    /**
     * List of gallery images
     * @return void
     */
    public
    function index()
    {
        $id = $_SERVER["REQUEST_URI"];
        $id = explode("/", $id);
        $n = count($id);
        $id = $id[$n - 1];
        $result = $this->image->indexGallery($id);
        Blade::render("/images", compact("result"));
    }

    /**
     * Show not logged users images
     * @return void
     */
    public function showNotLoggedUserImages()
    {
        $id = $_SERVER["REQUEST_URI"];
        $id = explode("/", $id);
        $n = count($id);
        $id = $id[$n - 1];
        $result = $this->image->indexGallery($id);
        Blade::render("/images", compact("result"));

    }
    /**
     * Get only one image to update
     * @return void
     */
    public function show()
    {
        $result = $this->image->show($_POST["getImage"]);
        Blade::render("/image", compact("result") );
    }
    /**
     * Update image
     * @return void
     */
    public function update()
    {
//var_dump($_POST);
//die();
        $hidden = (isset($_POST['hidden']) == '1' ? '1' : '0');
        $nsfw = (isset($_POST['nsfw']) == '1' ? '1' : '0');
        $imageData = [
            "imageId" => $_POST["imageId"],
            "galleryId" =>$_POST["galleryId"],
            "hidden" => $hidden,
            "nsfw" => $nsfw,
            "imageName" => $_POST["imageName"],
            "userUsername" => $_POST["userUsername"],
            "sessionUsername" => $_SESSION["username"],
            "userId" => $_POST["userId"],
        ];
        if($imageData["userId"] !== $_SESSION["id"] && $_SESSION["role"] === "moderator") {
            $this->image->createLogg($imageData);
        }
        $this->image->update($imageData);
        if ($imageData["userId"] === $_SESSION["id"]) {
            header("Location: http://localhost/profile/galleries/".$imageData["galleryId"]."page=0");
        }else{
            header("Location: http://localhost/profile/users/".$imageData["userId"]."/" . $imageData["galleryId"]."page=0");
        }
    }

    /**
     * Delete image
     * @return void
     */
    public function delete()
    {

        $imageData = [
            "galleryId" =>(int) $_POST["galleryId"],
            "userId" => $_POST["userId"],
            "imageId" =>$_POST["imageId"]
        ];
        $this->image->delete($imageData["imageId"]);
        if ($imageData["userId"] == $_SESSION["id"]) {
            header("Location: http://localhost/profile/galleries/".$imageData["galleryId"]."?page=0");
        }else{
            header("Location: http://localhost/profile/users/".$imageData["userId"] ."/" . $imageData["galleryId"]."?page=0");
        }
    }

}