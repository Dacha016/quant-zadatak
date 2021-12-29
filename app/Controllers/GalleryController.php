<?php

namespace App\Controllers;

use App\Models\Gallery;
use App\Blade\Blade;


class GalleryController
{
    protected Gallery $gallery;

    public function __construct()
    {
        $this->gallery = new Gallery;
    }
}

