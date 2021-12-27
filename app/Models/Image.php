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
    public function index()
    {
        $this->conn->queryPrepare("select file_name from image where hidden = 0 and nsfw = 0 limit 50") ;
        $this->conn->execute();
        return $this->conn->multy();
    }
    public function indexProfile($id)
    {
        $this->conn->queryPrepare("select * from image inner join user u on image.user_id = u.id where image.user_id = :id limit 50");
        $this->conn->bindParam(":id",$id);
        $this->conn->execute();
        return $this->conn->multy();
    }

}