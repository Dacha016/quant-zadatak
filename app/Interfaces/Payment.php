<?php

namespace App\Interfaces;

interface Payment
{
    public function isValid();

    public function pay();

}