<?php

namespace App\Controllers;

use App\Blade\Blade;
use App\Models\Subscription;


class SubscriptionController extends Controller
{
    public function __construct()
    {
        parent::__construct(new Subscription());
    }

    /**
     * Not logged user subscription list
     * @param $username
     * @return void
     */
    public function indexSubscriptionList($username)
    {
        $user = $this->model->show($username);

        if (isset($user["data"]["error"])) {

            $error = $user["data"]["error"];

            Blade::render("/subscription", compact("error"));

        } else {

            $result = $this->model->index($username);
            $result = $result["data"]["subscriptions"];

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

            $result = $this->model->index($_SESSION["username"]);
            $result = $result["data"]["subscriptions"];

            Blade::render("/subscription", compact("result"));

        } elseif (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {

            $userData = [
                "id" => $_SESSION["id"],
                "subscription" => $_POST["subscription"],
                "username" => $_SESSION["username"]
            ];

            $result = $this->model->subscribe($userData);

            if (isset($result["data"]["error"])) {

                $error = $result["data"]["error"];
                $result = $this->model->index($_SESSION["username"]);
                $result = $result["data"]["subscriptions"];

                Blade::render("/subscription", compact("result", "error"));

            } else {

                $result = $this->model->index($_SESSION["username"]);
                $result = $result["data"]["subscriptions"];

                Blade::render("/subscription", compact("result"));
            }
        }
    }
}
