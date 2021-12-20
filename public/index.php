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
use App\Models\User;
use Dotenv\Dotenv;
use Bramus\Router\Router;

$dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));
$dotenv->load();

$router= new Router;

// $router->get('/', function() {
//     echo 'About Page Contents';
// });
require_once realpath('../routes/web.php');
$router->run();





?>