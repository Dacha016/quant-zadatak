<?php

namespace App\Models;

use Predis\Client;

class Image extends Model
{

    private int $user_id;
    private string $file_name;
    private string $slug;
    private  int $nsfw = 0;
    private int $hidden = 0;

    public function __construct()
    {
        parent::__construct();
    }

    public function getUserId():int
    {
        return $this->user_id;
    }

    public function getFileName(): string
    {
        return $this->file_name;
    }

    public function getSlug():string
    {
        return $this->slug;
    }

    public function getNsfw():int
    {
        return $this->nsfw;
    }

    public function getHidden():int
    {
        return $this->hidden;
    }

    /**
     * Pictures on home page which are not hidden or nsfw
     * @return array
     */
    protected function indexHomePage() :array
    {
        $redis = new Client();
        $key = "home_image";
        $this->conn->queryPrepare("select file_name, id as 'imageId' from image where hidden = 0 and nsfw = 0 limit 150") ;
        $this->conn->execute();

        if (!$redis->exists($key)) {
            $images = [];
            while ($row = $this->conn->single()) {
                $images[] = $row;
            }
            $redis->set($key, serialize($images));
            $redis->expire($key, 300);
        }
        return unserialize($redis->get($key));
    }

    /**
     * Pictures of logged user on profile page
     * @param $id
     * @return array
     */
    protected function indexProfilePage($id):array
    {
        $redis = new Client();
        $key = "user_{$id}_profile_image";
        $this->conn->queryPrepare(
            "select file_name, id as 'imageId' from image where user_id =:id limit 150");
        $this->conn->bindParam(":id",$id);
        $this->conn->execute();

        if (!$redis->exists($key)) {
            $images = [];
            while ($row = $this->conn->single()) {
                $images[] = $row;
            }
            $redis->set($key, serialize($images));
            $redis->expire($key, 300);
            return $images;
        } else {
            return unserialize($redis->get($key));
        }
    }

    /**
     * Image comments
     * @param $id
     * @return array
     */
    protected function imageComments($id):array
    {
        $redis = new Client();
        $key = "image_{$id}_comments";
        $this->conn->queryPrepare(
            "select  i.file_name as 'file_name', u.username as 'username', comment from comment
            inner join image i on comment.image_id = i.id
            inner join user u on comment.user_id = u.id
            where image_id =:id");
        $this->conn->bindParam(":id",$id);
        $this->conn->execute();

        if (!$redis->exists($key)) {
            $comments = [];
            while ($row = $this->conn->single()) {
                $comments[] = $row;
            }
            $redis->set($key, serialize($comments));
            $redis->expire($key, 300);
            return  $comments;
        }else {
            return unserialize($redis->get($key));
        }
    }

    /**
     * Logged user pictures in galleries
     * @param $username $id of logged user
     * @return array
     */
    public function index($username):array
    {
        $redis = new Client();
        $key = "image_of_gallery_$username";
        $this->conn->queryPrepare(
            "select i.id as 'imageId', i.file_name as 'file_name', i.slug as 'slug', i.hidden as 'hidden', i.nsfw as 'nsfw', i.user_id as 'userId', u.username as 'username',  g.id as 'galleryId'  from image_gallery
                inner join image i on image_gallery.image_id = i.id     
                inner join gallery g on image_gallery.gallery_id = g.id
                inner join user u on i.user_id = u.id
                where image_gallery.gallery_id =:id");
        $this->conn->bindParam(":id",$username);
        $this->conn->execute();

        if (!$redis->exists($key)) {
            $images = [];
            while ($row = $this->conn->single()) {
                $images[] = $row;
            }
            $redis->set($key, serialize($images));
            $redis->expire($key, 300);
            return $images;
        }else {
            return unserialize($redis->get($key));
        }
    }

    /**
     * Show image in image table
     * @param $id
     * @return mixed
     */
    public function show($id):mixed
    {
        $this->conn->queryPrepare(
            "select image.id as 'imageId', image.file_name as 'file_name',image.hidden as 'hidden', image.nsfw as 'nsfw', u.username as 'username', u.id as 'userId' from image
            inner join user u on image.user_id = u.id
            where image.id =:id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
        return $this->conn->single();
    }

    /**
     * Show image in image_gallery table
     * @param $id
     * @return mixed
     */
    protected function showInGallery ($id)
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
        return $this->conn->single();
    }

    /**
     * Insert image in image table
     * @param $imageData
     * @return void
     */
    protected function createImage($imageData):void
    {
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
    }

    /**
     * Insert image in image_gallery table
     * @param $imageData
     * @return void
     */
    protected function insertImageInGallery($imageData):void
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
     * @param $commentData
     * @return void
     */
    protected function createImageComments($commentData):void
    {
        $redis = new Client();
        $redis->del("image_{$commentData['imageId']}_comments");
        $this->conn->queryPrepare("insert into comment (user_id, image_id, comment) values (:user_id, :image_id, :comment)");
        $this->conn->bindParam(":user_id", $commentData["userId"]);
        $this->conn->bindParam(":image_id", $commentData["imageId"]);
        $this->conn->bindParam(":comment", $commentData["comment"]);
        $this->conn->execute();
    }

    /**
     * Insert data in moderator_logging
     * @param $imageData
     * @return void
     */
    protected function createLogg($imageData):void
    {
        $this->conn->queryPrepare(
            "insert into moderator_logging (moderator_username, user_username,gallery_id, image_name, image_nsfw, image_hidden)
            values (:moderator_username, :user_username,:gallery_id, :image_name,  :image_nsfw, :image_hidden)");
        $this->conn->bindParam(":moderator_username", $imageData["sessionUsername"]);
        $this->conn->bindParam(":user_username", $imageData["userUsername"]);
        $this->conn->bindParam(":image_name", $imageData["imageName"]);
        $this->conn->bindParam(":gallery_id", $imageData["galleryId"]);
        $this->conn->bindParam(":image_nsfw", $imageData["nsfw"]);
        $this->conn->bindParam(":image_hidden", $imageData["hidden"]);
        $this->conn->execute();
    }

    /**
     * Update image
     * @param $imageData
     * @return void
     */
    protected function updateImage($imageData):void
    {
        $this->conn->queryPrepare("UPDATE image SET hidden =:hidden, nsfw = :nsfw WHERE id = :id");
        $this->conn->bindParam(":hidden", $imageData["hidden"]);
        $this->conn->bindParam(":nsfw", $imageData["nsfw"]);
        $this->conn->bindParam(":id", $imageData["imageId"]);
        $this->conn->execute();
    }

    /**
     * Delete image
     * @param $id
     * @return void
     */
    protected function deleteImage($id):void
    {
        $redis = new Client();
        $redis->del( "image_of_gallery_{$_POST['galleryId']}");
        $redis->del( "user_{$_SESSION['id']}_profile_image");
        $this->conn->queryPrepare("DELETE FROM image WHERE id =:id");
        $this->conn->bindParam(":id",$id);
        $this->conn->execute();
    }

    /**
     * Select last image in image table
     * @param $id
     * @return mixed
     */
    protected function selectLastImageId($id)
    {
        $this->conn->queryPrepare(
            "select id from image where user_id =:id order by id desc limit 1");
        $this->conn->bindParam(":id",$id);
        $this->conn->execute();
        return $this->conn->single();
    }

    /**
     * The number of pictures added by the user in the last month
     * @param $id
     * @param $start
     * @return mixed
     */
    protected function imageCount($id, $start)
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
}