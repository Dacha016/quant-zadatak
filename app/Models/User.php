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
    protected $table="user";
    protected $conn;
 
    /**
     * Constructor
     * 
     * @param $conn Data base connection
     */
    public function __construct($conn)
    {
        $this->conn=$conn;
    } 
    /**
     * Constructor
     *  
     * @param $id User Id
     * 
     * @return object
     */
    public function read($id)
    {
        $sql="SELECT username, email, role, password FROM ".$this->table." WHERE id = :id";
        try {
            $stmt=$this->conn->prepare($sql);
            echo "radi";
            $stmt->bindParam(":id", $id);
            $stmt->execute();
            return $stmt;
        }catch(PDOException $e){
            exit($e->getMessage());
        }
    }

}
?>