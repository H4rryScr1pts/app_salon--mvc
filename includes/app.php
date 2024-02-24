<?php 
use Model\ActiveRecord;
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();

require 'database.php';
require 'funciones.php';

$db->set_charset("utf8");

// Conectarnos a la base de datos
ActiveRecord::setDB($db);