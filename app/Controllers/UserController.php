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

use App\Models\User;

require dirname(__DIR__). "/helpers/helper.php";

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
     * @return void
     */
    public function registration()
    {
      $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
      $userData = [
          "username" => trim($_POST["username"]),
          "password" => trim($_POST["password"]),
          "rPassword" => trim($_POST["rPassword"]),
          "email" => trim($_POST["email"]),
      ];
      if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["email"])) {
            showError("register", "Fill out all fields");
      }
      // signed characters are allowed
      if (!preg_match("/^[a-zA-Z0-9]*$/",$userData["username"])) {
          showError("register", "Invalid username");
      }
      // check email
      if ( !filter_var($userData["email"], FILTER_VALIDATE_EMAIL)) {
           showError("register", "Invalid email");
      }
      //password length and password mach
      if (strlen($userData["password"])<6) {
          showError("register", "Password must have 6 characters");
      } else if ($userData["password"] !== $userData["rPassword"]) {
          showError("register", "Passwords do not match");
      }
      //check if user exist
      if ($this->user->find($userData["username"], $userData["email"])){
          showError("register", "User exist!!");
      }
      $userData["password"] = md5($userData["password"]);
      $userData["role"] = $this->role;
      $userData["api_key"] = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));
      // insert into database
      if ($this->user->register($userData)) {
          header("Location: http://localhost/login");
      }
      die("Something went wrong");
    }

    public function login()
    {
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
        $userData = [
            "username" => trim($_POST["username"]),
            "password" => trim($_POST["password"]),
            ];
        if (empty($_POST["username"]) || empty($_POST["password"])) {
            showError("login", "Fill out all fields");
        }
        if($this->user->findByUsernameAndPassword($userData["username"], $userData["password"])) {

            $loggedUser = $this->user->login($userData["username"], $userData["password"]);
            if ($loggedUser) {
                $_SESSION["id"] = $loggedUser->id;
                $_SESSION["username"] = $loggedUser->username;
                header("Location: http://localhost/profile");
            }
        } else {
              showError("login", "User not found");
        }
    }
    public function logout()
    {
        if(isset($_SESSION["id"])) {
            $_SESSION = [];
            session_destroy();
            $_SESSION["username"] = "";
            $_SESSION["id"] = "";
        }
        header("Location: http://localhost/");
    }

    public function index()
    {
      $result = $this->user->index();
      foreach ($result as $row){
          var_dump($row);
      }
    }
}
