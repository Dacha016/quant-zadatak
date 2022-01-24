<?php

namespace App\Models;

use App\Config\Connection;

abstract class Model
{
    protected $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
        Connection::connect();
        if (! session_start()) {
           session_start();
        }
    }

    abstract public function index($username);
    abstract public function show($id);
}