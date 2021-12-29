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
     * List of users in users tab
     * @return void
     */
    public function index()
    {
      $result = $this->user->indexUsers();

      Blade::render("/users", compact("result"));
    }

    /**
     * Show different permissions for different user
     * @return void
     */
    public function showGalleries()
    {
       $username = $_SERVER["REQUEST_URI"];
       $username = explode("/", $username);
       $n = count($username);
       $username = $username[$n - 1];
       if ($_SESSION["role"] === "user") {
           $result = $this->user->showUserGalleries($username);
       } else {
           $result = $this->user->showUserGalleriesAll($username);
       }
        Blade::render("/gallery", compact("result"));
    }


}
