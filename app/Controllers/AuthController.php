<?php

namespace App\Controllers;

use App\Blade\Blade;
use App\Models\Subscription;
use App\Models\User;

class AuthController extends Controller
{

    public function __construct()
    {
        parent::__construct(new User());
    }

    /**
     * Register new user
     * @return void
     * @throws \Exception
     */
    public function registration()
    {

        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {

            Blade::render("/registration");

        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {

            $result = $this->model->register();

            if (isset($result["data"]["error"])) {

                $error = $result["data"]["error"];
                Blade::render("/registration", compact("error"));

            } else {

                header("Location: /login");

            }
        }
    }

    /**
     * Log in
     * @return void
     * @throws \Exception
     */
    public function login()
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {

            Blade::render("/login");

        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {

            $result = $this->model->loginUser();

            if (isset($result["data"]["error"])) {

                $error = $result["data"]["error"];
                Blade::render("/login", compact("error"));

            } else {

                session_start();
                $_SESSION["id"] = $result["data"]["user"]->id;
                $_SESSION["username"] = $result["data"]["user"]->username;

                $subscribe = new Subscription();
                $userSubscribe = $subscribe->index($_SESSION["username"]);

                if (!$userSubscribe) {

                    $userData = [
                        "username" => $_SESSION["username"],
                        "id" => $_SESSION["id"],
                        "subscription" => "Free",
                    ];

                    $subscribe->subscribe($userData);
                }

                $_SESSION["role"] = $result["data"]["user"]->role;
                $_SESSION["plan"] = $userSubscribe[0]->plan;

                header("Location: /profile");
            }
        }
    }

    /**
     * Destroy session
     * @return void
     */
    public function logout()
    {

        session_unset();
        session_destroy();
        header("Location: /home");

    }
}