<?php

namespace App\Controllers;

use App\Blade\Blade;
use App\Models\Subscription;


class SubscriptionController extends Subscription
{
    /**
     * Not logged user subscription list
     * @param $username
     * @return void
     */
    public function indexSubscriptionList($username)
    {
        $user = $this->show($username);
        if (! $user) {
            $noData = "No data";
            Blade::render("/subscription", compact("noData"));

        } else {
            $result = $this->index($username);
            Blade::render("/subscription", compact("result", "user"));
        }
    }

    /**
     * Create subscription and list subscriptions of logged user
     * @return void
     * @throws \Exception
     */
    public function subscription()
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {
            $result = $this->index($_SESSION["username"]);
            Blade::render("/subscription", compact("result"));

        } elseif (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
            $userData = [
                "id" => $_SESSION["id"],
                "subscription" => $_POST["subscription"],
                "username" => $_SESSION["username"]
            ];
            $success = $this->subscribe($userData);
            if (!$success) {
                 $error = "Card problem";
                $result = $this->index($_SESSION["username"]);
                Blade::render("/subscription", compact("result", "error"));
            }else {
                $result = $this->index($_SESSION["username"]);
                Blade::render("/subscription", compact("result"));
            }
        }
    }


}