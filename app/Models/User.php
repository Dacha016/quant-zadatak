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
    protected string $table = "user";
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
        $this->conn->queryPrepare("SELECT * FROM ".$this->table." WHERE username = :username or email = :email");
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

    /**
     * Get users from table
     * @return mixed
     */
    public function indexUsers()
    {
        $this->conn->queryPrepare("SELECT * FROM user LIMIT 50");
        $this->conn->execute();
        return $this->conn->multy();
    }

    /**
     * Get galleries for users with role user
     * @param $username $username username of current user
     * @return mixed
     */
        public function showUserGalleries($id)
    {
        $this->conn->queryPrepare(
            "SELECT gallery.id as 'galleryId', gallery.description, gallery.name, gallery.user_id FROM gallery 
            INNER JOIN user u on gallery.user_id = u.id 
            WHERE gallery.user_id =:id AND hidden = 0 AND nsfw = 0");
            $this->conn->bindParam(":id", $id);
            $this->conn->execute();
            return $this->conn->multy();
    }

    /**
     * Get galleries for other users
     * @param $username $username username of current user
     * @return mixed
     */
    public function showUserGalleriesAll($id)
    {
        $this->conn->queryPrepare("
        SELECT  gallery.id as 'galleryId', gallery.description, gallery.name, gallery.user_id FROM gallery 
        INNER JOIN user u on gallery.user_id = u.id 
        WHERE gallery.user_id =:id AND hidden = 0 AND nsfw = 0");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
        return $this->conn->multy();
    }
//    public function showUserImages($id)
//    {
//        $this->conn->queryPrepare("SELECT file_name FROM image INNER JOIN user u on image.user_id =:id WHERE  hidden = 0 AND nsfw = 0 LIMIT 50");
//        $this->conn->bindParam(":id", $id);
//        $this->conn->execute();
//        return $this->conn->multy();
//    }
    public function showAllUserImages($id)
    {
        $this->conn->queryPrepare("SELECT * FROM image INNER JOIN user u on image.user_id =:id LIMIT 50");
        $this->conn->bindParam(":id", $id);
        $this->conn->execute();
        return $this->conn->multy();
    }
}