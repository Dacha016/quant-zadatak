<?php

namespace App\Models;

use App\Config\Connection;

class Gallery
{
    protected Connection $conn;

    public function __construct()
    {
        $this->conn= new Connection;
    }

    public function index()
    {
        $this->conn->queryPrepare("select name from gallery where hidden = 0 and nsfw = 0 limit 20") ;
        $this->conn->execute();
        return $this->conn->multy();

    }
    public function indexProfile($id)
    {
        $this->conn->queryPrepare("select * from gallery inner join user u on gallery.user_id = u.id where gallery.user_id = :id limit 50");
        $this->conn->bindParam(":id",$id);
        $this->conn->execute();
        return $this->conn->multy();
    }

}