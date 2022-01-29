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
    public function __construct($username = "", $email = "", $password = "", $api_key = "", $role = "user", $nsfw = 0, $active = 0, $payment = 0, $valid_until = "" )
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->api_key = $api_key;
        $this->role = $role;
        $this->nsfw = $nsfw;
        $this->active = $active;
        $this->payment = $payment;
        $this->valid_until = $valid_until;
        parent::__construct();
    }

    public function getUsername():string
    {
        return $this->username;
    }

//    public function getEmail():string
//    {
//        return $this->email;
//    }

    public function getPassword():string
    {
        return $this->password;
    }

    public function getApi_key():string
    {
        return $this->api_key;
    }

    public function getRole():string
    {
        return $this->role;
    }

    public function getNsfw():int
    {
        return $this->nsfw;
    }

    public function getActive():int
    {
        return $this->active;
    }

    public function getPayment():int
    {
        return $this->payment;
    }
    public function  getValidUntil():string
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
        $limit =50;
        $page = $_GET["page"]-1;
        $offset = abs($page * $limit);
        $this->conn->queryPrepare(
            "select * from user where username != :username limit $limit offset $offset");
        $this->conn->bindParam(":username", $username);
        $this->conn->execute();
        if (!$redis->exists($key)) {
            $users = [];
            while ($row = $this->conn->single()) {
                $users[] = $row;
            }
            $redis->set($key, serialize($users));
            $redis->expire($key, 300);
            return $users;
        }else {
            return unserialize($redis->get($key));
        }
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

        if ($result){
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Register new user
     * @param $userData
     * @return void
     */
    protected function register($userData):void
    {
        $this->conn->queryPrepare(
            "INSERT INTO user (username, email, password, role, api_key, nsfw, active) 
            VALUES (:username, :email, :password, :role, :api_key, :nsfw, :active)");
        $this->conn->bindParam(":username", $userData["username"]);
        $this->conn->bindParam(":email", $userData["email"]);
        $this->conn->bindParam(":password", $userData["password"]);
        $this->conn->bindParam(":role", $userData["role"]);
        $this->conn->bindParam(":api_key", $userData["api_key"]);
        $this->conn->bindParam(":nsfw", $userData["nsfw"]);
        $this->conn->bindParam(":active", $userData["active"]);
        $this->conn->execute();
    }

    /**
     * Insert data in moderator_logging
     * @param $updateData
     * @return void
     */
    protected function createLogg($updateData): void
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
    }

    /**
     * Update logged user account
     * @param $userData
     * @param $id
     * @return void
     */
    protected function updateLoggedUserAccount($userData,$id):void
    {
        $this->conn->queryPrepare(
            "update user set 
                username = :username,
                email = :email,
                password = :password
                where id =:id");
        $this->conn->bindParam(":username", $userData["username"]);
        $this->conn->bindParam(":email", $userData["email"]);
        $this->conn->bindParam(":password", $userData["password"]);
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
    }

    /**
     * Update not logged user account
     * @param $updateData
     * @return void
     */
    protected function updateNotLoggedUser($updateData):void
    {
        $redis = new Client();
        $redis->del("users_page_{$_POST['page']}");
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
    }

    /**
     * Change value of payment
     * @param $id
     * @return mixed
     */
    public function update($id)
    {
        $this->conn->queryPrepare("update user set payment = 0 where id =:id");
        $this->conn->bindParam(":id", $id);
        return $this->conn->execute();
    }

    /**
     * Find user by username adn compare passwords
     * @param $username
     * @param $password
     * @return bool
     */
    protected function findByUsername($username, $password): bool
    {
        $this->conn->queryPrepare("SELECT * FROM user WHERE username = :username ");
        $this->conn->bindParam(":username", $username);
        $this->conn->execute();
        $result = $this->conn->single();

        if (! $result) {
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
     * @param $username
     * @param $password
     * @return mixed
     */
    protected function loginUser($username, $password): mixed
    {
        $this->conn->queryPrepare("SELECT * FROM user WHERE username = :username ");
        $this->conn->bindParam(":username", $username);
        $this->conn->execute();
        $result = $this->conn->single();
        $hashedPassword = $result->password;

        if (password_verify($password, $hashedPassword)) {
            return $result;
        } else {
            return false;
        }
    }

    /**
     * Pages for pagination
     * @return float
     */
    public function getPages(): float
    {
        $limit =50;
        $this->conn->queryPrepare("select count(*) as 'row' from user");
        $this->conn->execute();
        $result = $this->conn->single();
        $rows = $result->row;
        return ceil($rows/$limit);
    }

    /**
     * Check is users card is valid
     * @return mixed
     */
    public function isValid():mixed
    {
        $now = date("Y-m-d");
        $user = $this->show($_SESSION["username"]);

        if ($now == $user->valid_until) {
            $this->update($_SESSION["id"]);
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
    public function pay():bool
    {
        $result = $this->isValid();

        if ($result == null) {
            return false;
        }

        return true;
    }
}