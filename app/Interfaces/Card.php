<?php

namespace App\Interfaces;

interface Card
{
    public function update($id);

    public function isValid();

    public function pay();
}