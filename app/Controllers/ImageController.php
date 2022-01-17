<?php

namespace App\Controllers;

if (!session_start()) {
    session_start();
}

use App\Blade\Blade;
use App\Models\Image;

class ImageController extends Image
{
    /**
     * List of image on home page which are not hidden or nsfw
     * @return void
     */
    public function indexHome()
    {
        $result =$this->indexHomePage();
        Blade::render("/home", compact("result"));
    }

    /**
     * List of users image on profile page
     * @return void
     */
    public function indexProfile()
    {
        $result = $this->indexProfilePage($_SESSION["id"]);
        Blade::render("/profile", compact("result"));
    }

    /**
     * List of images in gallery
     * @return void
     */
    public function indexImage($id)
    {
        $result = $this->index($id);
        $galleryId = $id;
        Blade::render("/images", compact("result", "galleryId"));
    }

    /**
     * Show not logged users images
     * @return void
     */
    public function notLoggedUserImages($slug,$id)
    {
        $result = $this->index($id);
        Blade::render("/images", compact("result"));
    }

    /**
     * Comments of image on profile page
     * @param $id
     * @return void
     */
    public function indexComments($id)
    {
        $this->comments($id);
    }

    /**
     * Comments of image in logged user gallery
     * @param $galleryId
     * @param $id
     * @return void
     */
    public function loggedUserImageComments($galleryId,$id)
    {
        $this->comments($id);
    }

    /**
     * Comments of not logged user picture
     * @param $slug
     * @param $galleryId
     * @param $id
     * @return void
     */
    public function notLoggedUserImageComments($slug,$galleryId,$id)
    {
        $this->comments($id);
    }

    /**
     * Find image and bind with comments
     * @param $id
     * @return void
     */
    public function comments($id)
    {
        $result = $this->imageComments($id);
        if ($result == null) {
            $result = "Be the first to comment";
            $image = $this->showInGallery($id);
            if (!$image) {
                $image = $this->show($id);
            }
            Blade::render("/noComment", compact("result", "image"));
        }else {
            $image = $this->showInGallery($id);
            if (!$image) {
                $image = $this->show($id);
            }
            Blade::render("/imageComment", compact("result", "image"));
        }
    }

    /**
     * Get only one image to update
     * @return void
     */
    public function showImage($id)
    {
        $result = $this->show($id);
        Blade::render("/imageUpdate", compact("result") );
    }

    /**
     * Show image in gallery
     * @param $slug
     * @param $id
     * @return void
     */
    public function showImageInGallery($slug,$id)
    {
         $result = $this->showInGallery($id);
         Blade::render("/imageUpdate", compact("result") );
    }

    /**
     * Show image in not logged user gallery
     * @param $slug
     * @param $galleryId
     * @param $id
     * @return void
     */
    public function showImageInNotLoggedUserGallery($slug, $galleryId, $id)
    {
        $result = $this->showInGallery($id);
        Blade::render("/imageUpdate", compact("result") );
    }

    /**
     * Insert image in image table
     * @return void
     */
    public function create()
    {
        $slug = str_replace(" ","-", $_POST["fileName"]);
        $slug = strtolower($slug);
        $imageData = [
            "userId" => $_SESSION["id"],
            "fileName" => $_POST["fileName"],
            "nsfw" => $this->getNsfw(),
            "hidden" => $this->getHidden(),
            "slug" => $slug
        ];
        $this->createImage($imageData);
        header("Location: /profile");
    }

    /**
     * Insert image in image_gallery table
     * @param $id
     * @return void
     */
    public function insertInGallery($id)
    {
        $slug = str_replace(" ","-", $_POST["fileName"]);
        $slug = strtolower($slug);
        $imageData = [
            "userId" => $_SESSION["id"],
            "fileName" => $_POST["fileName"],
            "nsfw" => $this->getNsfw(),
            "hidden" => $this->getHidden(),
            "slug" => $slug,
            "galleryId" => $id
        ];
        $this->createImage($imageData);
        $result = $this->selectLastImageId($imageData["userId"]);
        $imageData["imageId"] = $result->id;
        $this->insertImageIngallery($imageData);
        header("Location: /profile/galleries/{$imageData['galleryId']}");
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
        $this->updateImage($imageData);

        if (isset($_POST["galleryId"])) {
            $imageData["galleryId"] = $_POST["galleryId"];
            if ($_SESSION["username"] == $_POST["userUsername"]) {
                header("Location: /profile/galleries/" . $imageData["galleryId"] . "page=1");
            } else{
                $this->createLogg($imageData);
                header("Location: /profile/users/".$imageData["userUsername"]."/" . $imageData["galleryId"]."page=1");
            }
        } else {
            header("Location: /profile");
        }
    }

    /**
     * Create image comment
     * @return void
     */
    public function createComments()
    {
        $commentData = [
            "username" => $_POST["username"],
            "imageId" => $_POST["imageId"],
            "userId" => $_SESSION["id"],
            "comment" => $_POST["comment"]
        ];
        $this->createImageComments($commentData);

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
            "galleryId" =>$_POST["galleryId"],
            "userId" => $_POST["userId"],
            "imageId" =>$_POST["imageId"]
        ];
        $this->deleteImage($imageData["imageId"]);

        if (isset($imageData["galleryId"])) {
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