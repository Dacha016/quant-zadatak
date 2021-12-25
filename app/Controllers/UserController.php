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

require dirname(__DIR__,1). "/helpers/helper.php";

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
     protected $apiKey;
     protected $role = "user";
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
      if (!preg_match("/^[a-zA-Z0-9]*$/",$userData["username"])) {
          showError("register", "Invalid username");
      }
      if ( !filter_var($userData["email"], FILTER_VALIDATE_EMAIL)) {
           showError("register", "Invalid email");
      }
      if (strlen($userData["password"])<6) {
          showError("register", "Password must have 6 characters");
      } else if ($userData["password"] !== $userData["rPassword"]) {
          showError("register", "Passwords do not match");
      }

      if ($this->user->find($userData["username"])){
          showError("register", "User exist!!");
      }
      $userData["password"] = password_hash($userData["password"], PASSWORD_DEFAULT);
      $userData["role"] = $this->role;
      $userData["api_key"] = implode('-', str_split(substr(strtolower(md5(microtime().rand(1000, 9999))), 0, 30), 6));

      if ($this->user->register($userData)) {
          header("Location:" .dirname(__DIR__,2). "/resource/views/login.php");
      }
      die("Something went wrong");
    }
    public function index()
    {
      $result = $this->user->index();
      foreach ($result as $row){
          var_dump($row);

      }


    }
}
$user = new UserController;
if ($_SERVER["REQUEST_METHOD"]==="post") {
    if ($_POST["type"] === "register") {
        $user->registration();
        exit();
    }
} 