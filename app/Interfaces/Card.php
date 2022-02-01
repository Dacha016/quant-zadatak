<?php

namespace App\Interfaces;

interface Card
{

    public function deactivate($id);

    public function isValid();

    public function pay();

}