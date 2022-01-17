<?php

namespace App\Controllers;

if (!session_start()) {
    session_start();
}
use App\Models\Gallery;
use App\Blade\Blade;

class GalleryController extends Gallery
{
    /**
     * List of logged user galleries
     * @return void
     */
    public function indexGalleries()
    {
        $pages = $this->getPages($_SESSION["username"]);
        $result = $this->index($_SESSION["username"]);
        Blade::render("/galleries", compact("result","pages"));
    }

    /**
     * List of gallery comments
     * @param $id
     * @return void
     */
    public function indexGalleryComments($id)
    {
        $result = $this->indexComments($id);
        $gallery = $this->show($id);
        Blade::render("/galleryComments", compact("result","gallery"));
    }

    /**
     * Show not logged user galleries.
     * If logged user role is "user" show galleries which are not hidden or nsfw
     * if logged user role is "admin" or "moderator" show all galleries
     */
    public function notLoggedUserGalleries($slug)
    {
        if ($_SESSION["role"] === "user") {
            $pages = $this->getPagesVisible($slug);
            $result = $this->indexHiddenOrNsfw($slug);
        } else {
            $result = $this->index($slug);
            $pages = $this->getPages($slug);
        }
        Blade::render("/galleries", compact("result", "pages"));
    }

    /**
     * Create new gallery
     * @return void
     */
    public function create()
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {
            Blade::render("/createGallery");

        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $name = trim($_POST["name"]);
            $hidden = isset($_POST['hidden']) ? '1' : '0';
            $nsfw = isset($_POST['nsfw'])  ? '1' : '0';
            $slug = str_replace(" ","-", $name);
            $slug = strtolower($slug);
            $galleryData =[
                "userId" => $_SESSION["id"],
                "name" => trim($_POST["name"]),
                "slug" =>$slug,
                "description" => trim($_POST["description"]),
                "hidden" => $hidden,
                "nsfw" => $nsfw
            ];
            $this->createGallery($galleryData);
            header("Location: /profile/galleries?page=1");
        }
    }

    /**
     * Insert data in comment table
     * @return void
     */
    public function createComment()
    {
        $commentData = [
            "galleryId" =>$_POST["galleryId"],
            "userId" => $_SESSION["id"],
            "comment" => $_POST["comment"]
        ];
        $this->createGalleryComment($commentData);
            header("Location: /comments/galleries/{$_POST["galleryId"]}");
    }

    /**
     * Update gallery of logger user and other users
     * @return void
     */
    public function update($id)
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {
            $result = $this->show( $id);
            Blade::render("/updateGallery", compact("result"));
        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
            $hidden = isset($_POST['hidden']) ? '1' : '0';
            $nsfw = isset($_POST['nsfw'])  ? '1' : '0';
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
                $this->createLogg($galleryData);
            }
            $this->updateGallery($galleryData);
            if ($galleryData["userId"] == $_SESSION["id"]) {
                header("Location: /profile/galleries?page=1" );
            }
            if ($galleryData["userId"] !== $_SESSION["id"]) {
                header("Location: /profile/users/" . $galleryData["userUsername"] . "?page=1");
            }
        }
    }

    /**
     * Delete all data from gallery and aly other table with gallery_id
     * @return void
     */
    public function delete($id)
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {
            $result = $this->show($id);
            Blade::render("/deleteGallery", compact("result"));
        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
            $this->deleteGallery($_POST["galleryId"]);
            if ($_POST["userId"] === $_SESSION["id"]) {
                header("Location: /profile/galleries?page=1");
            } else {
                header("Location: /profile/users/" . $_POST["userUsername"] . "?page=1");
            }
        }
    }
}
