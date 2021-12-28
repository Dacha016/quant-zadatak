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
     * @return mixed
     */
    public function index()
    {
        $this->conn->queryPrepare("select file_name from image where hidden = 0 and nsfw = 0 limit 50") ;
        $this->conn->execute();
        return $this->conn->multy();
    }

    /**
     * Send pictures of user to profile
     * @param $id $id of logged user
     * @return mixed
     */
    public function indexProfile($id)
    {
        $this->conn->queryPrepare("select * from image inner join user u on image.user_id = u.id where image.user_id = :id limit 50");
        $this->conn->bindParam(":id",$id);
        $this->conn->execute();
        return $this->conn->multy();
    }

    /**
     * Change values of image
     * @param $hidden $hidden value
     * @param $nsfw $nsfw value
     * @param $slug $slug image slug
     * @return mixed
     */
    public function updatePicture($hidden, $nsfw, $slug )
    {
        $this->conn->queryPrepare("UPDATE image SET hidden =:hidden, nsfw = :nsfw WHERE slug = :slug");
        $this->conn->bindParam(":hidden", $hidden);
        $this->conn->bindParam(":nsfw", $nsfw);
        $this->conn->bindParam(":slug", $slug);
        return $this->conn->execute();
    }

    /**
     * Delete picture
     * @param $slug $slug Image slug
     * @return void
     */
    public function deleteImage($slug)
    {
        $this->conn->queryPrepare("DELETE FROM image WHERE slug =:slug");
        $this->conn->bindParam(":slug", $slug);
        $this->conn->execute();
    }
}