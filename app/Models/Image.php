<?php

namespace App\Models;

use Predis\Client;

class Image extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Send pictures to home page
     * @return array
     */
    public function indexHome() :array
    {
        $redis = new Client();
        $key = "home_image";
        $this->conn->queryPrepare("select file_name from image where hidden = 0 and nsfw = 0 limit 50") ;
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

    public function indexProfile($id)
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
        }
        return unserialize($redis->get($key));
    }

    public function indexComments($id)
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
        }
        return unserialize($redis->get($key));
    }
    /**
     * Galleries image
     * @param $id $id of logged user
     * @return array
     */
    public function index($id):array
    {
        $redis = new Client();
        $key = "image_of_gallery_$id";
        $this->conn->queryPrepare(
            "select i.id as 'imageId', i.file_name as 'file_name', i.slug as 'slug', i.hidden as 'hidden', i.nsfw as 'nsfw', i.user_id as 'userId', g.id as 'galleryId'  from image_gallery
                inner join image i on image_gallery.image_id = i.id     
                inner join gallery g on image_gallery.gallery_id = g.id
                where image_gallery.gallery_id =:id");
        $this->conn->bindParam(":id",$id);
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
     * @param $id
     * @return mixed
     */
    public function showImageInGallery ($id):mixed
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
     * @param $imageData
     * @return bool
     */
    public function update($imageData):bool
    {
        $this->conn->queryPrepare("UPDATE image SET hidden =:hidden, nsfw = :nsfw WHERE id = :id");
        $this->conn->bindParam(":hidden", $imageData["hidden"]);
        $this->conn->bindParam(":nsfw", $imageData["nsfw"]);
        $this->conn->bindParam(":id", $imageData["imageId"]);
        return $this->conn->execute();
    }

    public function createComments($commentData)
    {
        $redis = new Client();
        $redis->del("image_{$commentData['imageId']}_comments");
        $this->conn->queryPrepare("insert into comment (user_id, image_id, comment) values (:user_id, :image_id, :comment)");
        $this->conn->bindParam(":user_id", $commentData["userId"]);
        $this->conn->bindParam(":image_id", $commentData["imageId"]);
        $this->conn->bindParam(":comment", $commentData["comment"]);
         return $this->conn->execute();
    }
    /**
     * @param $id
     */
    public function delete($id)
    {
        $this->conn->queryPrepare("DELETE FROM image WHERE id =:id");
        $this->conn->bindParam(":id",$id);
        $this->conn->execute();
    }

    /**
     * @param $imageData
     * @return bool
     */
    public function createLogg($imageData):bool
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
        return $this->conn->execute();
    }
}