<?php
require 'vendor/autoload.php';
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

session_start();

function view($title, $data = null)
{
    $filename = __DIR__ . '/app/resource/views/' . $title . '.php';
    if (file_exists($filename)) {
        include($filename);
    } else {
        throw new Exception('View ' . $title . ' not found!');
    }
}