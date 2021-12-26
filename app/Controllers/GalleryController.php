<?php

namespace App\Controllers;

use App\Models\Gallery;
//use Jenssegers\Blade\Blade;
use App\Blade\Blade;

class GalleryController
{
    protected Gallery $gallery;

    public function __constructor()
    {
        $this->gallery = new Gallery;
    }



    public function index()
    {
        Blade::render("pb");
    }
}
