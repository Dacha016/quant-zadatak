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

    private static PDO $conn;
    private static $instance = null;
    protected $stmt;


    /**
     * Override constructor
     */
    private function __construct()
    {

    }

    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Connection;
        }
        return self::$instance;
    }

    private function __clone()
    {

    }

    public static function connect($host, $database, $username, $password)
    {
        try {
            self::$conn = new PDO("mysql:host=".$host.";dbname=".$database, $username, $password, array(PDO::ATTR_PERSISTENT=>true));
        } catch (PDOException $e) {
            return false;
        }
    }


    public static function getConn()
    {
        return self::$conn;
    }

    public function queryPrepare($sql)
    {
        return $this->stmt = self::getConn()-> prepare($sql);
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
