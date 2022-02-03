<?php

use App\Adapters\PaymentAdapter;
use App\Interfaces\Payment;
use App\Models\Subscription;
use App\Models\User;

if (isset($_SESSION["id"])) {

    $subscribe = new Subscription;
    $plans = $subscribe->index($_SESSION["username"]);
    $plans = $plans["data"]["subscriptions"];
    $n = count($plans);
    $lastPlanId = $plans[$n - 1]->id;

    //Change value when user first log in
    if ($plans[0]->id == $lastPlanId) {
        $subscribe->active($plans[0]->id);

    }

    function paySubscription(Payment $payment)
    {
        if ($payment->isValid()) {
            return $payment->pay();
        }
        return false;
    }

    $user = new User();
    $user = $user->show($_SESSION["username"]);

    $user = new PaymentAdapter(new User());
    paySubscription($user);


    $userSubscribe = $subscribe->show($_SESSION["username"]);
    $userSubscribe = $userSubscribe["data"]["subscription"];

    $now = new \DateTime();
    $ends = new \DateTime($userSubscribe->end);
    $interval = $now->diff($ends);

    $_SESSION["plan"] = $userSubscribe->plan;
    $_SESSION["plans end"] = $interval->format('%r%a days');
    $days = abs($interval->format('%r%a'));

    if (paySubscription($user) == true && $days == 0) {

        if ($userSubscribe->id < $lastPlanId) {
            $next = $subscribe->selectNext($_SESSION["id"]);
            $subscribe->active($next->id);
            $subscribe->deactivate($userSubscribe->id);
            exit();
        }

        $userData = [
            "username" => $_SESSION["username"],
            "id" => $_SESSION["id"],
            "subscription" => $userSubscribe->plan
        ];

        $subscribe->subscribe($userData);

    } elseif (paySubscription($user) == false && $days == 0) {
        if ($userSubscribe->id < $lastPlanId) {
            $next = $subscribe->selectNext($_SESSION["id"]);
            $subscribe->active($next);
            $subscribe->deactivate($userSubscribe->id);
            exit();
        }
        $userData = [
            "username" => $_SESSION["username"],
            "id" => $_SESSION["id"],
            "subscription" => "Free"
        ];

        $subscribe->subscribe($userData);
    }
}
