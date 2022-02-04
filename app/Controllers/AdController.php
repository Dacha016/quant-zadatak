<?php

namespace App\Controllers;

use App\Models\Ad;
use App\Blade\Blade;

class AdController extends Controller
{

    public function __construct()
    {
        parent::__construct(new Ad());
    }

    public function index()
    {
        $result = $this->model->index($username = null);

        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {

            if (isset($result["data"]["error"])) {

                $error = $result["data"]["error"];

                Blade::render("/ads", compact("error"));
            } else {

                $result = $result["data"]["ads"];

                Blade::render("/ads", compact("result"));
            }
        } elseif (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
            

        }

    }
}