<?php

namespace App\Models;

use App\Config\Connection;

class Gallery
{
    protected Connection $conn;

    public function __construct()
    {
        $this->conn = new Connection;
    }


    public function index()
    {
        $this->conn->queryPrepare("select name from gallery where hidden = 0 and nsfw = 0 limit 20");
        $this->conn->execute();
        return $this->conn->multy();

    }

    /**
     * List of users galleries
     * @param $id $id Users id
     * @return mixed
     */
    public function indexGalleries($id)
    {
        $this->conn->queryPrepare(
            "select gallery.id as 'galleryId', gallery.description, gallery.name, gallery.user_id from gallery  
            where gallery.user_id = :id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
        return $this->conn->multy();
    }

}