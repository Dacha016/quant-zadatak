<?php

namespace App\Models;

use App\Config\Connection;

abstract class Model
{
    protected Connection $conn;

    public function __construct()
    {
        $this->conn = new Connection;
    }
    public abstract function index($id);
    public abstract function show($id);
}