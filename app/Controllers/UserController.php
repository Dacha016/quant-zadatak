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

use App\Models\User;
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
     protected $conn;
    /**
     * Connection to base
     *
     * @param $conn Connection to base
     */
    // public function __construct($conn)
    // {
    //     $this->user= new User($conn);
    // }

    /**
     * Connection to base
     * 
     * @param $id int
     * 
     * @return string
     */
    public function show()
    {
        // $data=[
        //     "username"=>"",
        //    .
        // ];
        // if($_SERVER["REQUEST_METHOD"]==="POST"){

        // }
        // $result = $this->user->read($id);
        
        // $row= $result->fetch(PDO::FETCH_ASSOC);
        // if (!$row) {
        //     return $response= "Not found";
        // }
        // return $response = $row;
          include __DIR__ . "../../resource/views/index.php";
        // echo "mozda";
    }

}