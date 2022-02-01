<?php
/**
 * User
 *
 * PHP version 8
 *
 * @category Model
 * @package  User
 * @author   DaliborMarinkovic <dalibor.marinkovic@quantoxtechnology.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://github.com/Dacha016/quant-zadatak
 */

namespace App\Models;

use App\Interfaces\Card;
use Predis\Client;


/**
 * User
 *
 * @category Model
 * @package  User
 * @author   DaliborMarinkovic <dalibor.marinkovic@quantoxtechnology.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://github.com/Dacha016/quant-zadatak
 */
class User extends Model implements Card
{

    private string $username;
    private string $email;
    private string $password;
    private string $api_key;
    private string $role = "user";
    private int $nsfw = 0;
    private int $active = 0;
    private int $payment = 0;
    private string $valid_until;

    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function getUsername(): string
    {
        return $this->username;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getApi_key(): string
    {
        return $this->api_key;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function getNsfw(): int
    {
        return $this->nsfw;
    }

    public function getActive(): int
    {
        return $this->active;
    }

    public function getPayment(): int
    {
        return $this->payment;
    }

    public function getValidUntil(): string
    {
        return $this->valid_until;
    }

    /**
     * List of users without logged user
     * @param $username
     * @return array
     */
    public function index($username): array
    {

        $redis = new Client();
        $key = "users_page_{$_GET["page"]}";

        if (!$redis->exists($key)) {

            $limit = 50;
            $page = $_GET["page"] - 1;
            $offset = abs($page * $limit);

            $this->conn->queryPrepare(
                "select * from user where username != :username limit $limit offset $offset");
            $this->conn->bindParam(":username", $username);
            $this->conn->execute();

            $users = [];

            while ($row = $this->conn->single()) {
                $users[] = $row;
            }

            $redis->set($key, serialize($users));
            $redis->expire($key, 300);

            if (isset($users)) {

                $response["data"] = [
                    "users" => $users,
                    "status_code" => 'HTTP/1.1 200 Success'
                ];

            } else {

                $response["data"] = [
                    "error" => "Content not found, something is wrong",
                    "status_code" => 'HTTP/1.1 404 Not Found'
                ];

            }

        } else {

            $response["data"] = [
                "users" => unserialize($redis->get($key)),
                "status_code" => 'HTTP/1.1 200 Success'
            ];

        }
        return $response;
    }

    /**
     * Find user if exists
     * @param $username
     * @return mixed
     */
    public function show($username): mixed
    {

        $this->conn->queryPrepare("SELECT * FROM user WHERE username = :username");
        $this->conn->bindParam(":username", $username);
        $this->conn->execute();

        $result = $this->conn->single();

        if ($result) {

            $response["data"] = [
                "user" => $result,
                "status_code" => 'HTTP/1.1 200 Success'
            ];

            return $response;

        } else {

            return false;
        }
    }

    /**
     * Register new user
     * @return array
     */
    public function register(): array
    {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $payment = isset($_POST['payment']) ? '1' : '0';
        $userData = [
            "username" => trim($_POST["username"]),
            "password" => trim($_POST["password"]),
            "rPassword" => trim($_POST["rPassword"]),
            "email" => trim($_POST["email"]),
            "valid_until" => $_POST["valid_until"],
            "payment" => $payment
        ];

        if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["email"])) {

            $response["data"] = [
                "error" => "Empty fields are not allowed!",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;

        }

        //Check if username contain letters or numbers
        if (!preg_match("/^[a-zA-Z0-9]*$/", $userData["username"])) {

            $response["data"] = [
                "error" => "The username may contain only letters and numbers",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;

        }

        //Email check
        if (!filter_var($userData["email"], FILTER_VALIDATE_EMAIL)) {

            $response["data"] = [
                "error" => "Enter the correct email",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;

        }

        //password length and password mach
        if (strlen($userData["password"]) < 6) {

            $response["data"] = [
                "error" => "Password must be longer than 6 characters",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;

        } else if ($userData["password"] !== $userData["rPassword"]) {

            $response["data"] = [
                "error" => "Password does not match",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;

        }

        //Check if user exist
        if ($this->show($userData["username"])) {

            $response["data"] = [
                "error" => "User already exists",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;

        }

        $userData["password"] = password_hash($userData["password"], PASSWORD_BCRYPT);
        $userData["role"] = $this->getRole();
        $userData["nsfw"] = $this->getNsfw();
        $userData["active"] = $this->getActive();
        $userData["api_key"] = implode('-', str_split(substr(strtolower(md5(microtime() . rand(1000, 9999))), 0, 30), 6));

        $this->conn->queryPrepare(
            "INSERT INTO user (username, email, password, role, api_key, nsfw, active, payment, valid_until) 
            VALUES (:username, :email, :password, :role, :api_key, :nsfw, :active, :payment, :valid_until)");
        $this->conn->bindParam(":username", $userData["username"]);
        $this->conn->bindParam(":email", $userData["email"]);
        $this->conn->bindParam(":password", $userData["password"]);
        $this->conn->bindParam(":role", $userData["role"]);
        $this->conn->bindParam(":api_key", $userData["api_key"]);
        $this->conn->bindParam(":nsfw", $userData["nsfw"]);
        $this->conn->bindParam(":active", $userData["active"]);
        $this->conn->bindParam(":payment", $userData["payment"]);
        $this->conn->bindParam(":valid_until", $userData["valid_until"]);
        $this->conn->execute();

        $result = $this->show($userData["username"]);

        $userData["id"] = $result["data"]["user"]->id;
        $userData["subscription"] = $_POST["subscription"];

        $subscription = new Subscription;
        $subscription->subscribe($userData);


        $response["data"] = [
            "status_code" => 'HTTP/1.1 200 Success'
        ];

        return $response;

    }

    /**
     * Insert data in moderator_logging
     * @param $updateData
     * @return array
     */
    public function createLogg($updateData): array
    {

        $this->conn->queryPrepare(
            "insert into moderator_logging (moderator_username, user_username, user_active, user_nsfw, user_role)
            values (:moderator_username, :user_username, :user_active, :user_nsfw, :user_role)");
        $this->conn->bindParam(":moderator_username", $updateData["moderatorsUsername"]);
        $this->conn->bindParam(":user_role", $updateData["role"]);
        $this->conn->bindParam(":user_nsfw", $updateData["nsfw"]);
        $this->conn->bindParam(":user_active", $updateData["active"]);
        $this->conn->bindParam(":user_username", $updateData["username"]);
        $this->conn->execute();

        $response["data"] = [
            "status_code" => 'HTTP/1.1 200 Success'
        ];

        return $response;

    }

    /**
     * Update logged user account
     * @return array
     */
    public function updateLoggedUserAccount(): array
    {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $payment = isset($_POST['payment']) ? '1' : '0';

        $userData = [
            "username" => trim($_POST["username"]),
            "password" => trim($_POST["password"]),
            "rPassword" => trim($_POST["rPassword"]),
            "email" => trim($_POST["email"]),
            "payment" => $payment,
            "valid_until" => $_POST["valid_until"]
        ];

        if (empty($_POST["username"]) || empty($_POST["password"]) || empty($_POST["email"])) {

            $response["data"] = [
                "error" => "Empty fields are not allowed!",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;

        }

        //Check if username contain letters or numbers
        if (!preg_match("/^[a-zA-Z0-9]*$/", $userData["username"])) {

            $response["data"] = [
                "error" => "The username may contain only letters and numbers",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;

        }

        //Email check
        if (!filter_var($userData["email"], FILTER_VALIDATE_EMAIL)) {

            $response["data"] = [
                "error" => "Enter the correct email",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;

        }

        //password length and password mach
        if (strlen($userData["password"]) < 6) {

            $response["data"] = [
                "error" => "Password must be longer than 6 characters",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;

        } else if ($userData["password"] !== $userData["rPassword"]) {

            $response["data"] = [
                "error" => "Password does not match",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;

        }

        $userData["password"] = password_hash($userData["password"], PASSWORD_BCRYPT);

        $this->conn->queryPrepare(
            "update user set 
                username = :username,
                email = :email,
                password = :password,
                payment = :payment,
                valid_until = :valid_until
                where id =:id");
        $this->conn->bindParam(":id", $_SESSION["id"]);
        $this->conn->bindParam(":username", $userData["username"]);
        $this->conn->bindParam(":email", $userData["email"]);
        $this->conn->bindParam(":password", $userData["password"]);
        $this->conn->bindParam(":payment", $userData["payment"]);
        $this->conn->bindParam(":valid_until", $userData["valid_until"]);
        $this->conn->execute();

        $_SESSION["username"] = $userData["username"];

        $response["data"] = [
            "status_code" => 'HTTP/1.1 200 Success'
        ];

        return $response;
    }

    /**
     * Update not logged user account
     * @return array
     */
    public function updateNotLoggedUser(): array
    {

        $redis = new Client();
        $redis->del("users_page_{$_POST['page']}");

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $nsfw = isset($_POST['nsfw']) ? '1' : '0';
        $active = isset($_POST['active']) ? '1' : '0';

        $updateData = [
            "role" => trim($_POST["role"]),
            "nsfw" => $nsfw,
            "active" => $active,
            "userId" => $_POST["userId"]
        ];

        $this->conn->queryPrepare(
            "update user set 
                role = :role,
                nsfw = :nsfw,
                active = :active
                where id =:id");
        $this->conn->bindParam(":role", $updateData["role"]);
        $this->conn->bindParam(":nsfw", $updateData["nsfw"]);
        $this->conn->bindParam(":active", $updateData["active"]);
        $this->conn->bindParam(":id", $updateData["userId"]);
        $this->conn->execute();

        if ($_POST["userId"] !== $_SESSION["id"] && $_SESSION["role"] === "moderator") {
            $updateData["username"] = $_POST["username"];
            $updateData["moderatorsUsername"] = $_SESSION["username"];
            $this->createLogg($updateData);
        }

        $response["data"] = [
            "status_code" => 'HTTP/1.1 200 Success'
        ];

        return $response;
    }

    /**
     * Find user by username adn compare passwords
     * @param $username
     * @param $password
     * @return bool
     */
    public function findByUsername($username, $password): bool
    {

        $this->conn->queryPrepare("SELECT * FROM user WHERE username = :username ");
        $this->conn->bindParam(":username", $username);
        $this->conn->execute();

        $result = $this->conn->single();

        if (!$result) {
            return false;
        }
        $hashedPassword = $result->password;

        if (password_verify($password, $hashedPassword)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Log in user
     * @return array
     */
    public function loginUser(): array
    {

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $userData = [
            "username" => trim($_POST["username"]),
            "password" => trim($_POST["password"]),
        ];

        if (empty($_POST["username"]) && empty($_POST["password"])) {

            $response["data"] = [
                "error" => "Empty fields are not allowed!",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;

        }

        if (empty($_POST["username"]) && !empty($_POST["password"])) {

            $response["data"] = [
                "error" => "Please enter username!",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;
        }

        if (!empty($_POST["username"]) && empty($_POST["password"])) {

            $response["data"] = [
                "error" => "Please enter password!",
                "status_code" => 'HTTP/1.1 422 Unprocessable entity'
            ];

            return $response;
        }

        if (!$this->findByUsername($userData["username"], $userData["password"])) {

            $response["data"] = [
                "error" => "Username and password do not match",
                "status_code" => 'HTTP/1.1 403 Forbidden'
            ];

            return $response;
        }

        $this->conn->queryPrepare("SELECT * FROM user WHERE username = :username ");
        $this->conn->bindParam(":username", $userData["username"]);
        $this->conn->execute();

        $response["data"] = [
            "user" => $this->conn->single(),
            "status_code" => 'HTTP/1.1 200 Success'
        ];
        return $response;

    }

    /**
     * Change value of payment
     * @param $id
     * @return mixed
     */
    public function deactivate($id)
    {

        $this->conn->queryPrepare("update user set payment = 0 where id =:id");
        $this->conn->bindParam(":id", $id);

        return $this->conn->execute();
    }

    /**
     * Pages for pagination
     * @return float
     */
    public function getPages(): float
    {

        $limit = 50;

        $this->conn->queryPrepare("select count(*) as 'row' from user");
        $this->conn->execute();

        $result = $this->conn->single();
        $rows = $result->row;

        return ceil($rows / $limit);
    }

    /**
     * Check is users card is valid
     * @return mixed
     */
    public function isValid()
    {

        $now = date("Y-m-d");

        $user = $this->show($_SESSION["username"]);

        if ($now == $user["data"]["user"]->valid_until) {
            $this->deactivate($_SESSION["id"]);
        }

        $this->conn->queryPrepare("select payment from user where id =:id and payment = 1");
        $this->conn->bindParam(":id", $_SESSION["id"]);
        $this->conn->execute();

        return $this->conn->single();

    }

    /**
     * Pay if users card id valid
     * @return bool
     */
    public function pay()
    {
        return $this->isValid();
    }

}