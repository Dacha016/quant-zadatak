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
 namespace App\Config;

use PDO;
use PDOException;
use PDOStatement;

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
    protected PDO $conn;
    protected $stmt;
    protected $error;

    /**
     * Constructor
     */
    public function __construct()
    {
        try{
            $this->conn = new PDO("mysql:host=".$_ENV["HOST"].";dbname=".$_ENV["DATABASE"], $_ENV["USERNAME"], $_ENV["PASSWORD"], array(PDO::ATTR_PERSISTENT=>true));
        }catch(PDOException $e){
            $this->error = $e->getMessage();
            echo $this->error;
        }

    }
    public function queryPrepare($sql)
    {
        return $this->stmt = $this->conn-> prepare($sql);
    }
    public function bindParam($param, $value)
    {
        $this->stmt->bindValue($param, $value);
    }
    public function execute(){
        return $this->stmt->execute();
    }
    public function single()
    {
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }
    public function multi()
    {
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }
}