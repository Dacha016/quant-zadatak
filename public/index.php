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

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(dirname(__DIR__, 1));

require realpath('../routes/web.php');




?>