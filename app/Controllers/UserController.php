<?php
/**
 * Connection to base
 *
 * PHP version 8
 *
 * @category Connection
 * @package  DataBaseConnection
 * @author   DaliborMarinkovic <dalibor.marinkovic@quantoxtechnology.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://github.com/Dacha016/quant-zadatak
 */
namespace App\Controllers;

if (!session_start()) {
    session_start();
}

use App\Blade\Blade;
use App\Models\User;

/**
 * Connection to base
 *
 * PHP version 8
 *
 * @category Connection
 * @package  DataBaseConnection
 * @author   DaliborMarinkovic <dalibor.marinkovic@quantoxtechnology.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://github.com/Dacha016/quant-zadatak
 */
class UserController
{
    protected User $user;
    protected string $role= "user";
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user= new User();
    }
    /**
     * List of users in users tab
     * @return void
     */
    public function index()
    {
        $pages = $this->user->getPages();
        $result = $this->user->index($_SESSION["id"]);
        Blade::render("/users", compact("result", "pages"));
    }
    public function updateAccount()
    {
        $id = $_SESSION["id"];
        $result = $this->user->show($id);
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {
            Blade::render("/updateAccount", compact("result"));

        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $userData = [
                "username" => trim($_POST["username"]),
                "password" => trim($_POST["password"]),
                "rPassword" => trim($_POST["rPassword"]),
                "email" => trim($_POST["email"]),
            ];
            //Check if username contain letters or numbers
            if (!preg_match("/^[a-zA-Z0-9]*$/", $userData["username"])) {
                $error = "The username may contain only letters and numbers";
                Blade::render("/updateAccount", compact("error"));
            }
            //Email check
            if (!filter_var($userData["email"], FILTER_VALIDATE_EMAIL)) {
                $error = "Enter the correct email";
                Blade::render("/updateAccount", compact("error"));

            }
            //password length and password mach
            if (strlen($userData["password"]) < 6) {
                $error = "Password must be longer than 6 characters";
               Blade::render("/updateAccount", compact("error"));
            } else if ($userData["password"] !== $userData["rPassword"]) {
                $error = "Password does not match";
               Blade::render("/updateAccount", compact("error"));
            }
            $userData["password"] = password_hash($userData["password"], PASSWORD_BCRYPT);
            $this->user->updateAccount($userData, $id);
            header("Location: http://localhost/profile");
        }
    }
    public function updateUser()
    {
        $id = $_SERVER["REQUEST_URI"];
        $id = explode("/", $id);
        $n = count($id);
        $id = $id[$n - 1];
        $result = $this->user->show($id);
        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {
            Blade::render("/updateUsers", compact("result"));

        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $_POST["nsfw"] = (isset($_POST['nsfw']) == '1' ? '1' : '0');
            $_POST["active"] = (isset($_POST['active']) == '1' ? '1' : '0');
            $updateData = [
                "role" => trim($_POST["role"]),
                "nsfw" => (int)$_POST["nsfw"],
                "active" => (int)$_POST["active"],
                "userId" => (int)$_POST["userId"]
            ];
            $this->user->updateUser($updateData);
            if ($_POST["userId"] !== $_SESSION["id"] && $_SESSION["role"] === "moderator") {
                $updateData["username"] = $_POST["username"];
                $updateData["moderatorsUsername"] = $_SESSION["username"];
                $this->user->createLogg($updateData);
            }
            header("Location: http://localhost/profile/users?page=" . $_POST["page"]);
        }
    }
}
