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
    protected string $table="user";
    protected $conn;
    /**
     * Constructor
     *
     * @param $conn Connection to base
     */
    public function __construct($conn)
    {
        $this->conn=$conn;

    }
    /**
     * Read all users
     *
     * @return object
     */
    public function readAll(): object
    {
        $sql = "SELECT username, email, role, password FROM ".$this->table;
        try {
            $stmt=$this->conn->prepare($sql);
            $stmt->execute();
            return $stmt;
        }catch(PDOException $e){
            exit($e->getMessage());
        }
    }
    /**
     * Read only one user
     *
     * @param $id User Id
     *
     * @return object
     */
    public function read(int $id): object
    {
        $sql = "SELECT username, email, role, password FROM "
            .$this->table." WHERE id = :id";
        try {
            $stmt=$this->conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt;
        }catch(PDOException $e){
            exit($e->getMessage());
        }
    }

}