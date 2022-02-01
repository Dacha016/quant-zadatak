<?php

namespace App\Interfaces;

interface Card
{

    public function active($id);

    public function isValid();

    public function pay();

}