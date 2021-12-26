<?php

namespace App\Controllers;

use App\Blade\Blade;
use App\Models\Image;

class HomeController
{
    protected Image $image;

    public function __construct()
    {
        $this->image = new Image;
    }

    public function index()
    {
        $result =$this->image->index();

        Blade::render("/home", compact("result"));
    }
}