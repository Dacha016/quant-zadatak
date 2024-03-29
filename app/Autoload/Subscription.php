<?php

use App\Adapters\PaymentAdapter;
use App\Interfaces\Payment;
use App\Models\Subscription;
use App\Models\User;

if (isset($_SESSION["id"])) {

    function paySubscription(Payment $payment)
    {
      if ($payment->isValid()) {
          return $payment->pay();
      }
      return false;
    }

    $user = new User();
    $user = $user->show($_SESSION["username"]);
    $user = new PaymentAdapter(new User($user->username, $user->email, $user->password, $user->api_key, $user->role, $user->nsfw, $user->active, $user->payment, $user->valid_until));
    paySubscription($user);

    $subscribe = new Subscription;
    $userSubscribe = $subscribe->show($_SESSION["username"]);
    $userSubscribeAll = $subscribe->index($_SESSION["username"]);

    $now = new \DateTime();
    $ends = new \DateTime($userSubscribe->end);
    $interval = $now->diff($ends);
    $_SESSION["plan"] = $userSubscribe->plan;
    $_SESSION["plans end"] = $interval->format('%r%a days');
    $days = abs($interval->format('%r%a'));
    $plans = $subscribe->index($_SESSION["username"]);
    $n = count($plans);
    $lastPlanId = $plans[$n-1]->id;

    //Change value when user first log in
    if ($userSubscribeAll[0]->id == $lastPlanId) {
        $subscribe->active($userSubscribeAll[0]->id);
        exit();
    }

    if (paySubscription($user) == true && $days == 0) {
        if($userSubscribe->id < $lastPlanId) {
            $next = $subscribe->selectNext($_SESSION["id"]);
            $subscribe->active($next->id);
            $subscribe->deactive($userSubscribe->id);
            exit();
        }

        $userData = [
            "username" => $_SESSION["username"],
            "id" => $_SESSION["id"],
            "subscription" => $userSubscribe->plan
        ];

        $subscribe->subscribe($userData);
    } elseif ( paySubscription($user) == false && $days == 0) {
        if($userSubscribe->id < $lastPlanId) {
            $next = $subscribe->selectNext($_SESSION["id"]);
            $subscribe->active($next);
            $subscribe->deactive($userSubscribe->id);
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
