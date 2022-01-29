<?php

namespace App\Models;

use App\Config\Connection;

if (! session_start()) {
    session_start();
}
abstract class Model
{
    protected $conn;

    public function __construct()
    {
        $this->conn = Connection::getInstance();
        Connection::connect();
    }

    abstract public function index($username);
    abstract public function show($id);
    abstract public function active($id);
}