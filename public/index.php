<?php
/**
 * Index
 *
 * PHP version 8
 *
 * @category Index
 * @package  Index
 * @author   DaliborMarinkovic <dalibor.marinkovic@quantoxtechnology.com>
 * @license  http://www.php.net/license/3_01.txt  PHP License 3.01
 * @link     http://github.com/Dacha016/quant-zadatak
 */

require_once realpath('../vendor/autoload.php');
use App\Config\Connection;
use App\Controllers\UserController;
use Dotenv\Dotenv;
use App\Models\User;
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();
Connection::connect(
    $_ENV["HOST"], $_ENV["DATABASE"], $_ENV["USERNAME"], $_ENV["PASSWORD"]
);
$db= Connection::getInstance();
$conn=$db->getConn();
$user= new UserController($conn);
var_dump($user->show(1));


?>