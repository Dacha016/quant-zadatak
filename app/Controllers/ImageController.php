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
    public function index()
    {
        $result =$this->image->index();
        Blade::render("/home", compact("result"));
    }

    /**
     * List of users image on profile page
     * @return void
     */
    public function imagesOnTheMainPage()
    {
        $result = $this->image->imagesOnTheMainPage();
        Blade::render("/profile", compact("result"));
    }

    /**
     * List of gallery images
     * @return void
     */
    public
    function showImages()
    {
        $id = $_SERVER["REQUEST_URI"];
        $id = explode("/", $id);
        $n = count($id);
        $id = $id[$n - 1];
        $result = $this->image->showImages($id);
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
        $result = $this->image->showImages($id);
        Blade::render("/images", compact("result"));

    }
    /**
     * Get only one image to update
     * @return void
     */
    public function getImage()
    {
        $result = $this->image->getImage($_POST["getImage"]);
        Blade::render("/image", compact("result") );
    }
    /**
     * Update image
     * @return void
     */
    public function updateImage()
    {
        $hidden = (isset($_POST['hidden']) == '1' ? '1' : '0');
        $nsfw = (isset($_POST['nsfw']) == '1' ? '1' : '0');
        $imageId = $_POST["imageId"];
        $this->image->updateImage($imageId, $hidden, $nsfw);
        $galleryId = $_POST["galleryId"];
        $userId=$_POST["userId"];
        if ($_POST["userId"] === $_SESSION["id"]) {
            header("Location: http://localhost/profile/galleries/".$galleryId."page=0");
        }else{
            header("Location: http://localhost/profile/users/".$userId ."/" . $galleryId."page=0");
        }
    }

    /**
     * Delete image
     * @return void
     */
    public function deleteImage(){
        $galleryId = $_POST["galleryId"];
        $userId=$_POST["userId"];
        $imageId = $_POST["imageId"];
        $this->image->deleteImage($imageId);
        if ($userId === $_SESSION["id"]) {
            header("Location: http://localhost/profile/galleries/".$galleryId."?page=0");
        }else{
            header("Location: http://localhost/profile/users/".$userId ."/" . $galleryId."?page=0");
        }
    }

}