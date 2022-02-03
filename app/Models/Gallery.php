<?php

namespace App\Models;

use Predis\Client;

class Gallery extends Model
{
    private int $user_id;
    private string $name;
    private string $description;
    private string $slug;
    private int $nsfw;
    private int $hidden;

    public function __construct()
    {
        parent::__construct();
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getSlug(): string
    {
        return $this->slug;
    }

    public function getNsfw(): int
    {
        return $this->nsfw;
    }

    public function getHidden(): int
    {
        return $this->hidden;
    }

    /**
     * Get hidden and nsfw galleries of not logged user
     * @param $slug $id of current user
     * @return array
     */
    public function indexHiddenOrNsfw($slug): array
    {

        $redis = new Client();
        $key = "hidden_galleries_of_user_{$slug}_page_{$_GET['page']}";

        if (!$redis->exists($key)) {

            $limit = 50;
            $page = $_GET["page"] - 1;
            $offset = abs($page * $limit);

            $this->conn->queryPrepare(
                "select gallery.id as 'galleryId',description, name, user_id as 'userId', slug, gallery.nsfw as 'nsfw', hidden, u.username as 'username' 
                from gallery
                inner join user u on gallery.user_id = u.id
                where u.username =:slug and gallery.hidden = 0 and gallery.nsfw = 0 limit $limit offset $offset");
            $this->conn->bindParam(":slug", $slug);
            $this->conn->execute();

            $galleries = [];

            while ($row = $this->conn->single()) {
                $galleries[] = $row;
            }

            $redis->set($key, serialize($galleries));
            $redis->expire($key, 300);

            if (isset($galleries)) {

                $response["data"] = [
                    "galleries" => $galleries,
                    "status_code" => 'HTTP/1.1 200 Success'
                ];

            } else {

                $response["data"] = [
                    "error" => "Content not found, something is wrong",
                    "status_code" => 'HTTP/1.1 404 Not Found'
                ];
            }

        } else {
            $response["data"] = [
                "galleries" => unserialize($redis->get($key)),
                "status_code" => 'HTTP/1.1 200 Success'
            ];
        }

        return $response;
    }

    /**
     * Show all comments of gallery
     * @param $id
     * @return array
     */
    public function indexComments($slug): array
    {

        $redis = new Client();
        $key = "gallery_{$slug}_comments";

        if (!$redis->exists($key)) {

            $this->conn->queryPrepare(
                "select  g.name as 'galleryName', u.username as 'username', comment from comment
                inner join gallery g on comment.gallery_id = g.id
                inner join user u on comment.user_id = u.id
                where g.slug =:slug");
            $this->conn->bindParam(":slug", $slug);
            $this->conn->execute();

            $comments = [];

            while ($row = $this->conn->single()) {
                $comments[] = $row;
            }

            $redis->set($key, serialize($comments));
            $redis->expire($key, 300);

            if (isset($comments)) {

                $response["data"] = [
                    "comments" => $comments,
                    "status_code" => 'HTTP/1.1 200 Success'
                ];

            } else {

                $response["data"] = [
                    "error" => "Content not found, something is wrong",
                    "status_code" => 'HTTP/1.1 404 Not Found'
                ];

            }
        } else {

            $response["data"] = [
                "comments" => unserialize($redis->get($key)),
                "status_code" => 'HTTP/1.1 200 Success'
            ];
        }

        return $response;
    }

    /**
     * List of  galleries
     * @param $id $id Users id
     * @return mixed
     */
    public function index($username): array
    {
        $redis = new Client();
        $key = "galleries_of_user_{$username}_page_{$_GET['page']}";

        if (!$redis->exists($key)) {

            $limit = 50;
            $page = $_GET["page"] - 1;
            $offset = abs($page * $limit);

            $this->conn->queryPrepare(
                "SELECT  gallery.id as 'galleryId', description, name, user_id as 'userId', slug, gallery.nsfw as 'nsfw', hidden,  u.username as 'username' 
                FROM gallery 
                inner join user u on gallery.user_id = u.id
                WHERE u.username =:username limit $limit offset $offset");
            $this->conn->bindParam(":username", $username);
            $this->conn->execute();

            $galleries = [];

            while ($row = $this->conn->single()) {
                $galleries[] = $row;
            }

            $redis->set($key, serialize($galleries));
            $redis->expire($key, 300);

            if (isset($galleries)) {

                $response["data"] = [
                    "galleries" => $galleries,
                    "status_code" => 'HTTP/1.1 200 Success'
                ];

            } else {

                $response["data"] = [
                    "error" => "Content not found, something is wrong",
                    "status_code" => 'HTTP/1.1 404 Not Found'
                ];
            }

        } else {
            $response["data"] = [
                "galleries" => unserialize($redis->get($key)),
                "status_code" => 'HTTP/1.1 200 Success'
            ];
        }

        return $response;
    }

    /**
     * Show all images in gallery
     * @param $id
     * @return array
     */
    public function show($slug): array
    {

        $this->conn->queryPrepare(
            "SELECT gallery.id as 'galleryId',description, name, user_id as 'userId', slug, gallery.nsfw as 'nsfw', hidden, u.username as 'userUsername' 
            FROM gallery
            inner join user u on gallery.user_id = u.id
            WHERE gallery.slug =:slug");
        $this->conn->bindParam(":slug", $slug);
        $this->conn->execute();
        $result = $this->conn->single();

        if (!$result) {

            $response["data"] = [
                "status_code" => 'HTTP/1.1 404 Not found'
            ];
        } else {

            $response["data"] = [
                "gallery" => $result,
                "status_code" => 'HTTP/1.1 200 Success'
            ];
        }

        return $response;


    }

    /**
     * Create gallery
     * @return void
     */
    public function createGallery()
    {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $name = trim($_POST["name"]);
        $hidden = isset($_POST['hidden']) ? '1' : '0';
        $nsfw = isset($_POST['nsfw']) ? '1' : '0';
        $slug = str_replace(" ", "-", $name);
        $slug = strtolower($slug);

        $galleryData = [
            "userId" => $_SESSION["id"],
            "name" => trim($_POST["name"]),
            "slug" => $slug,
            "description" => trim($_POST["description"]),
            "hidden" => $hidden,
            "nsfw" => $nsfw
        ];
//        var_dump($galleryData);
//        die();


        if (empty($galleryData["name"]) || empty($galleryData["description"])) {

            $response["data"] = [
                "error" => "An empty field is not allowed!",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;
        }

        if (!preg_match("/^[a-zA-Z0-9-\\s]*$/", $galleryData["name"])) {

            $response["data"] = [
                "error" => "The gallery name may contain only letters and numbers",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;

        }

        if (!preg_match("/^[a-zA-Z0-9-\\s,.]*$/", $galleryData["description"])) {

            $response["data"] = [
                "error" => "The gallery description may contain only letters and numbers",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;

        }


        $this->conn->queryPrepare(
            "insert into gallery (user_id, name, nsfw, hidden, description, slug)
            values (:user_id, :name, :nsfw, :hidden, :description, :slug)");
        $this->conn->bindParam(":user_id", $galleryData["userId"]);
        $this->conn->bindParam(":name", $galleryData["name"]);
        $this->conn->bindParam("nsfw", $galleryData["nsfw"]);
        $this->conn->bindParam(":hidden", $galleryData["hidden"]);
        $this->conn->bindParam(":description", $galleryData["description"]);
        $this->conn->bindParam(":slug", $galleryData["slug"]);
        $this->conn->execute();

        $response["data"] = [
            "status_code" => 'HTTP/1.1 200 Success'
        ];

        $redis = new Client();

        if ($redis->keys("*galleries*")) {
            $redis->del($redis->keys("*galleries*"));
        }

        return $response;

    }

    /**
     * Insert data in moderator_logging
     * @param $galleryData
     * @return void
     */
    public function createLogg($galleryData)
    {

        $this->conn->queryPrepare(
            "insert into moderator_logging (moderator_username, user_username,gallery_id, gallery_nsfw, gallery_hidden)
            values (:moderator_username, :user_username, :gallery_id, :gallery_nsfw, :gallery_hidden)");
        $this->conn->bindParam(":moderator_username", $galleryData["sessionName"]);
        $this->conn->bindParam(":user_username", $galleryData["userUsername"]);
        $this->conn->bindParam(":gallery_id", $galleryData["galleryId"]);
        $this->conn->bindParam(":gallery_nsfw", $galleryData["nsfw"]);
        $this->conn->bindParam(":gallery_hidden", $galleryData["hidden"]);
        $this->conn->execute();


        $response["data"] = [
            "status_code" => 'HTTP/1.1 200 Success'
        ];

        return $response;

    }

    /**
     * Create comment for gallery
     * @param $commentData
     * @return mixed
     */
    public function createGalleryComment()
    {

        $commentData = [
            "slug" => $_POST["slug"],
            "galleryId" => $_POST["galleryId"],
            "userId" => $_SESSION["id"],
            "comment" => trim($_POST["comment"])
        ];

        if (empty($commentData["comment"])) {

            $response["data"] = [
                "error" => "An empty field is not allowed!",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;
        }

        if (!preg_match("/^[a-zA-Z0-9-\\s]*$/", $commentData["comment"])) {

            $response["data"] = [
                "error" => "The comment may contain only letters and numbers",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;

        }

        $redis = new Client();
        $redis->del("gallery_{$commentData['slug']}_comments");


        $this->conn->queryPrepare("insert into comment (user_id, gallery_id, comment) values (:user_id, :gallery_id, :comment)");
        $this->conn->bindParam(":user_id", $commentData["userId"]);
        $this->conn->bindParam(":gallery_id", $commentData["galleryId"]);
        $this->conn->bindParam(":comment", $commentData["comment"]);
        $this->conn->execute();

        $response["data"] = [
            "status_code" => 'HTTP/1.1 201 Created'
        ];

        return $response;
    }

    /**
     * Update gallery data
     * @return
     */
    public function update($slug)
    {

        $hidden = isset($_POST['hidden']) ? '1' : '0';
        $nsfw = isset($_POST['nsfw']) ? '1' : '0';

        $galleryData = [
            "userId" => $_POST["userId"],
            "galleryId" => $_POST["galleryId"],
            "name" => trim($_POST["name"]),
            "slug" => trim($slug),
            "description" => trim($_POST["description"]),
            "hidden" => $hidden,
            "nsfw" => $nsfw,
            "userUsername" => $_POST["userUsername"],
            "sessionName" => $_SESSION["username"]
        ];

        $redis = new Client();
        $redis->del("galleries_of_user_{$galleryData['userUsername']}_page_{$_POST["page"]}");
        $redis->del("hidden_galleries_of_user_{$galleryData['userUsername']}_page_{$_POST["page"]}");

        $this->conn->queryPrepare(
            "update gallery 
            set name =:name, description =:description, hidden =:hidden, nsfw =:nsfw
            where slug =:slug");
        $this->conn->bindParam(":name", $galleryData["name"]);
        $this->conn->bindParam(":slug", $galleryData["slug"]);
        $this->conn->bindParam(":description", $galleryData["description"]);
        $this->conn->bindParam(":hidden", $galleryData["hidden"]);
        $this->conn->bindParam(":nsfw", $galleryData["nsfw"]);
        $this->conn->execute();

        if ($_POST["userId"] !== $_SESSION["id"] && $_SESSION["role"] === "moderator") {

            $this->createLogg($galleryData);
        }

        $response["data"] = [
            "status_code" => 'HTTP/1.1 200 Success'
        ];

        return $response;

    }

    /**
     * Delete gallery
     * @param $id
     * @return void
     */
    public function deleteGallery($slug)
    {

        $redis = new Client();
        $redis->del("galleries_of_user_{$_POST['userUsername']}_page_{$_POST['page']}");

        $this->conn->queryPrepare("DELETE FROM gallery WHERE slug =:slug");
        $this->conn->bindParam(":slug", $slug);
        $this->conn->execute();

        $response["data"] = [
            "status_code" => 'HTTP/1.1 200 Success'
        ];

        return $response;

    }

    /**
     * Pages for pagination
     * @param $slug
     * @return float
     */
    public function getPages($username): float
    {
        $limit = 50;

        $this->conn->queryPrepare(
            "select count(*) as 'row' from gallery 
            inner join user u on gallery.user_id = u.id
            where u.username = :username");
        $this->conn->bindParam(":username", $username);
        $this->conn->execute();

        $result = $this->conn->single();
        $rows = $result->row;

        return ceil($rows / $limit);

    }

    /**
     * Pages for pagination without hidden or nsfw galleries
     * @param $slug
     * @return float
     */
    public function getPagesVisible($username): float
    {

        $limit = 50;

        $this->conn->queryPrepare(
            "select count(*) as 'row' from gallery 
            inner join user u on gallery.user_id = u.id
            where u.username = :username and gallery.hidden = 0 and gallery.nsfw =0");
        $this->conn->bindParam(":username", $username);
        $this->conn->execute();

        $result = $this->conn->single();
        $rows = $result->row;

        return ceil($rows / $limit);
    }
}