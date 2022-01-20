<?php

namespace App\Models;

interface Subscription
{
    public function indexSubscription($username);
    public function showSubscription($username);
    public function createSubscription($data);
}