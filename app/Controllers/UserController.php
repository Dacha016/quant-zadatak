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

use App\Blade\Blade;
use App\Models\User;

require dirname(__DIR__). "/helpers/helper.php";

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
    protected User $user;
    protected string $role= "user";
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->user= new User();
    }

    /**
     * @return void
     */





    public function index()
    {
      $result = $this->user->index();
      foreach ($result as $row){
          var_dump($row);
      }
    }
}
