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
namespace App\Controllers;


use PDO;
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
class UserController
{
     protected $user;
    /**
     * Connection to base
     *
     * @param $user Connection base connection
     */
    public function __construct($user)
    {
        $this->user= $user;
    }
    /**
     * Connection to base
     * 
     * @param 1 int
     * 
     * @return string
     */
    public function show($id)
    {
        // $data=[
        //     "username"=>"",
        //    .
        // ];
        // if($_SERVER["REQUEST_METHOD"]==="POST"){

        // }
        $result = $this->user->read($id);
        
        $row= $result->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return $response= "Not found";
        }
        return $response = $row;
        // include "/";
        echo"radi";

    }
}