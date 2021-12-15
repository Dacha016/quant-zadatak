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
use PDO;
use PDOException;
/**
 * Connection to base
 *
 * @category Connection
 * @package  DataBaseConnection
 * @author   DaliborMarinkovic <dalibor.marinkovic@quantoxtechnology.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://github.com/Dacha016/quant-zadatak
 */
class Connection
{
    protected $conn;
    /**
     * Make database connection
     *
     * @return object
     */
    public function connect()
    {
        try{
            $this->conn = new PDO("mysql:host=".$_ENV["HOST"].";dbname=".$_ENV["DATABASE"], $_ENV["USERNAME"], $_ENV["PASSWORD"]);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $e){
            return false;
        }
        return $this->conn;  
    }    
}
?>