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

use App\Config\Connection;
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
class User
{
    protected Connection $conn;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->conn = new Connection;
    }

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
    public function findByUsernameAndPassword($username, $password): bool
    {
        $this->conn->queryPrepare("SELECT * FROM user WHERE username = :username or password = :password");
        $this->conn->bindParam(":username", $username);
        $this->conn->bindParam(":password", $password);
        $this->conn->execute();
        $result = $this->conn->single();
        if ($result){
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
    public function login($username, $password) {
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
     public function indexRedis($id)
     {
         $redis = new Client();

         $limit =50;
         $page = $_GET["page"];
         $offset = abs($page * $limit);
         $key = "users_pages_{$offset}";
         $this->conn->queryPrepare(
             "select * from user where id != :id limit $limit offset $offset");
         $this->conn->bindParam(":id", $id);
         $this->conn->execute();
         if(!$redis->get($key)) {
             $users = [];
             while ( $row = $this->conn->single()) {
                 $users[] = $row;
             }
             $redis->set($key, serialize($users));
             $redis->expire($key, 3600);
//             return $this->conn->multi();
             return $users = unserialize($redis->get($key));

         } else{
             return $users = unserialize($redis->get($key));
         }
     }


    public function show($id)
    {
        $this->conn->queryPrepare(
            "select * from user where id = :id");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
        return $this->conn->single();
    }
    public function updateAccount($userData,$id)
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
    public function updateUser($updateData)
    {
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
    public function getPages()
    {
        $limit =50;
        $this->conn->queryPrepare("select count(*) as 'row' from user");
        $this->conn->execute();
        $result = $this->conn->single();
        $rows = $result->row;
        return $pages = floor($rows/$limit);
    }
    public function createLogg($updateData)
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