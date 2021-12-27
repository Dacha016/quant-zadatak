<?php

namespace App\Controllers;

use App\Blade\Blade;
use App\Models\User;
use DevCoder\SessionManager;

class AuthController
{
    protected User $user;
    protected string $role = "user";

    public function __construct()
    {
        $this->user = new User;
    }
    public function registration()
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {
            Blade::render("/registration");

        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
            $error = "";
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $userData = [
                "username" => trim($_POST["username"]),
                "password" => trim($_POST["password"]),
                "rPassword" => trim($_POST["rPassword"]),
                "email" => trim($_POST["email"]),
            ];

            if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["email"])) {
                $error = "Empty fields are not allowed!";
                die(Blade::render("/registration", compact("error")));
            }
            //Check if username contain letters or numbers
            if (!preg_match("/^[a-zA-Z0-9]*$/", $userData["username"])) {
                $error = "The username may contain only letters and numbers";
                die(Blade::render("/registration", compact("error")));
            }
            //Email check
            if (!filter_var($userData["email"], FILTER_VALIDATE_EMAIL)) {
                $error = "Enter the correct email";
                die(Blade::render("/registration", compact("error")));

            }
            //password length and password mach
            if (strlen($userData["password"]) < 6) {
                $error = "Password must be longer than 6 characters";
                die(Blade::render("/registration", compact("error")));
            } else if ($userData["password"] !== $userData["rPassword"]) {
                $error = "Password does not match";
                die(Blade::render("/registration", compact("error")));
            }
            //Check if user exist
            if ($this->user->find($userData["username"], $userData["email"])) {
                $error = "User already exists";
                die(Blade::render("/registration", compact("error")));
            }
            $userData["password"] = password_hash($userData["password"], PASSWORD_BCRYPT);
            $userData["role"] = $this->role;
            $userData["api_key"] = implode('-', str_split(substr(strtolower(md5(microtime() . rand(1000, 9999))), 0, 30), 6));
var_dump($userData["password"]);
die();
            // Insert into database
            if ($this->user->register($userData)) {
                header("Location: http://localhost/login");
                Blade::render("/login");
            }
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
                die(Blade::render("/login", compact("error")));
            }
            if (empty($_POST["username"]) && !empty($_POST["password"])) {
                $error = "Please enter username!";
                die(Blade::render("/login", compact("error")));
            }
            if (!empty($_POST["username"]) && empty($_POST["password"])) {
                $error = "Please enter password!";
                die(Blade::render("/login", compact("error")));
            }

            if($this->user->findByUsernameAndPassword($userData["username"], $userData["password"])) {
                $loggedUser = $this->user->login($userData["username"], $userData["password"]);
                if (isset($loggedUser)) {
                    $session = new SessionManager;
                    $session->set("id",$loggedUser->id);
                    $session->set("username", $loggedUser->username);
                    header("Location: http://localhost/profile");
                    Blade::render("/profile","session");
                } else {
                    $error = "Username and username do not match";
                    die(Blade::render("/login", compact("error")));
                }
            }
        }
    }
    public function logout()
    {
//        if(ini_get("session.use_cookies")) {
//            $params=session_get_cookie_params();
//            setcookie(session_name(), '', time() - 42000,
//                $params["path"], $params["domain"],
//                $params["secure"], $params["httponly"]
//            );
//        }
//        session_destroy();
//        header("Location: http://localhost/home");
        if(isset($_GET['logout'])) {
            session_destroy();
            unset($_SESSION["id"]);
            unset($_SESSION['username']);
            header("Location: http://localhost/home");
        }

    }
}