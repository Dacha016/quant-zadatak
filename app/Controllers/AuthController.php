<?php

namespace App\Controllers;

use App\Blade\Blade;
use App\Models\Subscription;
use App\Models\User;

class AuthController extends User
{

    public function registration()
    {

        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {
            Blade::render("/registration");

        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $userData = [
                "username" => trim($_POST["username"]),
                "password" => trim($_POST["password"]),
                "rPassword" => trim($_POST["rPassword"]),
                "email" => trim($_POST["email"]),
            ];

            if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["email"])) {
                $error = "Empty fields are not allowed!";
               Blade::render("/registration", compact("error"));
                exit();
            }

            //Check if username contain letters or numbers
            if (!preg_match("/^[a-zA-Z0-9]*$/", $userData["username"])) {
                $error = "The username may contain only letters and numbers";
                Blade::render("/registration", compact("error"));
                exit();
            }

            //Email check
            if (!filter_var($userData["email"], FILTER_VALIDATE_EMAIL)) {
                $error = "Enter the correct email";
              Blade::render("/registration", compact("error"));
                exit();
            }

            //password length and password mach
            if (strlen($userData["password"]) < 6) {
                $error = "Password must be longer than 6 characters";
                Blade::render("/registration", compact("error"));
                exit();
            } else if ($userData["password"] !== $userData["rPassword"]) {
                $error = "Password does not match";
               Blade::render("/registration", compact("error"));
                exit();
            }

            //Check if user exist
            if ($this->show($userData["username"])) {
                $error = "User already exists";
                Blade::render("/registration", compact("error"));
                exit();
            }

            $userData["password"] = password_hash($userData["password"], PASSWORD_BCRYPT);
            $userData["role"] = $this->getRole();
            $userData["nsfw"] = $this->getNsfw();
            $userData["active"] = $this->getActive();
            $userData["api_key"] = implode('-', str_split(substr(strtolower(md5(microtime() . rand(1000, 9999))), 0, 30), 6));

            $this->register($userData);
            $result =$this->show($userData["username"]);
            $userData["id"] = $result->id;
            $userData["subscription"] = $_POST["subscription"];

            $subscription = new Subscription;
            $subscription->create($userData);

            header("Location: /login");
            Blade::render("/login");
        }
    }

    public function login()
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {
            Blade::render("/login");
        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $userData = [
                "username" => trim($_POST["username"]),
                "password" => trim($_POST["password"]),
            ];

            if (empty($_POST["username"]) && empty($_POST["password"])) {
                $error = "Empty fields are not allowed!";
                Blade::render("/login", compact("error"));
                exit();
            }

            if (empty($_POST["username"]) && !empty($_POST["password"])) {
                $error = "Please enter username!";
                Blade::render("/login", compact("error"));
                exit();
            }

            if (!empty($_POST["username"]) && empty($_POST["password"])) {
                $error = "Please enter password!";
                Blade::render("/login", compact("error"));
                exit();
            }

            if(!$this->findByUsername($userData["username"], $userData["password"])) {
                $error = "Username and password do not match";
                Blade::render("/login", compact("error"));
                exit();
            }

            $loggedUser = $this->loginUser($userData["username"], $userData["password"]);
            $subscribe = new Subscription();
            $userSubscribe = $subscribe->show($loggedUser->username);

            if (! $userSubscribe) {
                $userData = [
                    "id" => $loggedUser->id,
                    "subscription" => "Free",
                ];
                $subscribe->create($userData);
            }

            $_SESSION["id"] = $loggedUser->id;
            $_SESSION["username"] = $loggedUser->username;
            $_SESSION["role"] = $loggedUser->role;
            $_SESSION["plan"] = $userSubscribe->plan;
            header("Location: /profile");
            Blade::render("/profile");
        }
    }
    public function logout()
    {
        session_unset();
        session_destroy();
        header("Location: /home");
    }
}