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
        var_dump( $this->conn->multy());
    }

}