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
        $result = $this->image->indexProfile($_SESSION["id"]);
        Blade::render("/profile", compact("result"));
    }

    public function indexComments($id)
    {
        $this->comments($id);
    }
    public function loggedUserGalleryComments($galleryId,$id)
    {
        $this->comments($id);
    }
    public function notLoggedUserGalleryComments($slug,$galleryId,$id)
    {
        $this->comments($id);
    }
    public function comments($id)
    {
        $result = $this->image->indexComments($id);
        if ($result == null) {
            $result = "Be the first to comment";
            $image = $this->image->showImageInGallery($id);
            if (!$image) {
                $image = $this->image->show($id);
            }
            Blade::render("/noComment", compact("result", "image"));
        }else {
            $image = $this->image->showImageInGallery($id);
            if (!$image) {
                $image = $this->image->show($id);
            }
            Blade::render("/imageComment", compact("result", "image"));
        }
    }
    /**
     * List of gallery images
     * @return void
     */
    public
    function index($id)
    {
        $result = $this->image->index($id);
        Blade::render("/images", compact("result"));
    }

    /**
     * Show not logged users images
     * @return void
     */
    public function notLoggedUserImages($slug,$id)
    {
        $result = $this->image->index($id);
        Blade::render("/images", compact("result"));
    }
    /**
     * Get only one image to update
     * @return void
     */
    public function show($id)
    {
        $result = $this->image->show($id);
        Blade::render("/image", compact("result") );
    }
    public function showImageInGallery($slug,$id)
    {
         $result = $this->image->showImageInGallery($id);
         Blade::render("/image", compact("result") );
    }
    /**
     * Update image
     * @return void
     */
    public function update($id)
    {
        $hidden = isset($_POST['hidden'])  ? '1' : '0';
        $nsfw = isset($_POST['nsfw']) ? '1' : '0';
        $imageData = [
            "imageId" => $_POST["imageId"],
            "hidden" => $hidden,
            "nsfw" => $nsfw,
            "imageName" => $_POST["imageName"],
            "userUsername" => $_POST["userUsername"],
            "sessionUsername" => $_SESSION["username"],
            "userId" => $_POST["userId"],
        ];

        if (isset($_POST["galleryId"])) {
            $imageData["galleryId"] = $_POST["galleryId"];
            $this->image->update($imageData);
            header("Location: /profile/galleries/".$imageData["galleryId"]."page=1");
        } else {
            $this->image->update($imageData);
            header("Location: /profile");
        }
    }

    public function notLoggedUserUpdate($id)
    {
        $hidden = isset($_POST['hidden'])  ? '1' : '0';
        $nsfw = isset($_POST['nsfw']) ? '1' : '0';
        $imageData = [
            "imageId" => $_POST["imageId"],
            "hidden" => $hidden,
            "nsfw" => $nsfw,
            "imageName" => $_POST["imageName"],
            "userUsername" => $_POST["userUsername"],
            "sessionUsername" => $_SESSION["username"],
            "userId" => $_POST["userId"],
            "galleryId" => $_POST["galleryId"]
        ];
        $this->image->update($imageData);
        $this->image->createLogg($imageData);
        header("Location: /profile/users/".$imageData["userUsername"]."/" . $imageData["galleryId"]."page=1");
    }

    public function createComments()
    {
        $commentData = [
            "username"=>$_POST["username"],
            "imageId" =>$_POST["imageId"],
            "userId" => $_SESSION["id"],
            "comment" => $_POST["comment"]
        ];
        $this->image->createComments($commentData);

        if (isset($_POST["galleryId"]) && $commentData["userId"] !== $_POST["userId"]) {
            header("Location: /comments/users/{$commentData['username']}/{$_POST["galleryId"]}/{$commentData['imageId']}");
        } elseif (isset($_POST["galleryId"]) && $commentData["userId"] == $_POST["userId"]){
             header("Location: /profile/comments/galleries/{$_POST["galleryId"]}/{$commentData['imageId']}");
        }
        else {
            header("Location: /profile/comments/images/{$commentData['imageId']}");
        }
    }

    /**
     * Delete image
     * @return void
     */
    public function delete($id)
    {
        $imageData = [
            "galleryId" =>(int) $_POST["galleryId"],
            "userId" => $_POST["userId"],
            "imageId" =>$_POST["imageId"]
        ];
        $this->image->delete($imageData["imageId"]);
        if ($imageData["galleryId"] !== 0) {
            if ($imageData["userId"] == $_SESSION["id"]) {
                header("Location: /profile/galleries/".$imageData["galleryId"]."?page=0");
            } else {
                header("Location: /profile/users/" . $imageData["userId"] . "/" . $imageData["galleryId"] . "?page=0");
            }
        } else {
            header("Location: /profile");
        }
    }
}