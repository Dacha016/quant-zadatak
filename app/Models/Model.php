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

    protected abstract function index($username);
    protected abstract function show($id);
}