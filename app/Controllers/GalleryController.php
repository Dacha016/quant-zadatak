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
     * List of logged user galleries
     * @return void
     */
    public function index()
    {
        $pages = $this->gallery->getPages($_SESSION["username"]);
        $result = $this->gallery->index($_SESSION["username"]);
        Blade::render("/galleries", compact("result","pages"));
    }

    public function indexComments($id)
    {
        $result = $this->gallery->indexComments($id);
        $gallery = $this->gallery->show($id);
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
            $pages = $this->gallery->getPagesVisible($slug);
            $result = $this->gallery->indexHiddenOrNsfw($slug);
        } else {
            $result = $this->gallery->index($slug);
            $pages = $this->gallery->getPages($slug);
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
            $this->gallery->create($galleryData);
            header("Location: /profile/galleries?page=1");
        }
    }

    public function createComment()
    {
        $commentData = [
            "galleryId" =>$_POST["galleryId"],
            "userId" => $_SESSION["id"],
            "comment" => $_POST["comment"]
        ];
        $this->gallery->createComment($commentData);
            header("Location: /comments/galleries/{$_POST["galleryId"]}");
    }

    /**
     * Update gallery of logger user and other users
     * @return void
     */
    public function update($id)
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {
            $result = $this->gallery->show( $id);
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
                $this->gallery->createLogg($galleryData);
            }
            $this->gallery->update($galleryData);
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
            $result = $this->gallery->show($id);
            Blade::render("/deleteGallery", compact("result"));
        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
            $this->gallery->delete($_POST["galleryId"]);
            if ($_POST["userId"] === $_SESSION["id"]) {
                header("Location: /profile/galleries?page=1");
            } else {
                header("Location: /profile/users/" . $_POST["userUsername"] . "?page=1");
            }
        }
    }
}
