<?php

namespace App\Models;

use Predis\Client;

class Image extends Model
{

    private int $user_id;
    private string $file_name;
    private string $slug;
    private int $nsfw = 0;
    private int $hidden = 0;

    public function __construct()
    {
        parent::__construct();
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getFileName(): string
    {
        return $this->file_name;
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
     * Pictures on home page which are not hidden or nsfw
     * @return array
     */
    public function indexHomePage(): array
    {

        $redis = new Client();
        $key = "home_image";

        if (!$redis->exists($key)) {

            $this->conn->queryPrepare("select file_name, id as 'imageId' from image where hidden = 0 and nsfw = 0 limit 150");
            $this->conn->execute();

            $images = [];

            while ($row = $this->conn->single()) {
                $images[] = $row;
            }

            $redis->set($key, serialize($images));
            $redis->expire($key, 300);

            if (isset($images)) {

                $response["data"] = [
                    "images" => $images,
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
                "images" => unserialize($redis->get($key)),
                "status_code" => 'HTTP/1.1 200 Success'
            ];

        }
        return $response;
    }

    /**
     * Pictures of logged user on profile page
     * @param $id
     * @return array
     */
    public function indexProfilePage($id): array
    {

        $redis = new Client();
        $key = "user_{$id}_profile_image";

        if (!$redis->exists($key)) {

            $this->conn->queryPrepare(
                "select file_name, id as 'imageId' from image where user_id =:id limit 150");
            $this->conn->bindParam(":id", $id);
            $this->conn->execute();

            $images = [];

            while ($row = $this->conn->single()) {
                $images[] = $row;
            }

            $redis->set($key, serialize($images));
            $redis->expire($key, 300);

            if (isset($images)) {

                $response["data"] = [
                    "images" => $images,
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
                "images" => unserialize($redis->get($key)),
                "status_code" => 'HTTP/1.1 200 Success'
            ];

        }
        return $response;
    }

    /**
     * Image comments
     * @param $id
     * @return array
     */
    public function imageComments($id): array
    {
        $redis = new Client();
        $key = "image_{$id}_comments";

        if (!$redis->exists($key)) {

            $this->conn->queryPrepare(
                "select  i.file_name as 'file_name', u.username as 'username', comment from comment
                inner join image i on comment.image_id = i.id
                inner join user u on comment.user_id = u.id
                where image_id =:id");
            $this->conn->bindParam(":id", $id);
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

            }

            if (!isset($comments[0]->comment)) {

                $response["data"] = [
                    "error" => "Be the first to comment",
                    "status_code" => 'HTTP/1.1 404 Not Found'
                ];

                return $response;

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
     * Logged user pictures in galleries
     * @param $username $id of logged user
     * @return array
     */
    public function index($username): array
    {
        $redis = new Client();
        $key = "image_of_gallery_$username";

        if (!$redis->exists($key)) {

            $this->conn->queryPrepare(
                "select i.id as 'imageId', i.file_name as 'file_name', i.slug as 'slug', i.hidden as 'hidden', i.nsfw as 'nsfw', i.user_id as 'userId', u.username as 'username',  g.id as 'galleryId'  from image_gallery
                    inner join image i on image_gallery.image_id = i.id     
                    inner join gallery g on image_gallery.gallery_id = g.id
                    inner join user u on i.user_id = u.id
                    where image_gallery.gallery_id =:id");
            $this->conn->bindParam(":id", $username);
            $this->conn->execute();

            $images = [];

            while ($row = $this->conn->single()) {
                $images[] = $row;
            }

            $redis->set($key, serialize($images));
            $redis->expire($key, 300);

            if (isset($images)) {

                $response["data"] = [
                    "images" => $images,
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
                "images" => unserialize($redis->get($key)),
                "status_code" => 'HTTP/1.1 200 Success'
            ];

        }

        return $response;
    }

    /**
     * Show image in image table
     * @param $id
     * @return mixed
     */
    public function show($id): mixed
    {

        $this->conn->queryPrepare(
            "select image.id as 'imageId', image.file_name as 'file_name',image.hidden as 'hidden', image.nsfw as 'nsfw', u.username as 'username', u.id as 'userId' from image
            inner join user u on image.user_id = u.id
            where image.id =:id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();

        $result = $this->conn->single();

        if ($result) {
            $response["data"] = [
                "image" => $result,
                "status_code" => 'HTTP/1.1 200 Success'
            ];
        } else {

            $response["data"] = [
                "error" => "Image not found",
                "status_code" => 'HTTP/1.1 404 Not Found'
            ];
        }

        return $response;

    }

    /**
     * Show image in image_gallery table
     * @param $id
     * @return mixed
     */
    public function showInGallery($id)
    {

        $this->conn->queryPrepare(
            "select i.id as 'imageId', i.slug as 'slug', i.nsfw as 'nsfw', i.hidden as 'hidden', i.file_name as 'file_name', i.user_id as 'userId', u.username as 'username', g.id as 'galleryId' 
            from image_gallery 
            inner join image i on image_gallery.image_id = i.id
            inner join gallery g on image_gallery.gallery_id = g.id
            inner join user u on i.user_id = u.id
            where i.id =:id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();

        $result = $this->conn->single();

        if ($result) {
            $response["data"] = [
                "image" => $result,
                "status_code" => 'HTTP/1.1 200 Success'
            ];
        } else {

            $response["data"] = [
                "error" => "Image not found",
                "status_code" => 'HTTP/1.1 404 Not Found'
            ];
        }

        return $response;

    }

    /**
     * Insert image in image table
     * @param $imageData
     * @return void
     */
    public function createImage()
    {

        $slug = str_replace(" ", "-", $_POST["fileName"]);
        $slug = strtolower($slug);

        $imageData = [
            "userId" => $_SESSION["id"],
            "fileName" => $_POST["fileName"],
            "nsfw" => $this->getNsfw(),
            "hidden" => $this->getHidden(),
            "slug" => $slug
        ];

        if (empty($imageData["fileName"])) {

            $response["data"] = [
                "error" => "Empty fields are not allowed!",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

        } else {

            $redis = new Client();
            $redis->del("user_{$imageData['userId']}_profile_image");

            $this->conn->queryPrepare(
                "insert into image (user_id, file_name, slug, nsfw, hidden, added)
            values (:user_id, :file_name, :slug, :nsfw, :hidden, :added)");
            $this->conn->bindParam(":user_id", $imageData["userId"]);
            $this->conn->bindParam(":file_name", $imageData["fileName"]);
            $this->conn->bindParam(":slug", $imageData["slug"]);
            $this->conn->bindParam(":nsfw", $imageData["nsfw"]);
            $this->conn->bindParam(":hidden", $imageData["hidden"]);
            $this->conn->bindParam(":added", date("Y-m-d"));
            $this->conn->execute();


            if (isset($_POST["galleryId"])) {
                $imageId = $this->selectLastImageId($imageData["userId"]);

                $imageData = [
                    "imageId" => $imageId->id,
                    "galleryId" => $_POST["galleryId"]
                ];

                $this->insertImageInGallery($imageData);
            }
            $response["data"] = [

                "status_code" => 'HTTP/1.1 200 Success'
            ];

        }
        return $response;

    }

    /**
     * Insert image in image_gallery table
     * @param $imageData
     * @return void
     */
    public function insertImageInGallery($imageData): void
    {

        $redis = new Client();
        $redis->del("image_of_gallery_{$imageData['galleryId']}");

        $this->conn->queryPrepare(
            "insert into image_gallery (image_id, gallery_id)
            values (:image_id, :gallery_id)");
        $this->conn->bindParam(":image_id", $imageData["imageId"]);
        $this->conn->bindParam(":gallery_id", $imageData["galleryId"]);
        $this->conn->execute();

    }

    /**
     * Create comment
     * @return void
     */
    public function createImageComments()
    {

        $commentData = [
            "imageId" => $_POST["imageId"],
            "userId" => $_SESSION["id"],
            "comment" => $_POST["comment"]
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
        $redis->del("image_{$commentData['imageId']}_comments");

        $this->conn->queryPrepare("insert into comment (user_id, image_id, comment) values (:user_id, :image_id, :comment)");
        $this->conn->bindParam(":user_id", $commentData["userId"]);
        $this->conn->bindParam(":image_id", $commentData["imageId"]);
        $this->conn->bindParam(":comment", $commentData["comment"]);
        $this->conn->execute();

        $response["data"] = [
            "status_code" => 'HTTP/1.1 201 Created'
        ];

        return $response;

    }

    /**
     * Insert data in moderator_logging
     * @return void
     */
    public function createLogg($galleryId)
    {

        $hidden = isset($_POST['hidden']) ? '1' : '0';
        $nsfw = isset($_POST['nsfw']) ? '1' : '0';

        $imageData = [
            "hidden" => $hidden,
            "nsfw" => $nsfw,
            "imageName" => $_POST["imageName"],
            "userUsername" => $_POST["userUsername"],
            "sessionUsername" => $_SESSION["username"],
        ];

        $this->conn->queryPrepare(
            "insert into moderator_logging (moderator_username, user_username,gallery_id, image_name, image_nsfw, image_hidden)
            values (:moderator_username, :user_username,:gallery_id, :image_name,  :image_nsfw, :image_hidden)");
        $this->conn->bindParam(":moderator_username", $imageData["sessionUsername"]);
        $this->conn->bindParam(":user_username", $imageData["userUsername"]);
        $this->conn->bindParam(":image_name", $imageData["imageName"]);
        $this->conn->bindParam(":gallery_id", $galleryId);
        $this->conn->bindParam(":image_nsfw", $imageData["nsfw"]);
        $this->conn->bindParam(":image_hidden", $imageData["hidden"]);
        $this->conn->execute();

        $response["data"] = [
            "status_code" => 'HTTP/1.1 201 Created'
        ];

        return $response;

    }

    /**
     * Update image
     * @param $imageData
     * @return void
     */
    public function update(): void
    {

        $hidden = isset($_POST['hidden']) ? '1' : '0';
        $nsfw = isset($_POST['nsfw']) ? '1' : '0';

        $imageData = [
            "imageId" => $_POST["imageId"],
            "hidden" => $hidden,
            "nsfw" => $nsfw
        ];

        $this->conn->queryPrepare("UPDATE image SET hidden =:hidden, nsfw = :nsfw WHERE id = :id");
        $this->conn->bindParam(":hidden", $imageData["hidden"]);
        $this->conn->bindParam(":nsfw", $imageData["nsfw"]);
        $this->conn->bindParam(":id", $imageData["imageId"]);
        $this->conn->execute();

    }

    /**
     * @param $id
     * @return array
     */
    public function deleteImage($id)
    {

        $redis = new Client();
        $redis->del("image_of_gallery_{$_POST['galleryId']}");
        $redis->del("user_{$_SESSION['id']}_profile_image");

        $this->conn->queryPrepare("DELETE FROM image WHERE id =:id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();

        $response["data"] = [

            "status_code" => 'HTTP/1.1 200 Success'
        ];

        return $response;
    }

    /**
     * Select last image in image table
     * @param $id
     * @return mixed
     */
    public function selectLastImageId($id)
    {

        $this->conn->queryPrepare(
            "select id from image where user_id =:id order by id desc limit 1");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();

        return $this->conn->single();

    }

    /**
     * The number of pictures added by the user in the last month
     * @param $id
     * @param $start
     * @return mixed
     */
    public function imageCount($id, $start)
    {

        $this->conn->queryPrepare(
            "select count(*) as 'row' from image 
           
            where user_id= :id and added > date_sub(:start, interval 1 month )");
        $this->conn->bindParam(":id", $id);
        $this->conn->bindParam(":start", $start);
        $this->conn->execute();

        $result = $this->conn->single();

        return $result->row;

    }

    /**
     * Number of uploaded images in last month
     * @return mixed
     */
    public function lastMonthImages()
    {
        $userSubscription = new Subscription;
        $user = $userSubscription->index($_SESSION["username"]);

        $date = $user["data"]["subscriptions"][0]->start;

        return $this->imageCount($_SESSION["id"], $date);
    }
}