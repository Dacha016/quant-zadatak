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
class UserController extends User
{
    /**
     * List of users in users tab
     * @return void
     */
    public function indexUsers()
    {
        $pages = $this->getPages();
        $result = $this->index($_SESSION["username"]);
        Blade::render("/users", compact("result", "pages"));
    }

    /**
     * Update logged user account
     * @return void
     */
    public function updateAccount()
    {
        $result = $this->show($_SESSION["username"]);

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
                Blade::render("/updateAccount", compact("error", "result"));
                exit();
            }
            //Email check
            if (!filter_var($userData["email"], FILTER_VALIDATE_EMAIL)) {
                $error = "Enter the correct email";
                Blade::render("/updateAccount", compact("error", "result"));
                exit();

            }
            //password length and password mach
            if (strlen($userData["password"]) < 6) {
                $error = "Password must be longer than 6 characters";
               Blade::render("/updateAccount", compact("error", "result"));
                exit();
            } else if ($userData["password"] !== $userData["rPassword"]) {
                $error = "Password does not match";
               Blade::render("/updateAccount", compact("error", "result"));
                exit();
            }
            $userData["password"] = password_hash($userData["password"], PASSWORD_BCRYPT);
            $this->updateLoggedUserAccount($userData, $_SESSION["id"]);
            $_SESSION["username"] = $userData["username"];
            header("Location: /profile");
        }
    }

    /**
     * Update not logged user account
     * @param $slug
     * @return void
     */
    public function updateUser($slug)
    {
        $result = $this->show($slug);

        if (strtolower($_SERVER["REQUEST_METHOD"]) === "get") {
            Blade::render("/updateUsers", compact("result"));

        } else if (strtolower($_SERVER["REQUEST_METHOD"]) === "post") {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $_POST["nsfw"] = isset($_POST['nsfw']) ? '1' : '0';
            $_POST["active"] = isset($_POST['active']) ? '1' : '0';
            $updateData = [
                "role" => trim($_POST["role"]),
                "nsfw" => (int)$_POST["nsfw"],
                "active" => (int)$_POST["active"],
                "userId" => (int)$_POST["userId"]
            ];
            $this->updateNotLoggedUser($updateData);

            if ($_POST["userId"] !== $_SESSION["id"] && $_SESSION["role"] === "moderator") {
                $updateData["username"] = $_POST["username"];
                $updateData["moderatorsUsername"] = $_SESSION["username"];
                $this->createLogg($updateData);
            }
            header("Location: /profile/users?page=" . $_POST["page"]);
        }
    }
}
