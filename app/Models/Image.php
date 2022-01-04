<?php

namespace App\Models;

use App\Config\Connection;

class Image
{
    protected Connection $conn;

    public function __construct()
    {
        $this->conn= new Connection;
    }

    /**
     * Send pictures to home page
     * @return array
     */
    public function indexHome() :array
    {
        $this->conn->queryPrepare("select file_name from image where hidden = 0 and nsfw = 0 limit 50") ;
        $this->conn->execute();
        return $this->conn->multi();
    }

    public function indexProfile()
    {
        $this->conn->queryPrepare("select file_name from image limit 50") ;
        $this->conn->execute();
        return $this->conn->multi();
    }

    /**
     * Send pictures of user to profile
     * @param $id $id of logged user
     * @return array
     */
    public function indexGallery($id):array
    {
        $this->conn->queryPrepare(
            "select i.id as 'imageId', i.file_name as 'file_name', i.slug as 'slug', i.hidden as 'hidden', i.nsfw as 'nsfw', i.user_id as 'userId', g.id as 'galleryId'  from image_gallery
                inner join image i on image_gallery.image_id = i.id     
                inner join gallery g on image_gallery.gallery_id = g.id
                where image_gallery.gallery_id =:id");
        $this->conn->bindParam(":id",$id);
        $this->conn->execute();
        return $this->conn->multi();
    }
    public function show ($id)
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

    /**
     * @param $imageData
     */
    public function delete($id)
    {
        $this->conn->queryPrepare("DELETE FROM image WHERE id =:id");
        $this->conn->bindParam(":id",$id);
        var_dump($this->conn->execute());
        die();

    }

    /**
     * @param $imageData
     * @return bool
     */
    public function createLogg($imageData):bool
    {

        $this->conn->queryPrepare(
            "insert into moderator_logging (moderator_username, user_username,gallery_id, image_name, image_nsfw, image_hidden)
            values (:moderator_username, :user_username, :image_name, :gallery_id, :image_nsfw, :image_hidden)");
        $this->conn->bindParam(":moderator_username", $imageData["sessionUsername"]);
        $this->conn->bindParam(":user_username", $imageData["userUsername"]);
        $this->conn->bindParam(":image_name", $imageData["imageName"]);
        $this->conn->bindParam(":gallery_id", $imageData["galleryId"]);
        $this->conn->bindParam(":image_nsfw", $imageData["nsfw"]);
        $this->conn->bindParam(":image_hidden", $imageData["hidden"]);
        return $this->conn->execute();

    }
}