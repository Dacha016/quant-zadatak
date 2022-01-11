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

use PDOException;
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
class User extends Model
{
    /**
     * Constructor
     */
    public function __construct()
    {
       parent::__construct();
    }

    /**
     * @param $username
     * @param $email
     * @return bool
     */
    public function find($username, $email): bool
    {
        $this->conn->queryPrepare("SELECT * FROM user WHERE username = :username or email = :email");
        $this->conn->bindParam(":username", $username);
        $this->conn->bindParam(":email", $email);
        $this->conn->execute();
        $result = $this->conn->single();
        if ($result){
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $username
     * @param $password
     * @return bool
     */
    public function findByUsernameAndPassword($username, $password): bool
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
    public function register($userData)
    {
        try {
            $this->conn->queryPrepare("INSERT INTO user (username, email, password, role, api_key) VALUES (:username, :email, :password, :role, :api_key)");
            $this->conn->bindParam(":username", $userData["username"]);
            $this->conn->bindParam(":email", $userData["email"]);
            $this->conn->bindParam(":password", $userData["password"]);
            $this->conn->bindParam(":role", $userData["role"]);
            $this->conn->bindParam(":api_key", $userData["api_key"]);
            return $this->conn->execute();
        } catch (PDOException $e) {
            exit($e->getMessage());
        }
    }

    /**
     * @param $username
     * @param $password
     * @return mixed
     */
    public function login($username, $password): mixed
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
     * Cache data into Redis Server
     * @param $id
     * @return mixed
     */
     public function index($id): mixed
     {
         $redis = new Client();
         $key = "users_page_{$_GET["page"]}";
         $limit =50;
         $page = $_GET["page"];
         $offset = abs($page * $limit);
         $this->conn->queryPrepare(
             "select * from user where id != :id limit $limit offset $offset");
         $this->conn->bindParam(":id", $id);
         $this->conn->execute();
         if (!$redis->exists($key)) {
             $users = [];
             while ($row = $this->conn->single()) {
                 $users[] = $row;
             }
             $redis->set($key, serialize($users));
             $redis->expire($key, 300);
         }
         return unserialize($redis->get($key));
     }

    /**
     * @param $id
     * @return mixed
     */
    public function show($id): mixed
    {
        $this->conn->queryPrepare(
            "select * from user where id = :id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
        return $this->conn->single();
    }

    /**
     * @param $userData
     * @param $id
     * @return mixed
     */
    public function updateAccount($userData,$id): mixed
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
        return $this->conn->execute();
    }

    /**
     * @param $updateData
     * @return mixed
     */
    public function updateUser($updateData): mixed
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
        return $this->conn->execute();
    }

    /**
     * @return float
     */
    public function getPages(): float
    {
        $limit =50;
        $this->conn->queryPrepare("select count(*) as 'row' from user");
        $this->conn->execute();
        $result = $this->conn->single();
        $rows = $result->row;
        return floor($rows/$limit);
    }

    /**
     * @param $updateData
     * @return bool
     */
    public function createLogg($updateData): bool
    {
        $this->conn->queryPrepare(
            "insert into moderator_logging (moderator_username, user_username, user_active, user_nsfw, user_role)
            values (:moderator_username, :user_username, :user_active, :user_nsfw, :user_role)");
        $this->conn->bindParam(":moderator_username", $updateData["moderatorsUsername"]);
        $this->conn->bindParam(":user_role", $updateData["role"]);
        $this->conn->bindParam(":user_nsfw", $updateData["nsfw"]);
        $this->conn->bindParam(":user_active", $updateData["active"]);
        $this->conn->bindParam(":user_username", $updateData["username"]);
        return $this->conn->execute();
    }
}