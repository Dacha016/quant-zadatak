<?php

namespace App\Controllers;

use App\Models\Gallery;
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

  $result =$this->gallery->index();
  foreach ($result as $row) {
      var_dump($row);
  }

//        Blade::render("pb", );
    }
}
