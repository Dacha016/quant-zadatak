<?php

use  \App\Models\Subscription;
use  \App\Models\User;

if (isset($_SESSION["id"])) {
    $subscribe = new Subscription;
    $userSubscribe = $subscribe->show($_SESSION["username"]);
    $now = new \DateTime();
    $ends = new \DateTime($userSubscribe->end);
    $interval = $now->diff($ends);
    $_SESSION["plans end"] = $interval->format('%r%a days');
    $days = $interval->format('%r%a');

    $user = new User;
    $user= $user->show($_SESSION["username"]);
    $payment =$user->payment;
    $userData = [
        "username" => $_SESSION["username"],
        "id" => $_SESSION["id"],
        "subscription" => $userSubscribe->plan
    ];

    if ($days == 0 && $payment == 1) {
        $subscribe->create($userData);
    } elseif ($days == 0 && $payment == 0) {
        $userData["subscription"] = "Free";
        $subscribe->create($userData);
    }
}
