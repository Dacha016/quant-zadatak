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
     * @return object
     */
    public static function connect()
    {
        try {
            self::$_conn = new PDO(
                "mysql:host=".$_ENV["HOST"].";dbname=".$_ENV["DATABASE"],
                $_ENV["USERNAME"], $_ENV["PASSWORD"]
            );
            return self::$_conn;
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