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
        $this->conn->queryPrepare("select file_name from image where hidden = 0 and nsfw = 0 limit 20") ;
        $this->conn->execute();
        return $this->conn->multy();
    }
    public function indexProfile()
    {
        $this->conn->queryPrepare("select file_name from image where hidden = 0 and nsfw = 0 limit 20") ;
        $this->conn->execute();
        return $this->conn->multy();
    }
}