<?php

namespace App\Controllers;

use App\Blade\Blade;
use App\Models\Image;

class ProfileController
{
    protected Image $image;

    public function __construct()
    {
        $this->image = new Image;
    }

    public function index()
    {
        $result =$this->image->indexProfile();

        Blade::render("/profile", compact("result"));
    }
}