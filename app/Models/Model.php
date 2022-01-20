<?php

namespace App\Models;

use App\Config\Connection;

abstract class Model
{
    protected $conn;

    public function __construct()
    {
        Connection::connect($_ENV["DATABASE_HOST"], $_ENV["DATABASE"], $_ENV["USERNAME"], $_ENV["PASSWORD"]);
        $this->conn = Connection::getInstance();
        session_start();
    }

    abstract public function index($username);
    abstract public function show($id);
}