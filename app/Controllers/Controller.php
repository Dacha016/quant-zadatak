<?php

namespace App\Controllers;

class Controller
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }
}
