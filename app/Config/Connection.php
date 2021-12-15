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
    private static $_conn;
    private static $_instance = null;
    /**
     * Override constructor
     */
    private function __construct()
    {

    }
    /**
     * If instance is null, create self
     *
     * @return object
     */
    public static function getInstance()
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new Connection;
        }
        return self::$_instance;
    }
    /**
     * Override clone
     * 
     * @return object
     */
    private function __clone()
    {

    }
    /**
     * Override wakeup
     * 
     * @return object
     */
    private function __wakeup()
    {
        
    }
    /**
     * Make database connection
     * 
     * @param $host     Host name we use to connect
     * @param $dbName   Data base name
     * @param $username Username we use to connect
     * @param $password Password we use to connect 
     *
     * @return object
     */
    public static function connect($host,$dbName,$username,$password)
    {
        try {
            self::$_conn = new PDO("mysql:host=".$host.";dbname=".$dbName, $username, $password);
        }catch(PDOException $e){
            return false;
        }
    } 
    /**
     * Get variable conn
     * 
     * @return object
     */   
    public static function getConn()
    {
        return self::$_conn;
    }
}
?>