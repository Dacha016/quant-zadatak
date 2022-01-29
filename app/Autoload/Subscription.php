<?php

use App\Adapters\PaymentAdapter;
use App\Interfaces\Payment;
use App\Models\Subscription;
use App\Models\User;

if (isset($_SESSION["id"])) {

    function paySubscription(Payment $payment)
    {
        $payment->isValid();

        $payment->pay();
    }
    $user = new PaymentAdapter(new User());

    $subscribe = new Subscription;
    $userSubscribe = $subscribe->show($_SESSION["username"]);
    $now = new \DateTime();
    $ends = new \DateTime($userSubscribe->end);
    $interval = $now->diff($ends);
    $_SESSION["plans end"] = $interval->format('%r%a days');
    $days = abs($interval->format('%r%a'));

    paySubscription($user);

    if (paySubscription($user) !== null && $days == 0) {
        $userData = [
            "username" => $_SESSION["username"],
            "id" => $_SESSION["id"],
            "subscription" => $userSubscribe->plan
        ];

        $subscribe->subscribe($userData);
    } elseif ( paySubscription($user) == null && $days == 0) {
        $userData = [
            "username" => $_SESSION["username"],
            "id" => $_SESSION["id"],
            "subscription" => "Free"
        ];
        $subscribe->subscribe($userData);
    }
}
